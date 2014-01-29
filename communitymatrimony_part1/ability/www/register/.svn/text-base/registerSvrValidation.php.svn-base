<?php
#=============================================================================================================
# Author 		: A.Kirubasankar
# Start Date	: 2009-10-27
# Project Name   : Server side validation
# Project Detail : Server side validation for registration
# Server Details : 
#     App server detail :  192.168.1.19 , community
#     DB server : NILL
#     App source path :  1) /home/product/community/ability/www/register/
#                        2) Conf path / someelse

#     Database name  : NILL
#     Table name     : NILL
#     DNS IP		 : 192.168.1.19

#=============================================================================================================

include_once($varRootBasePath.'/lib/clsSvrValidation.php');
global $clsSvrValidation;
$clsSvrValidation = new clsSvrValidation;

//mobileNo
if($_POST['addRegister']=='yes'){
//Checking if the profile creator is empty
$varErrorProfileCreatedBy = $clsSvrValidation -> validateInput($varProfileCreatedBy,"numeric","Select your relationship with the prospect...");
//profileCreatedBy

//Checking if the Display Name is empty
$varErrorDisplayName = $clsSvrValidation -> validateInput($varNickName,"alphanumeric","Enter the display name of the prospect...");

//Checking if the Gender is not selected
$varErrorGender = $clsSvrValidation -> validateInput($varGender,"numeric","Select the gender of the prospect...");

//Checking if the date is valid
if($varAge == ""){
	if($varDay <= "9") {$varDay = "0".$varDay;}
	$cuccncndate = "$varMonth-$varDay-$varYear";
	$varErrorDateAge .= $clsSvrValidation -> validateInput($cuccncndate,"date","Enter Valid Date of birth..");

	if($varErrorDateAge == "") {
		if(!checkdate($varMonth,$varDay,$varYear)){
			$varErrorDateAge = $clsSvrValidation -> addError("In-Valid Date of birth..");
		}
	}
}
else if($varAge <= 21){
	$varErrorDateAge = $clsSvrValidation -> addError("In-Valid Age..");
}


//Checking for validity of Marital status
$varErrorMaritalStatus = $clsSvrValidation -> validateInput($varMaritalStatus,"numeric","Select Marital Status ...");

//Checking for Height
$varErrorHeight = $clsSvrValidation -> validateInput($varHeightFeet,"notzero","Select the height of the prospect ...");

//Checking for Religion
$varErrorReligion = $clsSvrValidation -> validateInput($varReligion,"notzero","Select the religion of the prospect ...");

//Checking for Sub Caste
$varErrorCaste = $clsSvrValidation -> validateInput($varSubCaste,"notzero","Select the subcaste of the prospect ...");

//Checking for Education
$varErrorEducation = $clsSvrValidation -> validateInput($varEducationCategory,"notzero","Please select the education category of the prospect ...");

//Checking for Emploment
$varErrorEmployment = $clsSvrValidation -> validateInput($varEmploymentCategory,"numeric","Select Employment ...");

//Checking for Annual Income Currency
$varErrorAnnualIncomeCurrency = $clsSvrValidation -> validateInput($varAnnualIncomeCurrency,"notzero","Please select Income..");

//Checking for Annual Income
$varErrorAnnualIncome = $clsSvrValidation -> validateInput($varAnnualIncome,"numeric","Enter Annual Income...");


//Checking for country
$varErrorCountry = $clsSvrValidation -> validateInput($varCountry,"notzero","Select the country of living of the prospect ...");


//Checking for residing State
//$clsSvrValidation -> IsNumZero($varResidingState,"Select the residing state of the prospect ...");

//Checking for residing District
//$clsSvrValidation -> IsNumZero($varResidingCity,"Select the residing city of the prospect ...");

//Checking Citizenship - Need more attention.
$varErrorCitizenship = $clsSvrValidation -> validateInput($varCitizenship,"notzero","Select the citizenship of the prospect ...");


//Checking Email
$varErrorEmail = $clsSvrValidation -> validateInput($varEmail,"email","Enter a valid e-mail address");

//Checking ISD Codes
$varErrorPhone = $clsSvrValidation -> validateInput($varCountryCode,"numeric","Enter the ISD number...");

//Checking Mobile Number

if($varMobileNo == "Mobile number" || $varMobileNo == "")	{
	$varErrorPhone .=  $clsSvrValidation -> validateInput($varAreaCode,"numeric","Enter area / STD code...");
	$varErrorPhone .=  $clsSvrValidation -> validateInput($varPhoneNo,"numeric","Enter the Phone number..");
}


//Checking Mother Tongue
$varErrorMotherTongue = $clsSvrValidation -> validateInput($varMotherTongue,"notzero","Select the mother tongue of the prospect ...");

//Checking Family Value
$varErrorFamilyValue = $clsSvrValidation -> validateInput($varFamilyValue,"notzero","Please select the family value of the prospect ...");

//Checking Family Type
$varErrorFamilyType = $clsSvrValidation -> validateInput($varFamilyType,"notzero","Please select the family type of the prospect ...");

//Checking Family Status
$varfamilyStatus = $_REQUEST[familyStatus];
$varErrorFamilyStatus = $clsSvrValidation -> validateInput($varfamilyStatus,"notzero","Please select the family status of the prospect ...");

//$varErrorPassword = checkPassword($varPassword);

$varErrorPassword = $clsSvrValidation -> validateInput($varPassword,"alphanumeric","Enter your password");
if($varErrorPassword == "") {
	$varErrorPassword = $clsSvrValidation -> IsValidNum($varPassword,"4","","Your password must have a minimum of 4 characters");
}
//Checking valid number of characters in password

if($varName == $varPassword && $varErrorPassword == ""){
	$varErrorPassword = $clsSvrValidation -> addError("The name and password cannot be the same. Please change the password.");
}

//Checking for Confirm Password
$confirmPassword = $_REQUEST['confirmPassword'];
if($confirmPassword !== $varPassword){
	$clsSvrValidation -> addError("confirm your password..");
}

//Checking About me
$aboutme = $_REQUEST['DESCDET'];
$varErrorAboutMe = $clsSvrValidation -> IsValidNum($aboutme,"50","","Enter a profile description in not less than 50 characters");

//Checking About my partner
$varErrorAboutMyPartner = $clsSvrValidation -> IsValidNum($varAboutMyPartner,"1","100","Please enter partner details of the prospect");


//Checking I want to marry
$varErrorGetMarried = $clsSvrValidation -> validateInput($varGetMarried,"numeric","Enter when you want to marry");

//Checking Terms and Conditions
$termsAndConditions = $_REQUEST['termsAndConditions'];
$varErrortermsAndConditions = $clsSvrValidation -> IsValue($termsAndConditions,"Y","Select You Accept Terms and Conditions","notsame");

}
//echo $clsSvrValidation -> showError();
?>