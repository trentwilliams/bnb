<?php

include "checksession.php";
checkUser();
loginStatus(); 

include "header.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
?>



    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
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


            // search from selected- set the min date for the search to
            searchFromDate = $("#search_from").datepicker()
                .on("change", function () {
                    searchToDate.datepicker("option", "minDate", this.value);
                });


            // search to selected - set the max date for the search from
            searchToDate = $("#search_to").datepicker()
                .on("change", function () {
                    searchFromDate.datepicker("option", "maxDate", this.value);
                });


            //click search - fire Ajax search
            $("#search").on("click", function () {
                SearchAvaliable(searchFromDate.val(), searchToDate.val());
            });


        });


        //perform ALAX request for data (as per search paramerets passed)
        //in real this woudl only return the filtered results, in this case we are not doing any filtering, (as it woudl be done server side))
        function SearchAvaliable(searchStart, searchEnd) {

            // a bit of validation (shoudlnt' be needed in this example as woudl be done better)
            if (searchStart == "" || searchEnd == "") {
                $("#result").html("");
                return;
            }

            //create the http xml object and url
            var xmlhttp = new XMLHttpRequest();
            var url = "data/bookings.json?ci=" + searchStart + "&co=" + searchEnd;


            //request
            xmlhttp.open("GET", url, true);
            xmlhttp.send();

            // listen for successful (200)
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var myArr = JSON.parse(this.responseText);
                    outPut(myArr);
                }
            };



        }
        //loop though array creating the outpuut string
        function outPut(arr) {
            var out = ""
            var i;
            for (i = 0; i < arr.length; i++) {
                out += 'Checkin: "' + arr[i].checkIn + '" Checkout: "' + arr[i].checkOut + '" Room Number: "' + arr[i].roomNum + '" Room Name: "' + arr[i].roomName + '<br>';
            }

            // update result div on page
            $("#result").html(out);
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
    $bid = $_GET['bid'];
    //var_dump($_GET);
    //function to clean input but not validate type and content
    function cleanInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }


    //check if we are saving data first by checking if the submit button exists in the array
    if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {



        if (mysqli_connect_errno()) {
            echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
            exit; //stop processing the page further
        }

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

        //update the booking record
        if ($error == 0) {
            $query = "UPDATE bnb.booking SET roomId=?, checkinDate=?,checkoutDate=?,contactNumber=?, bookingExtra=?   WHERE bookingId=?";
            $stmt = mysqli_prepare($DBC,$query); //prepare the query
            mysqli_stmt_bind_param($stmt,'issssi',$roomId,$checkin,$checkout,$contact, $extra,$bid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "<h2>Booking Updated You may make another change below</h2>";
        } else {
            echo "<h2>$msg</h2>".PHP_EOL;
        }

    }

        // are read from DB, but coudl also just reuse them if it's a post save the server task... but good to show that is hase change
        //read vales from DBbased on the ID bid and we will insert them into the text boxes

        //prepare a query and send it to the server
        $query = "SELECT * FROM booking  ";
        $query .="WHERE bookingId= ". $bid;
        $query.= " LIMIT 1";

        $result = mysqli_query($DBC,$query);


        //check result for data
        if (mysqli_num_rows($result) > 0) {
            /* retrieve a row from the results
            one at a time until no rows left in the result */
           // echo "Record count: ".mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
                $roomId=$row['roomId'];
                $checkin=$row['checkinDate'];
                $checkout=$row['checkoutDate'];
                $contactNumber =$row['contactNumber'];
                $bookingExtra =$row['bookingExtra'];


                //echo "<hr />";
            
            mysqli_free_result($result);
        }


        ?>











    <h1>Edit booking</h1>
    <a href="bookingviewcurrent.php">return to the Bookings listing</a>      <a href="index.php">Return to the main page</a>

    <h2>Edit the booking for Trent Williams</h2>

    <form method="POST" action="bookingedit.php?bid=<?php echo $bid; ?>">
        <p>
            <label for="room">Room (name, type, beds):</label>
            <select id="room" name="room">
                                <?php

                                //prepare a query and send it to the server
                                $query = "SELECT roomID, roomname, roomtype, beds  FROM bnb.room";
                                $result = mysqli_query($DBC,$query);

                                //check result for data
                                if (mysqli_num_rows($result) > 0) {
                                    //loop through results
                                    //echo "Record count: ".mysqli_num_rows($result).PHP_EOL;
                                    while ($row = mysqli_fetch_array($result)) {



                                        // this is the looping that uses a select
                                        if ($roomId == $row['roomID'])
                                            {
                                                $selected = 'selected="selected"';
                                            }
                                            else
                                            {
                                                $selected = '';
                                            }
                                            //echo('<option value="'.$row['id'].' '.$selected.'">'.$row['username'].' ('.$row['fname'].' '.substr($row['lname'],0,1).'.)</option>');
                                            echo "<option value='" . $row['roomID'] ."' ". $selected." '>" . $row['roomname'] . ", " . $row['roomtype'] .", " .$row['beds'] . "</option>";




                                    }
                                }


                                mysqli_free_result($result);
                                ?>

                <option value="room1">Room 1, D, 1</option>
                <option value="room4">Room 2, D, 2</option>
                <option value="room2">Room 3, S, 1</option>
                <option value="room3">Room 4, S, 2</option>
            </select>
        </p>
        <p>
            <label for="checkin">Checkin date:</label>
            <input type="text" id="checkin" name="checkin" minlength="10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required value="<?php echo $checkin; ?>"/>
        </p>
        <p>
            <label for="checkout">Checkout date:</label>
            <input type="text" id="checkout" name="checkout" minlength="10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required value="<?php echo $checkout; ?>"/>
        </p>

        <p>
            <label for="contact">Contact number:</label>
            <input type="text" id="contact" name="contact" minlength="10" maxlength="14" placeholder="(###) ### ####" pattern="\([0-9]{3}\) [0-9]{3} [0-9]{4}" required value="<?php echo $contactNumber; ?>"/>
        </p>
        <p>
            <label for="extra">Booking extras:</label>
            <textarea id="extra" name="extra" rows="5" cols="25" maxlength="1000"><?php echo $bookingExtra; ?></textarea>
        </p>
                     <!--<p>
            <label for="review">Booking review:</label>
            <textarea id="review" rows="5" cols="25" maxlength="1000">this was a great place to stay!  :)</textarea>
        </p>-->
        <p>
            <input name="submit" type="submit" value="Update">            <a href="index.php">cancel</a>
        </p>
    </form>


<?php
echo '</div></div>';
require_once "footer.php";
?>