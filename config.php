<?php


$hostname=gethostname();



if ($hostname=="Stradale")
    {
    echo "running locally<BR>";
    define("DBHOSTNAME","localhost");
    define("DBUSER","root");
    define("DBPASSWORD","root");
    define("DBDATABASE","bnb");
    }
else
    {
    echo "running azure<BR>";
    define("DBHOSTNAME","ongaongamysql.mysql.database.azure.com");
    define("DBUSER","trent@ongaongamysql");
    define("DBPASSWORD","assesment3!");
    define("DBDATABASE","bnb");
    }

//MySQL credentails




?>
