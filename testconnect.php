<!DOCTYPE HTML>
<html><head><title>MySQL examples</title> </head>
<body>
<?php

echo "<pre>";


include "config.php"; //load in any variables
$DBC = mysqli_connect(DBHOSTNAME, DBUSER , DBPASSWORD, DBDATABASE);
//$db_select = mysqli_select_db($DBC , DBDATABASE); 
//echo DBUSER; 
//echo DBPASSWORD;
//echo DBDATABASE;

//check if the connection was good
if (!$DBC) {
    echo "Error: Unable to connect to MySQL.\n". mysqli_connect_errno()."=".mysqli_connect_error() ;
    exit; //stop processing the page further
};
//insert DB code from here onwards
/* show a quick confirmation that we have a connection
   this can be removed - not required for normal activities
*/
	echo "Connectted via ".mysqli_get_host_info($DBC); //show some info on the connection 


echo "</pre>";







 
mysqli_close($DBC); //close the connection once done
?>
</body>
</html>

