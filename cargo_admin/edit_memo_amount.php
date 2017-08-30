<?php include('../session_validator.php'); ?>

<?php
include('../dbConnect.php');
if(isset($_POST['submit_memoamt']))
{
	$challan_no = $_POST['challan_no'];
	if($challan_no == ""){ $challan_no = 'NULL'; } else { $challan_no = "'".$challan_no."'";}
	
	$account_no = $_POST['account_no'];
	if($account_no == ""){ $account_no = 'NULL'; } else { $account_no = "'".$account_no."'";}
	
	$mcm_pay = $_POST['mcm_pay'];
	if($mcm_pay == ""){ $mcm_pay = 'no'; } else { $mcm_pay = 'yes';}

	$date = $_POST['yy']."-".$_POST['mm']."-".$_POST['dd'];
	if($_POST['sql'] == 'insert')
	{
		 //Query to retirieve the total paid fees 
		 $sql_paid = "select sum(amount) as paid_amount from memo_amount where commission_id = ".$_POST['commission_id'];
		 //echo $sql_paid;
		 $res_paid = mysql_query($sql_paid);
		 $row_paid = mysql_fetch_array($res_paid);
		 
		 //Find the fright charges of the commission memo
		 $sql_charges = "Select fright_charges from commission_memo where commission_id = ".$_POST['commission_id'];
		 //echo $sql_charges;
		 $res_charges = mysql_query($sql_charges);
		 $row_charges = mysql_fetch_array($res_charges);
		 
		 //Check for paid amount and original amount is exceeded
		 $amt = $row_charges['fright_charges'] - ($row_paid['paid_amount'] + $_POST['amount']);
		 if($amt>=0 || $mcm_pay == 'yes')
		 {
			$sql = "insert into memo_amount values(NULL,".$_POST['commission_id'].", '".$_POST['perticulars']."', ".$_POST['amount'].", ".$account_no.", ".$challan_no.", '".$date."', '".$mcm_pay."')";
			echo $sql;
			$res = mysql_query($sql);
			//$id = mysql_insert_id();
		} else
		{
			?>
			<script>
				alert('Please check the due amount and paying amount\n\rAmount Exceeds the due amount');
				document.location = "edit_memo_amount.php?c_id=<?php echo $_POST['commission_id']; ?>&a=add";
			</script>
			<?php
		}
	} else
	{
		//Query to retirieve the total paid fees 
		 $sql_paid = "select sum(amount) as paid_amount from memo_amount where mcm_pay = 'no' and commission_id = ".$_POST['commission_id']." and memo_amount_id !=".$_POST['memo_amount_id'];
		 //echo $sql_paid;
		 $res_paid = mysql_query($sql_paid);
		 $row_paid = mysql_fetch_array($res_paid);
		 
		 //Find the fright charges of the commission memo
		 $sql_charges = "Select fright_charges from commission_memo where commission_id = ".$_POST['commission_id'];
		 //echo $sql_charges;
		 $res_charges = mysql_query($sql_charges);
		 $row_charges = mysql_fetch_array($res_charges);
		 
		 //Check for paid amount and original amount is exceeded
		 $amt = $row_charges['fright_charges'] - ($row_paid['paid_amount'] + $_POST['amount']);
		 if($amt>=0 || $mcm_pay == 'yes')
		 {
			$sql = "update memo_amount set date = '".$date."', amount = ".$_POST['amount'].", perticulars = '".$_POST['perticulars']."', acc_no = ".$account_no.", challan_no = ".$challan_no.", mcm_pay = '".$mcm_pay."' where memo_amount_id = ".$_POST['memo_amount_id'];
			//echo $sql;
			$res = mysql_query($sql);
			//$id = $_POST['fees_id'];
		} else
		{
			?>
			<script>
				alert('Please check the due amount and paying amount\n\rAmount Exceeds the due amount')
				//document.location = "edit_memo_amount.php?id=<?php echo $_POST['memo_amount_id']; ?>&c_id=<?php echo $_POST['commission_id']; ?>";
			</script>
			<?php
		}
	}
	//echo $sql;
	

?>
<script>
	window.close();
	if(window.opener && !window.opener.closed)
	{
		window.opener.location.reload();
	} 
</script>
<?php	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add/Edit Student Fees</title>
<script language="javascript" src="../files/form_validator.js"></script>
<link type="text/css" rel="stylesheet" href="../files/grid_style.css" media="screen" />
</head>

<body>
<?php
include('../dbConnect.php');
$sql = "select bill_no, truck_owner_id from commission_memo where commission_id = ".$_GET['c_id'];
$res = mysql_query($sql);
$row = mysql_fetch_array($res);

if($_GET['a'] == 'add')
{
	$row1 = array(
	  "commission_id" => "",
	  "date" => date('Y-m-d'),
	  "perticulars" => "",
	  "acc_no" => "",
	  "mcm_pay" => "no",
	  "amount" => "");
} else
{
	$sql = "select * from memo_amount where memo_amount_id = ".$_GET['id'];
	$res1 = mysql_query($sql);
	$row1 = mysql_fetch_array($res1);
}
?>
<form enctype="multipart/form-data" action="edit_memo_amount.php" method="post" onSubmit="if(isFormValid()) ; else { alert('Something is wrong');return false; }">
													<table border="0" cellpadding="2" cellspacing="0" width="100%">
                                                          <tbody><tr bgcolor="#E4EEE5">
                                                            <td  width="35%" style="font-weight:bold;" height="21">&nbsp;&nbsp;&nbsp;Bill No.</td>
                                                            <td width="49%"><?php echo $row['bill_no']; ?></td>
                                                            </tr>
                                                          <tr>
                                                            <td  style="font-weight:bold;" height="21">&nbsp;&nbsp;&nbsp;Date</td>
                                                            <td>
<?php
if($row1['date'] != "")
{
	$date = explode("-",$row1['date']);
	$yy = $date[0];
	$mm = $date[1];
	$dd = $date[2];
}
?>															
<table><tr>
			<td>
				<select name="dd" id="dd">
				<?php
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
				<select name="mm" id="mm">
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
				<select name="yy" id="yy">
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
														  
														  <tr bgcolor="#E4EEE5">
														    <td  style="font-weight:bold;" height="21">&nbsp;&nbsp;&nbsp;Amount</td>
                                                            <td><input type="text" id="amount" name="amount" style="width:200px;" value="<?php echo $row1['amount']?>" required="1" mask="float" /></td>
                                                          </tr>
														  <tr>
														    <td  style="font-weight:bold;" height="21">&nbsp;&nbsp;&nbsp;Perticulars</td>
                                                            <td>
															<?php if($row1['perticulars'] == "Commission Charges") { $readonly = "readonly=\"readonly\""; } else { $readonly = ""; }  ?>
															<input type="text" id="perticulars" name="perticulars" style="width:200px;" value="<?php echo $row1['perticulars']?>" <?php echo $readonly; ?> required="1" /></td>
                                                          </tr>
														  
                                                          <tr  bgcolor="#E4EEE5">
                                                            <td  style="font-weight:bold;" height="21">&nbsp;&nbsp;&nbsp;Account No. </td>
                                                            <td>
															<?php
															$account_no = $row1['acc_no'];
															if(($account_no != '') || ($_GET['a'] == 'add'))
															{
															?>
															<select style="width:200px;" name="account_no" id="account_no">
																<option value="">Select Account</option>
															<?php
																$sql_account = "SELECT acc_id, acc_no from truck_owner_acc where truck_owner_id = ".$row['truck_owner_id'];
																$res_account = mysql_query($sql_account);
																while($row_account = mysql_fetch_array($res_account))
																{
																	if($account_no == $row_account['acc_id']){ $selected = "selected"; } else { $selected = ""; }
																	echo "<option value=\"".$row_account['acc_id']."\" ".$selected.">".$row_account['acc_no']."</option>";
																}
															?>
																</select>
															<?php } else { ?>
																-NA-
																<?php
																	}
																?>
															</td>
                                                          </tr>
														  <tr>
														    <td  style="font-weight:bold;" height="21">&nbsp;&nbsp;&nbsp;Challan No</td>
                                                            <td><input type="text" id="challan_no" name="challan_no" style="width:200px;" value="<?php echo $row1['challan_no']?>" /></td>
                                                          </tr>
                                                          <tr bgcolor="#E4EEE5">
                                                            <td  style="font-weight:bold;">&nbsp;&nbsp;&nbsp;MCM Payment</td>
															<td><input type="checkbox" name="mcm_pay" id="mcm_pay" value="yes" <?php if($row1['mcm_pay'] == "yes"){ echo "checked=\"checked\"";} else { echo "";} ?>  />
															<font color="#FF0000" style="font-size:11px;">If you check this box payment will not be deducted from balance amount.</font>
															</td>
                                                            </tr>
															<tr>
                                                            <td  style="font-weight:bold;"><input type="submit" value="Done" name="submit_memoamt"  /></td>
                                                            <td>&nbsp;</td>
                                                            </tr>
                                                      </tbody></table>
<input type="hidden" name="memo_amount_id" id="memo_amount_id" value="<?php echo $_GET['id']; ?>"  />
<input type="hidden" name="commission_id" id="commission_id" value="<?php echo $_GET['c_id']; ?>"  />
<input type="hidden" name="sql" id="sql" value="<?php if($_GET['a'] == 'add'){ echo 'insert'; } else { echo 'update'; } ?>"  />
</form>													  
</body>
</html>
