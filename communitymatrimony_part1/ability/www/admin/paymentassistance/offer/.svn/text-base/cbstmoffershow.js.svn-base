
//File created by Anbu
//gobal variable
var divedbefor;
var packageone;
var divpost;
var totcount;
//enable the offer by package wise
function offerenable(packagestr) {
	var paka=9;	
	packageone=packagestr;
	for(var i=1;i<=9;i++) {

		if(packagestr==i) {
		document.getElementById('PACKAGEDIV'+i).style.display='block';
		} else {
		document.getElementById('PACKAGEDIV'+i).style.display='none';
		}
	}
}
function onloadhidepackage(offerokval) {
	var offerokval;
	if(offerokval=="1") {

		for(var i=1;i<=9;i++) {
			document.getElementById('PACKAGEDIV'+i).style.display='none';
			}
		}
	 
}

function checkfun(findvalue){

			//var elem = document.getElementById('FRMOFFER'+packageone).elements;
			 var elem = document.getElementById('PACKAGEDIV'+packageone).childNodes;
			for(var i = 0; i < elem.length; i++){
				if(elem[i].name){

					if(elem[i].value=="+") { divedbefor=i; 
						var postionval1=1; 
					} 
					if(elem[i].value=="-") { divedbefor=i; 
					var postionval2=2;
					} 
					if(findvalue==elem[i].name) { divpost=i; } //find the postion of fileds
					totcount=i; //total count
				}
			}

			//- (mines) offer enable and disable process start

				if(postionval2=='2') {
				if(divpost>divedbefor) { //(5>7)
				for(var j=0;j<divedbefor;j++) {
					if(elem[j].name){
						var names=elem[j].name;
						var types=elem[j].type;
						if(types=='radio') {
							
							var lengthvalue1=eval("document.PROFILEUPDATE."+names).length;
							for(var ass1=0;ass1<lengthvalue1;ass1++) {
							eval("document.PROFILEUPDATE."+names+"["+ass1+"]").disabled=true;
							}
						}
						else {
						eval("document.PROFILEUPDATE."+names).disabled=true;
						}
				}
			}
				for(var k=divedbefor;k<=totcount;k++) {
				if(elem[k].name){
					var names=elem[k].name;
					var types=elem[k].type;
					if(types=='radio') {
						
						var lengthvalue2=eval("document.PROFILEUPDATE."+names).length;
							for(var ass2=0;ass2<lengthvalue2;ass2++) {
							eval("document.PROFILEUPDATE."+names+"["+ass2+"]").disabled=false;
						}
					} else {
					eval("document.PROFILEUPDATE."+names).disabled=false;
					}
				}
			}
	}
			//(7<=10)
			else if(divpost<=divedbefor) {
				
				for(var j=0;j<divedbefor;j++) {
				if(elem[j].name){
				var names=elem[j].name;
				var types=elem[j].type;
					if(types=='radio') {
						
						var lengthvalue1=eval("document.PROFILEUPDATE."+names).length;
						for(var ass1=0;ass1<lengthvalue1;ass1++) {
							eval("document.PROFILEUPDATE."+names+"["+ass1+"]").disabled=false;
						}
					} else {
					eval("document.PROFILEUPDATE."+names).disabled=false;
					}
				}
			}
				for(var k=divedbefor;k<=totcount;k++) {
				if(elem[k].name){
				var names=elem[k].name;
					var types=elem[k].type;
					if(types=='radio') {
							var lengthvalue2=eval("document.PROFILEUPDATE."+names).length;
							for(var ass2=0;ass2<lengthvalue2;ass2++) {
							eval("document.PROFILEUPDATE."+names+"["+ass2+"]").disabled=true;
						}
					} else {
					eval("document.PROFILEUPDATE."+names).disabled=true;
					}
				}
			}
		}
	}
		//- (mines)offer enable and disable process end	]
					
		//And /Or offer enable and disable process strat
			if(postionval1=='1' || postionval2=='2') { 

				//before +/- offer
					if(divpost<divedbefor) {
						for(var m=divpost;m<divedbefor;m++) {
							if(elem[m].value=='#') {
							var findpostion1=m;
							}

							for(var x=findpostion1;x<divedbefor;x++) {
								if(elem[x].name){
									var namenew=elem[x].name;
									if(elem[x].type=='radio') {	
									var lengthvalue1=eval("document.PROFILEUPDATE."+namenew).length;
									for(var ass1=0;ass1<lengthvalue1;ass1++) {
									eval("document.PROFILEUPDATE."+namenew+"["+ass1+"]").disabled=true;
									}
									} else {
									eval("document.PROFILEUPDATE."+namenew).disabled=true;
									}
								}
							}
						}
						for(var n=divpost;0<=n;n--) {
							if(elem[n].value=='#') {
							var findpostion2=n;
							}
								for(var y=findpostion2;0<=y;y--) {
								if(elem[y].name){
								var namenew=elem[y].name;
								if(elem[y].type=='radio') {	
								var lengthvalue2=eval("document.PROFILEUPDATE."+namenew).length;
									for(var ass2=0;ass2<lengthvalue2;ass2++) {
									eval("document.PROFILEUPDATE."+namenew+"["+ass2+"]").disabled=true;
									}
								} else {
								eval("document.PROFILEUPDATE."+namenew).disabled=true;
									}
								}
							}
						}
					}
					//before +/- offer end

					//after +/- offer start
					if(divpost>divedbefor) {
						for(var m=divpost;m<=totcount;m++) {
							if(elem[m].value=='#') {
							var findpostion1=m;
							}
							for(var x=findpostion1;x<=totcount;x++) {
								if(elem[x].name){
								var namenew=elem[x].name;

								if(elem[x].type=='radio') {	
								var lengthvalue1=eval("document.PROFILEUPDATE."+namenew).length;
								for(var ass1=0;ass1<lengthvalue1;ass1++) {
									eval("document.PROFILEUPDATE."+namenew+"["+ass1+"]").disabled=true;
								}
								} else {
								eval("document.PROFILEUPDATE."+namenew).disabled=true;
								}
							}
						}
						}
						for(var n=divpost;0<=n;n--) {
							if(elem[n].value=='#') {
							var findpostion2=n;
							}
								for(var y=findpostion2;0<=y;y--) {
								if(elem[y].name){
								var namenew=elem[y].name;
								if(elem[y].type=='radio') {
								var lengthvalue2=eval("document.PROFILEUPDATE."+namenew).length;
								for(var ass2=0;ass2<lengthvalue2;ass2++) {
									eval("document.PROFILEUPDATE."+namenew+"["+ass2+"]").disabled=true;
								}
								} else {
								eval("document.PROFILEUPDATE."+namenew).disabled=true;
								}
							}
						}
						}
					}
					//after +/- offer end
				}	//single offer flow star 

				else {
						for(var m=divpost;m<=totcount;m++) {
						if(elem[m].value=='#') {
						var findpostion1=m;
						}
						for(var x=findpostion1;x<=totcount;x++) {
							if(elem[x].name){
							var namenew=elem[x].name;
							if(elem[x].type=='radio') {	
							var lengthvalue1=eval("document.PROFILEUPDATE."+namenew).length;
								for(var ass1=0;ass1<lengthvalue1;ass1++) {
									eval("document.PROFILEUPDATE."+namenew+"["+ass1+"]").disabled=true;
								}
							} else {
							eval("document.PROFILEUPDATE."+namenew).disabled=true;
							}
						}
						}
					}
					for(var n=divpost;0<=n;n--) {
						if(elem[n].value=='#') {
						var findpostion2=n;
						}
							for(var y=findpostion2;0<=y;y--) {
							if(elem[y].name){
							var namenew=elem[y].name;
							if(elem[y].type=='radio') {
							var lengthvalue1=eval("document.PROFILEUPDATE."+namenew).length;
								for(var ass1=0;ass1<lengthvalue1;ass1++) {
									eval("document.PROFILEUPDATE."+namenew+"["+ass1+"]").disabled=true;
								}
							} else {
							eval("document.PROFILEUPDATE."+namenew).disabled=true;
							}
						}
					}
					}
				}//single offer flow start

	
	}

