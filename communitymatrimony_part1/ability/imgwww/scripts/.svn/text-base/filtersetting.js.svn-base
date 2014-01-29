function filterenable(val){
	$('filterspan').innerHTML='';
	if(val==2){
		$('filterdiv').style.display="block";
		$('filterdiv1').style.display="block";

		$('filterdiv').style.display="block";
		$('filterdiv1').style.display="block";
	} else {
		$('filterdiv').style.display="none";
		$('filterdiv1').style.display="none";
	}
}

function showslide(s1,s2,s3,s4,s5,s6,s7,im1,im2,im3,im4,im5,im6,im7){

	//alert(arguments.length);
	//alert(arguments[1]); //div_2
	//alert(arguments[6]); //d2

	var totaldiv=(arguments.length)/2;
	var state=$(arguments[0]).style.display;
	var collimg=imgs_url+"/hob-plus-icon.gif";
	if(state=="none"){
		$(arguments[0]).style.display="block";
		$(arguments[totaldiv]).src=collimg;
		for(i=0;i<totaldiv;i++) {
			if(i!=0) {
				$(arguments[i]).style.display="none";
				$(arguments[(i+totaldiv)]).src=collimg;
			}
		}
	}else{
		for(i=0;i<totaldiv;i++) {
			$(arguments[i]).style.display="none";
			$(arguments[(i+totaldiv)]).src=collimg;
		}
	}
}

function closing(tag,im){
	var state=$(tag).style.display;
	if(state=="block"){
		$(im).src=imgs_url+"/hob-plus-icon.gif";
		$(tag).style.display="none";
	}else{
		$(im).src=imgs_url+"/hob-minus-icon.gif";
		$(tag).style.display="block";
	}
}

function srchblocking(tag,im){
	var state=$(tag).style.display;
	if(state=="block"){
		$(im).src=imgs_url+"/hob-plus-icon.gif";
		$(tag).style.display="none";
	}else{
		$(im).src=imgs_url+"/hob-minus-icon.gif";
		$(tag).style.display="block";
	}
}

function filterupdate(totalnodiv){
	var wholeval=new Array();
	var loopval = totalnodiv;
	var priFrm=document.privacysettings;

	if(priFrm.privacyval[1].checked==true){ 
		for(i=1;i<=loopval;i++){
			var val='';
			wholeval[i]='';
			var frmname=eval('document.frmresultd'+i);
			if(i==1){
				val1=frmname.AgeAbove.value;
				val2=frmname.AgeBelow.value;
				if(val1!=''&&val2!=''){
					if(val1>=18&&val1<=70&&val2>=18&&val2<=70){
						if(val1>val2){
							$('filterspan').innerHTML='Please give age range correctly';
							return false;
						}else{
							$('filterspan').innerHTML='';val=val1+','+val2;
						}
					}else{
						$('filterspan').innerHTML='Please give age range between 18 to 70';
						return false;
					}
				}
				wholeval[i]=val;
			}else{ 
				var len=frmname.chk.length;
				for(j=0;j<len;j++){
					if(frmname.chk[j].checked==true){
						val+=frmname.chk[j].value+'~';
					}
				}
				wholeval[i]=val;
			}
		}
		parameters='';
		submitval='';
		for(i=1;i<=loopval;i++){
			if(wholeval[i]!=''){
				submitval='yes';
			}
			parameters+=wholeval[i]+'^';
		}
		if(submitval==''){
			$('filterspan').innerHTML='Please select any one of the value in given options';
		}else{
			$('filterspan').innerHTML='';
			priFrm.fields.value=parameters;
		}
	}else{
	}
	priFrm.action.value=ser_url+'/profiledetail/index.php';
	priFrm.submit();
}