function validateFormOnSubmit(theForm) {

var myname=theForm.textfield2.value;
var reason1 = "";
reason1 += validatelname(myname);

var myemail=theForm.textfield3.value;
var reason2 = "";
reason2 += validateEmail(myemail);

var mypass=theForm.textfield4.value;
var reason3 = "";
reason3 += validatePassword(mypass);

var mycpass=theForm.textfield5.value;
var reason4 = "";
reason4 += validateCPassword(mycpass);

var mygen=theForm.gender.value;
var reason5 = "";
reason5 += validategen(mygen);

var mymonth=theForm.month.value;
var reason6 = "";
reason6 += valmonth(mymonth);


var uname=theForm.textfield25.value;
var reason7 = "";
reason7 +=valmyuser(uname);

var hadd=theForm.textfieldn1.value;
var reason8="";
reason8 +=validatenAddress(hadd);

var hpno=theForm.textfieldn2.value;
var reason9="";
reason9 +=validatenNumber(hpno);

var hsslc=theForm.textfieldnsslc.value;
var reason10="";
reason10 +=validatenSSLC(hsslc);

var hpuc=theForm.textfieldnpuc.value;
var reason11="";
reason11 +=validatenPUC(hpuc);

var hsem1=theForm.textfieldn3.value;
var reason12="";
reason12 +=validatensem1Marks(hsem1);

var hsem2=theForm.textfieldn4.value;
var reason13="";
reason13 +=validatensem2Marks(hsem2);

var hsem3=theForm.textfieldn5.value;
var reason14="";
reason14 +=validatensem3Marks(hsem3);

var hsem4=theForm.textfieldn6.value;
var reason15="";
reason15 +=validatensem4Marks(hsem4);

var hsem5=theForm.textfieldn7.value;
var reason16="";
reason16 +=validatensem5Marks(hsem5);

var hsem6=theForm.textfieldn8.value;
var reason17="";
reason17 +=validatensem6Marks(hsem6);

if(reason1 =="false")
{
return false;
}

else if(reason2 =="false")
{
return false;
}

else if(reason3 =="false")
{
return false;
}

else if(reason4 =="false")
{
return false;
}

else if(reason5 =="false")
{
return false;
}

else if(reason6 =="false")
{
return false;
}

else if(reason7 =="false")
{
return false;
}

else if(reason8 =="false")
{
return false;
}

else if(reason9 =="false")
{
return false;
}

else if(reason10 =="false")
{
return false;
}

else if(reason11 =="false")
{
return false;
}

else if(reason12 =="false")
{
return false;
}

else if(reason13 =="false")
{
return false;
}

else if(reason14 =="false")
{
return false;
}

else if(reason15 =="false")
{
return false;
}

else if(reason16 =="false")
{
return false;
}

else if(reason17 =="false")
{
return false;
}


else
{
return true;
}


}

/* *******************Newwwwwwwww Functions**************** */

function calculateSemMarks()
{
var csem1=document.getElementById("textfieldn3").value;
var csem2=document.getElementById("textfieldn4").value;
var csem3=document.getElementById("textfieldn5").value;
var csem4=document.getElementById("textfieldn6").value;
var csem5=document.getElementById("textfieldn7").value;
var csem6=document.getElementById("textfieldn8").value;

var csem_obtained_total=0;
var csem_max_total=0;

if (csem1 != 0 )
{
csem_obtained_total += (Number(csem1));
csem_max_total += 700;

}

if (csem2 != 0 )
{
csem_obtained_total += (Number(csem2));
csem_max_total += 700;

}

if (csem3 != 0 )
{
csem_obtained_total += (Number(csem3));
csem_max_total += 700;

}

if (csem4 != 0 )
{
csem_obtained_total += (Number(csem4));
csem_max_total += 700;

}

if (csem5 != 0 )
{
csem_obtained_total += (Number(csem5));
csem_max_total += 700;

}

if (csem6 != 0 )
{
csem_obtained_total += (Number(csem6));
csem_max_total += 800;

}

var csem_percentage = csem_obtained_total / csem_max_total * 100;

document.getElementById("calctable").innerHTML = " <tr><th>&nbsp;</th><th>Sem 1</th><th>Sem 2</th><th>Sem 3</th><th>Sem 4</th><th>Sem 5</th><th>Sem 6</th><th>Total</th><th>%</th></tr><tr><td>Maximum Marks</td><td>700</td><td>700</td><td>700</td><td>700</td><td>700</td><td>800</td><td>"+csem_max_total+"</td><td>&nbsp;</td></tr><tr><td>Obtained Marks</td><td>"+csem1+"</td><td>"+csem2+"</td><td>"+csem3+"</td><td>"+csem4+"</td><td>"+csem5+"</td><td>"+csem6+"</td><td>"+csem_obtained_total+"</td><td>"+csem_percentage+"</td></tr> ";

}

