<?php include('../session_validator.php')?>

<?php
	if(isset($_POST['submit']))
	{
		include('../dbConnect.php');
		$sql = "select * from user where username ='".$_SESSION['user']."' and password='".$_POST['old_pass']."'";
		//echo $sql;
		$res = mysql_query($sql);
		if(mysql_num_rows($res)>0)
		{
			$sql1 = "update user set password = '".$_POST['new_pass']."' where username ='".$_SESSION['user']."'";
			$res1 = mysql_query($sql1);
			?>
				<script>
					alert('Successfully updated your password');
					document.location="index.php";
				</script>
			<?php
		} else
		{
			?>
				<script>
					alert('Failed to update your password');
					//document.location="change_password.php";
				</script>
			<?php
		}
	}	
?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Change Password</title>

<script type="text/javascript" language="javascript">
//Script to check the user is already exist using AJAX
function checkPassword()
{
	var url = "checkPassword.php?password=";
	var old_pass = document.getElementById("old_pass").value;
	if(old_pass == "") 
	{ 
		document.getElementById('hint').innerHTML = "<input type=\"hidden\" id=\"status\" name=\"status\" value=\"\" />Old password cannot be blank";
		document.getElementById('hint').style.color="red";
		return;
	}
	url += escape(old_pass);
	div="hint";
	doAction(url,div);
}
</script>
<script language="javascript" src="js/ajax.js"></script>

<style>
/* classes for validator */
	.tfvHighlight
		{font-weight: bold; color: red;}
	.tfvNormal
		{font-weight: normal;	color: black;}
</style>
<script language="JavaScript" src="../files/validator.js"></script>
<script>
// form fields description structure
var a_fields = {
	/*'title': {
		'l': 'Title',  // label
		'r': false,    // required
		'f': 'alpha',  // format (see below)
		't': 't_title',// id of the element to highlight if input not validated
		
		'm': null,     // must match specified form field
		'mn': 2,       // minimum length
		'mx': 10       // maximum length
	},*/
	'old_pass':{'l':'Old Password','r':true,'f':'','t':'t_old_pass'},
	'new_pass':{'l':'New Password','r':true,'f':'','t':'t_new_pass'},
	'c_new_pass':{'l':'Confirm Password','r':true,'f':'','t':'t_c_new_pass','m':'new_pass'},
	'status':{'l':'Old Password','r':true,'f':'','t':'t_old_pass'}
},
	
o_config = {
	'to_disable' : ['Submit', 'Reset'],
	'alert' : 1
}

// validator constructor call
var v = new validator('password', a_fields, o_config);	
</script>	
<link type="text/css" rel="stylesheet" href="../files/grid_style.css" media="screen" />
<!--Header included here -->
<?php include('./header.php'); ?>

<!-- This is the Nevigation area -->
<?php include('./navigation.php'); ?>
<!-- This is the Nevigation area ends here -->

<!-- This is the central Working area -->
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #99CCFF;
}
-->
</style><td width="80%" align="left">
<table width="100%"><tr>
<td align="left" valign="top" width="100%">

<!--Warning! Do not change the above code-->

<table width="100%">
	<tr>
		<td height="400"><form name="password" enctype="multipart/form-data" action="change_password.php" method="post" onSubmit="return v.exec()" style="background-image:url(dsfsfsf.jpg)">
		  <table width="89%" align="center">
	<tr class="hr" height="25">
		<td colspan="3"><font style="font-size:14px;" color="#FFFFFF"><strong>Change Password </strong></font></td>
	</tr>
	<tr>
		<td width="25%" style="font-weight:bold;" height="36" id="t_old_pass" class="td1">Old Password</td>
		<td width="40%"><input type="password" name="old_pass" id="old_pass" style="width:200px;" onBlur="checkPassword();" /></td>
		<td width="35%" style="font-weight:bold;" height="36" class="td1"><span id="hint">
		  <input type="hidden" id="status" name="status" value="" /></span></td>
	</tr>
	<tr bgcolor="#E4EEE5">
		<td style="font-weight:bold;" height="49" id="t_new_pass" class="td1">New Password</td>
		<td><input type="password" name="new_pass" id="new_pass" style="width:200px;" /></td>
		<td style="font-weight:bold;" height="49"></td>
	</tr>
	<tr>
		<td style="font-weight:bold;" height="46" id="t_c_new_pass" class="td1">Retype Password</td>
		<td><input type="password" name="c_new_pass" id="c_new_pass" style="width:200px;" /></td>
		<td style="font-weight:bold;" height="46"></td>
	</tr>
	<tr bgcolor="#E4EEE5">
		<td height="42" colspan="3"><input type="submit" value="Submit" name="submit" />&nbsp;<input type="reset" name="reset" value="Reset" /></td>
	</tr>
</table>		
          <p>&nbsp;</p>
</form>		
		</td>
	</tr>
</table>
								  
<!-- Warning! Do not change the below code-->
</td>
</tr></table>
</td>
<!-- This is the central Working area ends here -->

<!-- Footer starts here -->
<?php include('footer.php'); ?>