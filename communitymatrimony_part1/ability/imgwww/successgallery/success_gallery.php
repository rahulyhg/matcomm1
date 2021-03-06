<?php
#=====================================================================================================================================
# Author 	  : Srinivasan.C
# Date		  : 2009-11-03
# Project	  : CommunityMatrimony
# Filename	  : success_gallery.php
#=====================================================================================================================================
# Description : getting success story information
#=====================================================================================================================================
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath."/lib/clsSuccessMailer.php");
include_once($varRootBasePath.'/lib/clsRegister.php');

//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new clsRegister;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

$domainName = str_replace("image.","",$_SERVER[SERVER_NAME]);
$arrPrefixDomainList1 = array_flip($arrPrefixDomainList);
$domainPrefix = $arrPrefixDomainList1[$domainName];
$arrMatriIdPre1 = array_flip($arrMatriIdPre);
$domainId = $arrMatriIdPre1[$domainPrefix];
$folderName = $arrFolderNames[$domainPrefix];

$pendingPhotosDir = $varRootBasePath."/www/success/".$folderName."/pendingphotos";
$bigPhotosDir = $varRootBasePath."/www/success/".$folderName."/bigphotos";
$smallPhotosDir = $varRootBasePath."/www/success/".$folderName."/smallphotos";
$homePhotosDir = $varRootBasePath."/www/success/".$folderName."/homephotos";
$storiesFolderPath = $varRootBasePath."/www/success/$folderName/stories/";
$navPath='http://'.$_SERVER['HTTP_HOST'].'/successgallery/';
$layout="";
 
$pageLimit=10;	
/*$prev=$_REQUEST['prev'];
$next=$_REQUEST['next'];
if(!$prev && !$next)$next=1;
if($prev){
    $endlimit=$pageLimit*$prev;
	$startlimit=$endlimit-$pageLimit;
	$prev=$prev-1;
}else{
	$prev=$next-1;
}

if($next){
    $endlimit=$pageLimit*$next;
	$startlimit=$endlimit-$pageLimit;
	$next=$next+1;
}else{
	$next=$prev+2;
}
if($startlimit==0){
	$startlimit=1;
}else{
    $startlimit=$startlimit+1;
}*/
$indx = $_REQUEST["indx"];
if(!$indx){
	$indx =intval(@$_REQUEST["indx"]);
}
if($indx){
    $endlimit=$pageLimit*($indx+1);
	$startlimit=$endlimit-$pageLimit;
	
}else{
	
	$endlimit=$pageLimit*1;
	$startlimit=$endlimit-$pageLimit;
}
if($startlimit==0){
	$startlimit=1;
	
}else{
    $startlimit=$startlimit+1;
}

