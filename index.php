<?php
include "checksession.php";
//checkUser();
//loginStatus(); 

include "header.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
phpinfo()

?>
<!DOCTYPE html>
<html>
<head>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
<body>
<h1>Ongaonga B & B</h1>
<p>Welcome to Ongaonga BNB, the best BNB in the land!</p>
<p>This is a case study website, to see the work completed please log in.</p>
    <p>Thanks and have a nice date, Trent</p>
<ul>
<li>

</li>
<li><a href="bookingadd.php">Make a booking</a>
<li><a href="bookingviewcurrent.php">View current bookings</a>

</ul>

<p>Note: the edit booking page is designed as requested.  The add booking page has been modified, this makea it easier for a person to book only rooms avaliable for their choosen date range. Ideally only one page woudl be created and it woudl handle adds and edits.</p>

<h2>Other</h2>
<ul>


<li><a href="privacy.php">Privacy policy</a>

</ul>

</body>
</html>
<?php
echo '</div></div>';
require_once "footer.php";
?>
