// JavaScript Document

var http = getHTTPObject(); // We create the XMLHTTPRequest Object

// to call from form 

function doAction(url,result) {     
    http.open("GET", url , true);
    http.onreadystatechange = function()
	{
    	if (http.readyState == 4) 
		{
        	if (http.status == 200) 
			{
			    var responce = http.responseText;
				//alert(responce);
				document.getElementById(result).innerHTML = responce;
			}
			else 
			{
            	alert ( "Not able to retrieve name" );
        	}
    	}    
	}
	http.send(null);
}


function doAction_custom(url) {     
    http.open("GET", url , true);
	var res = new Array();	
    http.onreadystatechange = function()
	{
    	if (http.readyState == 4) 
		{
        	if (http.status == 200) 
			{
			    var responce = http.responseText;
				//alert(responce);
				//return responce;
				//alert(result);
				var res = responce.split('$$$');
				document.getElementById('truck').innerHTML = res[0];
				document.getElementById('account').innerHTML = res[1];
			}
			else 
			{
            	alert ( "Not able to retrieve name" );
        	}
    	}    
	}
	http.send(null);
}


function getHTTPObject()
{
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	return xmlhttp;
}