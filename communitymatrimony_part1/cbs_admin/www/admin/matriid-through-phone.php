l<?php
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

//VARIABLE DECLARATION
$varCurDate= date("Y-m-d H:i:s", time());
$varUserName					= $_REQUEST["matriid"];
$varPaymentThroughViewProfile	= $_REQUEST["tvprofile"];
$argFields						= array('MatriId','Phone_Verified');
$argCondition					= "WHERE MatriId=".$objSlave->doEscapeString($varUserName,$objSlave);
$varNoOfResults					= $objSlave->numOfRecords($varTable['MEMBERINFO'],'MatriID',$argCondition);

if ($varNoOfResults >0) {	
$varExecute	= $objSlave->select($varTable['MEMBERINFO'],$argFields,$argCondition,0);
$varSelectValueInfo=mysql_fetch_assoc($varExecute);
}
if($varSelectValueInfo['Phone_Verified']==0){
$varCondition		= "WHERE MatriId=".$objSlave->doEscapeString($varUserName,$objSlave);
$varNonVerifiedNoOfResults		= $objSlave->numOfRecords($varTable['ASSUREDCONTACTBEFOREVALIDATION'],'MatriID',$varCondition);
$varNonVerifiedInfo	= $objSlave->selectAll($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$varCondition,1);
}

if($varSelectValueInfo['Phone_Verified']==1){
$varCondition		= "WHERE MatriId=".$objSlave->doEscapeString($varUserName,$objSlave);
$varVerifiedNoOfResults			= $objSlave->numOfRecords($varTable['ASSUREDCONTACT'],'MatriID',$varCondition);
$varVerifiedInfo	= $objSlave->selectAll($varTable['ASSUREDCONTACT'],$varCondition,1);
}
$objSlave->dbClose();
?>

<table border="0" cellpadding="0" cellspacing="0" align="left" width="540">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" align="left" width="540" style="padding-left:50px;">
				<tr><td height="10"></td></tr>
				<tr><td valign="top" class="heading" style="padding-left:10px;">View MatriId Details</td></tr>
				<tr><td height="10"></td></tr>	
				<tr><td align="left" class="smalltxt" style="padding-left:20px;"><b>MatriId</b> :<?=$varUserName?></td></tr>
				<?php  if (($varNonVerifiedNoOfResults==0)&&($varVerifiedNoOfResults==0))  { ?>
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
				<tr height="5px">
					<td>&nbsp;</td>
				</tr>
				<?php if($varNonVerifiedNoOfResults>0){?>				
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" align="center" width="35%" colspan="2">Pending Status </td>	
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >PinNo : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">
							<?=$varNonVerifiedInfo['PinNo']?$varNonVerifiedInfo['PinNo']:'-';?></td>
						</tr>						
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Matrimony Id : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">
							<?=$varNonVerifiedInfo['MatriId']?$varNonVerifiedInfo['MatriId']:'-';?></td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Time Generated : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">
							<?=$varNonVerifiedInfo['TimeGenerated']?$varNonVerifiedInfo['TimeGenerated']:'-';?></td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Phone No : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">
							<?=$varNonVerifiedInfo['PhoneNo1']?$varNonVerifiedInfo['PhoneNo1']:'-';?></td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Phone Status : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">Pending</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Contact person : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varNonVerifiedInfo['ContactPerson1']?$varNonVerifiedInfo['ContactPerson1']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Relation Ship : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varNonVerifiedInfo['Relationship1']?$varNonVerifiedInfo['Relationship1']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Time to call : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varNonVerifiedInfo['Timetocall1']?$varNonVerifiedInfo['Timetocall1']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Date Confirmed : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varNonVerifiedInfo['DateConfirmed']?$varNonVerifiedInfo['DateConfirmed']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Verified Flag : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varNonVerifiedInfo['VerifiedFlag']?$varNonVerifiedInfo['VerifiedFlag']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Description : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varNonVerifiedInfo['Description']?$varNonVerifiedInfo['Description']:'-';?>
							</td>
						</tr>
						</table>
					</td>
				</tr>				
				<tr height="5px">
					<td>&nbsp;</td>
				</tr><?php } ?>	
				<?php if($varVerifiedNoOfResults>0){?>				
				<tr>
					<td valign="top"  style="padding-left:10px;">
						<table border="0" cellpadding="5" cellspacing="0" align="left" width="70%" class="formborder" >
						<tr bgcolor="#EFEFEF">
							<td class="smalltxt boldtxt" style="padding-left:16px;" align="center" width="35%" colspan="2">Validated Status </td>	
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >PinNo : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">
							<?=$varVerifiedInfo['PinNo']?$varVerifiedInfo['PinNo']:'-';?></td>
						</tr>						
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Matrimony Id : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">
							<?=$varVerifiedInfo['MatriId']?$varVerifiedInfo['MatriId']:'-';?></td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Time Generated : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">
							<?=$varVerifiedInfo['TimeGenerated']?$varVerifiedInfo['TimeGenerated']:'-';?></td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Phone No : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">
							<?=$varVerifiedInfo['PhoneNo1']?$varVerifiedInfo['PhoneNo1']:'-';?></td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Phone Status : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">Validated</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Contact person : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varVerifiedInfo['ContactPerson1']?$varVerifiedInfo['ContactPerson1']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Relation Ship : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varVerifiedInfo['Relationship1']?$varVerifiedInfo['Relationship1']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Time to call : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varVerifiedInfo['Timetocall1']?$varVerifiedInfo['Timetocall1']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Date Confirmed : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varVerifiedInfo['DateConfirmed']?$varVerifiedInfo['DateConfirmed']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Verified Flag : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varVerifiedInfo['VerifiedFlag']?$varVerifiedInfo['VerifiedFlag']:'-';?>
							</td>
						</tr>
						<tr>
							<td class="smalltxt boldtxt" style="padding-left:16px;" width="35%" >Description : </td>
							<td class="smalltxt" style="padding-left:16px;" width="35%">							<?=$varVerifiedInfo['Description']?$varVerifiedInfo['Description']:'-';?>
							</td>
						</tr>
						</table>
					</td>
				</tr>				
				<tr height="5px">
					<td>&nbsp;</td>
				</tr><?php } ?>
	<tr><td height="10" colspan="6"></td></tr>
	<?php }//if ?>
</table>