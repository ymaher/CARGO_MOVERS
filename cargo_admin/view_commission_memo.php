<?php include('../session_validator.php');?>
<?php
if (isset($_GET["order"])) $order = @$_GET["order"]; 
if (isset($_GET["type"])) $ordtype = @$_GET["type"];

$filter="";
$filterfield="";
$wholeonly="";

$f = @$_GET["f"];
if(isset($_GET["f"])){
	$param = explode("`",$f);
	$filter = $param[0];
	$filterfield = $param[1];
	$wholeonly = $param[2];
	$fromdate = $param[3];
	$todate = $param[4];
	$transporter_id = $param[5];
	$truck_owner_id = $param[6];
}
$filter="";
$filterfield="";
$wholeonly="";
$fromdate="";
$todate="";
$transporter_id="";
$truck_owner_id="";

if (isset($_POST["filter"])) $filter = @$_POST["filter"];
if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
if (isset($_POST["fromdate"])) $fromdate = @$_POST["fromdate"];
if (isset($_POST["todate"])) $todate = @$_POST["todate"];
if (isset($_POST["transporter_id"])) $transporter_id = @$_POST["transporter_id"];
if (isset($_POST["truck_owner_id"])) $truck_owner_id = @$_POST["truck_owner_id"];
$f = $filter."`".$filterfield."`".$wholeonly."`".$fromdate."`".$todate."`".$transporter_id."`".$truck_owner_id;


