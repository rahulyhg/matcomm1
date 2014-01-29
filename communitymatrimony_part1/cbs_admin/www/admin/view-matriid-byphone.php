<?php
//BASE PATH
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once $varRootBasePath."/conf/config.cil14";
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objSlave	= new DB;

$objSlave->dbConnect('S',$varDbInfo['DATABASE']);


//CONTROL STATEMENT
if ($_POST["frmViewMatrimonySubmit"]=="yes")  {

	 $varphoneno 		= $_REQUEST["mobilephoneno"];
	 $varverified 		= $_REQUEST["verified"];
	 $varnonverified  	= $_REQUEST["nonverified"];
	if($varnonverified!=''){
	$argFields			= array('MatriId','PhoneNo1');
	if(strlen($varphoneno==8)){
		$argCondition		= "WHERE PhoneNo=".$objSlave->doEscapeString($varphoneno,$objSlave);
	}
	else{
		$argCondition		= "WHERE MobileNo=".$objSlave->doEscapeString($varphoneno,$objSlave);
	}
	 $varnonverifiedNoOfResults		= $objSlave->numOfRecords($varTable['ASSUREDCONTACTBEFOREVALIDATION'],'MatriID',$argCondition);
	$varNonVerifiedInfo1	= $objSlave->selectAll($varTable['ASSUREDCONTACTBEFOREVALIDATION'],$argCondition,0);
	}
	if($varverified !=''){
		$argFields			= array('MatriId','PhoneNo1');
		$argCondition		= "WHERE PhoneNo1 LIKE '%".$objSlave->doEscapeString($varphoneno,$objSlave)."%'";	
	  $varverifiedNoOfResults		= $objSlave->numOfRecords($varTable['ASSUREDCONTACT'],'MatriID',$argCondition);
	 $varVerifiedInfo1	= $objSlave->selectAll($varTable['ASSUREDCONTACT'],$argCondition,0);
	
	}	
}
//if

$objSlave->dbClose();
?>
<table border="0" cellpadding="0" cellspacing="0" align="left" width="540">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table border="0" cellpadding="0" cellspacing="0" align="left" width="540" style="padding-left:50px;">
				<tr>
					<td align="center"><a href="index.php?act=profile" class="grtxt"><b><u><font class="smalltxt boldtxt" color="red">View other Profiles >></font></u></b></a>&nbsp;</td>
				</tr>
				<tr><td height="10"></td></tr>
				<tr><td valign="top" class="heading" style="padding-left:10px;">View MatriId Details</td></tr>
				<tr><td height="10"></td></tr>					
				<?php  if (($varnonverifiedNoOfResults==0)&&($varverifiedNoOfResults==0))  { ?>
				<tr ><td align="center" class="smalltxt" height="550px" valign="top"><b>No Records found</b></td></tr>
				<?php }//if ?>		
			</table>
		</td>
	</tr>
	<?php if($varnonverifiedNoOfResults>0){?>
	<tr>
		<td class="smalltxt" style="padding-left:15px">
		<b>Non Verified List Count :</b> <?php echo $varnonverifiedNoOfResults;?>
		</td>
	</tr>
	<?php }?>
	<?php if($varverifiedNoOfResults>0){?>
	<tr>
		<td class="smalltxt" style="padding-left:15px">
		<b>Verified List Count :</b> <?php echo $varverifiedNoOfResults;?>
		</td>
	</tr>
	<?php }?>
	<tr><td height="5px" bgcolor="#FFFFFF"></td></tr>
	<tr>
		<td align="center">
			<table border="0" class="myprofsubbg"  cellpadding="0" cellspacing="1" align="left" width="743">
				<tr height="5px">
					<td>&nbsp;</td>
				</tr>
				<?php if($varnonverifiedNoOfResults>0){		
				while($varNonVerifiedInfo = mysql_fetch_array($varNonVerifiedInfo1)){			
					?>
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
				</tr><?php } } ?>
				<tr height="5px">
					<td>&nbsp;</td>
				</tr>
				<?php if($varverifiedNoOfResults>0){
				while($varVerifiedInfo = mysql_fetch_array($varVerifiedInfo1)){?>				
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
				</tr><?php } }?>
	<tr><td height="10" colspan="6"></td></tr>	
</table>