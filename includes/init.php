<?php
//operating system
//defined — Checks whether a given named constant exists
//define — Defines a named constant


defined('DS') ? null :define('DS',DIRECTORY_SEPARATOR);
//site root///Applications/XAMPP/xamppfiles/htdocs/galery 
define('SITE_ROOT', DS . 'Applications' . DS . 'XAMPP' . DS . 'xamppfiles'. DS .'htdocs'. DS .'galery');
//define 'SITE_ROOT' as ...application/xampp/....
defined('INCLUDES_PATH') ? null :define('INCLUDES_PATH',SITE_ROOT.DS . 'admin' . DS .'includes');




//apacth server will find the class from here , if not class is undefined 
//init to database path  all classes to use //require_once is more secure
require_once("new_config.php");
require_once("database.php");
require_once("db_object.php");
require_once("user.php");
require_once("photo.php");
require_once("functions.php");
require_once("session.php");

?>