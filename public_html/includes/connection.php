<?php
 $dbhost = 'localhost';
         $dbuser = 'u321792919_bioniqe';
         $dbpass = 'Bio@2021';
         $db='u321792919_bioniqe';
         $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db);
         
        if(! $conn ){
            die('Could not connect: ' . mysqli_error());
         }
?>