<?php


include "checksession.php";
//checkUser();
//loginStatus(); 

include "header.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
?>
        <h1>Privacy Policy</h1>

    <p>We collect personal information from you, including information about your:</p>
    <ul>
        <li>Name</li>
        <li>Contact information</li>
        <li>Billing or purchase information</li>
    </ul>
    We collect your personal information in order to:
    <ul>
        <li>Allow customers to make online bookings</li>
        <li>Processes online transactions</li>
        <li>Contact you in the event that we may need to change a purchase or booking</li>
    </ul>
    Besides our staff, we share this information with:
    <ul>
        <li>Our online payment solution, (ANZ) in order to process online transactions.</li>
        <li>Our online booking software in order to ensure your booking is stored and we can provide the accommodation for you.</li>
    </ul>

    <p>We keep your information safe by encrypting it and only allowing the required staff access to it.</p>
    <p>We keep your information for 24 months at which point we securely destroy it by securely erasing it.</p>
    <p>
        You have the right to ask for a copy of any personal information we hold about you, and to ask for it
        to be corrected if you think it is wrong. If you'd like to ask for a copy of your information, or to
        have it corrected, please contact us at admin@ongaongabnb.co.nz, or 03 347 7855, or 12 Amazing St,
        Ongaonga, New Zealand, 4751.
    </p>

<?php
echo '</div></div>';
require_once "footer.php";
?>