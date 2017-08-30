<?php include('../session_validator.php');?>
<?php
if (isset($_GET["order"])) $order = @$_GET["order"]; 
if (isset($_GET["type"])) $ordtype = @$_GET["type"];

$filter="";
$filterfield="";
$wholeonly="";
$f = @$_GET["f"];
if(isset($_GET["f"])){
	$filter = substr($f,0,strpos($f,"$"));
	$filterfield = substr($f,(strpos($f,"$")+1),(strpos($f,"@@")-strpos($f,"$")-1));
	$wholeonly = substr($f,strpos($f,"@@")+2,(strlen($f)-strpos($f,"@@")-2));
}

if (isset($_POST["filter"])) $filter = @$_POST["filter"];
if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
//$wholeonly = false;
if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];

$f = $filter."$".$filterfield."@@".$wholeonly;


$a = @$_GET["a"];
switch($a){
case 'word':
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=TruckDetails.doc');
	export_Word_Excel();
	exit();
	break;
case 'excel':
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=TruckDetails.xls');
	export_Word_Excel();
	exit();
	break;
case 'xml':	
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=TruckDetails.xml');
	export_xml($export);
	exit();
	break;
case 'csv':	
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename=TruckDetails.csv');
	export_csv($export);
	exit();
	break;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Manage Truck Detials</title>

<script language="javascript" src="../files/form_validator.js"></script>
<script language="javascript" type="text/javascript">
function MouseOver(row) {
	row.className = "B";
}

function MouseOut(row) {
	row.className = "Btable";
}
</script>
<link type="text/css" rel="stylesheet" href="../files/grid_style.css" media="screen" />

<?php include('header.php'); ?>
  
<?php include('navigation.php'); ?>
<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-weight: bold;
}
.style3 {color: #000000}
-->
</style>
<td width="80%" align="left">
<table width="100%"><tr>
<td align="left" valign="top" width="100%">	  
<!-- Warning!Do Not change Above Code-->						  
								  
<table width="100%">
	<tr>
		<td>
<?php 
  $showrecs = 25;
  $pagerange = 10;
  
  $recid = @$_GET["recid"];
  $page = @$_GET["page"];
  if (!isset($page)) $page = 1;
  
  $sql = @$_POST["sql"];
  switch ($sql) {
    case "insert":
      sql_insert();
      break;
    case "update":
      sql_update();
      break;
    case "delete":
      sql_delete();
      break;
  }
  
  $a = @$_GET["a"];
  switch ($a) {
    case "add":
      addrec();
      break;
    case "view":
      viewrec($recid);
      break;
    case "edit":
      editrec($recid);
      break;
    case "del":
      deleterec($recid);
      break;
    default:
      select();
      break;
  }
?>		
		</td>
	</tr>
</table>
								  
<!-- Warning! Do Not change Below Code-->
</td>
</tr></table>
</td>		  
  <?php include('footer.php'); ?>

<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//A default function to display the home page i.e. the initial contents.
function select()
{
  global $a;
  global $showrecs;
  global $page;
  global $filter;
  global $filterfield;
  global $wholeonly;
  global $order;
  global $ordtype;
  global $f;
  
  if ($a == "reset") {
    $filter = "";
    $filterfield = "";
    $wholeonly = "";
    $order = "";
    $ordtype = "";
  }

  
  $res = sql_select();
  $count = sql_getrecordcount();	
  
  $checkstr = "";
  if ($wholeonly) $checkstr = " checked";
  if ($ordtype == "asc") { $ordtypestr = "desc"; } else { $ordtypestr = "asc"; }
  
  if ($count % $showrecs != 0) {
  $pagecount = intval($count / $showrecs) + 1;
  }
  else {
    $pagecount = intval($count / $showrecs);
  }
  $startrec = $showrecs * ($page - 1);
  if ($startrec < $count) {mysql_data_seek($res, $startrec);}
  $reccount = min($showrecs * $page, $count);
?>

  <table border="0" cellspacing="1" cellpadding="4" width="100%" align="center">
  	<tr><td class="td1">Records shown <?php echo $startrec + 1 ?> - <?php echo $reccount ?> of <?php echo $count ?></td></tr>
  </table>
  
<hr size="1" noshade align="center" width="100%">
  
<form action="manage_truck.php" method="post" style="background-image:url(jgfhfhf.jpg)">
<table width="94%" height="201"  border="0" align="center" cellpadding="4" cellspacing="1">
<tr>
<td width="24%" class="td1"><h2><span class="style3"><strong>SEARCH</strong><strong> BY</strong></span></h2>
  </td>
<td width="35%"><input type="text" name="filter" value="<?php echo $filter ?>"> <input name="submit" type="submit" value="Apply Search" /></td>
<td width="20%"><select name="filter_field">
<option value="">All Fields</option>
<option value="<?php echo "truck_no" ?>"<?php if ($filterfield == "truck_no") { echo "selected"; } ?>>Truck No.</option>
<option value="<?php echo "truck_type" ?>"<?php if ($filterfield == "truck_type") { echo "selected"; } ?>>Truck Type</option>
</select></td>
<td width="20%" class="td1"><h1><a href="manage_truck.php?a=reset" class="style1">ResetSearch</a></h1></td>
<td width="1%"></td>
</tr>
<tr>
<td height="84">&nbsp;</td>
<td>&nbsp;</td>
<td><a href="manage_truck.php?a=reset"></a></td>
</tr>
</table>
</form>
<hr size="1" noshade width="100%" align="center"> 
 <br> <br>
<table border="0" cellspacing="1" cellpadding="5" width="100%" align="center">
<tr>
	<td class="hr"><font color="#FFFFFF">Truck Owner</font></td>
	<td class="hr"><a href="manage_truck.php?order=truck_no&type=<?php echo $ordtypestr ?>&f=<?php echo $f ?>"><font color="#FFFFFF">Truck No</font></a></td>
	<td class="hr"><a href="manage_truck.php?order=truck_type&type=<?php echo $ordtypestr ?>&f=<?php echo $f ?>"><font color="#FFFFFF">Truck Type</font></a></td>
	<td class="hr">&nbsp;</td>
	<td class="hr">&nbsp;</td>
	<td class="hr">&nbsp;</td>
</tr>

<?php
  for ($i = $startrec; $i < $reccount; $i++)
  {
    $row = mysql_fetch_assoc($res);
    $style = "dr";
	 $style1 = "#E4E7E6";
	 if ($i % 2 != 0) {
		 $style = "sr";
		 $style1 = "#C4DAE3";
	 }
	 
	 $sql_owner = "select name from truck_owner where truck_owner_id = ".$row['truck_owner_id'];
	 $res_owner = mysql_query($sql_owner);
	 $row_owner = mysql_fetch_array($res_owner);
?>
<tr height="20" bgcolor="<?php echo $style1?>" onmouseover="MouseOver(this);" onmouseout="MouseOut(this);">
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row_owner["name"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["truck_no"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["truck_type"]) ?></td>
<td class="<?php echo $style ?>"><a href="manage_truck.php?a=view&recid=<?php echo $i ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">View</a></td>
<td class="<?php echo $style ?>"><a href="manage_truck.php?a=edit&recid=<?php echo $i ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Edit</a></td>
<td class="<?php echo $style ?>"><a onclick="return confirm('Are you sure you want to delete this item?');" href="manage_truck.php?a=del&recid=<?php echo $i ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Delete</a></td>
</tr>
<?php
  }
  mysql_free_result($res);
?>
</table>
<br>

<?php showpagenav($page, $pagecount); ?>
<table width="100%" align="center" >
		<tr height="20" valign="middle"><td align="right"><a href="manage_truck.php?a=word&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="Microsoft WORD Format" style="text-decoration:none;">Export to Word</a><font style="color:#000000; font-weight:bold;"> &brvbar; </font><a href="manage_truck.php?a=excel&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="Microsoft EXCEL Format" style="text-decoration:none;">Export to Excel</a><font style="color:#000000; font-weight:bold;"> &brvbar; </font><a href="manage_truck.php?a=xml&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="XML Format" style="text-decoration:none;">Export to XML</a><font style="color:#000000; font-weight:bold;"> &brvbar; </font><a href="manage_truck.php?a=csv&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="Comma Saperated Values Format" style="text-decoration:none;">Export to CSV</a>&nbsp;&nbsp;&nbsp;</td></tr>
</table>
<?php
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>



<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To add a new record to database.
function addrec()
{
	global $order;
    global $ordtype;
	global $f;
?>
<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%">
<tr>
<td><a href="manage_truck.php">Index Page</a></td>
</tr>
</table>
<hr size="1" noshade>
<form enctype="multipart/form-data" action="manage_truck.php" method="post" onsubmit="if(isFormValid()) ; else { alert('Something is wrong');return false; }">
<p><input type="hidden" name="sql" value="insert"></p>
<?php
$row = array(
  "truck_owner_id" => "",
  "truck_no" => "",
  "truck_type" => "");
showroweditor($row, false);
?>
<br /><br />
<input type="submit" value="Post" />
</form>
<?php 
}
//--------------------------------------------------------------------------------------------------------------------------------------------
 ?>



<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To view a selected record
function viewrec($recid)
{
	global $order;
    global $ordtype;
	global $f;
  $res = sql_select();
  $count = sql_getrecordcount();
  mysql_data_seek($res, $recid);
  $row = mysql_fetch_assoc($res);
  showrecnav("view", $recid, $count);
?>
<br>
<?php showrow($row, $recid) ?>
<br>
<hr size="1" noshade align="center" width="100%">
<table  border="0" cellspacing="1" cellpadding="4" align="center" width="100%">
<tr>
<td><a href="manage_truck.php?a=add">Add Record</a></td>
<td><a href="manage_truck.php?a=edit&recid=<?php echo $recid ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Edit Record</a></td>
<td><a onclick="return confirm('Are you sure you want to delete this item?');" href="manage_truck.php?a=del&recid=<?php echo $recid ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Delete Record</a></td>
</tr>
</table>
<?php
  mysql_free_result($res);
}
//--------------------------------------------------------------------------------------------------------------------------------------------
 ?>



<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//Edit a selected Record...
function editrec($recid)
{
  $res = sql_select();
  $count = sql_getrecordcount();
  mysql_data_seek($res, $recid);
  $row = mysql_fetch_assoc($res);
  showrecnav("edit", $recid, $count);
?>
<br>
<form enctype="multipart/form-data" action="manage_truck.php" method="post" onsubmit="if(isFormValid()) ; else { alert('Something is wrong');return false; }">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xId" value="<?php echo $row["truck_detail_id"]; ?>">
<?php showroweditor($row, true); ?>
<br /><br />
<input type="submit" value="Post" />
</form>
<?php
  mysql_free_result($res);
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>



<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To delete a selected record...
function deleterec($recid)
{
  $res = sql_select();
  $count = sql_getrecordcount();
  mysql_data_seek($res, $recid);
  $row = mysql_fetch_assoc($res);
  showrecnav("del", $recid, $count);
?>
<br>
<form action="manage_truck.php" method="post">

<?php showrow($row, $recid) ?>
<br /><br />
<input type="submit" value="confirm" />
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xId" value="<?php echo $row["truck_detail_id"] ?>">
</form>
<?php
  mysql_free_result($res);
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>

<script type="text/javascript">
function validate_truck_no()
{
    var name=document.getElementById("truck_no").value;
	
  
	if(name==null || name=="")
	{
	   alert("Invalid truck no");
	   document.getElementById("truck_no").focus();
	   return false;
	 }
	else if (!name.match(/^[a-zA-Z][a-zA-Z][ ][0-9][0-9][ ][a-zA-Z][ ][0-9][0-9][0-9][0-9]$/)) 
	{
	  alert("Please enter valid truck no");
	  document.getElementById("truck_no").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
</script>


<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To show a row in editor...
function showroweditor($row, $iseditmode)
{
?>
<table class="tbl" border="1" cellspacing="1" cellpadding="5" width="100%" align="center">
<tr>
<td class="hr" width="25%">Truck Owner</td>
<td class="dr"><select name="truck_owner_id" id="truck_owner_id" style="width:200px;" required="1">
					<option value="">Select Truck Owner</option>
					<?php
						include('../dbConnect.php');
						$sql_owner = "select name, truck_owner_id from truck_owner where deleted = 'no'";
						$res_owner = mysql_query($sql_owner);
						while ($row_owner = mysql_fetch_assoc($res_owner))
						{
						  $val = $row_owner["truck_owner_id"];
						  $caption = $row_owner["name"];
						  if($row["truck_owner_id"] == $val) {$selstr = " selected"; } else {$selstr = ""; } ?>
							<option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
					<?php	
						}
					?>
				</select></td>
</tr>
<tr>
<td class="hr">Truck No</td>
<td class="dr"><input type="text" name="truck_no" id="truck_no" size="28" value="<?php echo str_replace('"', '&quot;', trim($row["truck_no"])) ?>" required="1" style="width:200px;" onblur="return validate_truck_no()"/>
( for example:KA 22 D 6022)</td>
</tr>
<tr>
<td class="hr">Truck Type</td>
<td class="dr">
<select name="truck_type" id="truck_type" style="width:200px;" required="1">
					<option value="" selected>-select-</option>
						<?php
  $lookupvalues = array("Tipper","Truck","Trailer","Container");
  reset($lookupvalues);
  foreach($lookupvalues as $val){
  $caption = $val;
  if ($row["truck_type"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
<?php } ?>
</select></td>
</tr>
<tr>
  <td class="hr">&nbsp;</td>
  <td class="dr">&nbsp;</td>
</tr>
</table>
<?php 
}
//--------------------------------------------------------------------------------------------------------------------------------------------
 ?>



<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To show record to view and delete...
function showrow($row, $recid)
{

	include('../dbConnect.php');
	$sql_owner = "select name from truck_owner where truck_owner_id = ".$row['truck_owner_id'];
	//echo $sql_owner;
	$res_owner = mysql_query($sql_owner);
	$row_owner = mysql_fetch_assoc($res_owner);
?>
<table class="tbl" border="1" cellspacing="1" cellpadding="5" width="100%" align="center">
<tr>
<td class="hr" width="25%">Truck Owner Name</td>
<td class="dr"><?php echo htmlspecialchars($row_owner["name"]) ?></td>
</tr>
<tr>
<td class="hr">Truck No.</td>
<td class="dr"><?php echo htmlspecialchars($row["truck_no"]) ?></td>
</tr>
<tr>
<td class="hr">Truck Type</td>
<td class="dr"><?php echo htmlspecialchars($row["truck_type"]) ?></td>
</tr>
</table>
<?php
 }
//--------------------------------------------------------------------------------------------------------------------------------------------
  ?>



<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To display Navigation during view edit and delete...
function showrecnav($a, $recid, $count)
{
	global $order;
    global $ordtype;
	global $f;

?>
<table   border="0" cellspacing="1" cellpadding="4" align="center" width="100%">
<tr>
<td><a href="manage_truck.php?order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Index Page</a></td>
<?php if ($recid > 0) { ?>
<td><a href="manage_truck.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Prior Record</a></td>
<?php } if ($recid < $count - 1) { ?>
<td><a href="manage_truck.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Next Record</a></td>
<?php } ?>
</tr>
</table>
<hr size="1" noshade width="100%" align="center">
<?php 
} 
//--------------------------------------------------------------------------------------------------------------------------------------------
?>





<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//Function to select the all the records from the database
function sql_select()
{
	global $order;
	global $ordtype;
	global $filter;
	global $filterfield;
	global $wholeonly;
	
	include("../dbConnect.php");
	$filterstr = sqlstr($filter);
	if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
	$sql = "SELECT * FROM truck_detail";
	if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
	$sql .= " where " .sqlstr($filterfield) ." like '" .$filterstr ."'";
	} elseif (isset($filterstr) && $filterstr!='') {
	$sql .= " where ((truck_no like '" .$filterstr ."') or (truck_type like '" .$filterstr ."'))";
	}
	if (isset($order) && $order!='') $sql .= " order by " .sqlstr($order) ."";
	else $sql .= " order by truck_no ";
	if (isset($ordtype) && $ordtype!='') $sql .= " " .sqlstr($ordtype);
	else $sql .= " asc ";
	//echo $sql;
	$res = mysql_query($sql) or die(mysql_error());
	return $res;
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>



 
<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To insert a record into the database...
function sql_insert()
{
  include("../dbConnect.php");
  global $_POST;
  $comp_name=$_POST["truck_no"];
  $result=mysql_query("select * from truck_detail where truck_no='$comp_name'");
  if(mysql_num_rows($result)>0)
  {
    ?>
	  <script>
	       alert("Truck Detail Is already Exist");
		   location.href="manage_truck.php";
	</script>
  <?php
  }
  else
  {		   

  $sql = "insert into truck_detail values(NULL," .sqlvalue(@$_POST["truck_owner_id"], true).", " .sqlvalue(@$_POST["truck_no"], true).", " .sqlvalue(@$_POST["truck_type"], true).")";
  mysql_query($sql) or die("Query : $sql" .mysql_error());

}
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>




<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To update a row in database...
function sql_update()
{
  global $_POST;
  include("../dbConnect.php");
  $sql = "update truck_detail set truck_owner_id=" .sqlvalue(@$_POST["truck_owner_id"], true).", truck_no=" .sqlvalue(@$_POST["truck_no"], true).", truck_type=" .sqlvalue(@$_POST["truck_type"], true)." where truck_detail_id = ".sqlvalue(@$_POST["xId"], true);
  mysql_query($sql) or die(mysql_error());
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>



<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To delete a row from the database...
function sql_delete()
{
  include("../dbConnect.php");
  $sql = "delete from truck_detail where truck_detail_id = ".sqlvalue(@$_POST["xId"], true);
  mysql_query($sql) or die(mysql_error());
  
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>




<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//To count all the records from the database
function sql_getrecordcount()
{
	global $order;
    global $ordtype;
    global $filter;
    global $filterfield;
	global $wholeonly;
    include("../dbConnect.php");
	
	$filterstr = sqlstr($filter);
	if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
	$sql = "SELECT COUNT(*) FROM truck_detail ";
	if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
	$sql .= " where " .sqlstr($filterfield) ." like '" .$filterstr ."'";
	} elseif (isset($filterstr) && $filterstr!='') {
	$sql .= " where ((truck_no like '" .$filterstr ."') or (truck_type like '" .$filterstr ."'))";
	}
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	reset($row);
	return current($row);
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>
 
<?php
function sqlstr($val)
{
  return str_replace("'", "''", $val);
}
?>


<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Fuction
//To convert special character into MySql Format...
function sqlvalue($val, $quote)
{
  if ($quote)
    $tmp = str_replace("'", "''", $val);
  else
    $tmp = $val;
  if ($tmp == "")
    $tmp = "NULL";
  elseif ($quote)
    $tmp = "'".$tmp."'";
  return $tmp;
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>



<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function
//FUnction To show the navigation of page...
/*&order=<?php if (isset($order)) echo $order ?>&type=<?php if (isset($type)) echo $ordtype?>*/
function showpagenav($page, $pagecount)
{
	global $order;
    global $ordtype;
	global $f;
?>
<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%" >
<tr>
<td><a href="manage_truck.php?a=add">Add Record</a>&nbsp;
<?php if ($page > 1) { ?>
<a href="manage_truck.php?page=<?php echo $page - 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">&lt;&lt;&nbsp;Prev</a>&nbsp;
<?php } ?>
<?php
  global $pagerange;

  if ($pagecount > 1) {

  if ($pagecount % $pagerange != 0) {
    $rangecount = intval($pagecount / $pagerange) + 1;
  }
  else {
    $rangecount = intval($pagecount / $pagerange);
  }
  for ($i = 1; $i < $rangecount + 1; $i++) {
    $startpage = (($i - 1) * $pagerange) + 1;
    $count = min($i * $pagerange, $pagecount);

    if ((($page >= $startpage) && ($page <= ($i * $pagerange)))) {
      for ($j = $startpage; $j < $count + 1; $j++) {
        if ($j == $page) {
?>
<b><?php echo $j ?></b>
<?php } else { ?>
<a href="manage_truck.php?page=<?php echo $j ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>"><?php echo $j ?></a>
<?php } } } else { ?>
<a href="manage_truck.php?page=<?php echo $startpage ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>"><?php echo $startpage ."..." .$count ?></a>
<?php } } } ?>
<?php if ($page < $pagecount) { ?>
&nbsp;<a href="manage_truck.php?page=<?php echo $page + 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Next&nbsp;&gt;&gt;</a>&nbsp;</td>
<?php } ?>
</tr>
</table>
<?php 
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>
 

<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Fuction
//To export the report into word or excel format Format...
function export_Word_Excel()
{
$res = sql_select();
$count = sql_getrecordcount();
?>
<table border="0" cellspacing="1" cellpadding="5" width="95%" align="center">
<tr bgcolor="#487698">  
	<td class="hr"><font color="#FFFFFF"><strong>Truck Owner</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>Truck No</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>Truck Type</strong></font></td>
</tr>

<?php
  for ($i = $startrec; $i < $count; $i++)
  {
    $row = mysql_fetch_assoc($res);
    $style = "dr";
	 $style1 = "#E4E7E6";
	 if ($i % 2 != 0) {
		 $style = "sr";
		 $style1 = "#C4DAE3";
	 }
	 
	 $sql_owner = "select name from truck_owner where truck_owner_id = ".$row['truck_owner_id'];
	 $res_owner = mysql_query($sql_owner);
	 $row_owner = mysql_fetch_array($res_owner);
?>
<tr height="20" bgcolor="<?php echo $style1?>">
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row_owner["name"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["truck_no"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["truck_type"]) ?></td>
</tr>
<?php
  }
  mysql_free_result($res);
?>
</table>

<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
}
?>



<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------
//Fuction
//To export the report into word or excel format Format...
function export_xml($export)
{
$res = sql_select();
$count = sql_getrecordcount();
	include('../dbConnect.php');
	echo "<?xml version='1.0'?><xml>";
	for ($i = 0; $i < $count; $i++)
	{
		$row = mysql_fetch_assoc($res);
		$sql_owner = "select name from truck_owner where truck_owner_id = ".$row['truck_owner_id'];
		$res_owner = mysql_query($sql_owner);
		$row_owner = mysql_fetch_assoc($res_owner);
		echo "<Truck_Detais>";
		echo "<Truck_Owner>".$row_owner["name"]."</Truck_Owner>";
		echo "<Truck_No>".$row["truck_no"]."</Truck_No>";
		echo "<Truck_Type>".$row["truck_type"]."</Truck_Type>";
		echo "</Truck_Detais>";
	}
	echo "</xml>";
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>


<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------
//Fuction
//To export the report into word or excel format Format...
function export_csv($export)
{
include('../dbConnect.php');
$res = sql_select();
$count = sql_getrecordcount();
	echo "Truck Owner Name,Truck No,Truck Type \n";
	for ($i = 0; $i < $count; $i++)
	{
		$row = mysql_fetch_assoc($res);
		$sql_owner = "select name from truck_owner where truck_owner_id = ".$row['truck_owner_id'];
		$res_owner = mysql_query($sql_owner);
		$row_owner = mysql_fetch_assoc($res_owner);
		
		echo "\"".$row_owner['name']."\",\"".$row['truck_no']."\",\"".$row['truck_type']."\" \n";
	}
	echo "\n";
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>

<?php
//-------------------------------------------------------------------------------------------------------------------------------------------
//Function to convert the date format into dd-mm-yyyy
function FormatDate($date)
{
	$da = explode('-',$date);
	return ($da[2]."-".$da[1]."-".$da[0]);
}
?>