//reset the selected offer and disable values start
function resetval(){
 
   var elem = document.getElementById('PACKAGEDIV'+packageone).childNodes;
//	var elem = document.getElementById('FRMOFFER'+packageone).elements;
	for(var i = 0; i < elem.length; i++){
		if(elem[i].name){
				var names=elem[i].name;
				if(elem[i].type=='radio') {
				
				var lengthvalue1=eval("document.PROFILEUPDATE."+names).length;
				for(var ass1=0;ass1<lengthvalue1;ass1++) {
					eval("document.PROFILEUPDATE."+names+"["+ass1+"]").disabled=false;
				}
				} else {
				eval("document.PROFILEUPDATE."+names).disabled = false;
				}


				if(elem[i].type=='select-one') {
				eval("document.PROFILEUPDATE."+names).selectedIndex=0;
				}
				if(elem[i].type=='radio') {

				var lengthvalue2=eval("document.PROFILEUPDATE."+names).length;
				for(var ass2=0;ass2<lengthvalue2;ass2++) {
					eval("document.PROFILEUPDATE."+names+"["+ass2+"]").checked=false;
				}

				}
				if(elem[i].type=='checkbox') {
				eval("document.PROFILEUPDATE."+names).checked= false;
				}
			}

	}
}
//reset the selected offer and disable values start
function callBack(){

	for(var t=1;t<=9;t++){

	   var elem = document.getElementById('PACKAGEDIV'+packageone).childNodes;
		for(var i = 0; i < elem.length; i++){
	if(elem[i].name){
			var names=elem[i].name;

			if(elem[i].type=='radio') {
			var lengthvalue1=eval("document.PROFILEUPDATE."+names).length;
				for(var ass1=0;ass1<lengthvalue1;ass1++) {
					eval("document.PROFILEUPDATE."+names+"["+ass1+"]").disabled=false;
				}
			} else {
			eval("document.PROFILEUPDATE."+names).disabled = false;
			}


			if(elem[i].type=='select-one') {
			eval("document.PROFILEUPDATE."+names).selectedIndex=0;
			}
			if(elem[i].type=='radio') {
			var lengthvalue2=eval("document.PROFILEUPDATE."+names).length;
				for(var ass2=0;ass2<lengthvalue2;ass2++) {
					eval("document.PROFILEUPDATE."+names+"["+ass2+"]").checked=false;
				}

			}
			if(elem[i].type=='checkbox') {
			eval("document.PROFILEUPDATE."+names).checked= false;
			}
		}
	}
	}

}

