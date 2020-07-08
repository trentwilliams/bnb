<!DOCTYPE HTML>
<html>
<head>
    <title>Booking add review</title>
</head>
<body>

    <h1>Booking add review</h1>
    <a href="bookingviewcurrent.php">Return to the booking listing</a>      <a href="index.php">Return to the main page</a>

    <h2>Add a review to your booking</h2>

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

        <p>
            <label for="contact">Contact number:</label><br />
            (234) 234 2341
        </p>
        <p>
            <label for="extra">Booking extras:</label><br />
            I request everything extra!  :)
        </p>
    <form method="POST" action="bookingaddreview.php">
             <p>
            <label for="review">Booking review:</label>
            <textarea id="review" rows="5" cols="25" maxlength="1000"></textarea>
        </p>
        <p>
            <input type="submit" value="Add"> <a href="index.php">cancel</a>
        </p>
    </form>
</body>
</html>