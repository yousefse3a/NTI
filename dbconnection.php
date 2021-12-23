<?php
$server = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "onspeed";
    
   $con =  mysqli_connect($server,$dbUser,$dbPassword,$dbName);

if(!$con){
       die("Error : ".mysqli_connect_error());
}
  date_default_timezone_get();
  date_default_timezone_set('africa/cairo');


?>