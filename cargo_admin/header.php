<link type="text/css" href="../files/style.css" media="screen" rel="stylesheet" />
<script language="JavaScript" type="text/javascript">
function clock() 
{
   var digital = new Date();
   var hours = digital.getHours();
   var minutes = digital.getMinutes();
   var seconds = digital.getSeconds();
   var amOrPm = "AM";
   if (hours > 11) amOrPm = "PM";
   if (hours > 12) hours = hours - 12;
   if (hours == 0) hours = 12;
   if (minutes <= 9) minutes = "0" + minutes;
   if (seconds <= 9) seconds = "0" + seconds;
   dispTime = hours + ":" + minutes + ":" + seconds + " " + amOrPm;

   document.getElementById('basicclock').innerHTML = dispTime;
   setTimeout("clock()", 1000);
}
</script>
</head><body>

<table border="0" cellpadding="0" cellspacing="0" ./../files/ width="100%">
<tbody>
<tr><td height="1"></td></tr>
<tr><td align="left" height="113" valign="top" width="100%">

<table height="114" width="100%">
<tr><td width="1px"></td>
<td bgcolor="#330066"> 
<table border="0" cellpadding="0" cellspacing="0" height="113" width="100%">
<tbody><tr>
<td rowspan="2" height="113" width="211"><img src="../files/logoo.gif" border="0" height="113" width="211"></td>
<td align="center" background="../files/topbg.gif" height="86" valign="middle" width="100%">
<br><img src="../files/title_textt.gif" border="0" height="65" width="600"></td>
<td rowspan="2" background="../files/topbg.gif" height="113" width="42"><img src="../files/crv.gif" border="0" height="113" width="42"></td>
<td rowspan="2" background="../files/ulbg.gif" height="113" width="100%"><img src="../files/spacer.gif" border="0" height="1" width="10"></td>
</tr>
<tr>
<td align="center" background="../files/mnubg.gif" height="27" valign="middle" width="100%">
<table align="right">
<tr>
	<td valign="middle"><img src="../files/user.png" /></td><td class="td1"><?php echo ucfirst($_SESSION['user']); ?>&nbsp;&nbsp;|&nbsp;</td><td valign="middle"><img src="../files/date.png" /></td><td class="td1"><?php echo date('l dS \of F Y'); ?>&nbsp;&nbsp;|&nbsp;</td><td><img src="../files/053.png" height="18" width="18" /></td><td  class="td1"><span id="basicclock"><script language="JavaScript" type="text/javascript">clock();</script></span></td>
</tr>
</table>

</td>
</tr>
</tbody></table>
</td>
<td width="1"></td>
</tr></table>
<tr><td height="1"></td></tr>

</td></tr>
<tr><td align="left" valign="top" width="100%">

<table width="100%">
<tr><td width="1px"></td>
<td width="20%" background="../files/navbgl.gif" valign="top" bgcolor="#330033">
<table border="0" cellpadding="0" cellspacing="0" height="" width="100%">
<tbody>
<tr>