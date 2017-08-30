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
	header('Content-Disposition: attachment; filename=Transporters.doc');
	export_Word_Excel();
	exit();
	break;
case 'excel':
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=Transporters.xls');
	export_Word_Excel();
	exit();
	break;
case 'xml':	
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=Transporters.xml');
	export_xml($export);
	exit();
	break;
case 'csv':	
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename=Transporters.csv');
	export_csv($export);
	exit();
	break;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Manage Transporteres</title>

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
  
<form action="manage_transporters.php" method="post" style="background-image:url(../banner8.jpg)"> 
<table width="96%" height="173"  border="0" align="center" cellpadding="4" cellspacing="1">
<tr>
<td width="22%" height="143" class="td1"><h2><strong>SEARCH BY</strong></h2></td>
<td width="31%"><input type="text" name="filter" value="<?php echo $filter ?>">
  <input name="submit" type="submit" value="Apply Search" /></td>
<td width="19%"><select name="filter_field">
<option value="">All Fields</option>
<option value="<?php echo "company_name" ?>"<?php if ($filterfield == "company_name") { echo "selected"; } ?>>Company Name</option>
<option value="<?php echo "contact_person" ?>"<?php if ($filterfield == "contact_person") { echo "selected"; } ?>>Contact Person</option>
<option value="<?php echo "contact_no" ?>"<?php if ($filterfield == "contact_no") { echo "selected"; } ?>>Contact No.</option>
<option value="<?php echo "city" ?>"<?php if ($filterfield == "city") { echo "selected"; } ?>>City</option>
<option value="<?php echo "state" ?>"<?php if ($filterfield == "state") { echo "selected"; } ?>>State</option>
</select></td>
<td width="27%" class="td1"><h1 align="left"><a href="manage_transporters.php?a=reset"> Reset Search </a></h1></td>
<td width="1%"></td>
</tr>
<tr>
<td height="27">&nbsp;</td>
<td>&nbsp;</td>
<td><a href="manage_transporters.php?a=reset"></a></td>
</tr>
</table>
</form>
<hr size="1" noshade width="100%" align="center"> 
 <br> <br>