function validatenAddress(homeaddress)
{
var homeadd="";
homeadd+=homeaddress;

if ( homeadd =="")
{
	    document.getElementById("replyn1").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Address is Required</b>";
    return false;
}

else
{
   document.getElementById("replyn1").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input </b>";
return true;
}

}


function validatenNumber(homenumber)
{
    var x = homenumber;
       
        if (x==null || x=="")
 	  {
 		document.getElementById("replyn2").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Number can not be blank</b>";
    return false;
 	  }       

      if(isNaN(x)|| x.indexOf(" ")!=-1)
	  {
      	document.getElementById("replyn2").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please enter valid number</b>";
    return false;
      }
      if (x.length > 10 || x.length < 10)
	  {
       document.getElementById("replyn2").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please enter 10 digit number</b>";
    return false;
      }
	   document.getElementById("replyn2").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input </b>";
return true;
	  
	  
}

function validatenSSLC(sslcmarks)
{
var sslc_total="";
sslc_total += sslcmarks;
if (sslc_total<0)
{
	    document.getElementById("replynsslc").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should not be negative</b>";
    return false;
}
if(sslc_total != "" )
{
if (isNaN(sslc_total))
{
	    document.getElementById("replynsslc").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should be Number</b>";
    return false;
}

else if (sslc_total > 625 )
{
	    document.getElementById("replynsslc").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Cannot be More Than 625 ( grand Total )</b>";
    return false;
}

else
{
var sslc_percentage = sslc_total / 625 * 100;
   document.getElementById("replynsslc").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input &nbsp;"+sslc_percentage+" % </b>";
return true;
}
}

else
{

   document.getElementById("replynsslc").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input You Can Update it Later </b>";
return true;
}
}



function validatenPUC(pucmarks)
{
var puc_total="";
puc_total += pucmarks;
if(puc_total<0)
{
	 document.getElementById("replynpuc").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please enter valid number</b>";
    return false;
}
if(puc_total != "" )
{
if (isNaN(puc_total))
{
	    document.getElementById("replynpuc").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should be Number</b>";
    return false;
}

else if (puc_total > 625 )
{
	    document.getElementById("replynpuc").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Cannot be More Than 625 ( grand Total )</b>";
    return false;
}

else
{
var puc_percentage = puc_total / 625 * 100;
   document.getElementById("replynpuc").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input &nbsp;"+puc_percentage+" % </b>";
return true;
}
}

else
{

   document.getElementById("replynpuc").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input You Can Update it Later </b>";
return true;
}
}




function validatensem1Marks(sem1marks)
{
var sem1="";
sem1+=sem1marks;

if(sem1<0)
{
	  document.getElementById("replys1").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should be Number</b>";
    return false;
}
if(sem1 != "" )
{

if ( isNaN(sem1))
{
	    document.getElementById("replys1").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should be Number</b>";
    return false;
}

else
{

   document.getElementById("replys1").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input </b>";
return true;
}



}

else
{

   document.getElementById("replys1").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input You Can Update it Later </b>";
return true;
}

}


function validatensem2Marks(sem2marks)
{
var sem2="";
sem2+=sem2marks;
if(sem2<0)
{
	  document.getElementById("replys2").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Invalid Number</b>";
    return false;
}

if(sem2 != "" )
{

if ( isNaN(sem2))
{
	    document.getElementById("replys2").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should be Number</b>";
    return false;
}

else
{

   document.getElementById("replys2").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input </b>";
return true;
}



}

else
{

   document.getElementById("replys2").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input You Can Update it Later </b>";
return true;
}

}



