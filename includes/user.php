<?php
////////////////////////////////////////
////verify the User password and username
////////////////////////////////////////////
//ABSTRUCTION protected db_table = "users" use db_table with self:: insted of users everytime
class User extends Db_object{
  protected static $db_table = "users";
  protected static $db_table_fields = array('username','password','first_name','last_name');
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;


public static function verify_user($username,$password){
global $database;
 
$username = $database->escape_string($username);
$password = $database->escape_string($password);
// .= concatinate make a query 
$sql = "SELECT * FROM ".self::$db_table." WHERE ";
$sql .= "username = '{$username}' ";
$sql .= "AND password = '{$password}' ";
$sql .= "LIMIT 1 ";
///send query
$the_result_array = self::find_by_query($sql);
return !empty($the_result_array) ? array_shift($the_result_array):false;

}




//////////////////////////////////////////////////////////////////////////
// ARRAY ... of course as database array needs a key(ex name )and value(name)
//////////////////////////////////////////////////////////////////////////
///What is the main reason of using mysqli_affected_rows(); function like this:
///return (mysqli_affected_rows($database->connection) == 1) ? true : false;
///- We are using it in order to check whether the row is affected or not , and if it is we will return TRUE or if it is not we will return FALSE thanks to that ternary operator that we are using.
///Why are we defining a LIMIT 1 on the query?
///- It is used as a precaution measure and is generally a good practice to always put LIMIT 1 just to be sure that we won't delete more than one record, even though the ids are unique, it's a matter of the best practice.
/////////////////////////////////////////////////////////////////////////
//1 create all object                                                  //
//2 create func has_the_attribute to evaluate key has an objects from 1 //
//3 use has_the_attribute use foreach                                    //
//4 put all elaluated value in the array                                 //
///////////////////////////////////////////////////////////////////////////

}
/////////////////////////////////////////////////////////////////////////
//// use Global to take a class 
//////////////////////////////////////////////////////////////////////////
//beter way to use static method more than instantiate New if access class///
//////////////////////////////////////////////////////////////////////////

?>

