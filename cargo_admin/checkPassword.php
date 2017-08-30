<?php
session_start();

include('../dbConnect.php');
$pass = $_GET['password'];
$sql = "select * from user where username = '".$_SESSION['user']."' and password = '".$pass."'";
//echo $sql;
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
	echo "<input type=\"hidden\" id=\"status\" name=\"status\" value=\"1\" /><font color=\"green\">Correct Password...</font>";
} else
{
	echo "<input type=\"hidden\" id=\"status\" name=\"status\" value=\"\" /><font color=\"red\">Incorrect Password...</font>";
}
?>