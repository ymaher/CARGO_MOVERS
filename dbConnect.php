<?php

/// For the following details,

/// please contact your server vendor



$hostname='localhost'; //// specify host, i.e. 'localhost'

$user='root'; //// specify username

$pass=''; //// specify password

$dbase='msccargo'; //// specify database name

$connection = mysql_connect("$hostname" , "$user" , "$pass") 

or die ("Can't connect to MySQL");

$db = mysql_select_db($dbase , $connection) or die ("Can't select database.");

?>