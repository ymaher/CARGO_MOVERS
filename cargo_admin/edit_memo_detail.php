<?php include('../session_validator.php');?>

<?php
if(isset($_POST['memo_edit']))
{
	include('../dbConnect.php');
	$error = 0;
	$description = "";
	/*if(isset($_POST['bill_no']) && ($_POST['bill_no'] != ""))
	{
		$sql_bill = "select count(*) as cnt from commission_memo where bill_no = ".$_POST['bill_no'];
		//echo $sql_bill;
		$res_bill = mysql_query($sql_bill);
		$row_bill = mysql_fetch_array($res_bill);
		if($row_bill['cnt']>0)
		{
			$bill_no = $_POST['bill_no'];
			$error = 1;
			$description = "Duplicate Bill No. Already assigned to another transctation";
		}
	} else { $error = 2; $description = "Bill No is required field"; }
	*/
	$bill_no = $_POST['bill_no'];
	$transporter_id = $_POST['transporter_id'];
	$truck_owner_id = $_POST['truck_owner_id']; 
	$from_location = $_POST['from_location'];
	$to_location = $_POST['to_location']; 
	$perticulars = $_POST['perticulars'];
	$truck_no = $_POST['truck_no'];
	$account_no = $_POST['account_no'];
	$fright_charges = $_POST['fright_charges'];
	$advance = $_POST['advance']; 
	//$driver_paid_advance = $_POST['driver_paid_advance'];
	//$advance_balance_amt = $_POST['advance_balance_amt'];
	$payable_at = $_POST['payable_at'];
	//$commission_charges = $_POST['commission_charges'];
	//$chalan_mamul = $_POST['chalan_mamul'];
	//$extra_charges = $_POST['extra_charges'];
	//$balance = $_POST['balance'];
	$gc_no = $_POST['gc_no'];
	//$challan_no = $_POST['challan_no'];
	$weight = $_POST['weight'];
	$remark = $_POST['remark'];
	
	 	
	if( $_POST['transporter_id']== "" ){ $error = 3; $description = "Transporters Id is required field";  }
	
	if($_POST['truck_owner_id']== ""){ $error = 4; $description = "Truck Owner Id is required field"; }
	
	if($_POST['from_location']== ""){ $error = 5; $description = "From Location is required field"; }
	
	if($_POST['to_location']== ""){ $error = 6; $description = "To Location is required field"; }
	
	if($_POST['perticulars']== ""){ $error = 7; $description = "Perticulars is required field"; }
	
	if($_POST['truck_no']== ""){ $error = 8; $description = "Truck No is required field"; }
	
	//if($_POST['account_no']== ""){ $error = 14; $description = "Account No is required field"; }
	
	if($_POST['fright_charges']== ""){ $error = 9; $description = "Fright Charges is required field"; }
	
	if($_POST['advance']== ""){ $error = 10; $description = "Advance is required field"; }
	
	//if($_POST['driver_paid_advance']== ""){ $error = 11; $description = "Driver Paid Advance is required field"; }
	
	//if($_POST['advance_balance_amt']== ""){ $error = 12; $description = "Advance Balance Amount is required field"; }
	
	if($_POST['payable_at']== ""){ $error = 13; $description = "Payable at is required field"; }
	
	//Memo date
	if(isset($_POST['dd'])){ $dd = $_POST['dd']; }
	if(isset($_POST['mm'])){ $mm = $_POST['mm']; }
	if(isset($_POST['yy'])){ $yy = $_POST['yy']; }
	$date = $yy."-".$mm."-".$dd;
	
	//GC Date handling
	if(isset($_POST['gc_dd'])){ $gc_dd = $_POST['gc_dd']; }
	if(isset($_POST['gc_mm'])){ $gc_mm = $_POST['gc_mm']; }
	if(isset($_POST['gc_yy'])){ $gc_yy = $_POST['gc_yy']; }
	$gc_date = $gc_yy."-".$gc_mm."-".$gc_dd;
	
	//Pouch Date handling
	if(isset($_POST['pouch_dd'])){ $pouch_dd = $_POST['pouch_dd']; }
	if(isset($_POST['pouch_mm'])){ $pouch_mm = $_POST['pouch_mm']; }
	if(isset($_POST['pouch_yy'])){ $pouch_yy = $_POST['pouch_yy']; }
	$pouch_date = $pouch_yy."-".$pouch_mm."-".$pouch_dd;
		

	?>
		<script>
			//alert('<?php echo $account_no;?>');
			//document.location = "commisssion_memo.php";
		</script>
	<?php
	
	if($error > 0)
	{
	?>
		<script>
			alert('<?php echo $description;?>');
			document.location = history.back();
		</script>
	<?php
	} else
	{
		//Updating memo...
		$sql_memo = "update commission_memo set transporter_id = $transporter_id, truck_owner_id = $truck_owner_id, from_location = '$from_location', to_location = '$to_location', date = '$date', perticulars = '$perticulars', truck_detail_id = $truck_no, fright_charges = $fright_charges, advance = $advance, payable_at = '$payable_at', gc_no = '$gc_no', gc_date = '$gc_date', weight = '$weight', pouch_date = '$pouch_date', remark = '$remark' where commission_id = ".$_POST['commission_id'];
		//echo $sql_memo;
		$res_memo = mysql_query($sql_memo);
	?>
		<script>
			//document.location = "fees_receipt.php?id=<?php echo $id; ?>";
			//alert('Successfully done the operation\r\nPlease refresh the page to see the effect');
			//opener=self;
			window.close();
			if(window.opener && !window.opener.closed)
			{
				window.opener.location.reload();
			} 	
		</script>
	<?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../files/grid_style.css" media="screen" />
<link type="text/css" href="../files/style.css" media="screen" rel="stylesheet" />
<script language="javascript" src="../files/form_validator.js"></script>
<script language="javascript" src="js/ajax.js"></script>
<script language="javascript">
function getTruckOwnerDetails(){
	document.getElementById('truck').innerHTML = "<img src=\"../files/ajax-loader.gif\" />";
	var url = "getTrucks.php?id=";
	var truck_owner_id = document.getElementById('truck_owner_id').value;
	//alert(truck_owner_id);
	if(truck_owner_id == "") 
	{ 	
		document.getElementById('truck').innerHTML = "<select style=\"width:100%;\" required=\"1\"><option value=\"\">Select Truck No.</option></select>";
		return;
	}
	url += escape(truck_owner_id);
	//alert(url);
	var i = doAction(url,'truck');	
}
</script>
<title>Edit Memo Details</title>
</head>

<body>
<?php 
include('../dbConnect.php');

$sql = "select * from commission_memo where commission_id = ".$_GET['memo_id'];
$res = mysql_query($sql);
$row = mysql_fetch_array($res);
?>
<form action="edit_memo_detail.php" method="post" onSubmit="if(isFormValid()) ; else { alert('Something is wrong');return false; }">
<table border="1" cellspacing="1" cellpadding="5" width="98%" align="center">
<tr>
<td colspan="4" class="hr" height="25" align="center"><font style="font-size:16px;"><strong>Commission Memo </strong></font></td>
</tr>
<tr>
<td class="hr" width="25%">Bill No</td>
<td class="dr" width="25%"><input type="text"  name="bii_no" value="<?php echo htmlspecialchars($row["bill_no"])?>"  readonly="true"/></td>
<td class="hr" width="25%">Date</td>
<td class="dr" width="25%">
<table><tr>
			<td>
				<select name="dd" id="dd" readonly="true">
				<?php
				  $date = explode('-',$row['date']);
				  $yy = $date[0];
				  $mm = $date[1];
				  $dd = $date[2];
				  
				  $lookupvalues = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($dd == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="mm" id="mm" readonly="true">
				<?php
				  $lookupvalues = array("00","01","02","03","04","05","06","07","08","09","10","11","12");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($mm == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="yy" id="yy" readonly="true">
				<?php
				  $lookupvalues = array("0000","2010","2011","2012","2013","2014","2015","2016","2017","2018","2019","2020","2021","2022","2023","2024","2025");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($yy == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
		</tr></table>
</td>
</tr>
<tr>
<td class="hr">Transporter</td>
<td class="dr"><select name="transporter_id" id="transporter_id" style="width:100%;" required="1" >
		<option value="">Select Transporter</option>
		<?php
			include('../dbConnect.php');
			$sql_owner = "select company_name, transporter_id from transporter where deleted = 'no'";
			$res_owner = mysql_query($sql_owner);
			while ($row_owner = mysql_fetch_assoc($res_owner))
			{
			  $val = $row['transporter_id'];
			  $caption = $row_owner["company_name"];
			  if($row_owner["transporter_id"] == $val) {$selstr = " selected"; } else {$selstr = ""; } ?>
				<option value="<?php echo $row_owner["transporter_id"] ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
		<?php	
			}
		?>
	</select></td>
<td class="hr">Lorry Owner</td>
<td class="dr">
	<select name="truck_owner_id" id="truck_owner_id" style="width:100%;" required="1" onChange="getTruckOwnerDetails();">
		<option value="" readonly="true">Select Truck Owner</option>
		<?php
			include('../dbConnect.php');
			$sql_owner = "select name, truck_owner_id from truck_owner where deleted = 'no'";
			$res_owner = mysql_query($sql_owner);
			while ($row_owner = mysql_fetch_assoc($res_owner))
			{
			  $val = $row['truck_owner_id'];
			  $caption = $row_owner["name"];
			  if($row_owner["truck_owner_id"] == $val) {$selstr = " selected"; } else {$selstr = ""; } ?>
				<option value="<?php echo $row_owner["truck_owner_id"] ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
		<?php	
			}
		?>
	</select>
</td>
</tr>
<tr>
<td class="hr">From</td>
<td class="dr"><input type="text" name="from_location" id="from_location" style="width:100%;" required="1" value="<?php echo htmlspecialchars($row["from_location"]) ?>"  readonly="true"/></td>
<td class="hr">To</td>
<td class="dr"><input type="text" name="to_location" id="to_location" style="width:100%;" required="1" value="<?php echo htmlspecialchars($row["to_location"]) ?>"  readonly="true"/></td>
</tr>
<tr>
<td class="hr">Perticulars</td>
<td class="dr"><input type="text" name="perticulars" id="perticulars" style="width:100%;" required="1" value="<?php echo htmlspecialchars($row["perticulars"]) ?>"  readonly="true"/></td>
<td class="hr">Truck No</td>
<td class="dr">
<span id="truck">
	<?php
	if($row['truck_owner_id'] != '')
	{
	?>
		<select style="width:100%" required="1" name="truck_no" id="truck_no">
		<option value="" readonly="true">Select Truck</option>
	<?php
		$sql_truck = "SELECT truck_detail_id, truck_no from truck_detail where truck_owner_id = ".$row['truck_owner_id'];
		$res_truck = mysql_query($sql_truck);
		while($row_truck = mysql_fetch_array($res_truck))
		{
			if($row['truck_detail_id'] == $row_truck['truck_detail_id']){ $selected = "selected"; } else { $selected = ""; }
			echo "<option value=\"".$row_truck['truck_detail_id']."\" ".$selected.">".$row_truck['truck_no']."</option>";
		}
	?>
		</select>
	<?php
	} else { ?>
	<select style="width:100%" required="1" name="truck_no" id="truck_no">
		<option value="" readonly="true">Select Truck No.</option>
	</select>
	<?php
		}
	?>
	</span>
</td>
</tr>
<tr>
<td class="hr">Fright Charges</td>
<td class="dr"><input type="text" name="fright_charges" id="fright_charges" style="width:100%;" required="1" mask="float" value="<?php echo htmlspecialchars($row["fright_charges"]) ?>" readonly="true"></td>
<td class="hr">Advance</td>
<td class="dr"><input type="text" name="advance" id="advance" style="width:100%;" required="1" mask="float" value="<?php echo htmlspecialchars($row["advance"]) ?>" /></td>
</tr>
<tr>
<td class="hr">G C No.</td>
<td class="dr"><input type="text" name="gc_no" id="gc_no" style="width:100%;" value="<?php echo htmlspecialchars($row["gc_no"]) ?>"  readonly="true"/></td>
<td class="hr">G C Date</td>
<td class="dr">
<table><tr>
			<td>
				<select name="dd" id="dd" readonly="true">
				<?php
				  $date = explode('-',$row['date']);
				  $yy = $date[0];
				  $mm = $date[1];
				  $dd = $date[2];
				  
				  $lookupvalues = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($dd == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="mm" id="mm" readonly="true">
				<?php
				  $lookupvalues = array("00","01","02","03","04","05","06","07","08","09","10","11","12");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($mm == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="yy" id="yy" readonly="true">
				<?php
				  $lookupvalues = array("0000","2010","2011","2012","2013","2014","2015","2016","2017","2018","2019","2020","2021","2022","2023","2024","2025");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($yy == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
		</tr></table>
</td>
</tr>
<tr>
<td class="hr">Weight</td>
<td class="dr"><input type="text" name="weight" id="weight" style="width:100%;" value="<?php echo htmlspecialchars($row["weight"]) ?>"  readonly="true"/></td>
<td class="hr">Payable At</td>
<td class="dr"><input type="text" name="payable_at" id="payable_at" style="width:100%;" value="<?php echo htmlspecialchars($row["payable_at"]) ?>" /></td>
</tr>
<tr>
<td class="hr">&nbsp;</td>
<td class="dr">&nbsp;</td>
<td class="hr">Remarks</td>
<td class="dr"><textarea name="remark" id="remark" style="width:100%;"><?php echo htmlspecialchars($row["remark"]) ?></textarea></td>
</tr>
<tr>
	<td class="hr" colspan="4" align="right"><input type="submit" value="Save" name="memo_edit" id="memo_edit" /></td>
</tr>
</table>
<input type="hidden" name="commission_id" id="commission_id" value="<?php echo $_GET['memo_id'];?>" />
</form>
</body>
</html>
