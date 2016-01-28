<?php
    /**
     *  @author     : Adrian Statescu 2011
     *  @package    : Design Pattern
     *  @description: File Iterator
     */

    class FileIterator {

          private $directory;
          private $fp=NULL;

          public function __construct($filename) {
                 $this->filename = $filename;
          }

          public function fetch() {

                 if(!isset($this->fp)) {
                     $this->fp = fopen($this->filename,"r");
                 }

                 if(!feof($this->fp)) {

                   return ($line = fgets($this->fp,4096));

                 } else {

                   fclose($this->fp);
                   $this->fp = NULL;
                   return false;
                 }
               
          }

    }

    $file = new FileIterator("colors-iterator.php");

    while(($line=$file->fetch()) !== false) {

           //echo$line."<br/>"; 
    }


    class FileIterator2 implements Iterator{

          private $filename;
          private $fp=NULL;

          public function __construct($file) {

                 $this->filename = $file;

          }

          public function __destruct() {
                 fclose($this->fp); 
          }          

          public function rewind() {
                 if(file_exists($this->filename)) {
                    $this->fp = fopen($this->filename,"r");
                 }
                 $this->k = 0;
          }


          public function next() {
                 $this->k++;                 
          }


          public function valid() {
                 return !feof($this->fp);
          }


          public function key() {
                 return $this->k;
          }


          public function current() {
                 return fgets($this->fp, 4096);
          }
    }
    
    $file = new FileIterator2("colors-iterator.php");
    foreach($file as $f) {
         echo$f."<br/>";  
    }  

    if(isset($_GET['show'])) {
       highlight_file($_SERVER[SCRIPT_FILENAME]);
    }

?>