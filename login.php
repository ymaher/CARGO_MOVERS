<html><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

<title>Login</title>

<!--Header included here -->
<?php include('header.php'); ?>

<!-- This is the Nevigation area -->
<?php include('navigation.php'); ?>
<!-- This is the Nevigation area ends here -->

<!-- This is the central Working area -->
<td width="80%" align="left">
<table width="100%"><tr>
<td align="left" valign="top" width="100%" style="background:url(files/home_bg.gif) repeat-x;">
<center>
<table width="600" height="400" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="background:url(files/home.gif);" valign="top">
			<br><br>
			<form action="loginprocess.php" method="POST" style="background-image:url(hfdgdfg.jpg)">
<table width="349" align="center">
  <tr><td height="160">
<table align="center">
<tr height="25">
	<td colspan="2" align="left" bgcolor="#48769F"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; color:#FFFFFF;">Login</font></td>
</tr>
<tr>
<td><div align="left"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#ffffff;
">Username :</font></div></td>
<td><input type="text" name="txtUserName"/></td>
</tr>
<td><div align="left"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:ffffff
;">Password :</font></div></td>
<td><input type="password" name="txtPassword"/></td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
  <td colspan="2" align="center">&nbsp;
    <input name="Button" type="submit" value="SignIn" align="center">&nbsp;&nbsp;&nbsp;
     <input type="reset" name="Reset" value="Reset"></td>
  </tr>
</table>
</td></tr></table>
</form>

		</td>
	</tr>
</table>
</center></td>
</tr></table>
</td>
<!-- This is the central Working area ends here -->

<!-- Footer starts here -->
<?php include('footer.php'); ?>