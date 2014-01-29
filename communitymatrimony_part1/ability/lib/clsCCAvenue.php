<?php
#==========================================================================================================
# File			: clsCCAvenue.php
# Author		: N. Dhanapal
# Date			: 13-March-2008
# Description	: CCAvenue payment process checking
#==========================================================================================================

$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
include_once($varRootBasePath."/conf/emailsconfig.cil14");
include_once($varRootBasePath.'/conf/payment.cil14');

Class CCAvenue
{
	function getCheckSum($MerchantId,$Amount,$OrderId ,$URL,$WorkingKey)
	{
		$str = "$MerchantId|$OrderId|$Amount|$URL|$WorkingKey";
		$adler = 1;
		$adler = $this->adler32($adler,$str);
		return $adler;
	}

	function verifychecksum($MerchantId,$OrderId,$Amount,$AuthDesc,$CheckSum,$WorkingKey)
	{
		$str = "$MerchantId|$OrderId|$Amount|$AuthDesc|$WorkingKey";
		$adler = 1;
		$adler = $this->adler32($adler,$str);
		if($adler == $CheckSum)	 {
			return "true" ;
		}
		else {
			return "false" ;
		}
	}

	function adler32($adler , $str)
	{
		$BASE =  65521 ;

		$s1 = $adler & 0xffff ;
		$s2 = ($adler >> 16) & 0xffff;
		for($i = 0 ; $i < strlen($str) ; $i++)
		{
			$s1 = ($s1 + ord(substr($str,$i,1))) % $BASE ;
			$s2 = ($s2 + $s1) % $BASE ;
		}
		return $this->leftshift($s2 , 16) + $s1;
	}

	function leftshift($str , $num)
	{
		$str = sprintf("%b",$str);
		for( $i = 0 ; $i < (64 - strlen($str)) ; $i++) {
			$str = "0".$str ;
		}
		for($i = 0 ; $i < $num ; $i++)
		{
			$str = $str."0";
			$str = substr($str , 1 ) ;
		}
		return $this->cdec($str) ;
	}

	function cdec($num)
	{
		$dec="";
		for ($n = 0 ; $n < strlen($num) ; $n++)
		{
		   $temp = substr($num,$n,1) ;
		   $kk1 = strlen($num) - $n - 1;
		   $kk2 = 2;
		   $kk3 = pow(2 , strlen($num) - $n - 1);
		   $dec = $dec + $temp*$kk3;
		}
		return $dec;
	}
}//Payment
?>