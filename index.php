
<?php

$hostname=gethostname();

if ($hostname=="Stradale"){
echo "running locally";
}else{
echo "running azure";
}

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
<h2>Assessment case study web applicaiton temporary launch page</h2>
<ul>
<li>
 <form method="POST" action="login.php" id="form" name="form">
    <input type="submit" name="logout" value="Logout"> 

</form>
</li>
<li><a href="bookingadd.php">Make a booking</a>
<li><a href="bookingviewcurrent.php">View current bookings</a>

</ul>
<p>Note: Edit a booking looks like how it was wanted, however I would use the same form for both add and edit, and it would recognise it was an edit if it were passed as ID</p>
<h2>Other</h2>
<ul>


<li><a href="privacy.php">Privacy policy</a>

</ul>

</body>
</html>
