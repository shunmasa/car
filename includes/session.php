
<?php
////////////////////////////////////
////Session store the data in the array 
///and use stored data check login and out 
///////////////////////////////////


class Session {
  private $signed_in = false;
  public $user_id;
  public $message;
//session_start() automatically run
function __construct(){
//session_start()
//creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
session_start();
$this->check_the_login();
$this->check_message();
}

//Session variables are stored in associative array called $_SESSION[]. These variables can be accessed during lifetime of a session.
public function message($msg=""){

  if(!empty($msg)){
   
     $_SESSION['message'] = $msg;

  }else{
     return $this->message;
  }

}
//isset()— Determine if a variable is declared and is different than NULL
private function check_message(){
  if(isset($_SESSION['message'])){

    $this->message = $_SESSION['message'];
    unset($_SESSION['message']);
  }else{
    $this->message= "";
  }
}



public function is_signed_in() {
  return $this->signed_in;
}

public function login($user){
  //_SESSION['user_id]; has already stored id ....expects id 
  if($user){
     $this->user_id = $_SESSION['user_id'] = $user->id;
     $this->signed_in = true;
   }
}

public function logout()
{
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->signed_in = false;
}


  //$_SESSION -- $HTTP_SESSION_VARS [deprecated] — Session variables
  private function check_the_login(){
    if(isset($_SESSION['user_id'])){
      $this->user_id = $_SESSION['user_id'];
       $this->signed_in = true;
    
    }else{
      unset($this->user_id);
      $this->signed_in = false;
    }

  }


}

$session = new Session();

?>