<?php
#================================================================================================================
# Author 		: S.Naresh
# Start Date	: 2006-07-03
# End Date		: 2006-07-12
# Project		: MatrimonyProduct
# Module		: Offer Available - View Offer
#================================================================================================================

//BASE PATH
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once $varRootBasePath."/conf/config.cil14";
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/payment.cil14");
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objSlave	= new DB;

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

//ARRAY DECLARATION
$varOfferCategory = array(1=>"Through Online",1053=>"Through TME");

//VARIABLE DECLARATION
$varCurDate= date("Y-m-d H:i:s", time());
$varUserName			= $_REQUEST["username"];
$varPaymentThroughViewProfile	= $_REQUEST["tvprofile"];
$varCondition		= "WHERE MatriId=".$objSlave->doEscapeString($varUsername,$objSlave)." and OfferEndDate>='".$varCurDate."'";
$varNoOfResults		= $objSlave->numOfRecords($varTable['OFFERCODEINFO'],'MatriID',$varCondition);
if ($varNoOfResults >0) {	
$varSelectOfferInfo	= $objSlave->selectAll($varTable['OFFERCODEINFO'],$varCondition,1);
}

 $varMemberExtraPhoneNumbers = $varSelectOfferInfo['MemberExtraPhoneNumbers'];
 $varPhoneNumbersExplode	 = explode("|",$varSelectOfferInfo["MemberExtraPhoneNumbers"]);
 foreach($varPhoneNumbersExplode as $varKey => $varValue) {
 $varPhoneNumbersSeparate[$varKey]=explode("~",$varValue);
 }

 $varMemberDiscountPercentageOffer = $varSelectOfferInfo['MemberDiscountPercentage'];
 $varMemberDiscountPercentageExplode	 = explode("|",$varSelectOfferInfo["MemberDiscountPercentage"]);
 foreach($varMemberDiscountPercentageExplode as $varKey => $varValue) {
 $varMemberDiscountPercentageSeparate[$varKey]=explode("~",$varValue);
 }

 $varMemberDiscountINRFlatRateOffer = $varSelectOfferInfo['MemberDiscountINRFlatRate'];
 $varMemberDiscountINRFlatRateExplode	 = explode("|",$varSelectOfferInfo["MemberDiscountINRFlatRate"]);
 foreach($varMemberDiscountINRFlatRateExplode as $varKey => $varValue) {
 $varMemberDiscountINRFlatRateSeparate[$varKey]=explode("~",$varValue);
 }
 $varMemberDiscountUSDFlatRateOffer = $varSelectOfferInfo['MemberDiscountUSDFlatRate'];
 $varMemberDiscountUSDFlatRateExplode	 = explode("|",$varSelectOfferInfo["MemberDiscountUSDFlatRate"]);
 foreach($varMemberDiscountUSDFlatRateExplode as $varKey => $varValue) {
 $varMemberDiscountUSDFlatRateSeparate[$varKey]=explode("~",$varValue);
 }
 $varMemberDiscountEUROFlatRateOffer = $varSelectOfferInfo['MemberDiscountEUROFlatRate'];
 $varMemberDiscountEUROFlatRateExplode	 = explode("|",$varSelectOfferInfo["MemberDiscountEUROFlatRate"]);
 foreach($varMemberDiscountEUROFlatRateExplode as $varKey => $varValue) {
 $varMemberDiscountEUROFlatRateSeparate[$varKey]=explode("~",$varValue);
 }
 $varMemberDiscountAEDFlatRateOffer = $varSelectOfferInfo['MemberDiscountAEDFlatRate'];
 $varMemberDiscountAEDFlatRateExplode	 = explode("|",$varSelectOfferInfo["MemberDiscountAEDFlatRate"]);
 foreach($varMemberDiscountAEDFlatRateExplode as $varKey => $varValue) {
 $varMemberDiscountAEDFlatRateSeparate[$varKey]=explode("~",$varValue);
 }
 $varMemberDiscountGBPFlatRateOffer = $varSelectOfferInfo['MemberDiscountGBPFlatRate'];
 $varMemberDiscountGBPFlatRateExplode	 = explode("|",$varSelectOfferInfo["MemberDiscountGBPFlatRate"]);
 foreach($varMemberDiscountGBPFlatRateExplode as $varKey => $varValue) {
 $varMemberDiscountGBPFlatRateSeparate[$varKey]=explode("~",$varValue);
 }

 $varMemberNextLevelOffer = $varSelectOfferInfo['MemberNextLevelOffer'];
 $varMemberNextLevelExplode	 = explode("|",$varSelectOfferInfo["MemberNextLevelOffer"]);
 foreach($varMemberNextLevelExplode as $varKey => $varValue) {
 $varMemberNextLevelSeparate[$varKey]=explode("~",$varValue);
 }
