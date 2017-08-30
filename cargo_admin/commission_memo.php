<?php include('../session_validator.php'); ?>
<?php
if(isset($_POST['commission_memo']))
{
	?>
		<script>
			//alert("Submitted");
			//document.location = "commisssion_memo.php";
		</script>
	<?php
	include('../dbConnect.php');
	$error = 0;
	$description = "";
	if(isset($_POST['bill_no']) && ($_POST['bill_no'] != ""))
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
	$driver_paid_advance = $_POST['driver_paid_advance'];
	$advance_balance_amt = $_POST['advance_balance_amt'];
	$payable_at = $_POST['payable_at'];
	$commission_charges = $_POST['commission_charges'];
	$chalan_mamul = $_POST['chalan_mamul'];
	$extra_charges = $_POST['extra_charges'];
	$balance = $_POST['balance'];
	$gc_no = $_POST['gc_no'];
	$challan_no = $_POST['challan_no'];
	$weight = $_POST['weight'];
	$remark = $_POST['remark'];
	
	 	
	if( $_POST['transporter_id']== "" ){ $error = 3; $description = "Transporters Id is required field";  }
	
	if($_POST['truck_owner_id']== ""){ $error = 4; $description = "Truck Owner Id is required field"; }
	
	if($_POST['from_location']== ""){ $error = 5; $description = "From Location is required field"; }
	
	if($_POST['to_location']== ""){ $error = 6; $description = "To Location is required field"; }
	
	if($_POST['perticulars']== ""){ $error = 7; $description = "Perticulars is required field"; }
	
	if($_POST['truck_no']== ""){ $error = 8; $description = "Truck No is required field"; }
	
	if($_POST['account_no']== ""){ $error = 14; $description = "Account No is required field"; }
	
	if($_POST['fright_charges']== ""){ $error = 9; $description = "Fright Charges is required field"; }
	
	if($_POST['advance']== ""){ $error = 10; $description = "Advance is required field"; }
	
	if($_POST['driver_paid_advance']== ""){ $error = 11; $description = "Driver Paid Advance is required field"; }
	
	if($_POST['advance_balance_amt']== ""){ $error = 12; $description = "Advance Balance Amount is required field"; }
	
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
	
	//Challan Date Handling
	if(isset($_POST['challan_dd'])){ $challan_dd = $_POST['challan_dd']; }
	if(isset($_POST['challan_mm'])){ $challan_mm = $_POST['challan_mm']; }
	if(isset($_POST['challan_yy'])){ $challan_yy = $_POST['challan_yy']; }
	$challan_date = $challan_yy."-".$challan_mm."-".$challan_dd;
	
	
	
	if($advance != ($driver_paid_advance + $chalan_mamul + $extra_charges + $advance_balance_amt + $commission_charges))
	{
		$error = 14; 
		$total = $driver_paid_advance + $chalan_mamul + $extra_charges + $advance_balance_amt + $commission_charges;
		$description = "Advance Amount and Expenditure are not matching\\n\\rAdvance: ".$advance."\\n\\rExpenditure: ".$total."";

	}
	
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
		</script>
	<?php
	} else
	{
		//Inserting a memo entry into the database...
		$sql_memo = "insert into commission_memo values(NULL, $bill_no, $transporter_id, $truck_owner_id, '$from_location', '$to_location', '$date', '$perticulars', $truck_no, $fright_charges, $advance, '$payable_at', '$gc_no', '$gc_date', '$weight','0000-00-00', '$remark')";
		$res_memo = mysql_query($sql_memo);
		
		//Getting the id from the above query
		$commission_memo_id = mysql_insert_id();
		
		//Inserting entries into memo_amount table
		if($_POST['driver_paid_advance'] != "")
		{
			$sql_amt = "insert into memo_amount values(NULL, '$commission_memo_id', 'Driver Paid Advance', ".$_POST['driver_paid_advance'].", NULL, NULL, '".date('Y-m-d')."','no')"; 
			$res_amt = mysql_query($sql_amt);
		}
		
		if($_POST['advance_balance_amt'] != "")
		{
			if($challan_no == ""){ $challan_no1 = 'NULL'; } else { $challan_no1 = "'".$challan_no."'";}
			$sql_amt = "insert into memo_amount values(NULL, $commission_memo_id, 'Advance Balance Paid to Lorry Owner', ".$_POST['advance_balance_amt'].", '".$_POST['account_no']."', ".$challan_no1.", '".$challan_date."', 'no')"; 
			$res_amt = mysql_query($sql_amt);
		}
		
		if($_POST['commission_charges'] != "")
		{
			$sql_amt = "insert into memo_amount values(NULL, $commission_memo_id, 'Commission Charges', ".$_POST['commission_charges'].", NULL, NULL, '".date('Y-m-d')."', 'no')"; 
			$res_amt = mysql_query($sql_amt);
		}
		
		if($_POST['extra_charges'] != "")
		{
			$sql_amt = "insert into memo_amount values(NULL, $commission_memo_id, 'Extra Charges', ".$_POST['extra_charges'].", NULL, NULL, '".date('Y-m-d')."', 'no')"; 
			$res_amt = mysql_query($sql_amt);
		}
		
		if($_POST['chalan_mamul'] != "")
		{
			$sql_amt = "insert into memo_amount values(NULL, $commission_memo_id, 'Challan Mamul', ".$_POST['chalan_mamul'].", NULL, NULL, '".date('Y-m-d')."', 'no')"; 
			$res_amt = mysql_query($sql_amt);
		}
	?>
		<script>
			alert("Successfully Added Memo");
			document.location = "commission_memo.php";
		</script>
	<?php
	}
}
?>

