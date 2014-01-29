<?php
#================================================================================================================
# Author 		: C.Mariyappan
# Start Date	: 2011-01-18
# End Date		: 2011-01-20
# Project		: MatrimonyProduct
# Module		: View Validation Log #================================================================================================================

//BASE PATH
 $varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES

include_once($varRootBasePath.'/conf/dbinfo.cil14');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objSlave	= new DB;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);

//VARIABLE DECLARATION

$varMatrimonyId = $_REQUEST['matrimonyId'];
$varReportType  = $_REQUEST['reportType'];
$varFromDate    = $_REQUEST['fromDate'];
$varToDate      = $_REQUEST['toDate'];


if(isset($_REQUEST['submit']))
	    {
		 $varMatrimonyId   = $_REQUEST['matrimonyId'];
		 $argFields 	   = array('*');
		 $argCondition	   = " WHERE matriid=".$objSlave->doEscapeString($varMatrimonyId,$objSlave);

		 if($varReportType!="")
		  {
           $argCondition.= " and reporttype=".$objSlave->doEscapeString($varReportType,$objSlave);
		  }
         
		 if($varFromDate)
		  {
           $argCondition.= " and date(validateddate) between ".$objSlave->doEscapeString($varFromDate,$objSlave)." and  ".$objSlave->doEscapeString($varToDate,$objSlave);
		  }
       	 $varAvailableRes   = $objSlave->select($varTable['SUPPORT_VALIDATION_REPORT'],$argFields,$argCondition,0);
		 $varAvailableCount	= mysql_num_rows($varAvailableRes);
        }

  $objSlave->dbClose();
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE>Validation-Log Search By Matrimony Id</TITLE>
  <script language="javascript" src="<?=$confValues['JSPATH']?>/calenderJS.js"></script>
  <script language="javascript" src="<?=$confValues['JSPATH']?>/search.js"></script>
 </HEAD>
