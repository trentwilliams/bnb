<?php
include "checksession.php";
//checkUser();
//loginStatus(); 
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Current bookings</title>
</head>
<body>


    <?php
    //**********************************
    //THIS CREATES THE DB CONNECTION -used in post and load, so initaite on page load no matter what
    //**********************************
    include "config.php"; //load in any variables
    $DBC = mysqli_connect(DBHOSTNAME, DBUSER , DBPASSWORD, DBDATABASE);
    ?>

    <h1>Current bookings</h1>
    <a href="bookingadd.php">Make a booking</a>
    <a href="index.php">Return to the main page</a>

    <h2>below are all the current bookings</h2>


    <table>
        <tr>
            <th>Booking (room, dates)</th>
            <th>Customer</th>
            <th>Action</th>
        </tr>


        <?php

        //prepare a query and send it to the server
        $query = "SELECT b.bookingId, b.checkinDate, b.checkoutDate, r.roomname, ";
        $query .="CONCAT( c.firstname, ' ', lastname ) AS fullname FROM booking b ";
        $query .="INNER JOIN room r ON b.roomId = r.roomID ";
        $query .="INNER JOIN customer c ON b.customerId=c.customerID";
        $result = mysqli_query($DBC,$query);

        //check result for data
        if (mysqli_num_rows($result) > 0) {
            //loop through results
            echo "Total of ".mysqli_num_rows($result).PHP_EOL ." bookings";
            while ($row = mysqli_fetch_array($result)) {
                $bookingId=$row['bookingId'];
                echo "<tr><td>".$row['roomname'].", ".$row['checkinDate']." > ".$row['checkoutDate']."</td>";
                echo "<td>".$row['fullname']."</td>";
                echo "<td><a href='bookingdetail.php?bid=".$bookingId."'>view</a> <a href='bookingedit.php?bid=".$bookingId."'>edit</a> <a href='bookingaddreview.php?bid=".$bookingId."'>manage reviews</a> <a href='bookingdeleteconfirm.php?bid=".$bookingId."'>delete</a></td></tr>";
            }
        }
        mysqli_free_result($result);
        ?>


    </table>

</body>
</html>