function validatensem3Marks(sem3marks)
{
var sem3="";
sem3+=sem3marks;

if(sem3<0)
{
	  document.getElementById("replys3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Invalid Number</b>";
    return false;
}
if(sem3 != "" )
{

if ( isNaN(sem3))
{
	    document.getElementById("replys3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should be Number</b>";
    return false;
}

else
{

   document.getElementById("replys3").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input </b>";
return true;
}



}

else
{

   document.getElementById("replys3").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input You Can Update it Later </b>";
return true;
}

}


function validatensem4Marks(sem4marks)
{
var sem4="";
sem4+=sem4marks;

if(sem4<0)
{
	  document.getElementById("replys4").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Invalid Number</b>";
    return false;
}
if(sem4 != "" )
{

if ( isNaN(sem4))
{
	    document.getElementById("replys4").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should be Number</b>";
    return false;
}

else
{

   document.getElementById("replys4").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px  verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input </b>";
return true;
}



}

else
{

   document.getElementById("replys4").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px  verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input You Can Update it Later </b>";
return true;
}

}


function validatensem5Marks(sem5marks)
{
var sem5="";
sem5+=sem5marks;

if(sem5<0)
{
	  document.getElementById("replys5").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Invalid Number</b>";
    return false;
}
if(sem5 != "" )
{

if ( isNaN(sem5))
{
	    document.getElementById("replys5").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should be Number</b>";
    return false;
}

else
{

   document.getElementById("replys5").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px  verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input </b>";
return true;
}



}

else
{

   document.getElementById("replys5").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px  verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input You Can Update it Later </b>";
return true;
}

}




function validatensem6Marks(sem6marks)
{
var sem6="";
sem6+=sem6marks;

if(sem6<0)
{
	  document.getElementById("replys6").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Invalid Number</b>";
    return false;
}
if(sem6 != "" )
{

if ( isNaN(sem6))
{
	    document.getElementById("replys6").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Marks Should be Number</b>";
    return false;
}

else
{

   document.getElementById("replys6").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px  verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input </b>";
return true;
}



}

else
{

   document.getElementById("replys6").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px  verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input You Can Update it Later </b>";
return true;
}

}









/* *******************End Newwwwwwwww Functions************************* */

function valmyuser(uname)
{
var illegalChars = /[\W_]/;
var usname="";
usname+=uname;
	if(usname=="")
	{
	    document.getElementById("reply25").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Username is Required</b>";
    return false;
  }
  
 	else if (illegalChars.test(usname)) {
  document.getElementById("reply25").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Must Contain only Letters &amp; numbers</b>";
    return false;
    } 

	    else if (usname.length < 5) {
    document.getElementById("reply25").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Must Be Atleast 5 Characters</b>";
    return false;
  }
	
  else
  {
   document.getElementById("reply25").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input</b>";
return true;
  }


}



function valmonth(mymonth)
{

var month=document.getElementById("months").value;
	if(month=="")
	{
	    document.getElementById("reply7").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Select Birth Date</b>";
    return false;
  }
  
  
  else
  {
   document.getElementById("reply7").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input</b>";
return true;
  }


}


function validateCPassword(cpass)
{
var fpass=document.getElementById("textfield4").value;
if(!cpass.match(fpass))
{

document.getElementById("reply5").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Password Does Not Match</b>";
    return false;

}

    else if (fpass == "") {
 document.getElementById("reply5").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Password is Required</b>";
    return false;
    }
	
else
{

document.getElementById("reply5").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid</b>";
return true;

}
}


function validatePassword(pass) {

    var illegalChars = /[\W_]/; // allow only letters and numbers 
 
    if (pass == "") {
 document.getElementById("reply4").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Password is Required</b>";
    return false;
    } else if (pass.length < 8) {
    document.getElementById("reply4").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Must Be atleast 8 Characters</b>";
    return false;
    } 
	
	else if (pass.length > 20) {
    document.getElementById("reply4").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Must Be Less than 20 Characters</b>";
    return false;
    }
	
	else if (illegalChars.test(pass)) {
  document.getElementById("reply4").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Must Contain only Letters &amp; numbers</b>";
    return false;
    } 
     else {
        document.getElementById("reply4").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid</b>";
return true;
    }

}  



function echeck(str) {
	

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1)
		{
		  document.getElementById("reply3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please Provide a Valid E-mail id</b>";

return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr)
		{
		   document.getElementById("reply3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please Provide a Valid E-mail id</b>";

return false;
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		   document.getElementById("reply3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please Provide a Valid E-mail id</b>";

return false;
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    document.getElementById("reply3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please Provide a Valid E-mail id</b>";

return false;
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    document.getElementById("reply3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please Provide a Valid E-mail id</b>";

return false;
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    document.getElementById("reply3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please Provide a Valid E-mail id</b>";

return false;
		 }
		
		 if (str.indexOf(" ")!=-1){
		    document.getElementById("reply3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please Provide a Valid E-mail id</b>";

return false;
		 }
          document.getElementById("reply3").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input</b>";
return true;
 							
	}


function validateEmail(mail){
	var emailID=mail;
	
	if ((emailID==null)||(emailID=="")){
		document.getElementById("reply3").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Please Provide a Valid E-mail id</b>";
	
		//emailID.focus()
		return false
	}
	if (echeck(emailID)==false){
		emailID.value=""
		emailID.focus()
		return false
	}
	return true
 }









function validategen(gender)
{

var reason1 = "";

  reason1 += gender;
  
  if (reason1 ==0) {
    document.getElementById("reply6").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;margin-bottom:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Select a Gender</b>";
    return false;
  }
  
  
  else
  {
   document.getElementById("reply6").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input</b>";
return true;
  }

}


  
  
  function validatelname(name)
{
var reason1 = "";
var illegalChars= new RegExp(/^[a-zA-Z]+$/);
//var illegalChars = /[\W_]/;
  reason1 += name;
  
      if (reason1.length =="" || reason1==null) {
    document.getElementById("reply2").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Name is required</b>";
	return false;
  }
  
  	else if (!name.match(/^[a-zA-Z]+$/)) {
  document.getElementById("reply2").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Must Contain only Letters</b>";
    return false;
    } 
  
    else if (reason1.length < 4) {
    document.getElementById("reply2").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Must Be Atleast 4 Characters</b>";
    return false;
  }
  else
  {
   document.getElementById("reply2").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid</b>";
return true;
  }
}
  
  



function myreset()
{
document.getElementById("reply2").innerHTML="";
document.getElementById("reply3").innerHTML="";
document.getElementById("reply4").innerHTML="";
document.getElementById("reply5").innerHTML="";
document.getElementById("reply6").innerHTML="";
document.getElementById("reply7").innerHTML="";
document.getElementById("reply25").innerHTML="";

document.getElementById("replyn1").innerHTML="";
document.getElementById("replyn2").innerHTML="";
document.getElementById("replynsslc").innerHTML="";
document.getElementById("replynpuc").innerHTML="";
document.getElementById("replys1").innerHTML="";
document.getElementById("replys2").innerHTML="";
document.getElementById("replys3").innerHTML="";
document.getElementById("replys4").innerHTML="";
document.getElementById("replys5").innerHTML="";
document.getElementById("replys6").innerHTML="";
document.getElementById("calctable").innerHTML = "";
}






function initForm() {
	document.getElementById("months").selectedIndex = 0;
	document.getElementById("months").onchange = populateDays;
	
}

function populateDays() {
	var monthDays = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
	var monthStr = this.options[this.selectedIndex].value;
	
	if (monthStr != "") {
		var theMonth = parseInt(monthStr);
					
		document.getElementById("days").options.length = 0;
		for(var i=0; i<monthDays[theMonth]; i++) {
			document.getElementById("days").options[i] = new Option(i+1);
		}
	}
	
	
	
var month=document.getElementById("months").value;
	if(month=="")
	{
	    document.getElementById("reply7").innerHTML="<img src='cross.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#E41B17;font:10px verdana;font-weight:bold;'>&nbsp;&nbsp;Select Birth Date</b>";
    return false;
  }
  
  
  else
  {
   document.getElementById("reply7").innerHTML="<img src='right6.gif' width='15px' height='15px' style='float:left;margin-left:5px;'/><b style='color:#000;font:10px verdana;font-weight:bold;text-align:center;'>&nbsp;&nbsp;Valid Input</b>";
return true;
  }
	
}



function validateuser(myname)
{

var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
		document.getElementById('reply25').innerHTML="";
			var ajaxDisplay = document.getElementById('reply25');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	var uname= "";
	uname += myname;
	var queryString = "?uname=" + uname;

	ajaxRequest.open("GET", "validateuser.php" + queryString, true);
	ajaxRequest.send(null); 
}