<FORM METHOD=POST Name="frmValidationLog" ACTION="" onsubmit="return funValidationLog();">
 <BODY>
 <title>Validation Log</title>
  <center>
  <br/>
  <table border=0 cellpadding=1 cellspacing=2 width='540'>
    <tr align=left><td>
	<div style="color: rgb(51, 153, 51); font-size: 14px; font-weight: bold; margin: 5px;">Validation Log</div>
	</td></tr>
	<tr align=center><td height="10">&nbsp;
	</td></tr>
	
	<tr align=center><td>
	<table  border="0" cellpadding="3" cellspacing="3" width="100%">
	<tr height="30px;"><td style="padding:0 0 0 25px;"><font class="mediumtxt"><b>Matrimony Id</b></font></td>
	<td style="padding:0 0 0 33px;">
	<INPUT TYPE="text" NAME="matrimonyId" style="width:189px;"></td></tr>
	<tr height="30px;"><td style="padding:0 0 0 25px;"><font class="mediumtxt"><b>Report Type</b></font></td>
	<td style="padding:0 0 0 33px;">
	<SELECT NAME="reportType" ID="reportType" style="width:189px;">
	<OPTION value="">Show All</OPTION>
	<OPTION value="1">Profile Validation</OPTION>
	<OPTION value="6">Profile Modification</OPTION>
	<OPTION value="3">Photo Validation</OPTION>
	<OPTION value="5">Horoscope Validation</OPTION>
	</SELECT></td></tr>

    <tr class="mediumtxt">
		<td style="padding:0 0 0 25px;"><font class="mediumtxt"><b>Select date</b></font></td>
		<td>
        <font class="mediumtxt">From</font>
		<input type="text" name="fromDate" readonly="" value="" style="width:80px" onclick="displayDatePicker('fromDate', document.frmValidationLog.fromDate, 'ymd', '-');document.getElementById('datepicker').style.backgroundColor='#FFF0D3';">
		&nbsp;&nbsp;
         <font class="mediumtxt">To</font>
		<input type="text" name="toDate" readonly="" value="" style="width:80px" onclick="displayDatePicker('toDate', document.frmValidationLog.toDate, 'ymd', '-');document.getElementById('datepicker').style.backgroundColor='#FFF0D3';">
		
		</td>
	</tr>
	    
	<tr><td colspan="2" align="center">
	<INPUT TYPE="submit" name="submit" class="button" value="Submit"></td></tr>
	</table>
	
	</td></tr>
	
	<tr><td>
        <?
		 if(isset($_REQUEST['submit']))
		  {
		   if($varAvailableCount>0) 
		    {?>
			<div align="center">
          <? 
		  $varSno=1;
		  while($arrMatriIddet= mysql_fetch_assoc($varAvailableRes)){?>
		  <table width="85%" class="formborder"  cellspacing="2" cellpadding="3" border="0" align="center" style="border: 1px solid rgb(197, 214, 83); color: rgb(96, 96, 96);">
						
	 	  <tbody>
		  <tr bgcolor="#efefef">
		  <td width="35%" align="center" colspan="2" style="padding-left: 16px;" class="smalltxt boldtxt"> S.No:&nbsp;<?=$varSno?> </td>
		  </tr>

		  		  
		  <tr>
			<td class="smalltxt" width="50%"><b>Admin Name:</b>&nbsp;</td>
			<td class="smalltxt"><label><? if($arrMatriIddet['userid']){echo $arrMatriIddet['userid'];}else{echo "-";}?></label>&nbsp;</td>
		  </tr>

		  <tr>
			<td class="smalltxt" width="50%"><b>Matrimony Id:</b>&nbsp;</td>
			<td class="smalltxt"><label><?=$arrMatriIddet['matriid']?></label>&nbsp;</td>
		  </tr>
		  
	 	  	  
	 	  <tr>
			<td class="smalltxt"><b>Edit Profile:</b>&nbsp;</td>
			<td class="smalltxt"><label><? if($arrMatriIddet['editprofile']){echo $arrMatriIddet['editprofile']; } else {echo "-";}?></label>&nbsp;</td>
		  </tr>
		  
	 	   <tr>
			<td class="smalltxt"><b>Support Modified Fields:</b>&nbsp;</td>
			<td class="smalltxt"><label><? if($arrMatriIddet['supportmodifiedfields']){echo $arrMatriIddet['supportmodifiedfields'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr>

		  <tr>
			<td class="smalltxt"><b>Before Edited Values:</b>&nbsp;</td>
			<td class="smalltxt"><label><?if($arrMatriIddet['beforeeditedvalues']) {echo $arrMatriIddet['beforeeditedvalues'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr>

		  <tr>
			<td class="smalltxt"><b>Support Modified:</b>&nbsp;</td>
			<td class="smalltxt"><label><?if($arrMatriIddet['supportmodified']) {echo $arrMatriIddet['supportmodified'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr>

		  <tr>
			<td class="smalltxt"><b>Comments:</b>&nbsp;</td>
			<td class="smalltxt"><label><? if($arrMatriIddet['comments']){echo $arrMatriIddet['comments'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr>

		  <tr>
			<td class="smalltxt"><b>Notify Customer:</b>&nbsp;</td>
			<td class="smalltxt"><label><?if($arrMatriIddet['notifycustomer']) {echo $arrMatriIddet['notifycustomer'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr>

		  <tr>
			<td class="smalltxt"><b>Profile Status:</b>&nbsp;</td>
			<td class="smalltxt">
			<label>
			<?php 
			  if(($arrMatriIddet['profilestatus']=="A")||($arrMatriIddet['profilestatus']=="1")){echo "ADD";} 
		      elseif($arrMatriIddet['profilestatus']=="I"){echo "IGNORE";}
			  elseif($arrMatriIddet['profilestatus']=="R"){echo "REJECT";}
			  elseif($arrMatriIddet['profilestatus']=="Z"){echo "TIMEOUT";}			 
			  elseif($arrMatriIddet['profilestatus']=="0"){echo "DELETE";}
			  else{echo "-";}
			 ?>
			</label>
		  </tr>

		 <!-- <tr>
			<td class="smalltxt"><b>Dynamic Data:</b>&nbsp;</td>
			<td class="smalltxt"><label><? if($arrMatriIddet['dynamicdata']){echo $arrMatriIddet['dynamicdata'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr>

		   <tr>
			<td class="smalltxt"><b>Profile Date Updated:</b>&nbsp;</td>
			<td class="smalltxt"><label><?if($arrMatriIddet['profiledateupdated']){echo $arrMatriIddet['profiledateupdated'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr>

         <tr>
			<td class="smalltxt"><b>Downloaded Date:</b>&nbsp;</td>
			<td class="smalltxt"><label><?if($arrMatriIddet['downloadeddate']){echo $arrMatriIddet['downloadeddate'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr> !-->

		  <tr>
			<td class="smalltxt"><b>Time-Taken:</b>&nbsp;</td>
			<td class="smalltxt"><label><?if($arrMatriIddet['timetaken']){echo $arrMatriIddet['timetaken'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr>

		  <tr>
			<td class="smalltxt"><b>Validate Date:</b>&nbsp;</td>
			<td class="smalltxt"><label><?if($arrMatriIddet['validateddate']!="0000-00-00 00:00:00"){echo $arrMatriIddet['validateddate'];} else { echo "-";}?></label>&nbsp;</td>
		  </tr>

          <tr>
			<td class="smalltxt"><b>Report Type:</b>&nbsp;</td>
			<td class="smalltxt">
			 <label>
			  <?
			  if($arrMatriIddet['reporttype']=="1"){echo "Profile Validation";} 
		      elseif($arrMatriIddet['reporttype']=="3"){echo "Photo";}
			  elseif($arrMatriIddet['reporttype']=="5"){echo "Horoscope";}
			  elseif($arrMatriIddet['reporttype']=="6"){echo "Profile Modification";}
			  else{echo "-";}
			  ?>
			  </label>&nbsp;</td>
		  </tr>
	 </tbody></table> 
	 <div style="clear:both;height:15px;"></div>
	 <? $varSno++;
	  }?>
	 </div>
	   <?
  	        }	
			else
			{
			?>
	         <div align="center" class="errortxt bld">No Results Found.</div>
			<?
			}
        
	   }
	 ?>
			
	</td></tr>
	
	</table>

  </center>
 </BODY>
 </FORM>
</HTML>

<SCRIPT LANGUAGE="JavaScript">
function  funValidationLog()
{
  if(document.frmValidationLog.matrimonyId.value =='')
   {
	document.frmValidationLog.matrimonyId.focus();
	alert ("Please Enter the Matrimony Id");
	return false;
   }

  if(document.frmValidationLog.fromDate.value!='')
   {
      if(document.frmValidationLog.toDate.value=='')
		{
		  alert("Please Select Todate");
		  return false;
		}
   }
  document.frmValidationLog.submit();
}
</SCRIPT>