
//File created by Anbu
//gobal variable
var divedbefor;
var packageone;
var divpost;
var totcount;
//enable the offer by package wise
function offerenable(packagestr) {
	var paka=document.getElementById('TOTALPACKAGE').value;
	var packKeys=new Array();
	packKeys=paka.split(",");
	packageone=packagestr;
	for(var i=0;i<=16;i++) {
		if(document.getElementById('PACKAGEDIV'+packKeys[i])) {
			if(packagestr==packKeys[i]) {
			document.getElementById('PACKAGEDIV'+packKeys[i]).style.display='block';
			} else {
			document.getElementById('PACKAGEDIV'+packKeys[i]).style.display='none';
			}
		}
	}
}
function onloadhidepackage(offerokval) {
	var offerokval;
	if(offerokval=="1") {
	var paka=document.getElementById('TOTALPACKAGE').value;
	var packKeys=new Array();
	packKeys=paka.split(",");
			for(var i=1;i<=16;i++) {
				if(document.getElementById('PACKAGEDIV'+packKeys[i])) {
				document.getElementById('PACKAGEDIV'+packKeys[i]).style.display='none';
				}
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
	var paka=document.getElementById('TOTALPACKAGE').value;
	for(var t=1;t<=paka;t++){
		if(t==10) { t='48'; }
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
	var amType=cuType.value
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
	}

}



//offer showing 
function showSavings(packshow,selectedValue,packkey) {

var packName=document.getElementById('SAVEPACKNAMES').value;
var	rates=document.getElementById('SAVEOVERALLRATES').value;
var maxOfferRate=document.getElementById('SAVEMAXOFFERRATE').value;
var depFaltRate=document.getElementById('SAVEFLAT'+packkey).value;
var	depNextLevel=document.getElementById('SAVENEXTLEVEL'+packkey).value;
var	depHoroscop=document.getElementById('SAVEHOROSCOPEDEP'+packkey).value;
var	Horoscopkey=document.getElementById('HOROKEYSONLY').value;
var	HoroscopRateonly=document.getElementById('HORORATEONLY').value;

var depNextArray=new Array();
var depFlatArray=new Array();
var rateArray=new Array();
var maxOfferRatearray= new Array();
var packNameArray= new Array();
var depHoroscopArray=new Array();
var HoroscopRate=new Array();
var HoroscopKeyArray=new Array();
var HoroscopRateArray=new Array();


packNameArray=packName.split("-");
maxOfferRatearray=maxOfferRate.split("-");//maxofferrate array
rateArray=rates.split("-");//rate array
depNextArray=depNextLevel.split("-");//dep array for Next
depFlatArray=depFaltRate.split("-");//dep array for flat
depHoroscopArray=depHoroscop.split("-");//dep array for flat
HoroscopKeyArray=Horoscopkey.split("-");//horo keys 
HoroscopRateArray=HoroscopRateonly.split("-");//horo rate

var netnextLevelAmount=0;
var netnextLevelSaveAmount=0;
var netsaveAmount=0;

		 if(packshow==3) { //for next level offer saving
				if(selectedValue.checked==true) {
					
				var high=depNextArray[0];
				var nextLevetLow=parseInt(rateArray[packkey-1]);
				var nextLevelHigh=parseInt(rateArray[high-1]);
				netnextLevelSaveAmount=Math.floor(nextLevelHigh-nextLevetLow);
				netnextLevelAmount=Math.floor(nextLevelHigh-netnextLevelSaveAmount);

				document.getElementById("SAVE"+packkey+packshow).innerHTML=netnextLevelSaveAmount;
				document.getElementById("PACKNAME"+packkey).innerHTML=packNameArray[high-1]
				document.getElementById("PACKRATES"+packkey).innerHTML=rateArray[high-1];
				document.getElementById("BASAMOUNT"+packkey).value=rateArray[high-1];
				}
				else if(selectedValue.checked==false) {
				document.getElementById("PACKNAME"+packkey).innerHTML=packNameArray[packkey-1];
				document.getElementById("PACKRATES"+packkey).innerHTML=rateArray[packkey-1];
				document.getElementById("SAVE"+packkey+packshow).innerHTML=netnextLevelAmount;
				document.getElementById("BASAMOUNT"+packkey).value=rateArray[packkey-1];
				}
				document.getElementById('SAVINGSNEXT'+packkey).value=netnextLevelSaveAmount;

		}

		if(packshow==5) { //for flat offer saving
				var sentpackamount=parseInt(rateArray[packkey-1]);
				netsaveAmount=Math.abs(sentpackamount-selectedValue.value);	
				var bascper=getpercentage(sentpackamount,selectedValue.value,1);
				document.getElementById("BASE"+packkey+packshow).innerHTML='0';
				document.getElementById("SAVE"+packkey+packshow).innerHTML=selectedValue.value;
				document.getElementById('SAVINGSAMOUNT'+packkey).value=selectedValue.value;
	
	
		for(var i=0;i<depFlatArray.length;i++) {
			
			var nexAmuntkey=depFlatArray[i];

				if(nexAmuntkey!=packkey) {
					var nextAmount=parseInt(rateArray[nexAmuntkey-1]);
					var nextFinalAmunt=getpercentage(nextAmount,bascper,2);
					var netnextAmount=Math.floor(nextAmount-nextFinalAmunt);
					var maxAmount=maxOfferRatearray[nexAmuntkey-1];

						if(nextFinalAmunt>maxAmount) { 
						var nextFinalAmunt=maxAmount;
						var netnextAmount=Math.floor(nextAmount-nextFinalAmunt);
						}
					document.getElementById("BASE"+nexAmuntkey+packshow).innerHTML='0';
					document.getElementById("SAVE"+nexAmuntkey+packshow).innerHTML=nextFinalAmunt;

					document.getElementById('SAVINGSAMOUNT'+nexAmuntkey).value=nextFinalAmunt;
					document.getElementById("BASAMOUNT"+nexAmuntkey).value=rateArray[nexAmuntkey-1];
					
					var nextfinalAmount=Math.abs(parseInt(rateArray[nexAmuntkey-1]-nextFinalAmunt));
					document.getElementById('SAVINGSTOTAL'+nexAmuntkey).innerHTML=nextFinalAmunt;
					document.getElementById('BASETOTAL'+nexAmuntkey).innerHTML=nextAmount;
					document.getElementById('NEWPRICE'+nexAmuntkey).innerHTML=nextfinalAmount;
					
				}
		}
	}

	if(packshow==6) { //for horoscope offer saving
			var horocount=HoroscopKeyArray.length;
			for(i=0;i<horocount;i++) {
			HoroscopRate[HoroscopKeyArray[i]]=HoroscopRateArray[i];
			}
			var horosel=selectedValue.value;
			document.getElementById("BASE"+packkey+packshow).innerHTML=HoroscopRate[horosel];
			document.getElementById("SAVE"+packkey+packshow).innerHTML=HoroscopRate[horosel];
			document.getElementById('SAVINGSHOROSCOPE'+packkey).value=HoroscopRate[horosel];

	}

	if(packshow==8 || packshow==9) { //AddOnPack 1

	var addOnPack1=0;
	var addOnPack2=0;
	var addonfinal=0;
	var addonfinaloffer=0;
	var addonselectedoffer=0;

	addOnPack1=document.getElementById("PROFILEHIGHLIGHT").value;
	addOnPack2=document.getElementById("RESPONSEBOOSTER").value;
	addonfinal=document.getElementById("ADDON"+packkey).value;
	addonfinaloffer=document.getElementById("ADDONOFFER"+packkey).value;
	var addonselectedoffer=selectedValue.value;
	
		if(packshow==8) {
			if(selectedValue.checked==true)  {
			document.getElementById("ADDON"+packkey).value=parseInt(addonfinal)+parseInt(addOnPack1);
			document.getElementById("ADDONOFFER"+packkey).value=parseInt(addonfinaloffer)+parseInt(addonselectedoffer);
			}
			else if(selectedValue.checked==false) {
			if(addonfinal>0) {
			document.getElementById("ADDON"+packkey).value=parseInt(addonfinal)-parseInt(addOnPack1);
			}
			if(addonfinaloffer>0 && addonselectedoffer>0) {
			document.getElementById("ADDONOFFER"+packkey).value=parseInt(addonfinaloffer)-parseInt(addonselectedoffer);
			}else {
			document.getElementById("BASE"+packkey+packshow).innerHTML=0;
			document.getElementById("SAVE"+packkey+packshow).innerHTML=0;
			document.getElementById("ADDONOFFER"+packkey).value=0;
			}
			}
		}
		else if(packshow==9) {
			var packshow=8;
			if(selectedValue.checked==true)  {
			document.getElementById("ADDON"+packkey).value=parseInt(addonfinal)+parseInt(addOnPack2);
			document.getElementById("ADDONOFFER"+packkey).value=parseInt(addonfinaloffer)+parseInt(addonselectedoffer);
			}
			else if(selectedValue.checked==false) {
			if(addonfinal>0) {
			document.getElementById("ADDON"+packkey).value=parseInt(addonfinal)-parseInt(addOnPack2);
			}
			if(addonfinaloffer>0 && addonselectedoffer>0) {
			document.getElementById("ADDONOFFER"+packkey).value=parseInt(addonfinaloffer)-parseInt(addonselectedoffer);
			} else {
			document.getElementById("BASE"+packkey+packshow).innerHTML=0;
			document.getElementById("SAVE"+packkey+packshow).innerHTML=0;
			document.getElementById("ADDONOFFER"+packkey).value=0;
			}
			}
		}
		document.getElementById("BASE"+packkey+packshow).innerHTML=document.getElementById("ADDON"+packkey).value;
		document.getElementById("SAVE"+packkey+packshow).innerHTML=document.getElementById("ADDONOFFER"+packkey).value
	}

		//show that final amount
		var next=0;
		var amount=0;
		var horos=0;
		var addonoffersaving=0;
		var addonbasetotal=0;
		next=document.getElementById('SAVINGSNEXT'+packkey).value;
		amount=document.getElementById('SAVINGSAMOUNT'+packkey).value;
		horos=document.getElementById('SAVINGSHOROSCOPE'+packkey).value;
		addonoffersaving=document.getElementById("ADDONOFFER"+packkey).value;
		addonbasetotal=document.getElementById("ADDON"+packkey).value;

		var basamount=document.getElementById("BASAMOUNT"+packkey).value;
		var finalAmount=Math.abs((parseInt(basamount)+parseInt(addonbasetotal))-(parseInt(next)+parseInt(amount)));
		document.getElementById('SAVINGSTOTAL'+packkey).innerHTML=(parseInt(next)+parseInt(amount)+parseInt(horos)+parseInt(addonoffersaving));
		document.getElementById('BASETOTAL'+packkey).innerHTML=(parseInt(basamount)+parseInt(horos)+parseInt(addonbasetotal));
		document.getElementById('NEWPRICE'+packkey).innerHTML=finalAmount;
		document.getElementById('EPROFFERPRICE'+packkey).value=finalAmount;
}

function getpercentage(sentpackamount,selrate,perType) {
	if(perType==1) {
	var per=Math.floor((selrate*100)/sentpackamount);
	} else if(perType==2) {

	var office=document.getElementById("SELECTEDCURRENCY").value;
	var newstr=Math.floor((sentpackamount*selrate)/100);
	var perAmount=newstr+'';
	var finalreturn='NO';
	
	if(office=='INR') {	perAmount=perAmount.slice(-2); var checkAmunt=50; var minAmount=100;}
	else if(office=='AED') { perAmount=perAmount.slice(-1); var checkAmunt=5; minAmount=10;}
	else { var finalreturn='OTHERS'; }

		if(finalreturn=='OTHERS') { var per=newstr;} 
		else {
		if(perAmount<checkAmunt) { var per=parseInt(newstr-perAmount);	}
		else if(perAmount>=checkAmunt){ 
		var addamount=parseInt(minAmount-perAmount);
		var per=newstr+addamount; }
		}
	}
	
	return per;
}

//clear the offers
function resetshows(packkey) {
	
	var packshowinvalue=document.getElementById('SHOWPACKVALUE'+packkey).value;
	var packshowArray=new Array();
	var selectedValue='';

	packshowArray=packshowinvalue.split(",");//dep array
	document.getElementById('BASETOTAL'+packkey).value=0;

		for(var i=0;i<packshowArray.length;i++) {

			if(packshowArray[i]==3) { //next level reset

				var selectedValue = document.createElement('input');   
				selectedValue.type = "checkbox";
				selectedValue.id = "RESETNEXTLEVEL";
				selectedValue.name = "RESETNEXTLEVEL";  
		
				showSavings(packshowArray[i],selectedValue,packkey);
			}
			if(packshowArray[i]==5) { //flate reset

				var selectedValue = document.createElement('input');   
				selectedValue.type = "hidden";
				selectedValue.id = "RESETFLAT";
				selectedValue.name = "RESETFLAT";  
				selectedValue.value = "0";
				showSavings(packshowArray[i],selectedValue,packkey);
			}
			if(packshowArray[i]==6) { //horoscope reset

				var selectedValue = document.createElement('input');   
				selectedValue.type = "hidden";
				selectedValue.id = "RESETHORO";
				selectedValue.name = "RESETHORO"; 
				selectedValue.value = "0"
		
				showSavings(packshowArray[i],selectedValue,packkey);
			}

			if(packshowArray[i]==8) { //horoscope reset

				var selectedValue = document.createElement('input');   
				selectedValue.type = "checkbox";
				selectedValue.id = "RESETADDON1";
				selectedValue.name = "RESETADDON1";  
				selectedValue.value = "0";
				showSavings(packshowArray[i],selectedValue,packkey);
				
			}

				if(packshowArray[i]==9) { //horoscope reset

				var selectedValue = document.createElement('input');   
				selectedValue.type = "checkbox";
				selectedValue.id = "RESETADDON1";
				selectedValue.name = "RESETADDON1";  
				selectedValue.value = "0";
				showSavings(packshowArray[i],selectedValue,packkey);
			}
			
		}
}
//get diff offer rates

//list the user
var xmlHttp
function getnewoffertype(currvalue){


xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 

var url="supportcbstmgetofferbycurrence.php";
url=url+"?mid="+document.getElementById('OFFERMATRIID').value;
url=url+"&cateId="+document.getElementById('OFFERID').value;
url=url+"&maxoffer="+document.getElementById('OFFERMAX').value;
url=url+"&newcurr="+currvalue;
url=url+"&cattype="+document.getElementById('OFFERCATETYPE').value;
url=url+"&sid="+Math.random();

xmlHttp.onreadystatechange=stateChangedforcurrence;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
document.getElementById('SELECTEDCURRENCY').value=currvalue;
} 

function stateChangedforcurrence() { 

document.getElementById('HIDEOFFERINFOSHOW').innerHTML="<img src='http://telemarketing.matchintl.com/tmiface/images/load.gif'/>";


	if (xmlHttp.readyState==4) { 
		 if(xmlHttp.responseText!=''){
		 
		 document.getElementById('HIDEOFFERINFOSHOW').innerHTML="";
		 document.getElementById('HIDEOFFERINFOSHOW').innerHTML=xmlHttp.responseText;
		 }
	 }
}


function GetXmlHttpObject(){
var xmlHttp=null;
try
{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try
{
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
}
}
return xmlHttp;
}

function clickTabNew(tabNo,tabTotal,tabName)
{
	
	var cur_act = tabName+"link"+tabNo+"_active";
	var cur_inact = tabName+"link"+tabNo+"_inactive";
	var cur_tab	= tabName+tabNo;
	document.getElementById(cur_act).style.display='block';
	document.getElementById(cur_inact).style.display='none';
	
	for(i=1;i<=tabTotal;i++)
		{
		if(i != tabNo)
			{
			var oth_act = tabName+"link"+i+"_active";
			var oth_inact = tabName+"link"+i+"_inactive";
			var oth_tab	= tabName+i;
			document.getElementById(oth_act).style.display='none';
			document.getElementById(oth_inact).style.display='block';
			}
		}
}
