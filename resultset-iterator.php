<?php

    //MySQL Result Set Class Definition

    class MySQLResultSet implements Iterator {
     
          const DATA_OBJECT            = 1; 
          const DATA_NUMERIC_ARRAY     = 2; 
          const DATA_ASSOCIATIVE_ARRAY = 3; 
          const DATA_ARRAY             = 4; 

          public function __construct($sql,$type,$link=false) {

                 if($link) {
                    $this->result = mysql_query($sql,$link);
                 } else {
                    $this->result = mysql_query($sql);
                 } 

                 if(!$this->result) {
                     throw new Exception(mysql_error());
                 }  

                 if(!is_resource($this->result) || get_resource_type($this->result) != 'mysql result') {
                     throw new Exception("Query does not return a mysql result resource.");                       
                 }

                 $this->num_rows = mysql_num_rows($this->result);

                 if($this->num_rows == 0) {
                    throw new Exception("Number of rows == 0");
                 }

                 $this->type = $type;
                 $this->query = $sql;
          }

          public function fetch() {

             if($this->num_rows > 0) {

                 switch($this->type) {

                    case MySQLResultSet::DATA_NUMERIC_ARRAY:
                    $func = 'mysql_fetch_row';
                    break;

                    case MySQLResultSet::DATA_ARRAY:
                    $func = 'mysql_fetch_array';
                    break;


                    case MySQLResultSet::DATA_ASSOCIATIVE_ARRAY:
                    $func = 'mysql_fetch_assoc';
                    break;
 
                    default:
                    $func = 'mysql_fetch_object';
                    break;
 
                 } 

                 $this->row = $func($this->result); 
                 $this->index++;
              }
          }

          public function rewind() {

              if($this->num_rows > 0) { 

                 mysql_data_seek($this->result,0);
                 $this->index=-1;
                 $this->fetch();
              }
          }

          public function next() {
                $this->fetch();
          }

          public function valid() {

                 if(false !== $this->row) {
                    return true;
                 } 
            return false;
          }

          public function key() {
                 return $this->index; 
          }

          public function current(){ 
                 return $this->row; 
          }

    }


    interface Database {

         public function connect($local,$user,$pass,$database);
         public function query($sql);
         public function fetch();           
         public function iterate($sql,$type='');
         public function close();           
           
    } 


    class MySQL implements Database {

          public function __construct() {

          }      

          public function connect($local,$user,$pass,$database) {
                 $this->db = mysql_connect($local,$user,$pass) or die("cannot connect to database");
                 mysql_select_db($database,$this->db) or die("cannot select database"); 
          }

          public function query($sql) {
                 $this->result = mysql_query($sql);
          }

          public function fetch() {
            $arr = array(); 
                 while($row=mysql_fetch_assoc($this->result)) {
                       $arr[] = $row;
                 }
            return $arr;
          }

          public function iterate($sql,$data_type=MySQLResultSet::DATA_OBJECT) {

                 return new MySQLResultSet($sql, $data_type, $this->db); 
          }

          public function close() {
                 mysql_close($this->db);
          }
    } 

    $obj = new MySQL();

    $obj->connect("localhost","root","","blogtastic");

    try{  
       foreach($obj->iterate("SELECT * from person",1) as $row) {
              echo$row->codep.'-'.$row->name.'-'.$row->phone1.'<br/>'; 
       }
    }catch(Exception $ex) {echo$ex->getMessage();}
     
?>