//echo "<br>startlimit:".$startlimit."endlimit:".$endlimit;
//echo "indx:".$indx;
//echo "<br>";
if($handle = opendir($storiesFolderPath)){
    $ii=1;  
	
	$countFileHandle = fopen($storiesFolderPath.'count.txt','r+');
	$fileCount = fread($countFileHandle,filesize($storiesFolderPath.'count.txt'));
    while (false !== ($file = readdir($handle))){
		
       if($file!='count.txt'){
		   
		   if($endlimit>$fileCount){$endlimit=$fileCount;}
           if($ii>=$startlimit && $ii<=$endlimit){
			   //echo "<br>".$file;
		   $storiesFilePath=$storiesFolderPath.$file;
		   $storiesFileHandle = fopen($storiesFilePath,'r+');
		   $storiesContent = fread($storiesFileHandle,filesize($storiesFilePath));
		   $content_arr=explode('|',$storiesContent);
			
		   $MatriId=$content_arr[0];
		   $Bride_Name=$content_arr[1];
		   $Groom_Name=$content_arr[2];
		   $Success_Message=$content_arr[3];
		   $Marriage_Date=$content_arr[4];
			
		   $smallImgPath='http://'.$_SERVER['HTTP_HOST'].'/success/'.$folderName.'/smallphotos/'.$MatriId.'_s.jpg';
		   $bigImgPath='http://'.$_SERVER['HTTP_HOST'].'/success/'.$folderName.'/bigphotos/'.$MatriId.'_b.jpg';
			
		   $layout.='<a name="'.$MatriId.'"></a>
		   <div class="borderline" style="width:490px;"><img src="'.$confValues['IMGSURL'].'/trans.gif" height="1"></div> <br clear="all">
		   <div class="vdotline1" style="width:490px;"><img src="'.$confValues['IMGSURL'].'/trans.gif" height="1"></div>
		   <div style="padding:5px 0px 5px 0px;" class="fleft">
		   <div style="width:145px;text-align:center;" class="smalltxt fleft"><b>Matrimony ID</b> <br>'.$MatriId.'</div>
		   <div style="width:145px;text-align:center;" class="smalltxt fleft"><b>Bride</b> <br>'.$Bride_Name.'</div>
		   <div style="width:145px;text-align:center;" class="smalltxt fleft"><b>Groom </b> <br>'.$Groom_Name.'</div>
		   <div style="width:100px;text-align:center;" class="smalltxt fleft"><b>Marriage Date</b> <br>'.$Marriage_Date.'</div>
		   </div><br clear="all">
		   <div class="vdotline1" style="width:490px;"><img src="'.$confValues['IMGSURL'].'/trans.gif" height="1"></div>
		   <div style="padding: 10px 0px 10px 5px;">
		   <div class="fleft" style="margin: 0px 10px 0px 0px;" onmousemove="javascript:showImg(event,'."'".$MatriId."'".');" onmouseout="javascript:hideImg('."'".$MatriId."'".');"><a href="javascript:void(0);"><img src="'.$smallImgPath.'" width="121" height="81" border="0" style="border: 1px solid #C5D653;" hspace="3" vspace="3"></a></div>
		   <div id="imgdiv'.$MatriId.'" style="display:none"><img src="'.$bigImgPath.'"></div>
		   <div class="fleft content" style="width:340px;">'.$Success_Message.'</div>
		   </div>
		   <br clear="all">';

		   }
		   $ii++;
		}
    }

   
    closedir($handle);
 }
 

?>

<script language="javascript" src="<?=$confValues['JSPATH']?>/common.js" ></script>
<script language="javascript" src="<?=$confValues['JSPATH']?>/successstory.js" ></script>
<script>
function setNavigation(url,nav_indx){
		document.getElementById('indx').value=nav_indx;
		document.forms[0].action=url+nav_indx;
		document.forms[0].submit();
		
	}
</script>

<form name="frm" method="POST">
<input type="hidden" name="indx" id="indx">
<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5" style="width:150px;float:left"><font class="clr bld">Success Galleries</font></div><div  style="width:80px;float:right" class="smalltxt"><?php echo $startlimit.' to '.$endlimit.' Of '.$fileCount; ?></div><br>
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br><br>
		
	<!--div class="normtxt1 clr2 padb5" align="right"><?php if($prev >=1){ ?><a href='<?=$navPath.'index.php?prev='.$prev;?>'> <? } ?>Prev</a>&nbsp;&nbsp;<?php if($endlimit<$fileCount){ ?><a href='<?=$navPath.'index.php?next='.$next;?>'><? } ?>Next</a></div-->
	<?php 
	  //echo $nav_indx = intval(@$_REQUEST["indx"]);
	  //$url='index.php?indx='.$nav_indx;
	  $url='index.php?indx=';
	  navigate($url,$fileCount,$indx,$pageLimit);?>
	<center>
	
	<div class="rpanel padt10">
	<?php if($startlimit>$fileCount){echo "<center><font class='errorMsg'>No Galleries Found !</font>";}else{ echo $layout;}?>
    
	</div>
	</center>
