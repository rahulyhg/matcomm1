function funAffiliatesValidate()
{
	var frmAssociates	= document.frmAffiliates;
	var strUserName=frmAssociates.username.value;
	var strName=frmAssociates.name.value;
	//strUserName = LTrim(strUserName);
	//strUserName = RTrim(strUserName);

	//strName = LTrim(strName);
	//strName = RTrim(strName);


	if(nullchk(strUserName) == true){
		alert( "Please enter the Username");
		frmAssociates.username.focus( );
		return false;
	}
	if (IsEmpty(frmAssociates.username,'text'))
	{
		alert( "Please enter the Username");
		frmAssociates.username.focus( );
		return false;
	}//if
	if(HasSpace(strUserName) == true){
		alert("Username should not contain spaces");
		frmAssociates.username.focus();
		return false
	}
	if(SplNameChar(strUserName) == true){
	    alert("Special characters are not accepted in Username");	
	    frmAssociates.username.focus();
	    return false;
	}

	if ( frmAssociates.username.value.length < 6 )
	{
		alert( "Username must contain a minimum of 6 characters and a maximum of 20 characters" );
		frmAssociates.username.focus( );
		return false;
	}
	// Check Password
	if ( frmAssociates.password.value == "" )
	{
		alert( "Please enter Password" );
		frmAssociates.password.focus( );
		return false;
		
	}
	if(frmAssociates.password.value != "")
	{
		if(frmAssociates.password.value.length < 4)
		{
			alert( "Password must be atleast 4 Characters and maximum of 8 Characters" );
			frmAssociates.password.focus( );
			return false;
		}
	}
	
	var pwd1=frmAssociates.password.value;
	pwd1=pwd1.toUpperCase()
	var una=frmAssociates.name.value
	una=una.toUpperCase()

	if (pwd1 == una)
	{
		alert("Name and Password cannot be the same. Please change the Password");
		frmAssociates.password.focus();return false;
	}

	if ( frmAssociates.confirmPassword.value == "" )
	{
		alert( "Please enter Confirm Password" );
		frmAssociates.confirmPassword.focus( );
		return false;
	}

	if ( frmAssociates.password.value != frmAssociates.confirmPassword.value )
	{
		alert( "Password does not match, Please Re-Enter Password" );
		frmAssociates.password.value = "";
		frmAssociates.confirmPassword.value = "";
		frmAssociates.password.focus( );
		return false;
	}

	tmpPass = frmAssociates.password.value;
	goodPasswd = 1;
	for( var idx=0; idx< tmpPass.length; idx++ )
	{
		ch = tmpPass.charAt(idx);
		if( !((ch>='a') && (ch<='z')) && !((ch>='A') && (ch<='Z')) && !((ch>=0) && (ch <=9)) )
		{
			goodPasswd = 0;
			break;
		}
	}

	if( goodPasswd ==0 )
	{
		alert( "Password should comprise only Numbers and Digits" );
		frmAssociates.password.value="";
		frmAssociates.confirmPassword.value="";
		frmAssociates.password.focus();
		return false;
	}
	if(nullchk(strName) == true)
	{
		alert( "Please enter Name");
		frmAssociates.name.focus( );
		return false;
	}//if

	if (IsEmpty(frmAssociates.name,'text'))
	{
		alert( "Please enter Name");
		frmAssociates.name.focus( );
		return false;
	}//if
	if(IsNumberPresent(strName)==true)
	{
		alert("Name should not contain any numbers");	
		frmAssociates.name.focus();
		return false;
	}//
	if(SplNameChar(strName) == true){
	    alert("Special characters are not accepted in Name");	
	    frmAssociates.name.focus();
	    return false;
	}

	if ( frmAssociates.email.value == "" )
	{
		alert( "Please enter a valid E-mail ID" );
		frmAssociates.email.focus( );
		return false;
	}
	else
	{
		if ( !ValidateEmail( frmAssociates.email.value ) )
		{
			alert( "Invalid E-mail " + frmAssociates.email.value );
			frmAssociates.email.focus( );
			return false;
		}
		for ( var Idx = 0; Idx < frmAssociates.email.value.length; Idx++ )
		{
			if ( frmAssociates.email.value.charAt(Idx) == '	' 
				|| frmAssociates.email.value.charAt(Idx) == ' '
					|| frmAssociates.email.value.charAt(Idx) == ','
					|| frmAssociates.email.value.charAt(Idx) == '/'
					|| frmAssociates.email.value.charAt(Idx) == '\\'
					|| frmAssociates.email.value.charAt(Idx) == ';' )
			{
				alert( "Blanks or other invalid characters are not allowed in the E-mail ID.\nPlease enter only one E-mail ID." );
				frmAssociates.email.focus( );
				return false;
			}
		}
	}
	if ( parseInt( frmAssociates.country.options[frmAssociates.country.selectedIndex].value ) == 0 || frmAssociates.country.options[frmAssociates.country.selectedIndex].value == "none")
	{
		alert( "Please select country" );
		frmAssociates.country.focus( );
		return false;
	}
	if ( frmAssociates.state.value=="")
	{
		alert( "Please enter state");
		frmAssociates.state.focus( );
		return false;
	}
	if ( frmAssociates.city.value=="")
	{
		alert( "Please enter city");
		frmAssociates.city.focus( );
		return false;
	}
	if ( frmAssociates.address.value=="")
	{
		alert( "Please enter address");
		frmAssociates.address.focus( );
		return false;
	}
	if ( frmAssociates.phoneNumber.value=="" && frmAssociates.mobileNumber.value=="")
	{
		alert( "Please enter phone number/ mobile Number");
		frmAssociates.phoneNumber.focus( );
		return false;
	}
	if( !(frmAssociates.terms.checked) )
	{
		alert("Please Read and Accept the Terms and Conditions");
		return false;
	}
return true;
}//funValidate