<table border="0" cellspacing="1" cellpadding="5" width="100%" align="center">
<tr>
	<td class="hr"><a href="manage_transporters.php?order=company_name&type=<?php echo $ordtypestr ?>&f=<?php echo $f ?>"><font color="#FFFFFF">Company Name</font></a></td>
	<td class="hr"><a href="manage_transporters.php?order=contact_person&type=<?php echo $ordtypestr ?>&f=<?php echo $f ?>"><font color="#FFFFFF">Contact Person</font></a></td>
	<td class="hr"><a href="manage_transporters.php?order=contact_no&type=<?php echo $ordtypestr ?>&f=<?php echo $f ?>"><font color="#FFFFFF">Contact No.</font></a></td>
	<td class="hr"><a href="manage_transporters.php?order=city&type=<?php echo $ordtypestr ?>&f=<?php echo $f ?>"><font color="#FFFFFF">City</font></a></td>	
	<td class="hr"><a href="manage_transporters.php?order=state&type=<?php echo $ordtypestr ?>&f=<?php echo $f ?>"><font color="#FFFFFF">State</font></a></td>		
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
?>
<tr height="20" bgcolor="<?php echo $style1?>" onmouseover="MouseOver(this);" onmouseout="MouseOut(this);">
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["company_name"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["contact_person"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["contact_no"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["city"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["state"]) ?></td>
<td class="<?php echo $style ?>"><a href="manage_transporters.php?a=view&recid=<?php echo $i ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">View</a></td>
<td class="<?php echo $style ?>"><a href="manage_transporters.php?a=edit&recid=<?php echo $i ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Edit</a></td>
<td class="<?php echo $style ?>"><a onclick="return confirm('Are you sure you want to delete this item?');" href="manage_transporters.php?a=del&recid=<?php echo $i ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Delete</a></td>
</tr>
<?php
  }
  mysql_free_result($res);
?>
</table>
<br>

<?php showpagenav($page, $pagecount); ?>
<table width="100%" align="center" >
		<tr height="20" valign="middle"><td align="right"><a href="manage_transporters.php?a=word&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="Microsoft WORD Format" style="text-decoration:none;">Export to Word</a><font style="color:#000000; font-weight:bold;"> &brvbar; </font><a href="manage_transporters.php?a=excel&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="Microsoft EXCEL Format" style="text-decoration:none;">Export to Excel</a><font style="color:#000000; font-weight:bold;"> &brvbar; </font><a href="manage_transporters.php?a=xml&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="XML Format" style="text-decoration:none;">Export to XML</a><font style="color:#000000; font-weight:bold;"> &brvbar; </font><a href="manage_transporters.php?a=csv&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="Comma Saperated Values Format" style="text-decoration:none;">Export to CSV</a>&nbsp;&nbsp;&nbsp;</td></tr>
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
<td><a href="manage_transporters.php">Index Page</a></td>
</tr>
</table>
<hr size="1" noshade>
<form enctype="multipart/form-data" action="manage_transporters.php" method="post" onsubmit="if(isFormValid()) ; else { alert('Something is wrong');return false; }">
<p><input type="hidden" name="sql" value="insert"></p>
<?php
$row = array(
  "company_name" => "",
  "contact_person" => "",
  "contact_no" => "",
  "city" => "",
  "state" => "");
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
<td><a href="manage_transporters.php?a=add">Add Record</a></td>
<td><a href="manage_transporters.php?a=edit&recid=<?php echo $recid ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Edit Record</a></td>
<td><a onclick="return confirm('Are you sure you want to delete this item?');" href="manage_transporters.php?a=del&recid=<?php echo $recid ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Delete Record</a></td>
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
<form enctype="multipart/form-data" action="manage_transporters.php" method="post" onsubmit="if(isFormValid()) ; else { alert('Something is wrong');return false; }">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xId" value="<?php echo $row["transporter_id"]; ?>">
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
<form action="manage_transporters.php" method="post" name="test">

<?php showrow($row, $recid) ?>
<br /><br />
<input type="submit" value="confirm" />
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xId" value="<?php echo $row["transporter_id"] ?>">
</form>
<?php
  mysql_free_result($res);
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>

<script type="text/javascript">
function validate_name()
{
    var name=document.getElementById("company_name").value;
	//var reason1 = "";
    //var illegalChars= new RegExp(/^[a-zA-Z]+$/);

  //reason1 += name;
  
	if(name==null || name=="")
	{
	   alert("invalid name");
	   document.getElementById("company_name").focus();
	   return false;
	 }
	else if (!name.match(/^[a-zA-Z]+$/)) 
	{
	  alert("name must contains only letters");
	  document.getElementById("company_name").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	

function validate_person()
{
    var name=document.getElementById("contact_person").value;
	//var reason1 = "";
    //var illegalChars= new RegExp(/^[a-zA-Z]+$/);

  //reason1 += name;
  
	if(name==null || name=="")
	{
	   alert("invalid name");
	   document.getElementById("contact_person").focus();
	   return false;
	 }
	else if (!name.match(/^[a-zA-Z]+$/)) 
	{
	  alert("name must contains only letters");
	  document.getElementById("contact_person").focus();
	  return false;
	}
	else if (name.length < 4) 
	{
	   alert("name should be atleast four char long");
	   document.getElementById("contact_person").focus();
	   return false;
	
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_city()
{
    var name=document.getElementById("city").value;
	//var reason1 = "";
    //var illegalChars= new RegExp(/^[a-zA-Z]+$/);

  //reason1 += name;
  
	if(name==null || name=="")
	{
	   alert("invalid city");
	   document.getElementById("city").focus();
	   return false;
	 }
	else if (!name.match(/^[a-zA-Z]+$/)) 
	{
	  alert("city must contains only letters");
	  document.getElementById("city").focus();
	  return false;
	}
	else if (name.length < 3) 
	{
	   alert("city should be atleast four char long")
	   document.getElementById("city").focus();;
	   return false;
	
	}
	else
	{
	 return true;  
	}
 
   
}	

function validate_contact()
{
    var num=document.getElementById("contact_no").value;
	//var reason1 = "";
    //var illegalChars= new RegExp(/^[a-zA-Z]+$/);

  //reason1 += name;
  
	if(num==null || num=="")
	{
	   alert("invalid number");
	   document.getElementById("contact_no").focus();
	   return false;
	 }
	else if (!num.match(/^[7-9][0-9[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]+$/)) 
	{
	  alert("plz enter correct number");
	  document.getElementById("contact_no").focus();
	  return false;
	}
	else if (num.length !=10) 
	{
	   alert("num must be 10 digits");
	   document.getElementById("contact_no").focus();
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
<table class="tbl" border="1" cellspacing="1" cellpadding="5" width="100%" align="center" >
<tr>
<td class="hr" width="25%">Company Name</td>
<td class="dr"><input type="text" name="company_name" id="company_name" size="28" value="<?php echo str_replace('"', '&quot;', trim($row["company_name"])) ?>" required="1" style="width:200px;" onblur="return validate_name()"/></td>
</tr>
<tr>
<td class="hr">Contact Person</td>
<td class="dr"><input type="text" name="contact_person" id="contact_person" size="28" value="<?php echo str_replace('"', '&quot;', trim($row["contact_person"])) ?>" required="1" style="width:200px;" onblur="return validate_person()"/></td>
</tr>
<tr>
<td class="hr">Contact No.</td>
<td class="dr"><input type="text" name="contact_no" id="contact_no" size="28" value="<?php echo str_replace('"', '&quot;', trim($row["contact_no"])) ?>" required="1" mask="numeric" style="width:200px;" onblur="return validate_contact()"/></td>
</tr>
<tr>
<td class="hr">City</td>
<td class="dr"><input type="text" name="city" id="city" size="28" value="<?php echo str_replace('"', '&quot;', trim($row["city"])) ?>" required="1" style="width:200px;" onblur="return validate_city()"/></td>
</tr>
<tr>
<td class="hr">State</td>
<td class="dr"><select name="state" id="state" style="width:200px;" required="1">
					<option value="" selected>Select</option>
						<?php
  $lookupvalues = array("Andaman and Nicobar Islands","Andhra Pradesh","Arunachal Pradesh","Assam","Bihar","Chandigarh","Chhattisgarh","Dadra and Nagar Haveli","Daman and Diu","Delhi","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and Kashmir","Jharkhand","Karnataka","Kerala","Lakshadweep","Madhya Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Orissa","Pondicherry","Punjab","Rajasthan","Sikkim","Tamil Nadu","Tripura","Uttaranchal","Uttar Pradesh","West Bengal");

  reset($lookupvalues);
  foreach($lookupvalues as $val){
  $caption = $val;
  if ($row["state"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
<?php } ?>
																	</select>
</td>
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
?>
<table class="tbl" border="1" cellspacing="1" cellpadding="5" width="100%" align="center">
<tr>
<td class="hr" width="25%">Company Name</td>
<td class="dr"><?php echo htmlspecialchars($row["company_name"]) ?></td>
</tr>
<tr>
<td class="hr">Contact Person</td>
<td class="dr"><?php echo htmlspecialchars($row["contact_person"]) ?></td>
</tr>
<tr>
<td class="hr">Contact No</td>
<td class="dr"><?php echo htmlspecialchars($row["contact_no"]) ?></td>
</tr>
<tr>
<td class="hr">City</td>
<td class="dr"><?php echo htmlspecialchars($row["city"]) ?></td>
</tr>
<tr>
<td class="hr">State</td>
<td class="dr"><?php echo htmlspecialchars($row["state"]) ?></td>
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
<td><a href="manage_transporters.php?order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Index Page</a></td>
<?php if ($recid > 0) { ?>
<td><a href="manage_transporters.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Prior Record</a></td>
<?php } if ($recid < $count - 1) { ?>
<td><a href="manage_transporters.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Next Record</a></td>
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
	$sql = "SELECT * FROM transporter where deleted = 'no'";
	if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
	$sql .= " and " .sqlstr($filterfield) ." like '" .$filterstr ."'";
	} elseif (isset($filterstr) && $filterstr!='') {
	$sql .= " and ((company_name like '" .$filterstr ."') or (contact_person like '" .$filterstr ."') or (contact_no like '" .$filterstr ."') or (city like '" .$filterstr ."') or (state like '" .$filterstr ."'))";
	}
	if (isset($order) && $order!='') $sql .= " order by " .sqlstr($order) ."";
	else $sql .= " order by company_name ";
	if (isset($ordtype) && $ordtype!='') $sql .= " " .sqlstr($ordtype);
	else $sql .= " desc ";
	$res = mysql_query($sql) or die(mysql_error());
	//echo $sql;
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
  $comp_name=$_POST["company_name"];
  $city=$_POST['city'];
  $result=mysql_query("select * from transporter where company_name='$comp_name' and deleted='no' and city='$city'");
  if(mysql_num_rows($result)>0)
  {
    ?>
	  <script>
	       alert("Company Name already Exist");
		   location.href="manage_transporters.php";
	</script>
  <?php
  }
  else
  {		   

  $sql = "insert into transporter values(NULL," .sqlvalue(@$_POST["company_name"], true).", " .sqlvalue(@$_POST["contact_person"], true).", " .sqlvalue(@$_POST["contact_no"], true).", " .sqlvalue(@$_POST["city"], true).", ".sqlvalue(@$_POST["state"], true).", 'no')";
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
  $sql = "update transporter set company_name=" .sqlvalue(@$_POST["company_name"], true).", contact_person=" .sqlvalue(@$_POST["contact_person"], true).", contact_no=" .sqlvalue(@$_POST["contact_no"], true).", city=" .sqlvalue(@$_POST["city"], true).", state=" .sqlvalue(@$_POST["state"], true)." where transporter_id = ".sqlvalue(@$_POST["xId"], true);
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
  $sql = "update transporter set deleted = 'yes' where transporter_id = ".sqlvalue(@$_POST["xId"], true);
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
	$sql = "SELECT COUNT(*) FROM transporter where deleted = 'no' ";
	if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
	$sql .= " and " .sqlstr($filterfield) ." like '" .$filterstr ."'";
	} elseif (isset($filterstr) && $filterstr!='') {
	$sql .= " and ((company_name like '" .$filterstr ."') or (contact_person like '" .$filterstr ."') or (contact_no like '" .$filterstr ."') or (city like '" .$filterstr ."') or (state like '" .$filterstr ."'))";
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
<td><a href="manage_transporters.php?a=add">Add Record</a>&nbsp;
<?php if ($page > 1) { ?>
<a href="manage_transporters.php?page=<?php echo $page - 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">&lt;&lt;&nbsp;Prev</a>&nbsp;
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
<a href="manage_transporters.php?page=<?php echo $j ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>"><?php echo $j ?></a>
<?php } } } else { ?>
<a href="manage_transporters.php?page=<?php echo $startpage ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>"><?php echo $startpage ."..." .$count ?></a>
<?php } } } ?>
<?php if ($page < $pagecount) { ?>
&nbsp;<a href="manage_transporters.php?page=<?php echo $page + 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Next&nbsp;&gt;&gt;</a>&nbsp;</td>
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
	<td class="hr"><font color="#FFFFFF"><strong>Company Name</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>Contact Person</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>Contact No.</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>City</strong></font></td>	
	<td class="hr"><font color="#FFFFFF"><strong>State</strong></font></td>		
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
?>
<tr height="20" bgcolor="<?php echo $style1?>">
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["company_name"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["contact_person"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["contact_no"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["city"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["state"]) ?></td>
</tr>
<?php
  }
  mysql_free_result($res);
?>
</table>
<br />

</body>
</html>	
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
	echo "<?xml version='1.0'?><xml>";
	for ($i = 0; $i < $count; $i++)
	{
		$row = mysql_fetch_assoc($res);
		echo "<Transporter>";
		echo "<Company_Name>".$row["company_name"]."</Company_Name>";
		echo "<Contact_Person>".$row["contact_person"]."</Contact_Person>";
		echo "<Contact_No>".$row["contact_no"]."</Contact_No>";
		echo "<City>".$row["city"]."</City>";
		echo "<State>".$row["state"]."</State>";
		echo "</Transporter>";
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
$res = sql_select();
$count = sql_getrecordcount();
	echo "Company Name,Contact Person,Contact No,City, State \n";
	for ($i = 0; $i < $count; $i++)
	{
		$row = mysql_fetch_assoc($res);
		echo "\"".$row['company_name']."\",\"".$row['contact_person']."\",\"".$row['contact_no']."\",\"".$row['city']."\",\"".$row['state']."\" \n";
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