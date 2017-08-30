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
	$str .= "<select name=\"truck_no\" id=\"truck_no\" style=\"width:100%;\">";
	while($row = mysql_fetch_array($result)){
		$str .=  "<option value=\"".$row['truck_detail_id']."\">".$row['truck_no']."</option>";
	}
	$str .= "</select>";	
	echo $str;
mysql_close();

?>