function checkSelect(item) 
{
	bLocValid = true;
	if(item.selectedIndex==0){bLocValid=false;}
	if (item.selectedIndex < 0){bLocValid = false;}
	if (item.selectedIndex == 0){if (item.options[0].value == ''){bLocValid = false;}}
	return bLocValid;
}


function checkUser()
{

	nm = document.frmAffiliates.username.value;
	nm = nm.toString().toLowerCase();
	if(validateUserName(document.frmAffiliates.username))
	{
		window.open("check-user.php?username="+nm,"win1",'width=450,height=140,menubar=no,status=no,scrollbars=no,toolbar=no,top=200,left=250');
	}
	else{
		//document.frmAddRegistrationBasic.username.focus();
		//return false;
	}
}//checkUser


function validateUserName (username)
{
	var max_username_length = 20;
	var min_username_length = 6;
	var user_name = username.value;
	if (user_name == null || user_name == "")
	{
		alert("Please enter username");
		document.frmAffiliates.username.focus();
		return false;
	}

	var username_length = user_name.length;
	if (username_length < min_username_length || username_length > max_username_length)
	{
		alert("Username must contain a minimum of " + min_username_length + " characters and a maximum of " + max_username_length + " characters\n");
		document.frmAffiliates.username.focus();
		return false;
	}
	var valid_first_characters = new RegExp ("[a-zA-Z]", "g");
	var first_character = user_name.charAt(0);
	if (!valid_first_characters.test (first_character))
	{
		alert("Username must begin with an alphabet\n");
		document.frmAffiliates.username.focus();
		return false;
	}
	var valid_characters;
	for (var i = 1; i < username_length; i++)
	{
		valid_characters = new RegExp ("[a-zA-Z0-9_.]", "g");
		part_username = user_name.charAt (i);
		if (!valid_characters.test (part_username))
		{
			alert("Special characters like '" + part_username + "' are not allowed.");
			document.frmAffiliates.username.focus();
			return false;
		}
		valid_characters = null;
	}
	var valid_last_characters = new RegExp ("[a-zA-Z0-9]", "g");
	var last_character = user_name.charAt(user_name.length-1);
	if (!valid_last_characters.test (last_character))
	{
		alert ("The last character of the username must either be an alphabet or a numeral. It cannot be '" + last_character + "'");
		document.frmAffiliates.username.focus();
		return false;
	}
	return true;
}//validateUserName

