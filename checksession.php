<?php
include "config.php"; //load in any variables
session_start();
        // echo HOSTURL;
//function to check if the user is logged else send to the login page 
function checkUser() {
    $_SESSION['URI'] = '';    
    if ($_SESSION['loggedin'] == 1)
       return TRUE;
    else {
       // echo HOSTURL;
       $_SESSION['URI'] = HOSTURL.$_SERVER['REQUEST_URI']; //save current url for redirect     
       header('Location: /login.php', true, 303);       
    }       
}
 
//just to show we are logged in
function loginStatus() {
    
    $debug=false;  // true to debug  false no

    if($debug)  
        {
        var_dump($_SESSION);
        if ($_SESSION['loggedin'] == 1)  
            {

            echo "<h2>Logged in as $un</h2>";
            }
        else
            {
            echo "<h2>Logged out</h2>";            
            }
        }
}
 
//log a user in
function login($id,$email) {
   //simple redirect if a user tries to access a page they have not logged in to
   if ($_SESSION['loggedin'] == 0 and !empty($_SESSION['URI']))        
        $uri = $_SESSION['URI'];          
   else { 
     $_SESSION['URI'] =  '/index.php';         
     $uri = $_SESSION['URI'];           
   }  
   
   $_SESSION['loggedin'] = 1;        
   $_SESSION['customerid'] = $id;   
   $_SESSION['email'] = $email; 
   $_SESSION['URI'] = ''; 
   header('Location: '.$uri, true, 303);        
}
 
//simple logout function
function logout(){
  $_SESSION['loggedin'] = 0;
  $_SESSION['customerid'] = -1;        
  $_SESSION['email'] = '';
  $_SESSION['URI'] = '';
  header('Location: /login.php', true, 303);    
}
?>