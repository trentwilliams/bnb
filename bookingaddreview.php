<?php
include "checksession.php";
checkUser();
loginStatus(); 
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Booking details</title>
</head>
<body>

    <?php
    //this line is for debugging purposes so that we can see the actual POST data
    $bid = $_GET['bid'];
    //var_dump($_GET);

    //**********************************
    //THIS CREATES THE DB CONNECTION -used in post and load, so initaite on page load no matter what
    //**********************************
    include "config.php"; //load in any variables
    $DBC = mysqli_connect(DBHOSTNAME, DBUSER , DBPASSWORD, DBDATABASE);

    $bid = $_GET['bid'];

    //function to clean input but not validate type and content
    function cleanInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    //check if we are saving data first by checking if the submit button exists in the array
    if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Add')) {



        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
            exit; //stop processing the page further
        }

        $error = 0; //clear our error flag
        $msg = 'Error: ';
        //read the posted values
        $review= cleanInput($_POST['review']);

        //update booking review
        if ($error == 0) {
            $query = "UPDATE bnb.booking SET bookingReview=?   WHERE bookingId=?";
            $stmt = mysqli_prepare($DBC,$query); //prepare the query
            mysqli_stmt_bind_param($stmt,'si',$review,$bid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<h2>Your Review has been saved</h2>";
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
        $contactNumber =$row['contactNumber'];
        $bookingExtra =$row['bookingExtra'];
        $bookingReview =$row['bookingReview'];
        $fullname=$row['fullname'];

        //echo "<hr />";

        mysqli_free_result($result);
    }


    ?>



    <h1>Booking details</h1>
    <a href="bookingviewcurrent.php">Return to the booking listing</a>
    <a href="index.php">Return to the main page</a>

    <h2>
        Booking for <?php echo $fullname; ?>
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

    <p>
        <label for="contact">Contact number:</label>
        <br />
        <?php echo $contactNumber; ?>
    </p>
    <p>
        <label for="extra">Booking extras:</label>
        <br />
        <?php echo $bookingExtra; ?>
    </p>

    <form method="POST" action="bookingaddreview.php?bid=<?php echo $bid; ?>">
        <p>
            <label for="review">Booking review:</label>
            <textarea id="review" name="review" rows="5" cols="25" maxlength="1000">
                <?php echo $bookingReview; ?>
            </textarea>
        </p>
        <p>
            <input type="submit" name="submit" value="Add" />
            <a href="index.php">cancel</a>
        </p>
    </form>

</body>
</html>
