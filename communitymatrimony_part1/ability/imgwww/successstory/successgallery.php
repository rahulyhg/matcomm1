<?php
#===================================================================================================================
# Author 	  : Srinivasan.C
# Date		  : 2009-11-03
# Project	  : CommunityMatrimony
# Filename	  : success_gallery.php
#===================================================================================================================
# Description : Getting success story informations
#===================================================================================================================

$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.cil14");
include_once($varRootBasePath."/conf/dbinfo.cil14");
include_once($varRootBasePath."/conf/domainlist.cil14");
include_once($varRootBasePath.'/lib/clsCommon.php');
include_once($varRootBasePath.'/lib/clsDB.php');

//OBJECT DECLARTION
$objMaster	= new DB;
$objSlave	= new DB;

//DB CONNECTION
$objSlave->dbConnect('S',$varDbInfo['DATABASE']);
$objMaster->dbConnect('M',$varDbInfo['DATABASE']);

$domainName = str_replace("image.","",$_SERVER[SERVER_NAME]);
if($domainName=='img.agarwalmatrimony.com'){
$domainName = str_replace("img.","",$_SERVER[SERVER_NAME]);
}
$arrPrefixDomainList1 = array_flip($arrPrefixDomainList);
$domainPrefix = $arrPrefixDomainList1[$domainName];
$arrMatriIdPre1 = array_flip($arrMatriIdPre);
$domainId = $arrMatriIdPre1[$domainPrefix];
$folderName = $arrFolderNames[$domainPrefix];

$storiesFolderPath = $varRootBasePath."/www/success/$folderName/stories/";
$PagingUrl='index.php?act=successgallery&indx=';
$pageLimit=5;
$layout="";
 
	

$indx = $_REQUEST["indx"];
if(!$indx)
	$indx =intval(@$_REQUEST["indx"]);

if($indx){
    $endlimit=$pageLimit*($indx+1);
	$startlimit=$endlimit-$pageLimit;
	
}else{
	$endlimit=$pageLimit*1;
	$startlimit=$endlimit-$pageLimit;
}
if($startlimit==0) 
    $startlimit=1;
else 
    $startlimit=$startlimit+1;


