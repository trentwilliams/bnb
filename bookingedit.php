<!DOCTYPE HTML>
<html>
<head>
    <title>Edit a booking</title>


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
</head>
<body>

    <h1>Edit booking</h1>
    <a href="bookingviewcurrent.php"></a>return to the Bookings listing</a>      <a href="index.php">Return to the main page</a>

    <h2>Edit the booking for Trent Williams</h2>

    <form method="POST" action="bookingedit.php">
        <p>
            <label for="room">Room (name, type, beds):</label>
            <select id="room">
                <option value="room1">Room 1, D, 1</option>
                <option value="room4" selected>Room 2, D, 2</option>
                <option value="room2">Room 3, S, 1</option>
                <option value="room3">Room 4, S, 2</option>
            </select>
        </p>
        <p>
            <label for="checkin">Checkin date:</label>
            <input type="text" id="checkin" minlength="10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required value="2020-08-25"/>
        </p>
        <p>
            <label for="checkout">Checkout date:</label>
            <input type="text" id="checkout" minlength="10" maxlength="10" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required value="2020-08-29"/>
        </p>

        <p>
            <label for="contact">Contact number:</label>
            <input type="text" id="contact" minlength="10" maxlength="14" placeholder="(###) ### ####" pattern="\([0-9]{3}\) [0-9]{3} [0-9]{4}" required value="(234) 234 2341"/>
        </p>
        <p>
            <label for="extra">Booking extras:</label>
            <textarea id="extra" rows="5" cols="25" maxlength="1000">can you please make sure my room is pink</textarea>
        </p>
                     <p>
            <label for="review">Booking review:</label>
            <textarea id="review" rows="5" cols="25" maxlength="1000">this was a great place to stay!  :)</textarea>
        </p>
        <p>
            <input type="submit" value="Update"> cancel
        </p>
    </form>



</body>
</html>