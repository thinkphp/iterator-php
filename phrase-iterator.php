<?php

    $str = "Nu indraznim nu pentru ca e greu, e greu pentru ca nu indraznim";

    //step 1
    class Phrase {
          public $arr;
 
          public function __construct($str) {
                 $this->arr = explode(" ",$str);
                 $n = count($this->arr);
          }

          public function fetch() {
                 $val = each($this->arr);
                 if($val) {
                   return $val['value'];
                 } else {
                   reset($this->arr);
                   return false;  
                 }
          }
    }

    //variant 1
    $ob = new Phrase($str);
    echo"<ul>";
    while(($word=$ob->fetch()) !== false) {
           echo"<li>".$word."</li>"; 
    } 
    echo"</ul>";

    //step 2
    class Phrase2 implements Iterator {

          public $arr;

          public function __construct($str) {

                 $this->arr = explode(" ",$str);
                 $this->n = count($this->arr);
          }
 
          public function rewind() {
                 $this->k = 0;
                 
          }

          public function valid() {
                 return $this->k < $this->n; 
          }

          public function current() {
                 return $this->arr[$this->k]; 
          }

          public function key() {
                 return $this->k;
          }

          public function next() {
                 $this->k++;
          }
    }

    $str2 = "Nu-ti fie teama ca inaintezi prea incet, teme-te daca stagnezi";
    $obj = new Phrase2($str2);
    echo"<ul>"; 
    foreach($obj as $word) {
       echo"<li>".$word."</li>";
    }
    echo"</ul>";

    if(isset($_GET['show'])) {
       highlight_file($_SERVER[SCRIPT_FILENAME]);
    }
?>