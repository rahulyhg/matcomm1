<script language="javascript">
	function funChooseLogin(argMatriId)
	{
		document.frmChooseLogin.idEmail.value=argMatriId;
		document.frmChooseLogin.submit();
	}//funChooseLogin
</script>

<form name="frmChooseLogin" method="post">
<input type="hidden" name="chooseLogin" value="yes">
<input type="hidden" name="frmLoginSubmit" value="yes">
<input type="hidden" name="act" value="logincheck">
<input type="hidden" name="idEmail" value="">

<?php

	$varDisplayAllUsername	= '';
	$varDisplayContent		= 'You are a member of '.$confValues['PRODUCTNAME'].'.Com with the following Username\'s';

	$varFields			= array('MatriId','User_Name');
	$varExecute			= $objSlaveDB->select($varTable['MEMBERLOGININFO'], $varFields, $argCondition,0);
	$varDisplayAllUsername	.= '<table border="0" cellspacing="0" cellpadding="0" width="450">';

	while($varMultiLoginInfo	= mysql_fetch_array($varExecute))
	{
		$varDisplayAllUsername	.= '<tr><td class="smalltxt"><a href="javascript:funChooseLogin(\''.$varMultiLoginInfo['MatriId'].'\');" class="clr1 grsearchtxt">'.$varMultiLoginInfo['User_Name'].'</a></td></tr>';
		$varDisplayAllUsername .= '<tr><td><img src="'.$confValues['IMGSURL'].'/trans.gif" height="2" border="0"></td></tr>';
	}//for
	$varDisplayAllUsername .= '</table>';
	//echo $varDisplayAllUsername;
?>

</form>
<div id="rndcorner" style="float:left;width:772px;">
	<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
	<div style="padding:5px 10px 5px 10px;">
		<div style="width:auto;text-align:center;">
			<div class="bl">
				<div class="br">
					<div class="tl">
						<div class="tr">
							<div style="clear:both;"></div>
							
							<div style="text-align:center;">
								<div style="text-align:left;padding:5px 0 2px 20px;">
								<!-- inside content -->
									<div class="smalltxt" style="height:190px;"><br>
										<div class="mediumtxt">Login with any of the Username listed below</div>
										<div style="padding:10px;"><?=$varDisplayAllUsername?></div>
									</div>
									
								<!-- inside content -->
								</div>
							</div>		
						</div><br clear="all">
						<!-- <div style="width:300px;"><img src="http://imgs.tamilmatrimony.com/bmimages/trans.gif" width="1" height="50"></div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
</div>