$objSlave->dbClose();
?>

<table border="0" cellpadding="0" cellspacing="0" align="left" width="540">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" align="left" width="540" style="padding-left:50px;">
				<tr><td height="10"></td></tr>
				<tr><td valign="top" class="heading" style="padding-left:10px;">View Offer Details</td></tr>
				<tr><td height="10"></td></tr>	
				<tr><td align="left" class="smalltxt" style="padding-left:20px;"><b>MatriId</b> :<?=$varUserName?></td></tr>
				<?php  if ($varNoOfResults==0)  { ?>
				<tr><td align="center" class="smalltxt"><b>No Records found</b></td></tr>
				<?php }//if ?>		
			</table>
		</td>
	</tr>
	<tr><td height="5px" bgcolor="#FFFFFF"></td></tr>

	<?php if ($varNoOfResults > 0){ ?>	
	<tr>
		<td align="center">
			<table border="0" class="myprofsubbg"  cellpadding="0" cellspacing="1" align="left" width="743">
			<tr>
				<td valign="top"  style="padding-left:10px;">Basic Details</td>
				</tr>
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<?php
							$j=1;	
							for ($i=0;$i<$varNoOfResults;$i++)
							{?>
						<tr >
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">CategoryId :</td>
							<td class="smalltxt">
							<?php 	
									if(array_key_exists($varSelectOfferInfo['OfferCategoryId'],$varOfferCategory))
										{
											print $varOfferCategory[$varSelectOfferInfo['OfferCategoryId']];
										}else{ 
											echo"-";
										}
								?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Code :</td>
							<td class="smalltxt">
							<?php echo $varSelectOfferInfo['OfferCode'];?>								
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Start Date :</td>
							<td class="smalltxt"><?php echo $varSelectOfferInfo['OfferStartDate'];?></td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">End Date :</td>
							<td class="smalltxt"><?php echo $varSelectOfferInfo['OfferEndDate'];?></td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Availed Status :
							</td>
							<td class="smalltxt"><?php echo $varStatus=$varSelectOfferInfo['OfferAvailedStatus']==0?"Offer has not used by member":"Offer has been used by member on '".$varSelectOfferInfo['OfferAvailedOn']."'"?></td>
						</tr>
							
						<tr><td height="10" colspan="6"></td></tr>
						<?php }?>
						</table>
					</td>
				</tr>
				<tr height="5px">
					<td>&nbsp;</td>
				</tr>
				<?php if($varSelectOfferInfo['MemberExtraPhoneNumbers']!=''){?>
				<tr>
					<td valign="top"  style="padding-left:10px;">Extra Phone Numbers </td>
				</tr>
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Name</td>
							<td class="smalltxt boldtxt">Total No's</td>
						</tr>
						<?php
																			
							//foreach($varExplode as $varKey => $varValue) {
							//$varPhoneNumbersSeparate[i]=explode("~",$varValue);
							$j=0;
							$k=1;
							for($i=0;$i<count($varPhoneNumbersExplode);$i++) {							
							?>

						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%"><?php 
							foreach ($arrPrdPackages as $key=>$value){
							if($key==$varPhoneNumbersSeparate[$i][$j]){
								echo $value;
							}}?>
							</td>
							<td class="smalltxt"><?php echo $varPhoneNumbersSeparate[$i][$k];?></td>
						</tr>
						<tr><td height="10" colspan="6"></td></tr>
						<?php } //}?>
						</table>
					</td>
				</tr>				
				<tr height="5px">
					<td>&nbsp;</td>
				</tr><?php } ?>
				<?php if($varSelectOfferInfo['MemberDiscountPercentage']!=''){?>
				<tr>
					<td valign="top"  style="padding-left:10px;">Discount Percentage</td>
				</tr>
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Offer Name</td>
							<td class="smalltxt boldtxt" style="padding-left:16px;">Discount Percentage</td>
						</tr>
						<?php						
							$j=0;
							$k=1;
							for($i=0;$i<count($varMemberDiscountPercentageExplode);$i++) {							
						   ?>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%"><?php 
							foreach ($arrPrdPackages as $key=>$value){
							if($key==$varMemberDiscountPercentageSeparate[$i][$j]){
								echo $value;
							}
						}?></td>
							<td class="smalltxt" style="padding-left:16px;"><?php echo $varMemberDiscountPercentageSeparate[$i][$k];
							?>%</td>
						</tr>
						<tr><td height="10" colspan="6"></td></tr>
						<?php } //}?>
						</table>
					</td>
				</tr>
				

				<tr height="5px">
					<td>&nbsp;</td>
				</tr><?php } ?>
				<?php if($varSelectOfferInfo['MemberDiscountINRFlatRate']!=''){?>
				<tr>
					<td valign="top"  style="padding-left:10px;">MemberDiscountINRFlatRate</td>
				</tr>
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Offer Name</td>
							<td class="smalltxt boldtxt" style="padding-left:16px;">Discount Percentage</td>
						</tr>
						<?php						
							$j=0;
							$k=1;
							for($i=0;$i<count($varMemberDiscountINRFlatRateExplode);$i++) {							
						   ?>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%"><?php 
							foreach ($arrPrdPackages as $key=>$value){
							if($key==$varMemberDiscountINRFlatRateSeparate[$i][$j]){
								echo $value;
							}
						}?></td>
							<td class="smalltxt" style="padding-left:16px;"><?php echo $varMemberDiscountINRFlatRateSeparate[$i][$k];
							?>%</td>
						</tr>
						<tr><td height="10" colspan="6"></td></tr>
						<?php } //}?>
						</table>
					</td>
				</tr>
				

				<tr height="5px">
					<td>&nbsp;</td>
				</tr><?php } ?>
				<?php if($varSelectOfferInfo['MemberDiscountUSDFlatRate']!=''){?>
				<tr>
					<td valign="top"  style="padding-left:10px;">MemberDiscountUSDFlatRate</td>
				</tr>
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Offer Name</td>
							<td class="smalltxt boldtxt" style="padding-left:16px;">Discount Percentage</td>
						</tr>
						<?php						
							$j=0;
							$k=1;
							for($i=0;$i<count($varMemberDiscountUSDFlatRateExplode);$i++) {							
						   ?>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%"><?php 
							foreach ($arrPrdPackages as $key=>$value){
							if($key==$varMemberDiscountUSDFlatRateSeparate[$i][$j]){
								echo $value;
							}
						}?></td>
							<td class="smalltxt" style="padding-left:16px;"><?php echo $varMemberDiscountUSDFlatRateSeparate[$i][$k];
							?>%</td>
						</tr>
						<tr><td height="10" colspan="6"></td></tr>
						<?php } //}?>
						</table>
					</td>
				</tr>
				

				<tr height="5px">
					<td>&nbsp;</td>
				</tr><?php } ?>
				<?php if($varSelectOfferInfo['MemberDiscountEUROFlatRate']!=''){?>
				<tr>
					<td valign="top"  style="padding-left:10px;">MemberDiscountEUROFlatRate</td>
				</tr>
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Offer Name</td>
							<td class="smalltxt boldtxt" style="padding-left:16px;">Discount Percentage</td>
						</tr>
						<?php						
							$j=0;
							$k=1;
							for($i=0;$i<count($varMemberDiscountEUROFlatRateExplode);$i++) {							
						   ?>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%"><?php 
							foreach ($arrPrdPackages as $key=>$value){
							if($key==$varMemberDiscountEUROFlatRateSeparate[$i][$j]){
								echo $value;
							}
						}?></td>
							<td class="smalltxt" style="padding-left:16px;"><?php echo $varMemberDiscountEUROFlatRateSeparate[$i][$k];
							?>%</td>
						</tr>
						<tr><td height="10" colspan="6"></td></tr>
						<?php } //}?>
						</table>
					</td>
				</tr>
				

				<tr height="5px">
					<td>&nbsp;</td>
				</tr><?php } ?>
				<?php if($varSelectOfferInfo['MemberDiscountAEDFlatRate']!=''){?>
				<tr>
					<td valign="top"  style="padding-left:10px;">MemberDiscountAEDFlatRate</td>
				</tr>
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Offer Name</td>
							<td class="smalltxt boldtxt" style="padding-left:16px;">Discount Percentage</td>
						</tr>
						<?php						
							$j=0;
							$k=1;
							for($i=0;$i<count($varMemberDiscountAEDFlatRateExplode);$i++) {							
						   ?>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%"><?php 
							foreach ($arrPrdPackages as $key=>$value){
							if($key==$varMemberDiscountAEDFlatRateSeparate[$i][$j]){
								echo $value;
							}
						}?></td>
							<td class="smalltxt" style="padding-left:16px;"><?php echo $varMemberDiscountAEDFlatRateSeparate[$i][$k];
							?>%</td>
						</tr>
						<tr><td height="10" colspan="6"></td></tr>
						<?php } //}?>
						</table>
					</td>
				</tr>
				

				<tr height="5px">
					<td>&nbsp;</td>
				</tr><?php } ?>
				<?php if($varSelectOfferInfo['MemberDiscountGBPFlatRate']!=''){?>
				<tr>
					<td valign="top"  style="padding-left:10px;">MemberDiscountGBPFlatRate</td>
				</tr>
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Offer Name</td>
							<td class="smalltxt boldtxt" style="padding-left:16px;">Discount Percentage</td>
						</tr>
						<?php						
							$j=0;
							$k=1;
							for($i=0;$i<count($varMemberDiscountGBPFlatRateExplode);$i++) {							
						   ?>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%"><?php 
							foreach ($arrPrdPackages as $key=>$value){
							if($key==$varMemberDiscountGBPFlatRateSeparate[$i][$j]){
								echo $value;
							}
						}?></td>
							<td class="smalltxt" style="padding-left:16px;"><?php echo $varMemberDiscountGBPFlatRateSeparate[$i][$k];
							?>%</td>
						</tr>
						<tr><td height="10" colspan="6"></td></tr>
						<?php } //}?>
						</table>
					</td>
				</tr>
				


				<tr height="5px">
					<td>&nbsp;</td>
				</tr><?php } ?>
				<?php if($varSelectOfferInfo['MemberNextLevelOffer']!=''){?>
				<tr>
					<td valign="top"  style="padding-left:10px;">Offers </td>
				</tr>
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%">Offers Choosen</td>
							<td class="smalltxt boldtxt">NextlevelOfferValue</td>
						</tr>
						<?php						
							$j=0;
							$k=1;
							for($i=0;$i<count($varMemberNextLevelExplode);$i++) {							
						   ?>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%"><?php 
							foreach ($arrPrdPackages as $key=>$value){
							if($key==$varMemberNextLevelSeparate[$i][$j]){
								echo $value;
							}
						}?></td>
							<td class="smalltxt"><?php
							foreach ($arrPrdPackages as $key=>$value){
							if($key==$varMemberNextLevelSeparate[$i][$k]){
								echo $value;
							}}?></td>
						</tr>
						<tr><td height="10" colspan="6"></td></tr>
						<?php } //}?>
						</table>
					</td>
				</tr>
				<?php } ?>				
			</table>
		</td>
	</tr>
	<tr><td height="10" colspan="6"></td></tr>
	<?php }//if ?>
</table>