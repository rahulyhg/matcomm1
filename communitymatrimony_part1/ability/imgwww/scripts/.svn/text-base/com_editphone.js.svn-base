  function funregphoneupdate(param){
    if(regphonevalidate(param)){
      var frmName=document.frmassuredcontact
      parameters='memid='+frmName.memid.value+'&assuredcountry='+frmName.assuredcountry.value+'&age='+frmName.age.value+'&gender='+frmName.gender.value+'&langid='+frmName.langid.value;

      if(param==1){
        parameters+='&MOBILENO='+frmName.MOBILENO.value;
      }else{
        parameters+='&area='+frmName.area.value+'&phoneno='+frmName.phoneno.value
      }
      var argUrl='/register/communityregisterphoneedit.php';
      objAjx=AjaxCall();AjaxPostReq(argUrl,parameters,"ajxRegPhRes",objAjx);
    }
  }
  function ajxRegPhRes(){
    if(objAjx.readyState==4)
		{
			if(objAjx.status==200){
			 // alert(objAjx.responseText);
			  var phonetxt = objAjx.responseText, phonesplittxt = phonetxt.split("|~|");
			  if(phonesplittxt[0]=='Y'){
				$('phonenocont').innerHTML=phonesplittxt[1];
				$('phonenocont1').innerHTML=phonesplittxt[1];
				$('phonetxtcont').innerHTML=phonesplittxt[2];
				$('phonetxtcont1').innerHTML=phonesplittxt[2];
				$('tollfreeno').innerHTML=phonesplittxt[3];
				$('tollfreecont').innerHTML=phonesplittxt[4];
				$('span_pin_no').innerHTML=phonesplittxt[5];
				
				
			  }
			  $('cont-edit').style.display='';
			  $('num_content_1').style.display='none';
    }else alert('There was a problem with the request.');}
  }
  function regphonevalidate(param){
    var arrErrorIds=new Array("errcountry","errphoneno","errarea","errmobileno");
    $('errcountry').innerHTML="&nbsp;";
    if($('errphoneno'))
      $('errphoneno').innerHTML="&nbsp;";
    if($('errarea'))
      $('errarea').innerHTML="&nbsp;";
    if($('errmobileno'))
      $('errmobileno').innerHTML="&nbsp;";

    var frmName=document.frmassuredcontact;
    if(frmName.assuredcountry.value=="0"){$('errcountry').innerHTML="Please select a Country";$('errcountry').style.display='';frmName.assuredcountry.focus();return false;
    }else{$('errcountry').innerHTML="&nbsp;";}
  if(param==1){
    if(IsEmpty($("MOBILENO"),'text')){$('errmobileno').innerHTML="Please enter Mobile number";$("MOBILENO").focus();return false;}else{$('errmobileno').innerHTML="&nbsp;";}
    if(!IsEmpty($("MOBILENO"),'text')){if(CompareValue($("MOBILENO").value,"0123456789 ")==false){$('errmobileno').innerHTML="Invalid Mobile Number";$('errmobileno').style.display='';$("MOBILENO").focus();return false;}else{$('errmobileno').innerHTML="&nbsp;";}}
    if(!IsEmpty($("MOBILENO"),'text')){
		if($("assuredcountry").options[$("assuredcountry").selectedIndex].value=="98") {
			if($("MOBILENO").value.length<9){
			$('errmobileno').innerHTML="Your Mobile Number must be between 9 and 11 digits only";
			$('errmobileno').style.display='';
			$("MOBILENO").focus();return false;
			}
			else{
				$('errmobileno').innerHTML="&nbsp;";}
			}
		else {
			if($("MOBILENO").value.length<8){
				$('errmobileno').innerHTML="Your Mobile Number must be between 8 and 10 digits only";
				$('errmobileno').style.display='';
				$("MOBILENO").focus();
				return false;
			}
			else{
				$('errmobileno').innerHTML="&nbsp;";
				}
			  }
	}
  }else{
    if(IsEmpty($("area"),'text')){$('errarea').innerHTML="Please enter Area / STD Code";$("area").focus();return false;}else{$('errarea').innerHTML="&nbsp;";}
    if(IsEmpty($("phoneno"),'text')){$('errphoneno').innerHTML="Please enter Phone Number";$("phoneno").focus();return false;}else{$('errphoneno').innerHTML="&nbsp;";}
    if(CompareValue($("area").value,"0123456789 ")==false){$('errarea').innerHTML="Invalid Area / STD Code";$('errarea').style.display='';$("area").focus();return false;}else{$('errarea').innerHTML="&nbsp;";}
    if(!IsEmpty($("area"),'text')){if($("area").value.length<2){$('errarea').innerHTML="Your Area / STD Code should be atleast 2 digits";$('errarea').style.display='';$("area").focus();return false;}else{$('errarea').innerHTML="&nbsp;";}if($("area").value.length>5){$('errarea').innerHTML="Your area/STD code should not exceed 5 digits";$('errarea').style.display='';$("area").focus();return false;}else{$('errarea').innerHTML="&nbsp;";}}
    if(!IsEmpty($("phoneno"),'text')){if(CompareValue($("phoneno").value,"0123456789 ")==false){$('errphoneno').innerHTML="Invalid Phone Number";$('errphoneno').style.display='';$("phoneno").focus();return false;}else{$('errphoneno').innerHTML="&nbsp;";}}
    if($("phoneno").value.length<5){$('errphoneno').innerHTML="Your Phone Number should be atleast 5 digits";$('errphoneno').style.display='';$("phoneno").focus();return false;}else{$('errphoneno').innerHTML="&nbsp;";}
    }
    return true;
  }
