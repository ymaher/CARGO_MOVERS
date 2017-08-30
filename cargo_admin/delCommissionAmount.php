<?php include('../session_validator.php'); ?>

<?php
include('../dbConnect.php');
$sql_commission_id = "select commission_id from memo_amount where memo_amount_id = ".$_GET['id'];
$res_commission_id = mysql_query($sql_commission_id);
$row_commission_id = mysql_fetch_array($res_commission_id);
$commission_id = $row_commission_id['commission_id'];

$sql = "delete from memo_amount where memo_amount_id = ".$_GET['id'];
//echo $sql;
$res = mysql_query($sql);

$sql_amt = "select sum(amount) as amt from memo_amount where commission_id = ".$commission_id;
$res_amt = mysql_query($sql_amt);
$row_amt = mysql_fetch_array($res_amt);

$sql_fright = "select fright_charges from commission_memo where commission_id = ".$commission_id;
$res_fright = mysql_query($sql_fright);
$row_fright = mysql_fetch_array($res_fright);

echo "Balance Amount : ".($row_fright['fright_charges'] - $row_amt['amt']);
?>