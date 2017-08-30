
<?php
session_start();
include('dbConnect.php');
$strUserName=$_POST["txtUserName"];
$strPassword=$_POST["txtPassword"];

$sql = "select * from user where username = '".$strUserName."' and password = '".$strPassword."'";
//echo $sql;
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
    $_SESSION['user'] = $strUserName;
	//header("Location: cargo_admin/index.php");
?>
<script>
location.href="cargo_admin/index.php";
</script>

<?php	
	//echo 'success';
} else
{
	header("Location: warning.php");
	//echo 'failure';
}
?>