if($handle = opendir($storiesFolderPath)){
    $k=1;  
	
	$countFileHandle = fopen($storiesFolderPath.'count.txt','r+');
	$fileCount = fread($countFileHandle,filesize($storiesFolderPath.'count.txt'));
    $filesarr = scandir($storiesFolderPath, 0);
	$cnt=count($filesarr);
	for($j=0;$j<$cnt;$j++){
		if($filesarr[$j]!='count.txt' && $filesarr[$j]!='..' && $filesarr[$j]!='.' && $filesarr[$j]!=''){
			$newFileArr[]=$filesarr[$j];
		}
	}
	natcasesort($newFileArr);
	
    $cntt=count($newFileArr);
	foreach($newFileArr as $key=>$value){
		$finalFileArr[$cntt]=$value;
		$cntt--;
	}
	ksort($finalFileArr);
	/*echo "<pre>";
	print_r($finalFileArr);
	echo "</pre>";*/
	
    //while (false !== ($file = readdir($handle))){
	foreach($finalFileArr as $key=>$file){  	
       if($file!='count.txt' && is_file($storiesFolderPath.$file) && (filesize($storiesFolderPath.$file)>5)){
		   if($endlimit>$fileCount){$endlimit=$fileCount;}
           if($k>=$startlimit && $k<=$endlimit){
		   $storiesFilePath=$storiesFolderPath.$file;

		   //Reading Stories File Contents
		   $storiesFileHandle = fopen($storiesFilePath,'r+');
		   $storiesContent = fread($storiesFileHandle,filesize($storiesFilePath));
		   $content_arr=explode('|',$storiesContent);
			
		   $MatriId=$content_arr[0];
		   $Bride_Name=$content_arr[1];
		   $Groom_Name=$content_arr[2];
		   $Success_Message=$content_arr[3];
		   $Marriage_Date=$content_arr[4];
		   $photoShowStatus=$content_arr[5];
		   if(($Success_Message && $Bride_Name && $Groom_Name) || ($Marriage_Date && $Bride_Name && $Groom_Name) || ($Success_Message && $Marriage_Date && $Groom_Name) || ($Success_Message && $Bride_Name && $Marriage_Date)){

           //$Groom_Name=$Groom_Name."--".$file;
		   $smallImgPath=$confValues['IMAGEURL'].'/success/'.$folderName.'/smallphotos/'.$MatriId.'_s.jpg';
		   $bigImgPath=$confValues['IMAGEURL'].'/success/'.$folderName.'/bigphotos/'.$MatriId.'_b.jpg';
		   $NoImgPath=$confValues['IMAGEURL'].'/images/img85_phundval_m.gif';
		   $smallPhotosDir = $varRootBasePath."/www/success/".$folderName."/smallphotos/".$MatriId."_s.jpg";
					   
		   $layout.='<br clear="all"><div class="linesep">
		             <img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="1" /></div>
				     <!--  gallery view started -->
				     <div id="gal1" class="padt10">
					 <div class="smalltxt clr padb10"><b>Bride</b> : <font class="clr1">'.$Bride_Name.'</font>&nbsp;&nbsp;<font class="clr2">|</font>&nbsp;&nbsp;<b>Groom</b> : <font class="clr1">'.$Groom_Name.'</font>&nbsp;&nbsp;<font class="clr2">|</font>&nbsp;&nbsp;<b>Marriage Date</b> : <font class="clr1">'.$Marriage_Date.'</font></div>
					 <div class="dotsep"><img src="'.$confValues['IMGSURL'].'/trans.gif" width="1" height="1" /></div><br clear="all">';
					 					 
                     if(is_file($smallPhotosDir)){
						 if($photoShowStatus==1){
						 $layout.='<div class="fleft brdr" style="width:122px;height:82px;" onmousemove="javascript:showImg(event,'."'".$MatriId."'".');" onmouseout="javascript:hideImg('."'".$MatriId."'".');"><img src="'.$smallImgPath.'" height="80" width="120" alt="" /></div>';

						 $layout.='<div id="imgdiv'.$MatriId.'" style="display:none"><img src="'.$bigImgPath.'"></div>
						 <div class="fleft smalltxt tljust" style="width:360px !important;width:378px;padding-left:15px;">'.$Success_Message.'</div><br clear="all">
						 </div><br clear="all">';
						 }else{
						 $layout.='<div id="imgdiv'.$MatriId.'" style="display:none"><img src="'.$bigImgPath.'"></div><div class="fleft smalltxt tljust" style="width:497px !important;width:497px;padding-left:0px;">'.$Success_Message.'</div><br clear="all">
				     </div><br clear="all">';

						 }
					 }else{
                     // $layout.='<div class="fleft brdr" style="width:122px;height:82px;"><img src="'.$NoImgPath.'" height="80" width="120" alt="" /></div>';
					 $layout.='<div id="imgdiv'.$MatriId.'" style="display:none"><img src="'.$bigImgPath.'"></div>
					 <div class="fleft smalltxt tljust" style="width:497px !important;width:497px;padding-left:0px;">'.$Success_Message.'</div><br clear="all">
				     </div><br clear="all">';
					 }

					 
            
		    }
			
			}
		   $k++;
		}
    }
	if($fileCount){
    $fileCount=$k;
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

<div class="rpanel fleft">
<form name="frm" method="POST">
<input type="hidden" name="indx" id="indx">
	<div class="normtxt1 clr2 padb5 padl"><font class="clr bld">Success Stories</font></div>
	<div class="linesep fright" style="width:550px;"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
	<div class="smalltxt clr2 padt5 fleft padl"><font class="clr bld">Success Story</font>&nbsp;&nbsp;|&nbsp;&nbsp; <a class="clr1" href="/successstory/index.php?act=success">Post Your Success Story</a></div><br clear="all">
	<center>
		<div class="rpanel padt10">
			<center>
			<div class="rpanelinner normtxt clr tljust" style="padding-top:15px;">
				<div><b>Most successful portal for <?=ucfirst($arrDomainInfo[$varDomain][2])?>s world over!</b><br><br>
				<?=$confValues['PRODUCTNAME']?> is the most popular site for <?=ucfirst($arrDomainInfo[$varDomain][2])?>s to connect globally. It is safe and fast for <?=ucfirst($arrDomainInfo[$varDomain][2])?>s to register, search, and find their perfect life partner. At <?=$confValues['PRODUCTNAME']?>, you get a chance to search across over more than 1.1 million active profiles of <?=ucfirst($arrDomainInfo[$varDomain][2])?>s anywhere in the world.</div><br clear="all">
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
				<!--Pagination function calling -->
				<?php navigate($PagingUrl,$fileCount,$indx,$pageLimit); ?>

                <!--  gallery view Started -->
				<?php if($startlimit>$fileCount){echo "<center><font class='clr1'>No Galleries Found !</font>";}else{ echo $layout;}?>
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
				<!--  gallery view ended -->

                <!--Pagination function calling -->
				<?php navigate($PagingUrl,$fileCount,$indx,$pageLimit); ?>
				<br clear="all">
			</div>
			</center>
		</div>
	</center>
	</form>
</div>
<?php

//Pagination Function
function navigate($url,$totalrecords,$indx,$list_length='') 
  {
      
      if($list_length) 
          $indxsettings = $list_length;
      else 
          $indxsettings = 10;
            
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

      // setting next and Previous Links 
	  if($totalrecords){
      if ($startindx >$displaylinks ) {
            $page= $startindx-($displaylinks+1);
                  echo '<div class="prevact" onclick="javascript:setNavigation('."'".$url."'".','.$page.');"> < </div><div class="spacing">&nbsp;</div>';
      }else{
		          echo '<div class="previnact"> < </div><div class="spacing">&nbsp;</div>';
	  }
	  }
      // setting current link
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
	  if($totalrecords){
      if ($totallinks >$endindex ) {
            $page= $endindex;
            echo '<div class="nextact" onclick="javascript:setNavigation('."'".$url."'".','.$page.');"> > </div>';
      }else{
			echo '<div class="nextinact"> > </div>';
	  }
	  }
            echo '</div></div>';
  }
  ?>