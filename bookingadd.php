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


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <script>

        // my listeners (date inputs and search button)
        $(function () {


            //set datepicker defaults for display calendar and date format
            $.datepicker.setDefaults({ dateFormat: "yy-mm-dd", numberOfMonths: [1, 2] });


            // checkin selected - set the min date for the checkout
            checkInDate = $("#checkin").datepicker()
                .on("change", function () {
                    checkOutdate.datepicker("option", "minDate", this.value);
                });


            // checkout selected - set the maxd ate for the checkin
            checkOutdate = $("#checkout").datepicker()
                .on("change", function () {
                    checkInDate.datepicker("option", "maxDate", this.value);
                });


            //click search - fire Ajax search
            $("#search").on("click", function () {
                SearchAvaliable(checkInDate.val(), checkOutdate.val());
            });


        });


        //perform ALAX request for data (as per search paramerets passed)
        function SearchAvaliable(searchStart, searchEnd) {

            // a bit of validation (shoudlnt' be needed in this example as woudl be done better)
            if (searchStart == "" || searchEnd == "") {
                $("#result").html("Please select the dates you wish to search for");
                return;
            }

            //create the http xml object and url
            var xmlhttp = new XMLHttpRequest();
            //var url = "data/bookings.json?ci=" + searchStart + "&co=" + searchEnd;
            var url = "bookingsearch.php?ci=" + searchStart + "&co=" + searchEnd;

            //request
            xmlhttp.open("GET", url, true);
            xmlhttp.send();

            // listen for successful (200)
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var myArr = JSON.parse(this.responseText);
                    console.log(this.responseText);
                    outPut(myArr);
                }
            };



        }
        //loop though array creating the outpuut string
        function outPut(arr) {
            var out="<label for='room'>Room (name, type, beds):</label>"
            out += "<select id='room' name='room' required>";
            out += "<option value=''>Select</option>";
            var i;
            for (i = 0; i < arr.length; i++) {

                //out += "roomId: " + arr[i].roomID + " roomName: " + arr[i].roomname + " roomType: " + arr[i].roomtype + " roomBeds: " + arr[i].beds + "<br>";
                out += "<option value=" + arr[i].roomID + ">" + arr[i].roomname + ", " + arr[i].roomtype + ", " + arr[i].beds + "</option >";
            }
            out += "</select>";
            // update result div on page
            $("#roomsavaliable").html(out);
        }






    </script>

    <?php

    //**********************************
    //THIS CREATES THE DB CONNECTION -used in post and load, so initaite on page load no matter what
    //**********************************
    include "config.php"; //load in any variables
    $DBC = mysqli_connect(DBHOSTNAME, DBUSER , DBPASSWORD, DBDATABASE);


    //this line is for debugging purposes so that we can see the actual POST data
    //echo "<pre>"; var_dump($_POST); echo "</pre>";

    //function to clean input but not validate type and content
    function cleanInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    //the data was sent using a form therefore we use the $_POST instead of $_GET
    //check if we are saving data first by checking if the submit button exists in the array
    if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Add')) {
    //if ($_SERVER["REQUEST_METHOD"] == "POST") { //alternative simpler POST test


        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
            exit; //stop processing the page further
        }

         //validation is done client side...
        //validate incoming data - only the first field is done for you in this example - rest is up to you to do
        //firstname
        $error = 0; //clear our error flag
        $msg = 'Error: ';
        //read the posted values
        $customerId=1;
        $roomId = cleanInput($_POST['room']);
        $checkin = cleanInput($_POST['checkin']);
        $checkout = cleanInput($_POST['checkout']);
        $contact = cleanInput($_POST['contact']);
        $extra= cleanInput($_POST['extra']);
        $review= "";



        //checking data before being saved to db
        include 'QuantumPHP.php';

        QuantumPHP::$MODE = 3; //mode = 3 for Chrome and Firefox
               
        QuantumPHP::add("customerid:". $_SESSION['customerid']);
        QuantumPHP::add("roomid:". $roomId);
        QuantumPHP::add("checkin:". $checkin);
        QuantumPHP::add("checkout:". $checkout);
        QuantumPHP::add("contact:". $contact);
        QuantumPHP::add("extra:". $extra);



        QuantumPHP::send();



        //add the booking
        if ($error == 0) {
            $query = "INSERT INTO bnb.booking (customerId, roomId,checkinDate,checkoutDate,contactNumber, bookingExtra,bookingReview) VALUES (?,?,?,?,?,?,?)";
            $stmt = mysqli_prepare($DBC,$query); //prepare the query
            mysqli_stmt_bind_param($stmt,'iisssss', $customerId,$roomId, $checkin,$checkout, $contact,$extra,$review);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<h2>Booking Recieved, You may make another booking below</h2>";
        } else {
            echo "<h2>$msg</h2>".PHP_EOL;
        }
        //mysqli_close($DBC); //close the connection once done
    }
    ?>










    <h1>Make a booking</h1>
    <a href="bookingviewcurrent.php">Return to the booking listing</a>
    <a href="index.php">Return to the main page</a>

    <h2>New booking for Trent Williams</h2>




    <form method="POST" action="bookingadd.php">

                <p>
            <label for="checkin">Checkin date:</label>
            <input type="text" id="checkin" name="checkin" minlength="10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required />
        </p>

        <p>
            <label for="checkout">Checkout date:</label>
            <input type="text" id="checkout" name="checkout" minlength=" 10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required />  <input type="button" id="search" value="View Avaliable Rooms" />
        </p>
            <p>
                  <div id="result"></div>  
        
        


    </p>

        <p>
            
            <div id="roomsavaliable"><label for="room">Select your dates and search to see avaliable rooms here</label><select required>";
            out += "<option value=''>Select</option></select></div>
        </p>


        <p>
            <label for="contact">Contact number:</label>
            <input type="text" id="contact" name="contact" minlength=" 10" maxlength="14" placeholder="(###) ### ####" pattern="\([0-9]{3}\) [0-9]{3} [0-9]{4}" required />
        </p>
        <p>
            <label for="extra">Booking extras:</label>
            <textarea id="extra" name="extra" rows="5" cols="25" maxlength="1000"></textarea>
        </p>
        <p>
            <input name="submit" type="submit" value="Add">
            <a href="index.php">cancel</a>
        </p>
    </form>




<?php
echo '</div></div>';
require_once "footer.php";
?>