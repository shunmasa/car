<?php
////////////////////////////////////
///connect mysql data base 
/////////////////////////////////////
require_once("new_config.php");


class Database{


public $connection;
 
function __construct(){

  $this->open_db_connection();

}

public function open_db_connection(){

//mysqli_connection  
$this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
// mysqli vs mysqli_connect [closed] stack overflow 
//new mysqli() oop style vs Procedural style mysqli_connction() 


//mysqli_connect_errno() errorconnection check
if($this->connection->connect_errno){
   //The die() function prints a message and exits the current script. 
   die("Database conenction failed badly". $this->connection->connect_error);
}//mysqli_connect_error — Returns a string description of the last connect error

}

public function query($sql){
//Perform queries against the database:
$result = $this->connection->query($sql);//mysqli->query() perform query
$this->confirm_query($result);
return $result;

}

private function confirm_query($result){

  if(!$result){

    die("Query Failed". $this->connection->error);
  }
}
//The mysqli_real_escape_string() function escapes special characters in a string for use in an SQL statement.
//escapestring	Required. The string to be escaped. Characters encoded are NUL (ASCII 0), \n, \r, \, ', ", and Control-Z.
//kind of sanitarize to prevent an illigal character before sending 
public function escape_string($string){

  $escaped_string = $this->connection->real_escape_string($string);
  return $escaped_string;

}

public function the_insert_id(){
  //mysqli::$insert_id -- mysqli_insert_id — Returns the auto increment id used in the latest query
  return mysqli_insert_id($this->connection);
}

}
$database = new Database();



?>