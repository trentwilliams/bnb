<?php

include "header.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
include "checksession.php";
checkUser();
loginStatus(); 
?>


    <h1>Thank you</h1>

    <a href="bookingviewcurrent.php">Return to the booking listing</a>      <a href="index.php">Return to the main page</a>

    
    <p>THank you for your request</p>

<?php
echo '</div></div>';
require_once "footer.php";
?>