function ValidateEmail(Email)
{
	var funRegExp	      = new RegExp("^[A-Za-z][A-Za-z0-9_\\.\-]*\\@[a-zA-Z0-9]+\\.[a-zA-Z]+[\\.]?[a-zA-Z]*$");
	if (!Email.match(funRegExp)) { return false; }//if
	return true;
}//funValidateEmail


function HasSpace(txt){		
	if(txt.length == 0)
		return false;
	for(var i = 0;i < txt.length;i++){
		if(txt.charAt(i) == " ")
			return true;
	}
	return false;
}//HasSpace

function nullchk(txt)
{
	if (txt == "" || txt == null)
	{ return true; }
		
	var i;
	for(i=0;i<txt.length;i++)
	{
		if (txt.charAt(i) != " ")
		return false
	}
	return true;
}//nullchk


function LTrim(value){
	var l,i,n,newvalue
	l = value.length //txt.charAt(i)
	for(i=0;i<l;i++){
		if(value.charAt(i) != " ")
			break;
	}
	newvalue="";
	for(n=i;n<l;n++)
		newvalue=newvalue+value.charAt(n)
	return newvalue;
}

function RTrim(value){
	var l,i,n,newvalue
	l = value.length //txt.charAt(i)
	for(i=l-1;i>=0;i--){
		if(value.charAt(i) != " ")
			break;
	}
	newvalue="";
	for(n=0;n<i;n++)
		newvalue=newvalue+value.charAt(n)
	return newvalue;
}

function IsNumberPresent(obj){
	if(obj.length == 0)
		return false;
	for(var i = 0;i < obj.length;i++){
		if(obj.charAt(i) >= '0' && obj.charAt(i) <= '9') 
			return true;
		else
			continue;
	}
	return false;
}//IsNumberPresent

function SplNameChar(txt){
	if(txt.length == 0)
		return false;
	for(var i = 0;i < txt.length;i++){
		if(txt.charAt(i) == '@' || txt.charAt(i) == '#' 
			|| txt.charAt(i) == '!' || txt.charAt(i) == '$' 
			|| txt.charAt(i) == '%' || txt.charAt(i) == '&' 
			|| txt.charAt(i) == '^' || txt.charAt(i) == '*' 
			|| txt.charAt(i) == '~' || txt.charAt(i) == '_' 
			|| txt.charAt(i) == '-' || txt.charAt(i) == '=' 
			|| txt.charAt(i) == '+' || txt.charAt(i) == '|' 
			|| txt.charAt(i) == '?' || txt.charAt(i) == '<' 
			|| txt.charAt(i) == '>' || txt.charAt(i) == '/' 
			|| txt.charAt(i) == '[' || txt.charAt(i) == ']' 
			|| txt.charAt(i) == '(' || txt.charAt(i) == ')' 
			|| txt.charAt(i) == '`' || txt.charAt(i) == "," 
			|| txt.charAt(i) == ":" || txt.charAt(i) == ";" 
			|| txt.charAt(i) == "{" 
			|| txt.charAt(i) == "}" || txt.charAt(i) == '"'
			|| txt.charAt(i) == '\\' )
			return true;
	}
	return false;
}//SplNameChar