</div></form>
<?php
function navigate($url,$totalrecords,$indx,$list_length='') 
  {
      if (!defined("LIST_LENGTH")) {
            $indxsettings = 10; // total rows per page   
      }
      else {
            if($list_length) {
                  $indxsettings = $list_length;
            }
            else {
                  $indxsettings = 10;
            }
      }
      $displaylinks = 5;  //number of links to be displayed 
      $totallinks = intval($totalrecords/$indxsettings);
      if ($totalrecords%$indxsettings >0){
            $totallinks++;
      }
               
      if(intval($indx%$displaylinks)==0){
            $startindx= $indx+1;
            $endindex = $indx+$displaylinks;
            if($endindex >$totallinks){
                  $endindex= $totallinks;                              
            }
            if (!$indx){
                  $startindx=1;
            }
      }
      else {
            $startindx = intval($indx/$displaylinks)*($displaylinks)+1;
            $endindex = $startindx+($displaylinks-1);
            if($endindex >$totallinks){
                  $endindex= $totallinks;                              
            }
      }
            echo '<div id="paging" class="padtb10"><div class="fright">';   

      //// setting next and Previous Links    
      if ($startindx >$displaylinks ) {
            $page= $startindx-($displaylinks+1);
                                 
                  echo '<div class="prevact" onclick="javascript:setNavigation('."'".$url."'".','.$page.');"> < </div><div class="spacing">&nbsp;</div>';
      }else{
		          echo '<div class="prevact"> < </div><div class="spacing">&nbsp;</div>';
	  }
      // setting current link /////   
      for ($i=$startindx;$i<=$endindex;$i++) {
            $page= $i-1;
                  if ($indx!=$page) { ?>
						<div class="paginginact" onclick="javascript:setNavigation('<?=$url;?>',<?=$page;?>);"><?=@$page+1;?></div><div class="spacing">&nbsp;</div>
                  <?php
                  }
                  else {
                        echo '<div class="pagingact">'.$i.'</div><div class="spacing">&nbsp;</div>';
            }
      }
      // setting next link   
      if ($totallinks >$endindex ) {
            $page= $endindex;
                        echo '<div class="nextact" onclick="javascript:setNavigation('."'".$url."'".','.$page.');"> > </div>';
            }else{
				        echo '<div class="nextact"> > </div>';
			}
            echo '</div></div>';
  }  
  function navigate1($url,$totalrecords,$indx,$list_length='') 
  {
      if (!defined("LIST_LENGTH")) {
            $indxsettings = 10; // total rows per page   
      }
      else {
            if($list_length) {
                  $indxsettings = $list_length;
            }
            else {
                  $indxsettings = 10;
            }
      }
      $displaylinks = 5;  //number of links to be displayed 
      $totallinks = intval($totalrecords/$indxsettings);
      if ($totalrecords%$indxsettings >0){
            $totallinks++;
      }
            //// Setting starting index value and endindex value
            // mod function to find whether the current link reaches more than display link
            // if so assign change the starting value with next if records are sufficient  and previous links     
      if(intval($indx%$displaylinks)==0){
            $startindx= $indx+1;
            $endindex = $indx+$displaylinks;
            if($endindex >$totallinks){
                  $endindex= $totallinks;                              
            }
            if (!$indx){
                  $startindx=1;
            }
      }
      else {
            $startindx = intval($indx/$displaylinks)*($displaylinks)+1;
            $endindex = $startindx+($displaylinks-1);
            if($endindex >$totallinks){
                  $endindex= $totallinks;                              
            }
      }
            echo "<table cellpadding = 0 border=0 cellspacing =0 align='right'><tr>";   

      //// setting next and Previous Links    
      if ($startindx >$displaylinks ) {
            $page= $startindx-($displaylinks+1);
                  //echo " <a href='$url&indx=$page' class=navlink>Previous</a>&nbsp;  ";                  
                  echo "<td class = 'select_tab' width=30 align ='center' onmouseover = this.className='select_mouse' onmouseout = this.className='select_tab'><a href='".$url.$page."'>Previous</a></td><td width =5 ></td >";
      }
      // setting current link /////   
      for ($i=$startindx;$i<=$endindex;$i++) {
            $page= $i-1;
                  if ($indx!=$page) {
                        //echo " <a href='$url&indx=$page' class=navlink>$i</a>&nbsp;  ";            
                  ?>
                  <td class = select_tab width = 15  align = center onmouseover = "this.className='select_mouse'" onmouseout = "this.className='select_tab'"><a href='<?php echo $url.($page);?>'><?=@$page+1;?></a></td >
                  <td width =5 ></td >
                  <?php
                  }
                  else {
                        echo " <td class = deselect_tab width = 15 align = center onmouseover = this.className='deselect_mouse' onmouseout = this.className='deselect_tab'>$i</td><td width =5 ></td >";
            }
      }
      // setting next link   
      if ($totallinks >$endindex ) {
            $page= $endindex;
                  //echo " <a href='$url&indx=$page' class=navlink>Next</a>&nbsp;  ";                  
                  echo "<td class = select_tab width = 30 onmouseover = this.className='select_mouse' onmouseout = this.className='select_tab'><a href='".$url.$page."'>Next</a></td>";
            }
            echo "</tr></table>";
  }  
?>