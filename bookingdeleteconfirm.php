<?php
include "checksession.php";
checkUser();
loginStatus(); 

include "header.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';


    //this line is for debugging purposes so that we can see the actual POST data
    $bid = $_GET['bid'];
    //var_dump($_GET);

    //**********************************
    //THIS CREATES THE DB CONNECTION -used in post and load, so initaite on page load no matter what
    //**********************************
    include "config.php"; //load in any variables
    $DBC = mysqli_connect(DBHOSTNAME, DBUSER , DBPASSWORD, DBDATABASE);


    $bid = $_GET['bid'];

    //cehck it's a deleted post back
    if(isset($_GET['del']))
    {
    $deleted= $_GET['del'];
    }else
    {$deleted=0;}
    

    //function to clean input but not validate type and content
    function cleanInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    //check if we are saving data first by checking if the submit button exists in the array
    if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Delete')) {

        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
            exit; //stop processing the page further
        }

        $error = 0; //clear our error flag
        $msg = 'Error: ';


        //delete the record
        if ($error == 0) {
            $query = "DELETE FROM bnb.booking WHERE bookingId=?";
            $stmt = mysqli_prepare($DBC,$query); //prepare the query
            mysqli_stmt_bind_param($stmt,'i',$bid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
        } else {
            echo "<h2>$msg</h2>".PHP_EOL;
        }

    }



    //read vales from DBbased on the ID bid and we will display them

    //prepare a query and send it to the server
    $query = "SELECT b.bookingId, b.checkinDate, b.checkoutDate,b.contactNumber, b.bookingExtra, b.bookingReview, ";
    $query .=" CONCAT(r.roomname, ', ' , r.roomtype, ', ' , r.beds) AS roomNameDetail, " ;
    $query .=" CONCAT( c.firstname, ' ' , c.lastname ) AS fullname  FROM booking b " ;
    $query .=" INNER JOIN room r ON b.roomId = r.roomID ";
    $query .=" INNER JOIN customer c ON b.customerId=c.customerID ";
    $query .=" WHERE bookingId=". $bid;
    $query.= " LIMIT 1";

    //var_dump($query);

    $result = mysqli_query($DBC,$query);


    //check result for data
    if (mysqli_num_rows($result) > 0) {
        /* retrieve a row from the results
        one at a time until no rows left in the result */
        //echo "Record count: ".mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $roomNameDetail=$row['roomNameDetail'];
        $checkin=$row['checkinDate'];
        $checkout=$row['checkoutDate'];
        $fullname=$row['fullname'];

        //echo "<hr />";

        mysqli_free_result($result);
    }


    if ($deleted==1){
    ?>
    <h1>Booking deleted</h1>
    <a href="bookingviewcurrent.php">Return to the booking listing</a>
    <a href="index.php">Return to the main page</a>

    <h2>
        Your booking has been deleted
    </h2>

    <?php

    }
    else
    {
    ?>
    <h1>Confirm booking delete</h1>
    <a href="bookingviewcurrent.php">Return to the booking listing</a>
    <a href="index.php">Return to the main page</a>

    <h2>
        Please confirm you wish to delete this booking for <?php echo $fullname; ?>
    </h2>

    <p>
        <label for="room">Room (name, type, beds):</label>
        <br />
        <?php echo $roomNameDetail; ?>
    </p>
    <p>
        <label for="checkin">Checkin date:</label>
        <br />
        <?php echo $checkin; ?>
    </p>
    <p>
        <label for="checkout">Checkout date:</label>
        <br />
        <?php echo $checkout; ?>
    </p>
    <form method="POST" action="bookingdeleteconfirm.php?bid=<?php echo $bid; ?>&del=1">
        <p>
            <input type="submit" name="submit" value="Delete" />
            <a href="bookingviewcurrent.php">cancel</a>
        </p>
    </form>

    <?php
    }
    ?>



<?php
echo '</div></div>';
require_once "footer.php";
?>