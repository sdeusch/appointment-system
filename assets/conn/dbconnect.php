<?php

    $con = mysqli_connect("localhost","root","","db_massage");
    ## Tell MySQL that we are in Austria 
    $con->query("SET lc_time_names = 'de_AT'");

    // Check connection
    if (mysqli_connect_errno())  {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

?>