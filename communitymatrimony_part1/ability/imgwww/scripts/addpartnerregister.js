//Validation for addpartner start here

	function childlivingst()
	{	
		var frmRegister = this.document.frmRegister;
			if ( frmRegister.lookingStatus[0].checked)
			{
				document.frmRegister.lookingStatus[4].checked=false;		
			}	
			else if ( frmRegister.lookingStatus[1].checked)
			{
				document.frmRegister.lookingStatus[4].checked=false;					
			}
			else if ( frmRegister.lookingStatus[2].checked)
			{
				document.frmRegister.lookingStatus[4].checked=false;					
			}	
			else if ( frmRegister.lookingStatus[3].checked)
			{
				document.frmRegister.lookingStatus[4].checked=false;					
			}				
			else if ( frmRegister.lookingStatus[4].checked)
			{
				document.frmRegister.lookingStatus[0].checked=false;					
				document.frmRegister.lookingStatus[1].checked=false;					
				document.frmRegister.lookingStatus[2].checked=false;											
				document.frmRegister.lookingStatus[3].checked=false;														
			}				
	}
		
	function childlivingstany()
	{	
		var frmRegister = this.document.frmRegister;
		if ( frmRegister.lookingStatus[4].checked)
		{
			document.frmRegister.lookingStatus[0].checked=false;					
			document.frmRegister.lookingStatus[1].checked=false;					
			document.frmRegister.lookingStatus[2].checked=false;
			document.frmRegister.lookingStatus[3].checked=false;														
		}				
	}

	function citizen()
	{
		
		if(frmRegister.citizenship.value==frmRegister.country.value)
		{frmRegister.residentStatus.value=1}
		else
		{frmRegister.residentStatus.value=0}
	}
		
	// Function to validate all the inputs
	function addPartnerValidate()
	{		
			var frmRegister = this.document.frmRegister;
			
			var finalAge = frmRegister.toAge.value - frmRegister.fromAge.value;		
			var stAge = 0, endAge = 0;

			if( IsEmpty(document.frmRegister.fromAge,"text"))
			{document.getElementById('agespan').innerHTML="Please enter the age range of your partner";frmRegister.fromAge.value="";document.getElementById('row2').className="errorrow";frmRegister.fromAge.focus();return false;
			}else{document.getElementById('agespan').innerHTML="&nbsp";document.getElementById('row2').className="normalrow";}

			if( IsEmpty(document.frmRegister.toAge,"text"))
			{document.getElementById('agespan').innerHTML="Please enter the age range of your partner";frmRegister.toAge.value="";document.getElementById('row2').className="errorrow";frmRegister.toAge.focus();return false;
			}else{document.getElementById('agespan').innerHTML="&nbsp";document.getElementById('row2').className="normalrow";}
			
			if ( finalAge > 20 )
			{document.getElementById('agespan').innerHTML="Age range should not exceed 20";document.getElementById('row2').className="errorrow";frmRegister.toAge.focus();return false;
			}else{document.getElementById('agespan').innerHTML="&nbsp";document.getElementById('row2').className="normalrow";}
		
			// Check Age 
			if (!ValidateNo( frmRegister.fromAge.value, "0123456789" ) )
			{document.getElementById('agespan').innerHTML="Invalid Age " + frmRegister.fromAge.value;document.getElementById('row2').className="errorrow";frmRegister.fromAge.focus();return false;
			}else{document.getElementById('agespan').innerHTML="&nbsp";document.getElementById('row2').className="normalrow";}

			if (!IsEmpty(document.frmRegister.fromAge,"text"))
			{
				stAge = parseInt( frmRegister.fromAge.value );
				if ( stAge < 18 || stAge > 70 )
				{document.getElementById('agespan').innerHTML="Invalid Age " +  frmRegister.fromAge.value + ".  Minimum age allowed is 18 and maximum age is 70.";document.getElementById('row2').className="errorrow";frmRegister.fromAge.focus();return false;
				}else{document.getElementById('agespan').innerHTML="&nbsp";document.getElementById('row2').className="normalrow";}
			}
			
			if(!ValidateNo( frmRegister.toAge.value, "0123456789"))
			{document.getElementById('agespan').innerHTML="Invalid Age " + frmRegister.toAge.value;document.getElementById('row2').className="errorrow";frmRegister.toAge.focus();return false;
			}else{document.getElementById('agespan').innerHTML="&nbsp";document.getElementById('row2').className="normalrow";}

			if (!IsEmpty(document.frmRegister.toAge,"text"))
			{
				endAge = parseInt( frmRegister.toAge.value );
				if ( endAge < 18 || endAge > 70 )
				{document.getElementById('agespan').innerHTML="Invalid Age " +  frmRegister.fromAge.value + ".  Minimum age allowed is 18 and maximum age is 70.";document.getElementById('row2').className="errorrow";frmRegister.toAge.focus();return false;
				}else{document.getElementById('agespan').innerHTML="&nbsp";document.getElementById('row2').className="normalrow";}
				

				if ( stAge != 0 && endAge < stAge )
				{document.getElementById('agespan').innerHTML="Invalid age range " + stAge + " to " + endAge;document.getElementById('row2').className="errorrow";frmRegister.fromAge.focus();return false;
				}else{document.getElementById('agespan').innerHTML="&nbsp";document.getElementById('row2').className="normalrow";}

			}

			if ( frmRegister.heightTo.selectedIndex  < frmRegister.heightFrom.selectedIndex )
			{document.getElementById('heightspan').innerHTML="Invalid height range";document.getElementById('row5').className="errorrow";frmRegister.heightTo.focus();return false;
			}else{document.getElementById('heightspan').innerHTML="&nbsp";document.getElementById('row5').className="normalrow";}

			return true;
		}
	//Validation for addpartner end here