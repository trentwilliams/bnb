<!DOCTYPE HTML>
<html><head><title>Booking</title> </head>
<body>
    <?php

echo "<pre>";



// get id from url
$id = $_GET['id'];
var_dump($_GET);

// if no ID is passed, then this form will be used to add a new booking
// else it will be used to edit exisitng data.

if (empty($id) or !is_numeric($id)){
//invalid member
 echo "<h2>add new memebr</h2>"; //simple error feedback
 //exit;

}else{

    echo "edit one of them";
    echo $id;
}


include "config.php"; //load in any variables
$DBC = mysqli_connect(DBHOSTNAME, DBUSER, DBPASSWORD);
//$db_select = mysqli_select_db($DBC , DBDATABASE);
//echo DBUSER;
//echo DBPASSWORD;
//echo DBDATABASE;


//check if the connection was good
if (!$DBC) {
    echo "Error: Unable to connect to MySQL.\n". mysqli_connect_errno()."=".mysqli_connect_error() ;
    exit; //stop processing the page further
}

echo "Connectted via ".mysqli_get_host_info($DBC); //show some info on the connection


// show form

// here is my stuff that i added


//echo "\nstart\n";
///* Select queries return a resultset */
//if ($result = mysqli_query($DBC, "SELECT * FROM webpro.member")) {
//    printf("Select returned %d rows.\n", mysqli_num_rows($result));

//        /* free result set */
//    mysqli_free_result($result);
//}
//echo "\nend\n";

////prepare a query and send it to the server
////$query = 'SELECT memberId,firstName,lastName,email FROM member';
//$query = 'SELECT * FROM webpro.member';
//$result = mysqli_query($DBC,$query);


////$result2= mysqli_result($DBC, $result);

////echo mysqli_num_rows($result);
//if (mysqli_num_rows($result) == 0) {
//    echo "in here";
//    echo mysqli_num_rows($result);
//    }


////check result for data
//if (mysqli_num_rows($result) > 0) {
//    /* retrieve a row from the results
//    one at a time until no rows left in the result */
//    echo "Record count: ".mysqli_num_rows($result).PHP_EOL;
//    while ($row = mysqli_fetch_assoc($result)) {
//        echo "member ID ".$row['memberId'] . PHP_EOL;
//        echo "Firstname ".$row['firstName'] . PHP_EOL;
//        echo "Lastname ".$row['lastName'] . PHP_EOL;
//        echo "Email ".$row['email'] . PHP_EOL;
//        echo "<hr />";
//    }
//}


	echo "</pre>";








mysqli_close($DBC); //close the connection once done
    ?>
</body>
</html>