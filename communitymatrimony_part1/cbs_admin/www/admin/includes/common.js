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

function checkSelect(item) 
{
	bLocValid = true;
	if(item.selectedIndex==0){bLocValid=false;}
	if (item.selectedIndex < 0){bLocValid = false;}
	if (item.selectedIndex == 0){if (item.options[0].value == ''){bLocValid = false;}}
	return bLocValid;
}


function validepassword(frm)
{
	var a1=document[frm].elements["password"].value;
	var b1=document[frm].elements["confirmPassword"].value;

	if (a1!=b1)
	{
		alert('Please confirm your password correctly');
		document[frm].elements["confirmPassword"].focus();
		
		return false;
	}
	else
	{
		return true;
	}
}//validepassword