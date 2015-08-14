package giw;


import org.xmldb.api.*;
import org.xmldb.api.base.*;
import org.xmldb.api.modules.*;
import java.io.*;
import org.exist.util.*;
import org.exist.xmldb.*;
 
/**
 * Clase encargada de subir los documentos xml a la base de datos
 * @author usuario_local
 */
public class Uploads {
    private final String[] args; //lista de argumentos que contendra /db doc1.xml doc2.xml...docN.xml 
    /**
     * Constructor clase Uploads
     * @param args lista de argumentos
     */
    public Uploads(String[] args){
        this.args=args;
    }
    /**
     * Metodo principal de la clase Uploads encargado de subir los documentos xml a la base de datos
     * @throws Exception 
     */
    public void uploadDocuments() throws Exception 
    {
	String collection = this.args[0];
	//Eliminar �/db� si es especificado en la entrada
	if (collection.startsWith("/db")) 
        	collection = collection.substring(3);
	// Se inicializa el driver
	String driver = "org.exist.xmldb.DatabaseImpl";
	Class cl = Class.forName(driver);
	Database database = (Database) cl.newInstance();
	database.setProperty("create-database", "true");
	DatabaseManager.registerDatabase(database);
	//Se intenta acceder a la colecci�n espec�ficada como primer argumento
	Collection col =DatabaseManager.getCollection("xmldb:exist://localhost:8080/exist/xmlrpc/db" + collection, "admin", "eXist");
	if (col == null)
            {
            // Si la colecci�n especificada como primer argumento no existe, entonces se crea
            Collection root = DatabaseManager.getCollection("xmldb:exist://localhost:8080/exist/xmlrpc/db", "admin", "eXist");
            CollectionManagementService mgtService = (CollectionManagementService) root.getService("CollectionManagementService", "1.0");
            col = mgtService.createCollection(collection);
            }
	String file;
	File f;
        //De esta forma subimos tantos documentos xml como queramos
	for (int i = 1; i< this.args.length-1; i++)
	{
            file = this.args[i];
            f = new File(file);
            if(!f.canRead())
		System.err.println("No se pudo leer el archivo " + file);
            else{
                //Al ser \ un simbolo especial se hace el split asi :
		String []delimitador = args[i].split("\\\\");
		// Se crea un recurso XML para almacenar el documento
		XMLResource document = (XMLResource) col.createResource(delimitador[delimitador.length-1], "XMLResource");
		document.setContent(f);
		System.out.println(f.toString());
		System.out.println("Almacenando el archivo " + document.getId() + "...");
		col.storeResource(document);
		}
        }
	System.out.println("Almacenado correctamente");
    }//fin metodo uploadDocuments
}//fin clase

