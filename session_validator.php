<?php
session_start();
if((isset($_SESSION['user'])) || ($_SESSION['user'] != ""))
{
	include('dbConnect.php');
	$username = $_SESSION['user'];
	$sql = "select * from user where username = '".$username."'";
	//echo $sql;
	$res = mysql_query($sql);
	if(mysql_num_rows($res)<=0)
	{
	?>
		<script>
			alert('Your session has been expired');
			document.location='../index.php';
		</script>
	<?php
	}
} else
{
	?>
		<script>
			alert('Your session has been expired');
			document.location='../index.php';
		</script>
	<?php
}
?>