/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package giw;

import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author usuario_local
 */
public class Main {
    
    public static void main(String [] args){
      
        try {
            Uploads subirDoc = new Uploads(args); 
            subirDoc.uploadDocuments();
            Query consulta = new Query(args[args.length-1],5);
            consulta.consultas();
        } catch (Exception ex) {
            Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    }
    
    
}
