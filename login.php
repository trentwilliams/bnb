<?php

include "checksession.php";
//checkUser();
//loginStatus(); 


//this line is for debugging purposes so that we can see the actual POST data
//echo "<pre>"; var_dump($_POST); echo "</pre>";





//echo "<pre>"; var_dump($_SESSION); echo "</pre>";
 
//simple logout
if (isset($_POST['logout'])) logout();
 
if (isset($_POST['login']) and !empty($_POST['login']) and ($_POST['login'] == 'Login')) {
    include "config.php"; //load in any variables
    $DBC = mysqli_connect(DBHOSTNAME, DBUSER, DBPASSWORD, DBDATABASE) or die();
 
//validate incoming data - only the first field is done for you in this example - rest is up to you to do
//firstname
    $error = 0; //clear our error flag
    $msg = 'Error: ';
    if (isset($_POST['email']) and !empty($_POST['email']) and is_string($_POST['email'])) {
       $un = htmlspecialchars(stripslashes(trim($_POST['email'])));  
       $email = (strlen($un)>32)?substr($un,1,32):$un; //check length and clip if too big       
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid email '; //append error message
       $email = '';  
    } 
                    
//password  - normally we avoid altering a password apart from whitespace on the ends   
       $password = trim($_POST['password']);        
       
//This should be done with prepared statements!!
    if ($error == 0) {
        $query = "SELECT customerID,password FROM bnb.customer WHERE email = '$email'"; //"SELECT memberID,password FROM member WHERE username = '$username'";
        $result = mysqli_query($DBC,$query);     
        if (mysqli_num_rows($result) == 1) { //found the user
            $row = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            mysqli_close($DBC); //close the connection once done
  //this line would be added to the registermember.php to make a password hash before storing it
  //$hash = password_hash($password); 
  //this line would be used if our user password was stored as a hashed password




           //if (password_verify($password, $row['password'])) {           
            if ($password === $row['password']) //using plaintext for demonstration only!            
              login($row['customerID'],$email);
        } echo "<h2>Login fail</h2>".PHP_EOL;   
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
}


  //%%%%%%%%%%%%%%%%%%%%%%%%%%
  //hader header header header
  include "header.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
?>
<h1>Login</h1>
<p>The resource you are trying to access requires you to be registered.<br />To register please email Trent - <a href="mailto:trent@evolve12.com?subject=I%20require%20a%20login&body=(before%20you%20send%20-%20try%20these%20%3A)%0Aemail%3A%20non%40et.ca%0Apassword%3A%20pw%0A%0AHi%20Trent%2C%20%0AI%20need%20a%20login%20for%20the%20website.">trent@evolve12.com</a></p>
<form method="POST" action="login.php">

  <p>
    <label for="email">Email: </label>
    <input type="text" id="email" name="email" maxlength="32"> 
  </p> 
  <p>
    <label for="password">Password: </label>
    <input type="password" id="password" name="password" maxlength="32"> 
  </p> 
  
   <input type="submit" name="login" value="Login">

 </form>
</body>
</html>