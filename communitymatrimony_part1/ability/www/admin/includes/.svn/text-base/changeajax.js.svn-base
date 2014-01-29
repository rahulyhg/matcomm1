

function createRequestObject(){
	var request_o; //declare the variable to hold the object.
	var browser = navigator.appName; //find the browser name
	if(browser == "Microsoft Internet Explorer"){
		/* Create the object using MSIE's method */
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		/* Create the object using other browser's method */
		request_o = new XMLHttpRequest();
	}
	return request_o; //return the object
}

/* You can get more specific with version information by using 
	parseInt(navigator.appVersion)
	Which will extract an integer value containing the version 
	of the browser being used.
*/
/* The variable http will hold our new XMLHttpRequest object. */
var http = createRequestObject(); 




function changeValue(val,sid,mid,defval){

rnd=Math.random();
http.open('get','chkOfferDetails.php?val='+val+'&sid='+sid+'&mid='+mid+'&rnd='+rnd+'&defval='+defval,true);

http.onreadystatechange = handleSCImage; 
http.send(null);
}


/* Function called to handle the list that was returned from the internal_request.php file.. */
function handleSCImage(){
	
	if(http.readyState == 1){document.getElementById("AJAXContent").innerHTML = "<center>Loading Offers...</center>";}
	if(http.readyState == 4){ //Finished loading the response
		
		var response = http.responseText;
		
			if (http.status == 200)
			{	
				document.getElementById("AJAXContent").innerHTML = response;
			}else{
				document.getElementById("AJAXContent").innerHTML="";
				
			}
			//if(response==''){ alert("No offer available for this package");}
	}
}