<?php


    class DirIterator {

          private $directory;
          private $handler=NULL;

          public function __construct($directory) {
                 $this->dir = $directory;
          }

          public function fetch() {

                 if(!isset($this->handler)) {
                     $this->handler = dir($this->dir);
                 }

                 if(($entry=$this->handler->read()) !== false) {
                     return $entry; 
                 }  else {
                    $this->handler->close();
                    $this->handler = NULL;
                    return false;  
                 }               
          }

    }

    $director = new DirIterator(".");

    while(($file=$director->fetch()) !== false) {

           echo$file."<br/>";
    }


    class DirectIterator implements Iterator{

          private $directory;
          private $handler=NULL;

          public function __construct($directory) {
                 $this->dir = $directory;
          }

          public function __destruct() {
                 $this->handler->close();  
          }          

          public function rewind() {

                 $this->handler = dir($this->dir);
                 $this->k=0;
                 $this->readDir();

          }

          public function readDir() {

                 $this->valid = (($this->file = $this->handler->read()) !== false);
          }

          public function next() {
                 $this->k++; 
                 $this->readDir();
          }


          public function valid() {
                 return $this->valid;
          }


          public function key() {
                 return $this->k;
          }


          public function current() {
                 return $this->file;
          }
    }
    

    echo"<hr/>";

    $it = new DirectIterator(".");

    foreach($it as $file) {
        echo$file."<br/>"; 
    }  

    if(isset($_GET['show'])) {
       highlight_file($_SERVER[SCRIPT_FILENAME]);
    }

?>