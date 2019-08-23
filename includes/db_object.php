<?php

//Late Static Bindings' usage ¶
//Late static bindings tries to solve that limitation by introducing a keyword that references the class that was initially called at runtime. Basically, a keyword that would allow you to reference B from 
//in the previous example. It was decided not to introduce a new keyword but rather use static that was already reserved.
//when inherit can not use instantiation from parent class 
//as solution , use "LATE STATIC BUINDING" or after instantiate .then this-> because subclass does not have static
//self::find_this_query()....this->find_this_query also work but not reacistic
//or better way static::find_this_query 
//this is because since after abstruction every class has slfe instantiation 
//but better way to replace all self to static ..define public static $db_table = "user" and then replace static 


class Db_object {
  protected static $db_table = "users";

  public static function find_all(){
    
  
  return static::find_by_query("SELECT * FROM ". static::$db_table ." ");
  
  }
 

  public static function find_by_id($id){
     //can access to database class global database = new Database
  global $database;//array
  $the_result_array = static::find_by_query("SELECT * FROM ".static::$db_table ." WHERE id = $id LIMIT 1" );

  return !empty($the_result_array) ? array_shift($the_result_array):false;
  //pull first index
  
  }


  public static function find_by_query($sql){
    global $database;
    $result_set = $database->query($sql);
    //empty array and fetch all result from sql to row (key) to method instantiation
    $the_object_array = array();
    while($row = mysqli_fetch_array($result_set)){
      $the_object_array[] = static::instantation($row);
    }
    return $the_object_array;

  }
    public static function instantation($the_record){
  
      //get_called_class — The "Late Static Binding" class name from sub class
      $calling_class = get_called_class();
      $the_object = new $calling_class;
    //loop through array and assign the value in foreach
  
      foreach($the_record as $the_attribute => $value){
        if($the_object->has_the_attribute($the_attribute)){
          $the_object->$the_attribute = $value;
        }
      }
    // $the_object->id = $found_user['id'];
      // $the_object->username = $found_user['username'];
      // $the_object->password = $found_user['password'];
      // $the_object->first_name = $found_user['first_name'];
      // $the_object->last_name = $found_user['last_name'];
       
      return $the_object;
    }
    


    private function has_the_attribute($the_attribute){
    
     $object_properties= get_object_vars($this);
      //array_key_exists — Checks if the given key or index exists in the array
     //2 param one objects and where 
      return array_key_exists($the_attribute,$object_properties);
      
    }

//ABSTRUCTION METHOD
protected function properties(){
  //get_object_vars — Gets the properties of the given object
  //var_dump(get_object_vars($this));
  //  return get_object_vars($this);
  
$properties = array();
//property_exists — Checks if the object or class has a property
foreach(static::$db_table_fields as $db_field){
    if(property_exists($this,$db_field)){
       $properties[$db_field] = $this->$db_field;
    }
}
return $properties;
}




//property()needs key and value in the array so clean_properties () create them 
protected function clean_properties() {
  global $database;
  $clean_properties = array();

  foreach ($this->properties() as $key => $value) {
    
    $clean_properties[$key] = $database->escape_string($value);


  }

  return $clean_properties ;






}

    public function save(){
      //isset — Determine if a variable is declared and is different than NULL
      return isset($this->id) ? $this->update() : $this->create();
      
      
      }
      
      
      
      public function create(){
      global $database;
      
      $properties = $this->clean_properties();
      //impload() implode — Join array elements with a string,first parameter "," divide the objects in array
      //pull out keys in the array  key is value can use value as keys ..array_keys — Return all the keys or a subset of the keys of an array
      // it was $sql = "INSERT INTO users (username,password,firstname,lastname)";
      
      $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
      $sql .= "VALUES ('". implode("','", array_values($properties)) ."')";
      //pull properties as values array_values wrapp '' single quote 
      //pull id as objects
      if($database->query($sql)) {

        $this->id = $database->the_insert_id();
  
        return true;
  
      } else {
  
        return false;
  
  
      }


      }//Create Method
      public function update(){
      global $database;
      //if integer need '' single quote but id is not string so do not need it 
      //set the username = the username we expect to get
      //why escape_string ..In HTML code sometime,system can not recognize the bugging word 
      //so escape_string can escape from such a situation when facing. 
      //foreach($properties as $key =>$value)impload , array_keys ...now value turns to keys ..
      //arrays_values ....put values in values ..
      //now array looks like {kyes => value}like {"username="."this->username"}<---{keys(username).vlaue(this->username)}
      
      //it was $sql = "username='" . $dtabase->escape_string($this->username).'",";--->(username,firstname,lastname,id)
      //value charactor or string '' wrap with single quote 'masa'
      
      $properties = $this->clean_properties();

      $properties_pairs = array();
  
      foreach ($properties as $key => $value) {
        $properties_pairs[] = "{$key}='{$value}'";
      }
  
      $sql = "UPDATE  " .static::$db_table . " SET ";
      $sql .= implode(", ", $properties_pairs);
      $sql .= " WHERE id= " . $database->escape_string($this->id);
  
      $database->query($sql);
      //database->conneciton ..datbase class ..connect database 
      //mysqli_affected_rows — Gets the number of affected rows in a previous MySQL operation
      //if affected rows in previous operation is 1 
      
      return (mysqli_affected_rows($database->connection) == 1) ? true : false;
      
      }
      
      

      public function delete(){
         global $database;
      //only delete id .. LIMIT 1 why 1 for the porpose of sequrity
      //last " " is just space between WHERE as message 
         $sql = "DELETE FROM " .static::$db_table ." ";
         $sql .= " WHERE id=" . $database->escape_string($this->id);
         $sql .= " LIMIT 1 ";
      //always space 
         $database->query($sql);
         return (mysqli_affected_rows($database->connection) == 1) ? true : false;
      
      }
  
//////////////////////////////////
//What is the difference between new self and new static?
//self refers to the same class in which the new keyword is actually written
//static, in PHP 5.3's late static bindings, refers to whatever class in the hierarchy
// you called the method on.
//{key:value}...{name:masa}
/////////////////////////////////////
}




?>