$a = @$_GET["a"];
switch($a){
case 'word':
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=MemoList.doc');
	export_Word_Excel();
	exit();
	break;
case 'excel':
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=MemoList.xls');
	export_Word_Excel();
	exit();
	break;
case 'xml':	
	header('Content-Type: text/xml');
	header('Content-Disposition: attachment; filename=MemoList.xml');
	export_xml($export);
	exit();
	break;
case 'csv':	
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename=MemoList.csv');
	export_csv($export);
	exit();
	break;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>View Commission Memo</title>

<script language="javascript" src="../files/form_validator.js"></script>
<script language="javascript" type="text/javascript">
function MouseOver(row) {
	row.className = "B";
}

function MouseOut(row) {
	row.className = "Btable";
}
</script>
<script>
function openWindow(url)
{
	var h = 300;
	var w = 400;
	var winl = (screen.width-w)/2;
	var wint = (screen.height-h)/2;
	NewWin=window.open(url,'NewWin','menubar=yes,status=yes, width='+w+', height='+h+', scrollbars=1, top='+wint+', left='+winl);
}
</script>

<script>
function openWindow1(url)
{
	var h = 400;
	var w = 800;
	var winl = (screen.width-w)/2;
	var wint = (screen.height-h)/2;
	NewWin=window.open(url,'NewWin','menubar=yes,status=no, width='+w+', height='+h+', scrollbars=1, top='+wint+', left='+winl);
}
</script>
<script language="javascript" src="js/ajax.js"></script>
<script type="text/javascript">
function deleteRec(i,id)
{
	if(confirm('Are you sure you want to delete this record??'))
	{
		document.getElementById('balance').innerHTML = "<img src=\"../files/ajax-loader.gif\" />";
		document.getElementById('memo_amount').deleteRow(i)
		var url = "delCommissionAmount.php?id=";
		url += escape(id);
		//alert(url);
		var i = doAction(url,'balance');
		//window.location.reload();
	}
}
</script>
<link type="text/css" rel="stylesheet" href="../files/grid_style.css" media="screen" />
<link type="text/css" rel="stylesheet" href="../files/dhtmlgoodies_calendar.css?random=20051112" media="screen" />
<SCRIPT type="text/javascript" src="../files/dhtmlgoodies_calendar.js?random=20060118"></script>

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
  global $fromdate;
  global $todate;
  global $transporter_id;
  global $truck_owner_id;
  
  if ($a == "reset") {
    $filter = "";
    $filterfield = "";
    $wholeonly = "";
    $order = "";
    $ordtype = "";
	$fromdate = "";
	$todate = "";
	$transporter_id = "";
	$truck_owner_id = "";
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
<form action="view_commission_memo.php" method="post" style="background-image:url(ettwre.jpg)">
<table width="93%" height="214"  border="0" align="center" cellpadding="4" cellspacing="1">
<tr>
<td class="td1"><h1>Search By </h1></td>
<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
<td><select name="filter_field">
<option value="">All Fields</option>
<option value="<?php echo "bill_no" ?>"<?php if ($filterfield == "bill_no") { echo "selected"; } ?>>C M No.</option>
<option value="<?php echo "gc_no" ?>"<?php if ($filterfield == "gc_no") { echo "selected"; } ?>>G C No.</option>
</select></td>
<td class="td1">&nbsp;</td>
</td></tr>
<tr>
	<td class="td1"><strong>To Date:</strong>
	  <input type="text" name="todate" id="todate" onFocus="displayCalendar(this,'yyyy-mm-dd',this)" value="<?php echo $todate; ?>" /></td>
	<td class="td1"><strong>From Date</strong>:
	  <input type="text" name="fromdate" id="fromtodate" onFocus="displayCalendar(this,'yyyy-mm-dd',this)" value="<?php echo $fromdate; ?>" /></td>
	<td class="td1"><strong>Transporters
	</strong>	  <select name="transporter_id" id="transporter_id">
		<option value="">All Transporters</option>
		<?php
			include('../dbConnect.php');
			$sql_owner = "select company_name, transporter_id from transporter where deleted = 'no'";
			$res_owner = mysql_query($sql_owner);
			while ($row_owner = mysql_fetch_assoc($res_owner))
			{
			  $val = $transporter_id;
			  $caption = $row_owner["company_name"];
			  if($row_owner["transporter_id"] == $val) {$selstr = " selected"; } else {$selstr = ""; } ?>
				<option value="<?php echo $row_owner["transporter_id"] ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
		<?php	
			}
		?>
	</select>	</td>
	<td class="td1"><strong>Lorry Owner
	</strong>	  <select name="truck_owner_id" id="truck_owner_id">
		<option value="">All Lorry Owner</option>
		<?php
			include('../dbConnect.php');
			$sql_owner = "select name, truck_owner_id from truck_owner where deleted = 'no'";
			$res_owner = mysql_query($sql_owner);
			while ($row_owner = mysql_fetch_assoc($res_owner))
			{
			  $val = $truck_owner_id;
			  $caption = $row_owner["name"];
			  if($row_owner["truck_owner_id"] == $val) {$selstr = " selected"; } else {$selstr = ""; } ?>
				<option value="<?php echo $row_owner["truck_owner_id"] ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
		<?php	
			}
		?>
	</select>	</td>
</tr>
<tr>
<td height="60">&nbsp;</td>
<td><input type="submit" value="Apply Search" /></td>
<td><a href="view_commission_memo.php?a=reset">Reset Search </a></td>
<td>&nbsp;</td>
</tr>
</table>
</form>
<hr size="1" noshade width="100%" align="center"> 
 <br> <br>
<table border="0" cellspacing="1" cellpadding="5" width="100%" align="center">
<tr>
	<td class="hr"><font color="#FFFFFF">Bill No</font></td>
	<td class="hr"><font color="#FFFFFF">GC No</font></td>
	<td class="hr"><font color="#FFFFFF">Transporter</font></td>
	<td class="hr"><font color="#FFFFFF">Truck Owner</font></td>
	<td class="hr"><font color="#FFFFFF">Date</font></td>
	<td class="hr"><font color="#FFFFFF">Fright Charges</font></td>
	<td class="hr"><font color="#FFFFFF">Balance Amount</font></td>
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
	 
	 $sql_truckowner = "select name from truck_owner where truck_owner_id = ".$row['truck_owner_id'];
	 $res_truckowner = mysql_query($sql_truckowner);
	 $row_truckowner = mysql_fetch_array($res_truckowner);
	 
	 $sql_transporter = "select company_name from transporter where transporter_id = ".$row['transporter_id'];
	 $res_transporter = mysql_query($sql_transporter);
	 $row_transporter = mysql_fetch_array($res_transporter);
	 
	 $sql_amt = "select sum(amount) as amt from memo_amount where memo_amount_id = 'no' and commission_id = ".$row['commission_id'];
     $res_amt = mysql_query($sql_amt);
	 $row_amt = mysql_fetch_array($res_amt);
?>
<tr height="20" bgcolor="<?php echo $style1?>" onmouseover="MouseOver(this);" onmouseout="MouseOut(this);">
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["bill_no"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["gc_no"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row_transporter["company_name"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row_truckowner["name"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars(FormatDate($row["date"])) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars(indian_cur($row["fright_charges"])) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars(indian_cur($row["fright_charges"] - $row['advance'])) ?></td>
<td class="<?php echo $style ?>" align="center"><a href="view_commission_memo.php?a=view&recid=<?php echo $i ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="View Memo Details">View</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="return confirm('Are you sure you want to delete this item?');" href="view_commission_memo.php?a=del&recid=<?php echo $i ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="Delete Commission Memo">Delete</a></td>
</tr>
<?php
  }
  mysql_free_result($res);
?>
<tr>
	<td colspan="6"></td>
	<td class="hr">Grand Total : <?php echo indian_cur(calc_balance_amount()); ?></td>
	<td></td>
</tr>
</table>
<br>
<table width="100%" align="center" >
		<tr height="20" valign="middle"><td align="right"><a href="view_commission_memo.php?a=word&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="Microsoft WORD Format" style="text-decoration:none;">Export to Word</a><font style="color:#000000; font-weight:bold;"> &brvbar; </font><a href="view_commission_memo.php?a=excel&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>" title="Microsoft EXCEL Format" style="text-decoration:none;">Export to Excel</a>&nbsp;&nbsp;&nbsp;</td></tr>
	</table>

<?php showpagenav($page, $pagecount); ?>

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
<td><a href="commission_memo.php">Add Record</a></td>
<td><a onclick="return confirm('Are you sure you want to delete this item?');" href="view_commission_memo.php?a=del&recid=<?php echo $recid ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Delete Record</a></td>
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
<form enctype="multipart/form-data" action="view_commission_memo.php" method="post" onsubmit="if(isFormValid()) ; else { alert('Something is wrong');return false; }">
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
<form action="view_commission_memo.php" method="post">

<?php showrow($row, $recid) ?>
<br />
<hr size="1" noshade align="center" width="100%">
<input type="submit" value="Confirm" />
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xId" value="<?php echo $row["commission_id"] ?>">
</form>
<?php
  mysql_free_result($res);
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
//Query to fetch truck owner name
$sql_truckowner = "select name from truck_owner where truck_owner_id = ".$row['truck_owner_id'];
$res_truckowner = mysql_query($sql_truckowner);
$row_truckowner = mysql_fetch_array($res_truckowner);

//Query to fetch transporter company name
$sql_transporter = "select company_name from transporter where transporter_id = ".$row['transporter_id'];
$res_transporter = mysql_query($sql_transporter);
$row_transporter = mysql_fetch_array($res_transporter);
?>
<table border="1" cellspacing="1" cellpadding="5" width="90%" align="center">
<tr>
<td colspan="4" class="hr" height="25" align="center"><font style="font-size:16px;"><strong>Commission Memo </strong></font></td>
</tr>
<tr>
<td class="hr" width="25%">C M No.</td>
<td class="dr" width="25%"><?php echo htmlspecialchars($row["bill_no"]) ?></td>
<td class="hr" width="25%">Date</td>
<td class="dr" width="25%"><?php echo htmlspecialchars(FormatDate($row["date"])) ?></td>
</tr>
<tr>
<td class="hr">Transporter</td>
<td class="dr"><?php echo htmlspecialchars($row_transporter["company_name"]) ?></td>
<td class="hr">Lorry Owner</td>
<td class="dr"><?php echo htmlspecialchars($row_truckowner["name"]) ?></td>
</tr>
<tr>
<td class="hr">From</td>
<td class="dr"><?php echo htmlspecialchars($row["from_location"]) ?></td>
<td class="hr">To</td>
<td class="dr"><?php echo htmlspecialchars($row["to_location"]) ?></td>
</tr>
<tr>
<td class="hr">Perticulars</td>
<td class="dr"><?php echo htmlspecialchars($row["perticulars"]) ?></td>
<td class="hr">Truck No</td>
<?php
//Query to fetch Truck No.
$sql_truckno = "select truck_no from truck_detail where truck_detail_id = ".$row['truck_detail_id'];
$res_truckno = mysql_query($sql_truckno);
$row_truckno = mysql_fetch_array($res_truckno);
?>
<td class="dr"><?php echo htmlspecialchars($row_truckno["truck_no"]) ?></td>
</tr>
<tr>
<td class="hr">Fright Charges</td>
<td class="dr"><?php echo htmlspecialchars($row["fright_charges"]) ?></td>
<td class="hr">Advance</td>
<td class="dr"><?php echo htmlspecialchars($row["advance"]) ?></td>
</tr>
<tr>
<td class="hr">G C No.</td>
<td class="dr"><?php echo htmlspecialchars($row["gc_no"]) ?></td>
<td class="hr">G C Date</td>
<td class="dr"><?php echo htmlspecialchars($row["gc_date"]) ?></td>
</tr>
<tr>
<td class="hr">Weight</td>
<td class="dr"><?php echo htmlspecialchars($row["weight"]) ?></td>
<td class="hr">Payable At</td>
<td class="dr"><?php echo htmlspecialchars($row["payable_at"]) ?></td>
</tr>
<tr>
<td class="hr">&nbsp;</td>
<td class="dr">&nbsp;</td>
<td class="hr">Remarks</td>
<td class="dr"><?php echo htmlspecialchars($row["remark"]) ?></td>
</tr>
<tr>
	<td class="hr" colspan="4" align="right"><input type="button" value="Edit" onClick="openWindow1('edit_memo_detail.php?memo_id=<?php echo $row['commission_id']?>');" /></td>
</tr>
</table>

<?php
$sql1 = "select * from memo_amount where commission_id = ".$row['commission_id']." order by date desc";
$res1 = mysql_query($sql1);
?>
<br />
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
<td><a href="view_commission_memo.php?order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Index Page</a></td>
<?php if ($recid > 0) { ?>
<td><a href="view_commission_memo.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Prior Record</a></td>
<?php } if ($recid < $count - 1) { ?>
<td><a href="view_commission_memo.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Next Record</a></td>
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
	global $fromdate;
    global $todate;
	global $transporter_id;
    global $truck_owner_id;
  	
	include("../dbConnect.php");
	$filterstr = sqlstr($filter);
	if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
	$sql = "SELECT * FROM commission_memo";
	if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
	$sql .= " where " .sqlstr($filterfield) ." like '" .$filterstr ."'";
	} elseif (isset($filterstr) && $filterstr!='') {
	$sql .= " where ((bill_no like '" .$filterstr ."') or (gc_no like '" .$filterstr ."'))";
	}
	if((isset($todate) && $todate!='') && (isset($fromdate) && $fromdate!=''))
	{
		if(strpos($sql, 'where')>0){$sql .= " and "; } else {{$sql .= " where "; }}
		$sql .= " date between '".$todate."' and '".$fromdate."'";
	}
	if((isset($transporter_id) && $transporter_id!=''))
	{
		if(strpos($sql, 'where')>0){$sql .= " and "; } else {{$sql .= " where "; }}
		$sql .= " transporter_id = ".$transporter_id;
	}
	if((isset($truck_owner_id) && $truck_owner_id!=''))
	{
		if(strpos($sql, 'where')>0){$sql .= " and "; } else {{$sql .= " where "; }}
		$sql .= " truck_owner_id = ".$truck_owner_id;
	}
	if (isset($order) && $order!='') $sql .= " order by " .sqlstr($order) ."";
	else $sql .= " order by date ";
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
//To delete a row from the database...
function sql_delete()
{
  include("../dbConnect.php");
  $sql = "delete from commission_memo where commission_id = ".sqlvalue(@$_POST["xId"], true);
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
	global $fromdate;
	global $todate;
	global $transporter_id;
    global $truck_owner_id;
    include("../dbConnect.php");
	
	$filterstr = sqlstr($filter);
	if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
	$sql = "SELECT COUNT(*) FROM commission_memo ";
	if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
	$sql .= " where " .sqlstr($filterfield) ." like '" .$filterstr ."'";
	} elseif (isset($filterstr) && $filterstr!='') {
	$sql .= " where ((bill_no like '" .$filterstr ."') or (gc_no like '" .$filterstr ."'))";
	}
	if((isset($todate) && $todate!='') && (isset($fromdate) && $fromdate!=''))
	{
		if(strpos($sql, 'where')>0){$sql .= " and "; } else {{$sql .= " where "; }}
		$sql .= " date between '".$todate."' and '".$fromdate."'";
	}
	if((isset($transporter_id) && $transporter_id!=''))
	{
		if(strpos($sql, 'where')>0){$sql .= " and "; } else {{$sql .= " where "; }}
		$sql .= " transporter_id = ".$transporter_id;
	}
	if((isset($truck_owner_id) && $truck_owner_id!=''))
	{
		if(strpos($sql, 'where')>0){$sql .= " and "; } else {{$sql .= " where "; }}
		$sql .= " truck_owner_id = ".$truck_owner_id;
	}
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	reset($row);
	return current($row);
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>

<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function to calculate the entire balance amount depending upon the query
function calc_balance_amount()
{
	$balance_amount = 0;
	$res = sql_select();
	while($row = mysql_fetch_array($res))
	{
		$sql_amt = "select sum(amount) as amt from memo_amount where memo_amount_id = 'no' and commission_id = ".$row['commission_id'];
		$res_amt = mysql_query($sql_amt);
		$row_amt = mysql_fetch_array($res_amt);
		$balance_amount += $row['fright_charges'] - $row['advance'];
	}
	return $balance_amount;
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
<td><a href="commission_memo.php">Add Record</a>&nbsp;
<?php if ($page > 1) { ?>
<a href="view_commission_memo.php?page=<?php echo $page - 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">&lt;&lt;&nbsp;Prev</a>&nbsp;
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
<a href="view_commission_memo.php?page=<?php echo $j ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>"><?php echo $j ?></a>
<?php } } } else { ?>
<a href="view_commission_memo.php?page=<?php echo $startpage ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>"><?php echo $startpage ."..." .$count ?></a>
<?php } } } ?>
<?php if ($page < $pagecount) { ?>
&nbsp;<a href="view_commission_memo.php?page=<?php echo $page + 1 ?>&order=<?php echo $order ?>&type=<?php echo $ordtype ?>&f=<?php echo $f ?>">Next&nbsp;&gt;&gt;</a>&nbsp;</td>
<?php } ?>
</tr>
</table>
<?php 
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
	<td class="hr"><font color="#FFFFFF"><strong>Bill No</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>GC No</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>Transporter</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>Truck Owner</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>Date</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>Fright Charges</strong></font></td>
	<td class="hr"><font color="#FFFFFF"><strong>Balance Amount</strong></font></td>
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
	 
	 $sql_truckowner = "select name from truck_owner where truck_owner_id = ".$row['truck_owner_id'];
	 $res_truckowner = mysql_query($sql_truckowner);
	 $row_truckowner = mysql_fetch_array($res_truckowner);
	 
	 $sql_transporter = "select company_name from transporter where transporter_id = ".$row['transporter_id'];
	 $res_transporter = mysql_query($sql_transporter);
	 $row_transporter = mysql_fetch_array($res_transporter);
	 
	 $sql_amt = "select sum(amount) as amt from memo_amount where memo_amount_id = 'no' and commission_id = ".$row['commission_id'];
     $res_amt = mysql_query($sql_amt);
	 $row_amt = mysql_fetch_array($res_amt);
?>
<tr height="20" bgcolor="<?php echo $style1?>">
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["bill_no"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["gc_no"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row_transporter["company_name"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row_truckowner["name"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars(FormatDate($row["date"])) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars(indian_cur($row["fright_charges"])) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars(indian_cur($row["fright_charges"] - $row_amt['amt'] )) ?></td>
</tr>
<?php
  }
  mysql_free_result($res);
?>
<tr>
	<td colspan="6"></td>
	<td bgcolor="#487698"><font color="#FFFFFF"><strong>Grand Total : <?php echo indian_cur(calc_balance_amount()); ?></strong></font></td>
</tr>
</table>
<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
}
?>

<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
//Function to convert the amount into indian currency format
function indian_cur($amt)
{
	$str = (string)$amt;
	$arr = explode('.',$str);
	$num = (string)$arr[0];
	$len = strlen($num) - 1;
	for($i=0; $i<=$len; $i++)
	{
		$x = $len - $i; // finding the offset to place a comma seperator
		if(($x<$len) && ($x==2 || $x==4 || $x==6 || $x==8 || $x==10 || $x==12 || $x==14 || $x==16 || $x==18))
		{
			echo ',';
		}
		echo $num[$i];
	}
	//if(strlen($arr[1])>0)
		//echo ".".$arr[1];
}
//--------------------------------------------------------------------------------------------------------------------------------------------
?>