<html><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

<title>Commission Memo</title>
<link type="text/css" rel="stylesheet" href="../files/grid_style.css" media="screen" />
<script language="javascript" src="../files/form_validator.js"></script>

<script language="javascript" src="js/ajax.js"></script>
<script language="javascript">
function getTruckOwnerDetails(){
	document.getElementById('truck').innerHTML = "<img src=\"../files/ajax-loader.gif\" />";
	document.getElementById('account').innerHTML = "<img src=\"../files/ajax-loader.gif\" />";
	var url = "getTruckOwnerDetails.php?id=";
	var truck_owner_id = document.getElementById('truck_owner_id').value;
	//alert(truck_owner_id);
	if(truck_owner_id == "") 
	{ 	
		document.getElementById('truck').innerHTML = "<select style=\"width:100%;\" required=\"1\"><option value=\"\">Select Truck No.</option></select>";
		document.getElementById('account').innerHTML = "<select style=\"width:100%;\" required=\"1\"><option value=\"\">Select Acc No.</option></select>";
		return;
	}
	url += escape(truck_owner_id);
	//alert(url);
	var i = doAction_custom(url);	
}
</script>
<script>
function calcBalance()
{
    var name=document.getElementById("advance").value;
	if(name==null || name=="")
	{
	   alert("Invalid advance amount");
	   document.getElementById("advance").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("advance  must contains only digits");
	  document.getElementById("advance").focus();
	  return false;
	}
	else
	{
	  var fright_charges = document.getElementById('fright_charges').value;
	var advance = document.getElementById('advance').value;
	if((fright_charges !="") && (advance != ""))
	{
		document.getElementById('balance').value = fright_charges - advance;
	}
	}
 
  
	
}
</script>
<!--Header included here -->
<?php include('./header.php'); ?>

<!-- This is the Nevigation area -->
<?php include('./navigation.php'); ?>
<!-- This is the Nevigation area ends here -->

<!-- This is the central Working area -->
<td width="80%" align="left">
<table width="100%"><tr>
<td align="left" valign="top" width="100%">
<script type="text/javascript">

