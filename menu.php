    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="/bnb/"><span class="logo_colour">Ongaonga Bed & Breakfast</span></a></h1>
          <h2>Make yourself at home is our slogan. We offer some of the best beds on the east coast. Sleep well and rest well.</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->


          <li><a href="/">Home</a></li>
            <?php

            if ($_SESSION['loggedin']>0)
            {
            ?>
          <li><a href='listrooms.php'>Rooms</a></li>"

          <li><a href="bookingviewcurrent.php">Bookings</a></li>            
          <li><a href="registercustomer.php">Register</a></li>            
          <?php
            }?>




          <li><a href="login.php">Login</a></li>
        </ul>
      </div>
    </div>

	