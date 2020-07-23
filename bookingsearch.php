<?php
//Our member search/filtering engine
include "config.php"; //load in any variables


        //checking data serverside
        include "QuantumPHP.php";

        QuantumPHP::$MODE = 3; //mode = 3 for Chrome and Firefox


//$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE) or die();
    $DBC = mysqli_connect(DBHOSTNAME, DBUSER , DBPASSWORD, DBDATABASE);

//read checkin and checkout from GET URL
    $checkin= $_GET['ci'];
    $checkout= $_GET['co'];


    QuantumPHP::add("checkin:". $checkin);
    QuantumPHP::add("checkout:". $checkout);
    QuantumPHP::send();  

//do some simple validation to check if sq contains a string
//    //prepare a query and send it to the server using our search string as a wildcard on surname

$query ="SELECT * FROM room r WHERE r.roomId NOT IN (SELECT b.roomId FROM booking b ";
$query .="WHERE b.checkinDate BETWEEN  CAST('$checkin' AS DATETIME) AND CAST('$checkout' AS DATETIME) ";
$query .="OR b.checkoutDate BETWEEN CAST('$checkin' AS DATETIME) AND CAST('$checkout' AS DATETIME))";
//echo $query;
$stmt = mysqli_prepare($DBC,$query); //prepare the query


$result = mysqli_query($DBC,$query);


$rowcount = mysqli_num_rows($result);


//echo $rowcount;
//makes sure we have members
$mybookings= array();
if ($rowcount > 0)

{

    //JSON formatting
    while ($row = mysqli_fetch_assoc($result)) {
        $mybookings[] = $row;
        QuantumPHP::add("row:". implode(",",$row));

    }
            //cheking wiht quantum
            QuantumPHP::send();  

}
else
{

    //HTML FORMAT
    //echo "<tr><td colspan=3><h2>No members found!</h2></td></tr>";
}


mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done

echo json_encode($mybookings);
//echo  $searchresult;
?>