<?php
/*
 * @author: Héctor Valentín Úbeda
 */

abstract class DBModel {

    private static $db_host = "localhost";
    private static $db_user = "dwes";
    private static $db_pass = "abc123.";
    private static $db_name = "stockdroid";
    private static $conn;

    private function open_connection() {
        include "adodb5/adodb.inc.php";
        $db=NewADOConnection("mysql");
        $db->Connect(
            self::$db_host,
            self::$db_user,
            self::$db_pass,
            self::$db_name);
        $db->EXECUTE("set names 'utf8'"); 
        
        self::$conn = $db;
    }
    
    /**
     * 
     * @param string $query
     * @return array
     */
     public function get_results_from_query($query) {
        if (self::$conn == null) {
            $this->open_connection();            
        }
       
        $result = self::$conn->Execute($query);
        $rows = array();
       
        while (!($result->EOF)){
            $rows[]=$result->fields;
            $result->MoveNext();
        }
       
        return $rows;
    }

  /**
   * 
   * @param string $query
   * @return boolean
   */
    public function execute_single_query($query) {
        if (self::$conn == null) {
            $this->open_connection();            
        }
        return self::$conn->Execute($query);
    }

  
   

}
