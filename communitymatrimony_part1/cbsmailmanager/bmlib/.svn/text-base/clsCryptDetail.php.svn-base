<?

//INCLUDE FILES
include_once('cryptlist.inc');

class CryptDetail {
	//For mailer AutoLogin Start
	function mclink($argMatriId,$requestComeFrom)
	{
		$varLink="";
		if($argMatriId!="") {

			$varFEMatriId	= base64_encode($argMatriId);
			$varSEMatriId	= base64_encode($varFEMatriId);
	
			$varFirstSalt	= crypt($argMatriId,ALSALT1);
			$varSecondSalt	= crypt($varFirstSalt,ALSALT2);

			$varSecondFirstSalt		= crypt($varSecondSalt,ALSALT3);
			$varSecondSecondSalt	= crypt($varSecondFirstSalt,ALSALT4);

			$varLink="sde=".$varSEMatriId."&sds=".$varSecondSalt."&sdss=".$varSecondSecondSalt."&rcf=".$requestComeFrom;
		}
		return $varLink;
	}

	function revlink()
	{
		if(trim($_REQUEST["sde"])!="" && trim($_REQUEST["sds"])!="" && trim($_REQUEST["sdss"])!="")
		{
			$varFDMatriId=base64_decode(trim($_REQUEST["sde"]));
			$varSDMatriId=base64_decode($varFDMatriId);

			$varFirstDECSalt=crypt($varSDMatriId,ALSALT1);
			$varSecondDECSalt=crypt($varFirstDECSalt,ALSALT2);

			$varSecondFirstDECSalt=crypt($varSecondDECSalt,ALSALT3);
			$varSecondSecondDECSalt=crypt($varSecondFirstDECSalt,ALSALT4);

			if(trim($_REQUEST["sds"])==$varSecondDECSalt && trim($_REQUEST["sdss"])==$varSecondSecondDECSalt){return "Success";}else{return "Failed";}
		}
		else{return "Failed";}
	}
	//For mailer AutoLogin End
}
?>