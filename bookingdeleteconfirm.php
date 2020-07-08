<!DOCTYPE HTML>
<html>
<head>
    <title>Confirm booking delete</title>
</head>
<body>

    <h1>Confirm booking delete</h1>
    <a href="bookingviewcurrent.php">Return to the booking listing</a>       <a href="index.php">Return to the main page</a>

    <h2>Please confirm you wish to delete this booking for Trent Williams</h2>

        <p>
            <label for="room">Room (name, type, beds):</label><br />
            Room 3, S, 1</p>
        <p>
            <label for="checkin">Checkin date:</label><br />
            2020-08-25
        </p>
        <p>
            <label for="checkout">Checkout date:</label><br />
            2020-08-29
        </p>
    <form method="POST" action="bookingdone.html">
        <p>
            <input type="submit" value="Delete"> <a href="index.html">cancel</a>
        </p>
    </form>

</body>
</html>