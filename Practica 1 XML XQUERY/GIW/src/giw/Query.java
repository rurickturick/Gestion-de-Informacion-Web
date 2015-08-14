/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package giw;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import org.xmldb.api.base.*;
import org.xmldb.api.modules.*;
import org.xmldb.api.*;
/**
 * Clase Query encargada de:
 *      Leer las consultas de un archivo cuya ruta se proporciona como parametro
 *      Realizar las consultas en XQuery
 *      Escribir los resultados de dichas consultas en el archivo Resultado.txt
 * @author usuario_local
 */ 
public class Query {
    private final String ruta;//Ruta donde se ubica el archivo donde estan almacenadas las consultas
    private final int num_consultas; //Numero de consultas que contiene el archivo
    /**
     * Constructor de la clase Query
     * @param ruta ubicacion del archivo donde se almacena las consultas
     * @param num_consultas numero de consultas en dicho archivo
     */
    public Query(String ruta, int num_consultas){
        this.ruta=ruta;
        this.num_consultas=num_consultas;
    }
    /**
     * Metodo principal que se encarga de leer,ejecutar y escribir consultas
     * @throws Exception 
     */
    public void consultas() throws Exception 
    {
        //Codigo proporcionado para realizar las consultas
        String driver = "org.exist.xmldb.DatabaseImpl"; 
        //Cargamos el driver.
        Class cl = Class.forName(driver);
        //Creamos una nueva instancia de la base de datos.
        Database database = (Database) cl.newInstance(); 
        database.setProperty("create-database", "true");
        //Registramos la base de datos.
        DatabaseManager.registerDatabase(database); 
        //Accedemos a la colección
        Collection col=DatabaseManager.getCollection
        ("xmldb:exist://localhost:8080/exist/xmlrpc/db/", "admin", "eXist");
        XPathQueryService service =(XPathQueryService)col.getService("XPathQueryService", "1.0");
        service.setProperty("pretty", "true");
        service.setProperty("encoding", "ISO-8859-1");
        //Fin de codigo proporcionado 
               
        int j = 0;
        String [] respuestas=new String[this.num_consultas];
        String [] consulta=leerConsultas();
        while (j < this.num_consultas)
        {
            System.out.println("-----------");
            System.out.println("Consulta: "+ (j+1) );
            ResourceSet result = service.query(consulta[j]);
            ResourceIterator i = result.getIterator();
            //Se procesa el resultado. 
            while (i.hasMoreResources()) 
            { 
                Resource r = i.nextResource();
                respuestas[j]=(String) r.getContent();
                System.out.println((String) r.getContent());
            }
            j++;
        }       
        this.escribeResultados(respuestas);       
    }//fin metodo consultas
    /**
     * Metodo que lee las consultas del archivo proporcionado en la ruta dada como argumento
     * Entre cada consulta debe haber un limitador especial, usamos el caracter #
     * @return Un array de string en el que cada posicion representa una consulta
     */
    private String[] leerConsultas(){
        File archivo = new File (this.ruta);
        FileReader fr;
        String queries[] = new String[this.num_consultas];
        try {
             fr = new FileReader (archivo);
             BufferedReader br = new BufferedReader(fr);
             String linea = br.readLine();
             int i=0;
             while (linea!=null)
             {
               queries[i] = "";
               while(!linea.equals("#")){
                  queries[i]=queries[i].concat(linea);
                  linea = br.readLine();
                }
             i++;
             linea = br.readLine();
             } 
        } catch (Exception ex) {
           ex.printStackTrace();
        }
         return queries;
    }//fin metodo leerConsultas
    /**
     * Metodo que escribe los resultados de realizar las consultas en el archivo Resultado.txt
     * Este archivo se encuentra donde se haya creado el proyecto NetBeans
     * @param query Array que contiene las respuestas a cada consulta realizada
     */
    private void escribeResultados(String[] query){
        FileWriter fichero= null;
        try
        {   
            fichero = new FileWriter("Resultado.txt");
            PrintWriter pw = new PrintWriter(fichero);
            pw.println("RESULTADOS CONSULTAS XQUERY");
            pw.println("==========================");
            for (int i = 1; i <= query.length; i++){
                pw.println("-----------------CONSULTA "+ i + "----------------------------:");
                pw.println(query[i-1]);
            }
        }
        catch (IOException e) {
            System.err.println("Error de fichero");
        }
        finally {
            try {           
                if (null != fichero)
                    fichero.close();
            }catch (IOException e2) {
                e2.printStackTrace();
                System.err.println("Error de cerrar fichero");
            }
                 
                }
        
    }//Fin metodo escribeResultados
}//Fin de clase Query