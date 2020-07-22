<?php


$hostname=gethostname();

//override and use remote server
$azuremode=true;

if ($hostname!="Stradale" || $azuremode==true)
    {
    //echo "foce to use azure mysql<BR>";
    define("HOSTURL","https://ongaonga.azurewebsites.net/");
    define("DBHOSTNAME","ongaongamysql.mysql.database.azure.com:3306");
    define("DBUSER","trent@ongaongamysql");
    define("DBPASSWORD","assesment3!");
    define("DBDATABASE","bnb");
    }
else
    {
    //echo "running locally<BR>";
    define("HOSTURL","http://localhost");
    define("DBHOSTNAME","localhost");
    define("DBUSER","root");
    define("DBPASSWORD","root");
    define("DBDATABASE","bnb");
    }
//MySQL credentails




?>
