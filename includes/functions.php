<?php


function classAutoLoader($class){
//Convert all characters to lowercase: string to lowercase
$class = strtolower($class);
$the_path = "includes/{$class}.php";//path
//is_file — Tells whether the filename is a regular file
//class_exists — Checks if the class has been defined
if(is_file($the_path) && !class_exists($class)){
   include $the_path;


 }else{
  die("This file name {$class}.php was not found");
 }



spl_autoload_regiser('classAutoLoder');

}


?>