<?php
$varRootBasePath = '/home/product/community/ability';
include_once($varRootBasePath."/www/admin/includes/config.php");
include_once($varRootBasePath."/conf/dbinfo.inc");
include_once($varRootBasePath."/lib/clsDB.php");

$email=$_GET['email'];

if($adminUserName == '') {
  header("Location: index.php?act=login");
}

if($email) {
  $objDBSlave			= new DB;
  $objDBSlave->dbConnect('S',$varDbInfo['DATABASE']);
  if(!$objDBSlave->clsErrorCode) {
	 $argFields		=     array('MatriId','Email');
     $argCondition	    = " WHERE Email = '".$email."'";
     $varExecute1		= $objDBSlave->select($varTable['MEMBERLOGININFO'], $argFields, $argCondition,0);
	 echo '<link rel=stylesheet href='.$confValues['CSSPATH'].'/global-style.css>';
	 ?>
	 <table border="0" cellpadding="0" cellspacing="0" align="center" WIDTH="400">
	    <caption><label class="heading"><?php echo "Total Count =     </label><label class=smalltxt>".mysql_num_rows($varExecute1); ?></label></caption>
		<tr align="left"><th class="heading">Matri Id</th><th class="heading" >Email</th><th class="heading" >Gender</th></tr>
	    <tr><td height="10" colspan="3"></td></tr>
	 <?php
	   $varIndex=1;
       while($varIndex <= 20) {
		 $varUserInfo = mysql_fetch_assoc($varExecute1);
         $argFields		=     array('Gender');
         $argCondition	    = " WHERE MatriId = '".$varUserInfo['MatriId']."'";
         $varExecute2		= $objDBSlave->select($varTable['MEMBERINFO'], $argFields, $argCondition,1);
		 echo '<tr class="smalltxt" style="padding-left:15px;_padding-left:15px;"><td>'.$varUserInfo['MatriId'].'</td><td>'.(($varExecute2[0]['Gender']==2)?"Female":"Male").'</td><td>'.$varUserInfo['Email'].'</td></tr>';
		 echo '<tr><td height="10" colspan="3"></td></tr>';$varIndex++;
	   }
	   echo '<tr><td height="10" colspan="3"></td></tr>';
	   echo '<tr><td align=middle colspan=2><input type=submit class=button value=Close onClick=javascript:self.close();></td></tr></table>';
  }
  else {
   echo $objDBSlave->clsErrorCode;
  }
}


?>