<!DOCTYPE HTML>
<html>
<head>
    <title>Make a booking</title>


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
                $("#result").html("Please select the dates you wish to search for");
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
</head>
<body>

    <?php

    //**********************************
    //THIS CREATES THE DB CONNECTION
    //**********************************
    include "config.php"; //load in any variables
    $DBC = mysqli_connect(DBHOSTNAME, DBUSER , DBPASSWORD, DBDATABASE);




    ?>




    <h1>Make a booking</h1>
    <a href="bookingviewcurrent.html">Return to the booking listing</a>
    <a href="index.html">Return to the main page</a>

    <h2>New booking for Trent Williams</h2>


    <div id="result"></div>

    <form method="POST" action="bookingdone.html">
        <p>
            <label for="room">Room (name, type, beds):</label>
            <select id="room">

                <?php

                //prepare a query and send it to the server
                $query = "SELECT roomID, roomname, roomtype, beds  FROM bnb.room";
                $result = mysqli_query($DBC,$query);

                //check result for data
                if (mysqli_num_rows($result) > 0) {
                    //loop through results
                    echo "Record count: ".mysqli_num_rows($result).PHP_EOL;
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['roomID'] . "'>" . $row['roomname'] . ", " . $row['roomtype'] .", " .$row['beds'] . "</option>";
                    }
                }


                mysqli_free_result($result);
                ?>

            </select>
        </p>
        <p>
            <label for="checkin">Checkin date:</label>
            <input type="text" id="checkin" minlength="10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required />
        </p>

        <p>
            <label for="checkout">Checkout date:</label>
            <input type="text" id="checkout" minlength="10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required />
        </p>

        <p>
            <label for="contact">Contact number:</label>
            <input type="text" id="contact" minlength="10" maxlength="14" placeholder="(###) ### ####" pattern="\([0-9]{3}\) [0-9]{3} [0-9]{4}" required />
        </p>
        <p>
            <label for="extra">Booking extras:</label>
            <textarea id="extra" rows="5" cols="25" maxlength="1000"></textarea>
        </p>
        <p>
            <input type="submit" value="Add" />
            <a href="index.html">cancel</a>
        </p>
    </form>
    <hr />

    <p>
        <label for="search_from">Search from:</label>
        <input type="text" id="search_from" minlength="10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required />
    </p>
    <p>
        <label for="search_to">Search to:</label>
        <input type="text" id="search_to" minlength="10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required />
    </p>
    <p>

        <button id="search">search</button>
        <a href="index.html">cancel</a>


    </p>




</body>
</html>