function validate_bill()
{
    var name=document.getElementById("bill_no").value;
	if(name==null || name=="")
	{
	   alert("Invalid number");
	   document.getElementById("bill_no").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("number must contains only digits");
	  document.getElementById("bill_no").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	

function validate_gc()
{
    var name=document.getElementById("gc_no").value;
	if(name==null || name=="")
	{
	   alert("Invalid gc number");
	   document.getElementById("bill_no").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("gc number must contains only digits");
	  document.getElementById("gc_no").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_fright()
{
    var name=document.getElementById("fright_charges").value;
	if(name==null || name=="")
	{
	   alert("Invalid fright charge");
	   document.getElementById("fright_charges").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("fright charges  must contains only digits");
	  document.getElementById("fright_charges").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_advance()
{
    var name=document.getElementById("advance").value;
	if(name==null || name=="")
	{
	   alert("Invalid advance amount");
	   document.getElementById("advance").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("advance  must contains only digits");
	  document.getElementById("advance").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_commch()
{
    var name=document.getElementById("commission_charges").value;
	if(name==null || name=="")
	{
	   alert("Invalid charge number");
	   document.getElementById("commission_charges").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("commisssion   must contains only digits");
	  document.getElementById("commission_charges").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_cm()
{
    var name=document.getElementById("chalan_mamul").value;
	if(name==null || name=="")
	{
	   alert("Invalid challan mamul");
	   document.getElementById("chalan_mamul").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("challan mamul  must contains only digits");
	  document.getElementById("chalan_mamul").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_extra()
{
    var name=document.getElementById("extra_charges").value;
	if(name==null || name=="")
	{
	   alert("Invalid extra charge");
	   document.getElementById("extra_charges").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("extra charge must contains only digits");
	  document.getElementById("extra_charges").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	

function validate_dp()
{
    var name=document.getElementById("driver_paid_advance").value;
	if(name==null || name=="")
	{
	   alert("Invalid payment");
	   document.getElementById("driver_paid_advance").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("payment must contains only digits");
	  document.getElementById("driver_paid_advance").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_ad()
{
    var name=document.getElementById("advance_balance_amt").value;
	if(name==null || name=="")
	{
	   alert("Invalid payment");
	   document.getElementById("advance_balance_amt").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("payment must contains only digits");
	  document.getElementById("advance_balance_amt").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	

function validate_cno()
{
    var name=document.getElementById("challan_no").value;
	if(name==null || name=="")
	{
	   alert("Invalid number");
	   document.getElementById("challan_no").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("number must contains only digits");
	  document.getElementById("challan_no").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_wht()
{
    var name=document.getElementById("weight").value;
	if(name==null || name<=0)
	{
	   alert("Invalid weight");
	   document.getElementById("weight").focus();
	   return false;
	 }
	else if (!name.match(/^[0-9]+$/)) 
	{
	  alert("weight must contains only digits");
	  document.getElementById("weight").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	

function validate_from()
{
    var name=document.getElementById("from_location").value;
	if(name==null || name=="")
	{
	   alert("Invalid location");
	   document.getElementById("from_location").focus();
	   return false;
	 }
	else if (!name.match(/^[a-zA-Z]+$/)) 
	{
	  alert("location must contains only letters");
	  document.getElementById("from_location").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_rmark()
{
    var name=document.getElementById("remark").value;
	if(name==null || name=="")
	{
	   alert("Invalid remark");
	   document.getElementById("remark").focus();
	   return false;
	 }
	else if (!name.match(/^[a-zA-Z]+$/)) 
	{
	  alert("remark  must contains only letters");
	  document.getElementById("remark").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	
function validate_pay()
{
    var name=document.getElementById("payable_at").value;
	if(name==null || name=="")
	{
	   alert("Invalid location");
	   document.getElementById("payable_at").focus();
	   return false;
	 }
	else if (!name.match(/^[a-zA-Z]+$/)) 
	{
	  alert("location must contains only letters");
	  document.getElementById("payable_at").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	

function validate_to()
{
    var name=document.getElementById("to_location").value;
	if(name==null || name=="")
	{
	   alert("Invalid location");
	   document.getElementById("to_location").focus();
	   return false;
	 }
	else if (!name.match(/^[a-zA-Z]+$/)) 
	{
	  alert("location must contains only letters");
	  document.getElementById("to_location").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	

function validate_pert()
{
    var name=document.getElementById("perticulars").value;
	if(name==null || name=="")
	{
	   alert("Invalid perticulars");
	   document.getElementById("perticulars").focus();
	   return false;
	 }
	else if (!name.match(/^[a-zA-Z]+$/)) 
	{
	  alert("perticulars must contains only letters");
	  document.getElementById("perticulars").focus();
	  return false;
	}
	else
	{
	 return true;  
	}
 
   
}	

</script>

<br>
<center>
<form action="commission_memo.php" method="post" onSubmit="if(isFormValid()); else { alert('Something is wrong');return false; }">
<table width="95%" border="1" cellspacing="1" cellpadding="4">
  <tr>
    <td colspan="4" class="hr" height="25" align="center"><font style="font-size:16px;"><strong>Commission Memo </strong></font></td>
  </tr>
  <tr>
    <td class="hr"><strong>C M No.</strong></td>
    <td><input type="text" name="bill_no" id="bill_no" style="width:100%;" required="1" value="" onClick="return validate_bill()" ></td>
    <td class="hr"><strong>Date</strong></td>
    <td>
		<?php 
			if(!(isset($dd))) $dd = date('d');
			if(!(isset($mm))) $mm = date('m');
			if(!(isset($yy))) $yy = date('Y');
		?>
		<table><tr>
			<td>
				<select name="dd" id="dd">
				<?php
				  $lookupvalues = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($dd == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="mm" id="mm">
				<?php
				  $lookupvalues = array("01","02","03","04","05","06","07","08","09","10","11","12");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($mm == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="yy" id="yy">
				<?php
				  $lookupvalues = array("2010","2011","2012","2013","2014","2015","2016","2017","2018","2019","2020","2021","2022","2023","2024","2025");
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
    <td width="20%" class="hr"><strong>Transporters</strong></td>
    <td width="30%">
	<select name="transporter_id" id="transporter_id" style="width:100%;" required="1">
		<option value="">Select Transporter</option>
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
	</select>
	</td>
    <td width="20%" class="hr"><strong>Lorry Owner </strong></td>
    <td width="30%">
	<select name="truck_owner_id" id="truck_owner_id" style="width:100%;" required="1" onChange="getTruckOwnerDetails();">
		<option value="">Select Truck Owner</option>
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
	</select>
	</td>
  </tr>
  <tr>
    <td class="hr"><strong>From</strong></td>
    <td><input type="text" name="from_location" id="from_location" style="width:100%;" required="1" value="" onClick="return validate_from()"></td>
    <td class="hr"><strong>To</strong></td>
    <td><input type="text" name="to_location" id="to_location" style="width:100%;" required="1" value="" onClick="return validate_to()"></td>
  </tr>
  <tr>
    <td class="hr"><strong>Perticulars</strong></td>
    <td><input type="text" name="perticulars" id="perticulars" style="width:100%;" value="" onClick="return validate_pert()"></td>
    <td class="hr"><strong>Truck No. </strong></td>
    <td><span id="truck">
	<?php
	if(isset($truck_owner_id) && $truck_owner_id != '')
	{
	?>
		<select style="width:100%" required="1" name="truck_no" id="truck_no">
		<option value="">Select Truck</option>
	<?php
		$sql_truck = "SELECT truck_detail_id, truck_no from truck_detail where truck_owner_id = ".$truck_owner_id;
		$res_truck = mysql_query($sql_truck);
		while($row_truck = mysql_fetch_array($res_truck))
		{
			if($truck_no == $row_truck['truck_detail_id']){ $selected = "selected"; } else { $selected = ""; }
			echo "<option value=\"".$row_truck['truck_detail_id']."\" ".$selected.">".$row_truck['truck_no']."</option>";
		}
	?>
		</select>
	<?php
	} else { ?>
	<select style="width:100%" required="1" name="truck_no" id="truck_no">
		<option value="">Select Truck No.</option>
	</select>
	<?php
		}
	?>
	</span>
	</td>
  </tr>
  <tr>
    <td class="hr"><strong>Fright Charges </strong></td>
    <td><input type="text" name="fright_charges" id="fright_charges" style="width:100%;" required="1" mask="float" value=""onClick="return validate_fright();"></td>
    <td class="hr"><strong>Advance</strong></td>
    <td><input type="text" name="advance" id="advance" style="width:100%;" required="1" mask="float" value="" onClick="calcBalance();" ></td>
  </tr>
  <tr>
    <td class="hr"><strong>Commission Charge </strong></td>
    <td><input type="text" name="commission_charges" id="commission_charges" style="width:100%;" required="1" mask="float" value="" onClick="return validate_commch()"></td>
    <td class="hr"><strong>Chalan Mamul </strong></td>
    <td><input type="text" name="chalan_mamul" id="chalan_mamul" style="width:100%;" mask="float" value=" " onClick="return validate_cm()"></td>
  </tr>
  <tr>
    <td class="hr"><strong>Extra Charges </strong></td>
    <td><input type="text" name="extra_charges" id="extra_charges" style="width:100%;" mask="float" value="" onClick="return validate_extra()"></td>
    <td class="hr"><strong>Driver Paid Advance </strong></td>
    <td><input type="text" name="driver_paid_advance" id="driver_paid_advance" style="width:100%;" mask="float" required="1" value="" onClick="return validate_dp()"></td>
  </tr>
  <tr>
    <td class="hr"><strong>Advance Balance Amount </strong></td>
    <td><input type="text" name="advance_balance_amt" id="advance_balance_amt" style="width:100%;" required="1" mask="float" value="" onClick="return validate_ad()"></td>
    <td class="hr"><strong>Account No</strong></td>
    <td><span id="account">
	<?php
	if(isset($truck_owner_id) && $truck_owner_id != '')
	{
	?>
		<select style="width:100%" required="1" name="account_no" id="account_no">
		<option value="">Select Account</option>
	<?php
		$sql_account = "SELECT acc_id, acc_no from truck_owner_acc where truck_owner_id = ".$truck_owner_id;
		$res_account = mysql_query($sql_account);
		while($row_account = mysql_fetch_array($res_account))
		{
			if($account_no == $row_account['acc_id']){ $selected = "selected"; } else { $selected = ""; }
			echo "<option value=\"".$row_account['acc_id']."\" ".$selected.">".$row_account['acc_no']."</option>";
		}
	?>
		</select>
	<?php
	} else { ?>
	<select style="width:100%" required="1" name="account_no" id="account_no">
		<option value="">Select Acc No.</option>
	</select>
	<?php
		}
	?>
	</span></td>
  </tr>
  <tr>
    <td class="hr"><strong>Balance</strong></td>
    <td><input type="text" name="balance" id="balance" style="width:100%;" readonly="readonly" value=""></td>
    <td class="hr"><strong>Payable At </strong></td>
    <td><input type="text" name="payable_at" id="payable_at" style="width:100%;" required="1" value="" onClick="return validate_pay()"></td>
  </tr>
  <tr>
    <td class="hr"><strong>G C No.</strong></td>
    <td><input type="text" name="gc_no" id="gc_no" style="width:100%;" value="" onClick="return validate_gc()"></td>
    <td class="hr"><strong>G C Date </strong></td>
    <td>
	<?php 
			if(!(isset($gc_dd))) $gc_dd = '00';
			if(!(isset($gc_mm))) $gc_mm = '00';
			if(!(isset($gc_yy))) $gc_yy = '0000';
		?>
		<table><tr>
			<td>
				<select name="dd" id="dd">
				<?php
				  $lookupvalues = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($dd == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="mm" id="mm">
				<?php
				  $lookupvalues = array("01","02","03","04","05","06","07","08","09","10","11","12");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($mm == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="yy" id="yy">
				<?php
				  $lookupvalues = array("2010","2011","2012","2013","2014","2015","2016","2017","2018","2019","2020","2021","2022","2023","2024","2025");
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
    <td class="hr"><strong>Challan No.</strong></td>
    <td><input type="text" name="challan_no" id="challan_no" style="width:100%;" value="" onClick="return validate_cno()"></td>
    <td class="hr"><strong>Challan Date </strong></td>
    <td>
	<?php 
			if(!(isset($challan_dd))) $challan_dd = '00';
			if(!(isset($challan_mm))) $challan_mm = '00';
			if(!(isset($challan_yy))) $challan_yy = '0000';
		?>
		<table><tr>
			<td>
				<select name="dd" id="dd">
				<?php
				  $lookupvalues = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($dd == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="mm" id="mm">
				<?php
				  $lookupvalues = array("01","02","03","04","05","06","07","08","09","10","11","12");
				  reset($lookupvalues);
				  foreach($lookupvalues as $val){
				  $caption = $val;
				  if ($mm == $val) {$selstr = " selected"; } else {$selstr = ""; }
				 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
				<?php } ?>
				</select>
			</td>
			<td>
				<select name="yy" id="yy">
				<?php
				  $lookupvalues = array("2010","2011","2012","2013","2014","2015","2016","2017","2018","2019","2020","2021","2022","2023","2024","2025");
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
    <td class="hr"><strong>Weight</strong>(in kg)</td>
    <td><input type="text" name="weight" id="weight" style="width:100%;" value=""  onClick="return validate_wht()"></td>
    <td class="hr">Remarks</td>
    <td><textarea name="remark" id="remark" style="width:100%;"></textarea></td>
  </tr>
</table>
<br>
<table><tr><td><input type="submit" value="Submit" name="commission_memo" id="commission_memo" /></td><td>&nbsp;&nbsp;</td><td><input name="Reset" type="reset" id="Reset" value="Reset" /></td></tr></table>
</form>
</center>

<!-- Warning! Do not change the below code-->
</td>
</tr></table>
</td>
<!-- This is the central Working area ends here -->

<!-- Footer starts here -->
<?php include('footer.php'); ?>