function currenceCalculate(cuType) {

	var docValue=document.getElementById('AMOUNT').value;
	var amType=cuType.value;
	if(docValue!='') {
	var cuTypeAmount=Math.abs(docValue * amType); 
	var fStr=(cuTypeAmount+'');
	var dotval=fStr.match(".");
	if(dotval>0) {
		var splAmnt=fStr.split(".");
		var intStr=splAmnt[0];
		var rmStrlen=splAmnt[1].length
		if(rmStrlen>2) {
			var fPoint=splAmnt[1].substr(0,2);
			var cuTypeAmount=intStr+"."+fPoint;
		}
	}
	document.getElementById('RETAMT').innerHTML=cuTypeAmount;
	} else {
	document.getElementById('RETAMT').innerHTML=0;
	document.getElementById('AMOUNT').focus();
	}

}
function srch_overlay(curobj, srch_saveobj){
	if (document.getElementById){
	var srch_saveobj=document.getElementById(srch_saveobj)
	srch_saveobj.style.left=srch_getposOffset(curobj, "left")-8+"px"
	srch_saveobj.style.top=srch_getposOffset(curobj, "top")-172+"px"
	srch_saveobj.style.display="block"
	//document.getElementById('BMID').focus();
	return false
	}
	else
	return true
}

function srch_overlayclose(srch_saveobj){
document.getElementById(srch_saveobj).style.display="none"
}
function srch_getposOffset(overlay, offsettype){
	var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
	var parentEl=overlay.offsetParent;
	while (parentEl!=null){
	totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
	parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}
