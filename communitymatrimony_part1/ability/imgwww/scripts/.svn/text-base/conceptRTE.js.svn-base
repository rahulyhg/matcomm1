var isRichText = false;var rng;var currentRTE;var allRTEs = "";var isIE;var isGecko;var isSafari;var isKonqueror;var imagesPath;var includesPath;var cssFile;var richTxtCont;
var language = "EN";var command = "forecolor";   
function initRTE(imgPath, incPath, css, lang) {
	//set browser vars
	var ua = navigator.userAgent.toLowerCase();
	isIE = ((ua.indexOf("msie") != -1) && (ua.indexOf("opera") == -1) && (ua.indexOf("webtv") == -1));
	isGecko = (ua.indexOf("gecko") != -1);
	isSafari = (ua.indexOf("safari") != -1);
	isKonqueror = (ua.indexOf("konqueror") != -1);
	//check to see if designMode mode is available
	if ($ && document.designMode && !isSafari && !isKonqueror) { isRichText = true; }
	//set paths vars
	imagesPath = imgPath;
	includesPath = incPath;
	cssFile = css;
    language = lang;
	//for testing standard textarea, uncomment the following line
	//isRichText = false;
}
function writeRichText(rte, html, width, height, buttons, readOnly) {
	if (isRichText) {
		if (allRTEs.length > 0) allRTEs += ";";
		allRTEs += rte;
		writeRTE(rte, html, width, height, buttons, readOnly, language);
	} else { writeDefault(rte, html, width, height, buttons, readOnly); }
}
function writeDefault(rte, html, width, height, buttons, readOnly) {
	if (!readOnly) {
		richTxtCont += '<textarea name="' + rte + '" id="' + rte + '" style="width: ' + width + 'px; height: ' + height + 'px;">' + html + '</textarea>';
	} else {
		richTxtCont += '<textarea name="' + rte + '" id="' + rte + '" style="width: ' + width + 'px; height: ' + height + 'px;" readonly>' + html + '</textarea>';
	}
}
function raiseButton(e) {
	if (isIE) {var el = window.event.srcElement;
	} else { var el= e.target; }
	className = el.className;
	if (className == 'btnImage' || className == 'btnImageLowered') {el.className = 'btnImageRaised';}
}
function normalButton(e) {
	if (isIE) {
		var el = window.event.srcElement;
	} else {var el= e.target;}
	className = el.className;
	if (className == 'btnImageRaised' || className == 'btnImageLowered') {el.className = 'btnImage';}
}
function lowerButton(e) {
	if (isIE) {var el = window.event.srcElement;
	} else {var el= e.target;}
	className = el.className;
	if (className == 'btnImage' || className == 'btnImageRaised') {el.className = 'btnImageLowered';}
}
function writeRTE(rte, html, width, height, buttons, readOnly,language) {
	if (isIE) {var tablewidth = width;
	} else {var tablewidth = width + 4;}
	currentRTE = rte;
	var styleWord     = 'Style';
	var fontWord      = 'Font';
	var sizeWord      = 'Size';
	var boldWord      = 'Bold';
	var italicWord    = 'Italic';
	var underlineWord = 'Underline';
	var alignLWord    = 'Align Left';
	var alignCWord    = 'Center';
	var alignRWord    = 'Align Right';
	var alignFWord    = 'Justify Full';
	var rulerWord     = 'Horizontal Rule';
	var orderWord     = 'Ordered List';
	var unorderWord   = 'Unordered List';
	var outdentWord   = 'Outdent';
	var indentWord    = 'Indent';
	var textColorWord = 'Text Color';
	var backColorWord = 'Background Color';
	var linkWord      = 'Insert Link';
	var imageWord     = 'Add Image'
	if (readOnly) buttons = false;
	if (buttons == true) {
		richTxtCont = '<table class="btnBack" cellpadding="0" cellspacing="0" id="Buttons2_' + rte + '" width="' + tablewidth + '">';
		richTxtCont += '	<tr>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'bold.gif" width="25" height="24" alt="' + boldWord + '" title="' +boldWord + '" onClick="FormatText(\'' + rte + '\', \'bold\', \'\')"></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'italic.gif" width="25" height="24" alt="' + italicWord + '" title="' + italicWord + '" onClick="FormatText(\'' + rte + '\', \'italic\', \'\')"></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'underline.gif" width="25" height="24" alt="' + underlineWord + '" title="' + underlineWord + '" onClick="FormatText(\'' + rte + '\', \'underline\', \'\')"></td>';
		richTxtCont += '		<td><span class="vertSep"></span></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'left_just.gif" width="25" height="24" alt="' + alignLWord + '" title="' + alignLWord + '" onClick="FormatText(\'' + rte + '\', \'justifyleft\', \'\')"></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'centre.gif" width="25" height="24" alt="' + alignCWord + '" title="' + alignCWord + '" onClick="FormatText(\'' + rte + '\', \'justifycenter\', \'\')"></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'right_just.gif" width="25" height="24" alt="' + alignRWord + '" title="' + alignRWord + '" onClick="FormatText(\'' + rte + '\', \'justifyright\', \'\')"></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'justifyfull.gif" width="25" height="24" alt="' + alignFWord + '" title="' + alignFWord + '" onclick="FormatText(\'' + rte + '\', \'justifyfull\', \'\')"></td>';
		richTxtCont += '		<td><span class="vertSep"></span></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'hr.gif" width="25" height="24" alt="' + rulerWord + '" title="' + rulerWord + '" onClick="FormatText(\'' + rte + '\', \'inserthorizontalrule\', \'\')"></td>';
		richTxtCont += '		<td><span class="vertSep"></span></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'numbered_list.gif" width="25" height="24" alt="' + orderWord + '" title="' + orderWord + '" onClick="FormatText(\'' + rte + '\', \'insertorderedlist\', \'\')"></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'list.gif" width="25" height="24" alt="' + unorderWord + '" title="' + unorderWord + '" onClick="FormatText(\'' + rte + '\', \'insertunorderedlist\', \'\')"></td>';
		richTxtCont += '		<td><span class="vertSep"></span></td>';
		richTxtCont += '		<td><div id="forecolor_' + rte + '"  onClick="showForecolor(this.id,0)" style="position:left"><img class="btnImage" src="' + imagesPath + 'textcolor.gif" width="25" height="24" alt="' + textColorWord + '" title="' + textColorWord + '"></div></td>';
		richTxtCont += '		<td><div id="hilitecolor_' + rte + '" onClick="showForecolor(this.id,1)" style="position:left"><img class="btnImage" src="' + imagesPath + 'bgcolor.gif" width="25" height="24" alt="' + backColorWord + '" title="' + backColorWord + '"></div></td>';
		richTxtCont += '		<td><span class="vertSep"></span></td>';
		richTxtCont += '	    <td><img id="smiley_' + rte + '" class="btnImage" src="' + imagesPath + 'smiley.gif" width="25" height="24" alt="Smileys" title="Smileys" onclick="showSmiley(this.id)"></td>';
		richTxtCont += '		<td><span class="vertSep"></span></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'outdent.gif" width="25" height="24" alt="' + outdentWord + '" title="' + outdentWord + '" onClick="FormatText(\'' + rte + '\', \'outdent\', \'\')"></td>';
		richTxtCont += '		<td><img class="btnImage" src="' + imagesPath + 'indent.gif" width="25" height="24" alt="' + indentWord + '" title="' + indentWord + '" onClick="FormatText(\'' + rte + '\', \'indent\', \'\')"></td>';
		richTxtCont += '		<td width="100%"></td>';
		richTxtCont += '	</tr>';
		richTxtCont += '</table>';
		richTxtCont += '<table class="btnBack" cellpadding=2 cellspacing=0 id="Buttons1_' + rte + '" width="' + tablewidth + '">';
		richTxtCont += '	<tr>';
		richTxtCont += '		<td>';
		richTxtCont += '<select class="smalltxt" id="formatblock_' + rte + '" onchange="Select(\'' + rte + '\', this.id);">';
		richTxtCont += '				<option value="">[' + styleWord + ']</option>';
		richTxtCont += '				<option value="<p>">Paragraph</option>';
		richTxtCont += '				<option value="<h1>">Heading 1 <h1></option>';
		richTxtCont += '				<option value="<h2>">Heading 2 <h2></option>';
		richTxtCont += '				<option value="<h3>">Heading 3 <h3></option>';
		richTxtCont += '				<option value="<h4>">Heading 4 <h4></option>';
		richTxtCont += '				<option value="<h5>">Heading 5 <h5></option>';
		richTxtCont += '				<option value="<h6>">Heading 6 <h6></option>';
		richTxtCont += '				<option value="<address>">Address <ADDR></option>';
		richTxtCont += '				<option value="<pre>">Formatted <pre></option>';
		richTxtCont += '			</select>';
		richTxtCont += '		</td>';
		richTxtCont += '		<td>';
		richTxtCont += '			<select class="smalltxt" id="fontname_' + rte + '" onchange="Select(\'' + rte + '\', this.id);">';
		richTxtCont += '				<option value="Font" selected>[' + fontWord + ']</option>';
		richTxtCont += '				<option value="Arial, Helvetica, sans-serif">Arial</option>';
		richTxtCont += '				<option value="Courier New, Courier, mono">Courier New</option>';
		richTxtCont += '				<option value="Tahoma, Verdana">Tahoma</option>';
		richTxtCont += '				<option value="Times New Roman, Times, serif">Times New Roman</option>';
		richTxtCont += '				<option value="Verdana, Arial, Helvetica, sans-serif">Verdana</option>';
		richTxtCont += '			</select>';
		richTxtCont += '		</td>';
		richTxtCont += '		<td>';
		richTxtCont += '			<select class="smalltxt" unselectable="on" id="fontsize_' + rte + '" onchange="Select(\'' + rte + '\', this.id);">';
		richTxtCont += '				<option value="Size">[ ' + sizeWord + ']</option>';
		richTxtCont += '				<option value="1">1</option>';
		richTxtCont += '				<option value="2">2</option>';
		richTxtCont += '				<option value="3">3</option>';
		richTxtCont += '				<option value="4">4</option>';
		richTxtCont += '				<option value="5">5</option>';
		richTxtCont += '				<option value="6">6</option>';
		richTxtCont += '				<option value="7">7</option>';
		richTxtCont += '			</select>';
		richTxtCont += '		</td>';
		richTxtCont += '		<td width="100%">';
		richTxtCont += '		</td>';
		richTxtCont += '	</tr>';
		richTxtCont += '</table>';
	}
	richTxtCont += '<iframe id="' + rte + '" name="' + rte + '" width="' + width + 'px" height="' + height + 'px"></iframe>';
	richTxtCont += '<input type="hidden" id="hdn' + rte + '" name="' + rte + '" value="">';
	richTxtCont += '<div id="fcpop" style="display:none;position:absolute;float:left;">';
	richTxtCont += '<table cellpadding="0" cellspacing="1" border="1" align="center" width="150" bgcolor="#FFFFFF">';
	richTxtCont += '	<tr>';
	columnDiv	= ' width="15" height="14"  onmousedown="forecolorselect(this.id)"><img width="1" height="1"></td>';
	richTxtCont += '		<td id="#FFFFFF" bgcolor="#FFFFFF"'+columnDiv;
	richTxtCont += '		<td id="#FFCCCC" bgcolor="#FFCCCC"'+columnDiv;
	richTxtCont += '		<td id="#FFCC99" bgcolor="#FFCC99"'+columnDiv;
	richTxtCont += '		<td id="#FFFF99" bgcolor="#FFFF99"'+columnDiv;
	richTxtCont += '		<td id="#FFFFCC" bgcolor="#FFFFCC"'+columnDiv;
	richTxtCont += '		<td id="#99FF99" bgcolor="#99FF99"'+columnDiv;
	richTxtCont += '		<td id="#99FFFF" bgcolor="#99FFFF"'+columnDiv;
	richTxtCont += '		<td id="#CCFFFF" bgcolor="#CCFFFF"'+columnDiv;
	richTxtCont += '		<td id="#CCCCFF" bgcolor="#CCCCFF"'+columnDiv;
	richTxtCont += '		<td id="#FFCCFF" bgcolor="#FFCCFF"'+columnDiv;
	richTxtCont += '	</tr>';
	richTxtCont += '	<tr>';
	richTxtCont += '		<td id="#CCCCCC" bgcolor="#CCCCCC"'+columnDiv;
	richTxtCont += '		<td id="#FF6666" bgcolor="#FF6666"'+columnDiv;
	richTxtCont += '		<td id="#FF9966" bgcolor="#FF9966"'+columnDiv;
	richTxtCont += '		<td id="#FFFF66" bgcolor="#FFFF66"'+columnDiv;
	richTxtCont += '		<td id="#FFFF33" bgcolor="#FFFF33"'+columnDiv;
	richTxtCont += '		<td id="#66FF99" bgcolor="#66FF99"'+columnDiv;
	richTxtCont += '		<td id="#33FFFF" bgcolor="#33FFFF"'+columnDiv;
	richTxtCont += '		<td id="#66FFFF" bgcolor="#66FFFF"'+columnDiv;
	richTxtCont += '		<td id="#9999FF" bgcolor="#9999FF"'+columnDiv;
	richTxtCont += '		<td id="#FF99FF" bgcolor="#FF99FF"'+columnDiv;
	richTxtCont += '	</tr>';
	richTxtCont += '	<tr>';
	richTxtCont += '		<td id="#C0C0C0" bgcolor="#C0C0C0"'+columnDiv;
	richTxtCont += '		<td id="#FF0000" bgcolor="#FF0000"'+columnDiv;
	richTxtCont += '		<td id="#FF9900" bgcolor="#FF9900"'+columnDiv;
	richTxtCont += '		<td id="#FFCC66" bgcolor="#FFCC66"'+columnDiv;
	richTxtCont += '		<td id="#FFFF00" bgcolor="#FFFF00"'+columnDiv;
	richTxtCont += '		<td id="#33FF33" bgcolor="#33FF33"'+columnDiv;
	richTxtCont += '		<td id="#66CCCC" bgcolor="#66CCCC"'+columnDiv;
	richTxtCont += '		<td id="#33CCFF" bgcolor="#33CCFF"'+columnDiv;
	richTxtCont += '		<td id="#6666CC" bgcolor="#6666CC"'+columnDiv;
	richTxtCont += '		<td id="#CC66CC" bgcolor="#CC66CC"'+columnDiv;
	richTxtCont += '	</tr>';
	richTxtCont += '	<tr>';
	richTxtCont += '		<td id="#999999" bgcolor="#999999"'+columnDiv;
	richTxtCont += '		<td id="#CC0000" bgcolor="#CC0000"'+columnDiv;
	richTxtCont += '		<td id="#FF6600" bgcolor="#FF6600"'+columnDiv;
	richTxtCont += '		<td id="#FFCC33" bgcolor="#FFCC33"'+columnDiv;
	richTxtCont += '		<td id="#FFCC00" bgcolor="#FFCC00"'+columnDiv;
	richTxtCont += '		<td id="#33CC00" bgcolor="#33CC00"'+columnDiv;
	richTxtCont += '		<td id="#00CCCC" bgcolor="#00CCCC"'+columnDiv;
	richTxtCont += '		<td id="#3366FF" bgcolor="#3366FF"'+columnDiv;
	richTxtCont += '		<td id="#6633FF" bgcolor="#6633FF"'+columnDiv;
	richTxtCont += '		<td id="#CC33CC" bgcolor="#CC33CC"'+columnDiv;
	richTxtCont += '	</tr>';
	richTxtCont += '	<tr>';
	richTxtCont += '		<td id="#666666" bgcolor="#666666"'+columnDiv;
	richTxtCont += '		<td id="#990000" bgcolor="#990000"'+columnDiv;
	richTxtCont += '		<td id="#CC6600" bgcolor="#CC6600"'+columnDiv;
	richTxtCont += '		<td id="#CC9933" bgcolor="#CC9933"'+columnDiv;
	richTxtCont += '		<td id="#999900" bgcolor="#999900"'+columnDiv;
	richTxtCont += '		<td id="#009900" bgcolor="#009900"'+columnDiv;
	richTxtCont += '		<td id="#339999" bgcolor="#339999"'+columnDiv;
	richTxtCont += '		<td id="#3333FF" bgcolor="#3333FF"'+columnDiv;
	richTxtCont += '		<td id="#6600CC" bgcolor="#6600CC"'+columnDiv;
	richTxtCont += '		<td id="#993399" bgcolor="#993399"'+columnDiv;
	richTxtCont += '	</tr>';
	richTxtCont += '	<tr>';
	richTxtCont += '		<td id="#333333" bgcolor="#333333"'+columnDiv;
	richTxtCont += '		<td id="#660000" bgcolor="#660000"'+columnDiv;
	richTxtCont += '		<td id="#993300" bgcolor="#993300"'+columnDiv;
	richTxtCont += '		<td id="#996633" bgcolor="#996633"'+columnDiv;
	richTxtCont += '		<td id="#666600" bgcolor="#666600"'+columnDiv;
	richTxtCont += '		<td id="#006600" bgcolor="#006600"'+columnDiv;
	richTxtCont += '		<td id="#336666" bgcolor="#336666"'+columnDiv;
	richTxtCont += '		<td id="#000099" bgcolor="#000099"'+columnDiv;
	richTxtCont += '		<td id="#333399" bgcolor="#333399"'+columnDiv;
	richTxtCont += '		<td id="#663366" bgcolor="#663366"'+columnDiv;
	richTxtCont += '	</tr>';
	richTxtCont += '	<tr>';
	richTxtCont += '		<td id="#000000" bgcolor="#000000"'+columnDiv;
	richTxtCont += '		<td id="#330000" bgcolor="#330000"'+columnDiv;
	richTxtCont += '		<td id="#663300" bgcolor="#663300"'+columnDiv;
	richTxtCont += '		<td id="#663333" bgcolor="#663333"'+columnDiv;
	richTxtCont += '		<td id="#333300" bgcolor="#333300"'+columnDiv;
	richTxtCont += '		<td id="#003300" bgcolor="#003300"'+columnDiv;
	richTxtCont += '		<td id="#003333" bgcolor="#003333"'+columnDiv;
	richTxtCont += '		<td id="#000066" bgcolor="#000066"'+columnDiv;
	richTxtCont += '		<td id="#330099" bgcolor="#330099"'+columnDiv;
	richTxtCont += '		<td id="#330033" bgcolor="#330033"'+columnDiv;
	richTxtCont += '	</tr>';
	richTxtCont += '</table>';
	richTxtCont += '</div>';

	richTxtCont += '<div id="smileypop" style="display:none;position:absolute;float:left;">';
	richTxtCont += '<table cellpadding="3" cellspacing="1" border="1" align="center" bgcolor="#FFFFFF">';
	richTxtCont += '<tr>';
	imageDiv	= '<td width="15" height="15" align=center><img onmousedown="insertSmiley(this.src)" border=0 src="';
	richTxtCont += imageDiv + imagesPath + '/01.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/02.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/03.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/04.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/05.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/06.gif"></td>';
	richTxtCont += '</tr>';
	richTxtCont += '<tr>';
	richTxtCont += imageDiv + imagesPath + '/07.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/08.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/09.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/10.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/11.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/12.gif"></td>';
	richTxtCont += '</tr>';
	richTxtCont += '<tr>';
	richTxtCont += imageDiv + imagesPath + '/13.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/14.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/15.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/16.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/17.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/18.gif"></td>';
	richTxtCont += '</tr>';
	richTxtCont += '<tr>';
	richTxtCont += imageDiv + imagesPath + '/19.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/20.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/21.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/22.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/23.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/24.gif"></td>';
	richTxtCont += '</tr>';
	richTxtCont += '<tr>';
	richTxtCont += imageDiv + imagesPath + '/25.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/26.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/27.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/28.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/29.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/30.gif"></td>';
	richTxtCont += '</tr>';
	richTxtCont += '<tr>';
	richTxtCont += imageDiv + imagesPath + '/31.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/32.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/33.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/34.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/35.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/37.gif"></td>';
	richTxtCont += '</tr>';
	richTxtCont += '<tr>';
	richTxtCont += imageDiv + imagesPath + '/39.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/40.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/47.gif"></td>';
	richTxtCont += imageDiv + imagesPath + '/50.gif"></td>';
	richTxtCont += '</tr>';
	richTxtCont += '</table>';
	richTxtCont += '</div>';
	$('richedit').innerHTML = richTxtCont;
	$('hdn' + rte).value = html;
	enableDesignMode(rte, html, readOnly);
}

function showForecolor(obj,colortype) {
	var objj = $(obj);
	if(colortype==1) {
		command = "hilitecolor";
		$("fcpop").style.left=objj.offsetParent.offsetLeft;
	}
	else{
		command = "forecolor";
		$("fcpop").style.left=objj.offsetParent.offsetLeft;
	}
	$("fcpop").style.display = "";
	$("fcpop").style.top=objj.offsetParent.offsetTop+30;
	$("fcpop").style.left=objj.offsetParent.offsetLeft-50;
	$("smileypop").style.display = "none";
}

function forecolorselect(color) {
	if (color) {
		if (document.all) {
			if (command == "hilitecolor") {
				command = "backcolor";
			}
		}
		$(currentRTE).contentWindow.focus();
		$(currentRTE).contentWindow.document.execCommand(command, false, color);
		$("fcpop").style.display = "none";
	}
}
	
function showSmiley(obj) {
	var objj = $(obj);
	$("smileypop").style.display = "";
	$("smileypop").style.top=objj.offsetParent.offsetTop+30;
	$("smileypop").style.left=objj.offsetParent.offsetLeft-50;
	$("fcpop").style.display = "none";
}

function insertSmiley(img) {
	if (img) {
		$(currentRTE).contentWindow.focus();
		$(currentRTE).contentWindow.document.execCommand('InsertImage', false, img);
		$("smileypop").style.display = "none";
	}
}

function enableDesignMode(rte, html, readOnly) {
	var frameHtml = "<html><head>";
	//to reference your stylesheet, set href property below to your stylesheet path and uncomment
	if (cssFile.length > 0) {
		frameHtml += "<link media=\"all\" type=\"text/css\" href=\"" + cssFile + "\" rel=\"stylesheet\">\n";
	}
	frameHtml += "<style>body {background: #FFFFFF;margin: 0px;padding: 0px;}</style></head><body>";
	frameHtml += html;
	frameHtml += "</body></html>";

	if (document.all) {
		var oRTE = frames[rte].document;
		oRTE.open();
		oRTE.write(frameHtml);
		oRTE.close();
		if (!readOnly) oRTE.designMode = "On";
		if(window.addEventListener){ // Mozilla, Netscape, Firefox
			oRTE.addEventListener("click", mouse_handler, true);
			document.body.addEventListener("click", mouse_handler, true);
		} else { // IE
			oRTE.attachEvent("onclick", mouse_handler,false);
			window.document.attachEvent("onmousedown", mouse_handler,false);
		}
	} else {
		try {
			if (!readOnly) $(currentRTE).contentDocument.designMode = "on";
			try {
				var oRTE = $(currentRTE).contentWindow.document;
				oRTE.open();
				oRTE.write(frameHtml);
				oRTE.close();
				if (isGecko && !readOnly) {
					//attach a keyboard handler for gecko browsers to make keyboard shortcuts work
					oRTE.addEventListener("keypress", kb_handler, true);
					oRTE.addEventListener("click", mouse_handler, true);
					document.body.addEventListener("click", mouse_handler, true);
				}
			} catch (e) {
				alert("Error preloading content.");
			}
		} catch (e) {
			//gecko may take some time to enable design mode.
			//Keep looping until able to set.
			if (isGecko) {
				setTimeout("enableDesignMode('" + rte + "', '" + html + "', " + readOnly + ");", 10);
			} else {
				return false;
			}
		}
	}
}

function updateRTEs() {
	var vRTEs = allRTEs.split(";");
	for (var i = 0; i < vRTEs.length; i++) {
		updateRTE(vRTEs[i]);
	}
}

function updateRTE(rte) {
	if (!isRichText) return;

	//set message value
	var oHdnMessage = $('hdn' + rte);
	var oRTE = $(currentRTE);
	var readOnly = false;
	//check for readOnly mode
	if (document.all) {
		if (frames[currentRTE].document.designMode != "On") readOnly = true;
	} else {
		if ($(currentRTE).contentDocument.designMode != "on") readOnly = true;
	}

	if (isRichText && !readOnly) {

		if (oHdnMessage.value == null) oHdnMessage.value = "";
		if (document.all) {
			oHdnMessage.value = frames[rte].document.body.innerHTML;
		} else {
			oHdnMessage.value = oRTE.contentWindow.document.body.innerHTML;
		}

		//if there is no content (other than formatting) set value to nothing
		if (stripHTML(oHdnMessage.value.replace("&nbsp;", " ")) == ""
			&& oHdnMessage.value.toLowerCase().search("<hr") == -1
			&& oHdnMessage.value.toLowerCase().search("<img") == -1) oHdnMessage.value = "";
		//fix for gecko
		if (escape(oHdnMessage.value) == "%3Cbr%3E%0D%0A%0D%0A%0D%0A") oHdnMessage.value = "";
	}
}

//Function to format text in the text box
function FormatText(rte, command, option) {
	var oRTE;
	if (document.all) {
		oRTE = frames[rte];

		//get current selected range
		var selection = oRTE.document.selection;
		if (selection != null) {
			rng = selection.createRange();
		}
	} else {
		oRTE = $(currentRTE).contentWindow;

		//get currently selected range
		var selection = oRTE.getSelection();
		rng = selection.getRangeAt(selection.rangeCount - 1).cloneRange();
	}

	try {
		oRTE.focus();
	  	oRTE.document.execCommand(command, false, option);
		oRTE.focus();
	} catch (e) {
		alert(e);
	}
	mouse_handler();
}

function getOffsetTop(elm) {
	var mOffsetTop = elm.offsetTop;
	var mOffsetParent = elm.offsetParent;

	while(mOffsetParent){
		mOffsetTop += mOffsetParent.offsetTop;
		mOffsetParent = mOffsetParent.offsetParent;
	}

	return mOffsetTop;
}

function getOffsetLeft(elm) {
	var mOffsetLeft = elm.offsetLeft;
	var mOffsetParent = elm.offsetParent;

	while(mOffsetParent) {
		mOffsetLeft += mOffsetParent.offsetLeft;
		mOffsetParent = mOffsetParent.offsetParent;
	}

	return mOffsetLeft;
}

function Select(rte, selectname) {
	var oRTE;
	if (document.all) {
		oRTE = frames[rte];

		//get current selected range
		var selection = oRTE.document.selection;
		if (selection != null) {
			rng = selection.createRange();
		}
	} else {
		oRTE = $(currentRTE).contentWindow;

		//get currently selected range
		var selection = oRTE.getSelection();
		rng = selection.getRangeAt(selection.rangeCount - 1).cloneRange();
	}

	var idx = $(selectname).selectedIndex;
	// First one is always a label
	if (idx != 0) {
		var selected = $(selectname).options[idx].value;
		var cmd = selectname.replace('_' + rte, '');
		oRTE.focus();
		oRTE.document.execCommand(cmd, false, selected);
		oRTE.focus();
		//$(selectname).selectedIndex = 0;
	}
	mouse_handler();
}

function kb_handler(evt) {
	var rte = evt.target.id;

	//contributed by Anti Veeranna (thanks Anti!)
	if (evt.ctrlKey) {
		var key = String.fromCharCode(evt.charCode).toLowerCase();
		var cmd = '';
		switch (key) {
			case 'b': cmd = "bold"; break;
			case 'i': cmd = "italic"; break;
			case 'u': cmd = "underline"; break;
		};

		if (cmd) {
			FormatText(rte, cmd, true);
			//evt.target.ownerDocument.execCommand(cmd, false, true);
			// stop the event bubble
			evt.preventDefault();
			evt.stopPropagation();
		}
 	}
}

function mouse_handler() {
	$("fcpop").style.display = "none";
	$("smileypop").style.display = "none";
	clearTextArea("R");
}

function stripHTML(oldString) {
	var newString = oldString.replace(/(<([^>]+)>)/ig,"");

	//replace carriage returns and line feeds
   newString = newString.replace(/\r\n/g," ");
   newString = newString.replace(/\n/g," ");
   newString = newString.replace(/\r/g," ");

	//trim string
	newString = trim(newString);

	return newString;
}

function trim(inputString) {
   // Removes leading and trailing spaces from the passed string. Also removes
   // consecutive spaces and replaces it with one space. If something besides
   // a string is passed in (null, custom object, etc.) then return the input.
   if (typeof inputString != "string") return inputString;
   var retValue = inputString;
   var ch = retValue.substring(0, 1);

   while (ch == " ") { // Check for spaces at the beginning of the string
      retValue = retValue.substring(1, retValue.length);
      ch = retValue.substring(0, 1);
   }
   ch = retValue.substring(retValue.length-1, retValue.length);

   while (ch == " ") { // Check for spaces at the end of the string
      retValue = retValue.substring(0, retValue.length-1);
      ch = retValue.substring(retValue.length-1, retValue.length);
   }

	// Note that there are two spaces in the string - look for multiple spaces within the string
   while (retValue.indexOf("  ") != -1) {
		// Again, there are two spaces in each of the strings
      retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length);
   }
   return retValue; // Return the trimmed string back to the user
}
function popup(page,popupname,height,width) {
	var topPosition = (screen.height - height) / 2;
	var leftPosition = (screen.width - width) / 2;
	var windowprops = "width=" + width + ",height=" + height + ",top=" + topPosition + ",left=" + leftPosition + ",location=no,menubar=no,toolbar=no,scrollbars=no,resizable=no,status=no";
	newWindow = window.open(page,popupname,windowprops);
}