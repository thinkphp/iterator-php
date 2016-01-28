<?php

    class Colors {

          private $_colors = array();

          public function __construct($arr) {
                 $this->_colors = $arr;
          }

          public function fetch() {
                 $color = each($this->_colors);

                 if($color) {
                    return $color['value'];
                 } else {
                   reset($this->_colors);
                   return false; 
                 }
          }
    }

    $arr = array("blue","red","green","orange","white");

    $obj = new Colors($arr);

    while(($c=$obj->fetch())!= false) {
           echo$c."<br/>"; 
    }

    class Colors2 implements Iterator {

          private $_colors = array();

          public function __construct($arr) {
                  $this->_colors = $arr;
                  $this->n = count($arr);
          }  

          public function rewind() {
               $this->start = 0;
          }

          public function valid() {
               return $this->start < $this->n;
          }

          public function next() {
               $this->start++;  
          }

          public function key() {
               return $this->start;
          }

          public function current() {
               return $this->_colors[$this->start];
          }
    }

    $obj2 = new Colors2($arr);

    foreach($obj2 as $c) {
            echo$c." ";   
    }

    class Colors3 implements Iterator {

          private $_colors = array();

          public function __construct($arr) {
                 $this->_colors = $arr;
          }  

          public function __destruct() {
                 reset($this->_colors);
          }

          public function rewind() {
                 $this->color = each($this->_colors);
          }

          public function valid() {
               return $this->color;
          }

          public function next() {
               $this->color = each($this->_colors);
          }

          public function key() {
               return $this->color['key'];
          }

          public function current() {
               return $this->color['value'];
          }
    }

    echo"<br>";

    $obj3 = new Colors3($arr);

    foreach($obj3 as $c) {
         echo$c."-";   
    }

    if(isset($_GET['show'])) {
       highlight_file($_SERVER[SCRIPT_FILENAME]);
    }
?>