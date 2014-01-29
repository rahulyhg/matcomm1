	function clearcroptool(){
			document.getElementById('testWrap').innerHTML = '<img src="http://image.tamilmatrimony.com/photos/tmp/<?=$newimgname_id?>" alt="test image" id="testImage" />';
	}
	function clickTab(tabNo,tabTotal,tabName)
		{
		//current tab
		var cur_act = tabName+"link"+tabNo+"_active";
		var cur_inact = tabName+"link"+tabNo+"_inactive";
		var cur_tab	= tabName+tabNo;
		document.getElementById(cur_act).style.display='block';
		document.getElementById(cur_inact).style.display='none';
		/*document.getElementById(cur_tab).style.paddingTop = '3px';
		document.getElementById(cur_tab).style.paddingLeft = '5px';
		document.getElementById(cur_tab).style.borderBottom ='1px solid #FFFDF9';
		document.getElementById(cur_tab).style.backgroundColor = '#FFFDF9';*/

		//other tabs
		for(i=1;i<=tabTotal;i++)
			{
			if(i != tabNo)
				{
				var oth_act = tabName+"link"+i+"_active";
				var oth_inact = tabName+"link"+i+"_inactive";
				var oth_tab	= tabName+i;
				document.getElementById(oth_act).style.display='none';
				document.getElementById(oth_inact).style.display='block';
				/*document.getElementById(oth_tab).style.paddingTop = '3px';
				document.getElementById(oth_tab).style.paddingLeft = '5px';
				document.getElementById(oth_tab).style.borderBottom = '1px solid #C4A080';
				document.getElementById(oth_tab).style.backgroundColor = '#FBEED6';*/
				}
			}
		showTab(tabNo,tabTotal,tabName);
		}
	function showTab(tabNo,tabTotal,tabName)
		{
		if(tabNo == 3) {
			loadcroptool();
		}else {
			clearcroptool();
		}
		var cur_tab_content = tabName+"_content_"+tabNo;
		document.getElementById(cur_tab_content).style.display="block";
		for(i=1;i<=tabTotal;i++)
			{
			if(i != tabNo)
				{
				var oth_tab_content = tabName+"_content_"+i;
				document.getElementById(oth_tab_content).style.display="none";
				}
			}
		}
	function load_crop(){
		document.getElementById('cropbutton').disabled=true;
		document.getElementById('cropbutton').value="processing";
		x1=document.getElementById('x1').value;
		y1=document.getElementById('y1').value;
		
		x2=document.getElementById('width').value;
		y2=document.getElementById('height').value;
		imagename=document.getElementById('imagename').value;
		
	url= "processimage.php?action=crop&x="+x1+"&y="+y1+"&w="+x2+"&h="+y2+"&imageName="+imagename;
	
	makeRequest1(url);
	}
	function load_contrast(){
		document.getElementById('contrastbutton').disabled=true;
		document.getElementById('contrastbutton').value="processing";
		x1=document.getElementById('x1').value;
		y1=document.getElementById('y1').value;
		x2=document.getElementById('width').value;
		y2=document.getElementById('height').value;
		imagename=document.getElementById('imagename').value;
		sharp = document.getElementById('shr-input').value;
	url= "processimage.php?action=sharpen&x="+x1+"&y="+y1+"&w="+x2+"&h="+y2+"&imageName="+imagename+"&sharp="+sharp;
	
	makeRequest(url);
	}
	 function makeRequest(url) {

        http_request = false;

        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        http_request.onreadystatechange = alertContents;		 
        http_request.open('GET', url, true);
        http_request.send(null);
    }
	 function makeRequest1(url) {

        http_request = false;

        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        http_request.onreadystatechange = alertContents_crop;		 
        http_request.open('GET', url, true);
        http_request.send(null);
    }
	function alertContents() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) 
			{
				document.getElementById('contrastbutton').disabled=false;
				document.getElementById('contrastbutton').value="Submit";
				document.getElementById('testWrap').innerHTML=http_request.responseText;
            } else 
			{
                alert('There was a problem with the request.');
            }
        }
    }
		function alertContents_crop() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) 
			{
				
				document.getElementById('result').innerHTML=http_request.responseText;
				document.getElementById('cropbutton').disabled=false;
				document.getElementById('cropbutton').value="Crop";
            } else 
			{
                alert('There was a problem with the request.');
            }
        }
    }
	function load_manage(){		
		document.getElementById('savbutton').disabled=true;
		document.getElementById('savbutton').value="processing";
		imagename=document.getElementById('imagename').value;
		phnum=document.getElementById('phnum').value;				
		action = "<?=$action?>";
		url= "addcropphoto.php?photo75="+imagename+"&photo150="+imagename+"&photo450="+imagename+"&phnum="+phnum+"&action="+action;
		makeRequest_add(url);
	}
	 function makeRequest_add(url) {
        http_request = false;
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }
        if (!http_request) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        http_request.onreadystatechange = alertContents_add;		 
        http_request.open('GET', url, true);
        http_request.send(null);
    }
	function alertContents_add() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) 
			{
				//document.getElementById('main_div').innerHTML=http_request.responseText;
				window.location="managephoto.php";
            } else 
			{
                alert('There was a problem with the request.');
            }
        }
    }