function IsEmpty(obj, obj_type)
{
	if (obj_type == "text" || obj_type == "password" || obj_type == "textarea" || obj_type == "file")
	{
		var objValue;
		objValue = obj.value.replace(/\s+$/,"");

		if (objValue.length == 0)
		{ return true; }
		else { return false; }
	}//if
	else if (obj_type == "select")
	{
		for (i=0; i < obj.length; i++) {
			if (obj.options[i].selected) {
				if(obj.options[i].value == "") {
					obj.focus();
					return true;
				}
				else { return false; }
			}
		}
		return true;	
	}
	else if (obj_type == "radio" || obj_type == "checkbox") {
		if (!obj[0] && obj) {
			if (obj.checked) {
				return false;
			}
			else
			{
				obj.focus();
				return true;	
			}
		}
		else 
		{
			for (i=0; i < obj.length; i++) {
				if (obj[i].checked) {
					return false;
				}
			}
			obj[0].focus();
			return true;
		}
	}
	else
	{
		return false;
	}
}


function funUpgradeProfile()
{
	var frmAddPayment	= document.frmAddPayment;
	if ( frmAddPayment.username.value == "" )
	{
		alert( "Please enter username" );
		frmAddPayment.username.focus( );
		return false;
		
	}
	if ( frmAddPayment.paymentMode.value == "" )
	{
		alert( "Please select payment mode" );
		frmAddPayment.paymentMode.focus( );
		return false;
		
	}
	if ( frmAddPayment.category.value == "" )
	{
		alert( "Please select category" );
		frmAddPayment.category.focus( );
		return false;
		
	}
	if ( frmAddPayment.comments.value == "" )
	{
		alert( "Please enter comments" );
		frmAddPayment.comments.focus( );
		return false;
		
	}
}//funUpgradeProfile
////////////////////////////////////////////////////////////////////////////////////////////


function funValidate(frm)
{
	for (i=0; i < document[frm].elements.length; i++)
	{
		var item = document[frm].elements[i]; 
		var flag=0;
		var sp=item.id;
		var alertMsg=item.id.substring((item.id.lastIndexOf("_") + 1),item.id.length);
		var type=item.type; 
		if(item.id.indexOf("c_")>=0 ){}
		else
		{ 
			if(item.id.indexOf("req_")>=0)
			{
				switch (item.type)
				{ 
					case 'text':
						if ((item.value=="") && (item.disabled == false))
						{ 
							var x = document.getElementById(sp); 
							alert(innerHTML = "Please enter "+alertMsg); 
							item.focus(); flag=1; 
							return false;
						}
						break; 
					
					case 'password':
						if(item.value=="")
						{ 
							var x = document.getElementById(sp); 
							alert(innerHTML = "Please enter "+alertMsg); 
							item.focus(); flag=1; 
							return false;
						}
						if(item.name=="confirmPassword")
						{ 
							if(!(item.value)=="")
							{ 
								//alert("Form Name" + frm);
								var email=validepassword(frm);
								if(email==false)
								{
									flag=1;
									return false;
								}
							}
						}
						break; 
					
					case 'select-one':
						if (!checkSelect(item))
						{ 
							var x = document.getElementById(sp); 
							if(item.value == "")
							{ 
								alert(innerHTML = "Please select "+alertMsg); 
								item.focus(); flag=1; 
								return false;
							}
						}

					case 'textarea':
						if(item.value=="")
						{	
							var x = document.getElementById(sp);
							alert(innerHTML = "Please enter "+alertMsg);
							item.focus();
							flag=1;	
							return false;							
						}
						break;
				}
			}
		}
		if (flag==1){break;return false;}
	}
	if(flag == 0){document[frm].submit();return true;}
}//funValidate

function Validate() {

	var frmAssociatesLoginDetails=this.document.frmAssociatesLogin;
	if(frmAssociatesLoginDetails.username.value == "") {
		document.getElementById('errorname').innerHTML="Please enter the Username";
		frmAssociatesLoginDetails.username.focus();
		return false;
	}
	else
	{document.getElementById('errorname').innerHTML="";}
	if(frmAssociatesLoginDetails.password.value == "") {
		document.getElementById('errorpwd').innerHTML="Please enter the Password";
		frmAssociatesLoginDetails.password.focus();
		return false;
	}
	else
	{document.getElementById('errorpwd').innerHTML="";}
return true;
}