<?php
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache"); // HTTP/1.0
	include("../dbConnect.php");
	$id = $_GET['id'];
	$query = "SELECT truck_detail_id, truck_no from truck_detail where truck_owner_id = ".$id;
	//echo $query;
	
	$result = mysql_query($query);
	$str = "<select name=\"truck_no\" id=\"truck_no\" style=\"width:100%;\">";
	while($row = mysql_fetch_array($result)){
		$str .=  "<option value=\"".$row['truck_detail_id']."\">".$row['truck_no']."</option>";
	}
	$str .= "</select>";	
	$str .= '$$$';
	
	//Uppend the batch result with the subject list
	
	$sql_acc = "select acc_id, acc_no from truck_owner_acc where truck_owner_id = ".$id;
	$res_acc = mysql_query($sql_acc);
	$str .= "<select name=\"account_no\" id=\"account_no\" style=\"width:100%;\">";
	while($row_acc = mysql_fetch_array($res_acc))
	{
		$str .=  "<option value=\"".$row_acc['acc_id']."\">".$row_acc['acc_no']."</option>";
	}
	$str .= "</select>";
	echo $str;
mysql_close();

?>