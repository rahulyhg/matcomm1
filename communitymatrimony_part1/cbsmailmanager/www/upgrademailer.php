<?php

error_reporting(0);

//$emailArr=file("bmloginremainder.dat");
$domin_arr = array(7=>"B",6=>"R",5=>"G",8=>"P",10=>"H",9=>"S",4=>"K",3=>"E",2=>"T",1=>"M",14=>"D",12=>"C",13=>"A",11=>"Y",15=>"U");

$domain['H'] = 'hindimatrimony';
$domain['A'] = 'assamesematrimony';
$domain['C'] = 'parsimatrimony';
$domain['Y'] = 'oriyamatrimony';
$domain['S'] = 'sindhimatrimony';
$domain['P'] = 'punjabimatrimony';
$domain['G'] = 'gujaratimatrimony';
$domain['R'] = 'marathimatrimony';
$domain['B'] = 'bengalimatrimony';
$domain['D'] = 'marwadimatrimony';
$domain['U'] = 'urdumatrimony';
$domain['M'] = 'tamilmatrimony';
$domain['T'] = 'telugumatrimony';
$domain['E'] = 'keralamatrimony';
$domain['K'] = 'kannadamatrimony';


$emailArr=file("emailadd.dat");
$total=0;
$insertCnt=0;

while(list($ind,$val)=each($emailArr))
{

        if($ind>=0)
        {
        $total=$total+1;
        if($total >= 0)
        {

				$cont = explode("~", $val);
				$to=trim($cont[0]);
				$MatriId=trim($cont[1]);
				$dom=$MatriId[0];
				

				if($to != ""){
					
					$TO = trim($cont[0]);
					
					$SUBJECT = "Special Membership Offer only for 2 days.Hurry&Upgrade!";
				 
    $MSG='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>bharatmatrimony.com</TITLE>
</HEAD>
<BODY>
<table border="0" cellpadding="0" cellspacing="0" width="548" style="border: 1px solid #24903A">
<tr><td vAlign=top background="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-model.jpg" WIDTH="176" HEIGHT="717" BORDER="0" ALT=""><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="176" HEIGHT="1" BORDER="0" ALT=""></td>
	<td background="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-bord.jpg" WIDTH="372" HEIGHT="717" BORDER="0" ALT="">
	<table border="0" cellpadding="0" cellspacing="0">
	<tr><td style="padding:90px 0px 0px 30px;">
		<table border="0" cellpadding="0" cellspacing="0" width="293">
		
		<tr><td vAlign=top><img src="http://imgs.bharatmatrimony.com/bmimages/bharat-logo.gif" width="200" height="80" border="0" alt=""><br />
		
		
		<font align=right><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-line.gif" WIDTH="293" HEIGHT="1" BORDER="0" ALT=""><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="10" BORDER="0" ALT=""><br /><font  style="font-family:impact;font-size:23px;color:#FE7313;padding-left:220px;">Special<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="155" HEIGHT="1" BORDER="0" ALT=""> Upgrade Offer</font><br /><font  style="font : bold 18px tahoma;color:#24903A;line-height:20px;padding-left:119px;">Exclusively for you.</font><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="16" BORDER="0" ALT=""><br /><font style="font-family:verdana;font-size:11px;color:#FE7313;padding-left:46px;"><B>Offer available on 6th & 7th May only!</B></font><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="8" BORDER="0" ALT=""><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-line.gif" WIDTH="293" HEIGHT="1" BORDER="0" ALT=""></font>
		
		
		
		
		<font align=justify style="font-family:verdana;font-size:11px;">Dear Member '.$MatriId.',<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="16" BORDER="0" ALT=""><br />As you are a regular member on our site, we specially created this offer just to help you find your life partner.<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="10" BORDER="0" ALT=""><br /><font style="font-family:verdana;font-size:11px;color:#FE7313"><B>Get a FREE upgrade:</B></font><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="7" BORDER="0" ALT=""><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-round.gif" WIDTH="11" HEIGHT="12" BORDER="0" ALT="" align="absmiddle"><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="5" HEIGHT="1" BORDER="0" ALT=""><B>Classic Super</B> at the rate of a <B>Classic Plus</B><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="5" BORDER="0" ALT=""><br />
<IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-round.gif" WIDTH="11" HEIGHT="12" BORDER="0" ALT="" align="absmiddle"><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif" WIDTH="5" HEIGHT="1" BORDER="0" ALT="">Or get <B>Classic Plus</B> at the rate of <B>Classic</B> <br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif" WIDTH="1" HEIGHT="16" BORDER="0" ALT=""><br /><font style="font-family:verdana;font-size:11px;color:#FE7313"><B>As a paid member you can:</B></font>		
		<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="7" BORDER="0" ALT=""><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-round.gif" WIDTH="11" HEIGHT="12" BORDER="0" ALT="" align="absmiddle"><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="5" HEIGHT="1" BORDER="0" ALT="">Access verified phone numbers		
		<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="5" BORDER="0" ALT=""><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-round.gif" WIDTH="11" HEIGHT="12" BORDER="0" ALT="" align="absmiddle"><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="5" HEIGHT="1" BORDER="0" ALT="">Send and receive personalised e-mail messages		
		<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="5" BORDER="0" ALT=""><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-round.gif" WIDTH="11" HEIGHT="12" BORDER="0" ALT="" align="absmiddle"><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="5" HEIGHT="1" BORDER="0" ALT="">Chat with prospects		
		<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="5" BORDER="0" ALT=""><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-round.gif" WIDTH="11" HEIGHT="12" BORDER="0" ALT="" align="absmiddle"><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="5" HEIGHT="1" BORDER="0" ALT="">Participate in online matrimony meets for free<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="5" BORDER="0" ALT=""><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="15" HEIGHT="1" BORDER="0" ALT="">And so much more benefits…		
		<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="15" BORDER="0" ALT=""><br />So what are you waiting for? Let money not be the constraint in helping you find the perfect match.<br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="1" HEIGHT="15" BORDER="0" ALT=""><br /><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif"" WIDTH="10" HEIGHT="1" BORDER="0" ALT=""><A HREF="http://www.'.$domain[$dom].'.com/paymentoptions.shtml?WT.mc_id=Bm-10_per_dis_payment-may5th2008&WT.mc_ev=clickthrough"><IMG SRC="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-button.gif" WIDTH="266" HEIGHT="35" BORDER="0" ALT=""></a></font></td></tr>		
		</table>
		</td></tr></table>
	</td>
</tr>
<tr><td colspan="2" background="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-sites.jpg" WIDTH="548" HEIGHT="98" BORDER="0" ALT="">
<center><table border="0" cellspacing="0" cellpadding="0" width="500" >	<tr><td height="15"></td></tr>
						<tr><td valign="top"  WIDTH="500" HEIGHT="70" BORDER="0" ALT="" style="background-repeat:no-repeat; font:normal 11px verdana;padding-top:5px;"><center><font style="font-weight:bold;color:#8A8A8A;">Our Group Portals</font></center><BR><center><A HREF="http://www.clickjobs.com" style="text-decoration:none;" target="_blank"><font style="font:normal 11px verdana;color:#BF2228;">Click</font><font style="font:normal 11px verdana;color:#336699;">Jobs.com</font></A> <font color="#333333">|</font> <A HREF="http://www.indiaproperty.com" style="text-decoration:none;" target="_blank"><font style="font:normal 11px verdana;color:#0077BA;">India</font><font style="font:normal 11px verdana;color:#019B53;">Property.com</font></a> <font color="#333333">|</font> <A HREF="http://www.indiaautomobile.com" style="text-decoration:none;" target="_blank"><font style="font:normal 11px verdana;color:#E1242B;"> India</font><font style="font:normal 11px verdana;color:#006DB4;">Automobile.com</font></a><br><img src="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif" width="1" height="7"><br><A HREF="http://www.indialist.com" style="text-decoration:none;" target="_blank"><font style="font:normal 11px verdana;color:#55529E;">India</font><font style="font:normal 11px verdana;color:#36AD77;">List.com</font></a> <font color="#333333">|</font> <A HREF="http://www.indiapages.com" style="text-decoration:none;" target="_blank"><font style="font:normal 11px verdana;color:#F8AB02;">India</font><font style="font:normal 11px verdana;color:#565656;">Pages.com</font></a> <font color="#333333">|</font> <A HREF="http://www.loanwala.com" style="text-decoration:none;" target="_blank"><font style="font:normal 11px verdana;color:#005EBF;">Loan</font><font style="font:normal 11px verdana;color:#FF0000;">Wala.com</font></a></center></td></tr>
						</table></center>
</td></tr>
<tr><td colspan="2" vAlign=top background="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/may08/offer/discount-bottom.jpg" WIDTH="548" HEIGHT="173" BORDER="0" ALT="">

<center><table border="0" cellpadding="0" cellspacing="0" width="510" valign="top" align="center">
		<tr>
		<td valign="top" style="padding-left:30px;padding-bottom:15px;padding-top:10px; padding-right:5px;font: normal 10px verdana;color:#A9A9A9;border-right:1px solid #C9C9C9;" >
		Leader in the Online Matrimony Category. 2007 Study<br><img src="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif" width="1" height="30" border="0" alt=""><br><img src="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/mail-juxtconsult.gif" width="95" height="29" border="0" alt=""> </td>
		<td valign="top"  width="120" style="padding-left:10px;padding-right:10px;padding-bottom:15px;padding-top:10px;font: normal 10px verdana;color:#A9A9A9;border-right:1px solid #C9C9C9;">
		In the Limca Book of Records for record number of documented marriages online<br><img src="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif" width="1" height="15" border="0" alt=""><br><center><img src="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/mail-limca-recicon-bot.gif" width="62" height="62" border="0" alt=""></center> </td>
		<td valign="top" style="padding-left:10px;padding-right:20px;padding-bottom:15px;padding-top:10px;font: normal 10px verdana;color:#A9A9A9;border-right:1px solid #C9C9C9;" >The Best Indian Matrimony Website 2007<br><img src="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif" width="1" height="50" border="0" alt=""><br><img src="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/mail-pc-world.gif" width="94" height="28" border="0" alt=""></td>
		<td valign="top" style="padding-left:10px;padding-right:30px;padding-bottom:15px;padding-top:10px;font: normal 10px verdana;color:#A9A9A9;" >The most visited Matrimony portal in the world<br><img src="http://imgs.bharatmatrimony.com/bmimages/mailers/images/trans.gif" width="1" height="20" border="0" alt=""><br><img src="http://imgs.bharatmatrimony.com/bmimages/mailers/internal/mail-alexa-trafic.gif" width="79" height="44" border="0" alt=""></td>	
		</tr>
		</table></center>
</td></tr>
</table>
<table cellpadding="0" cellspacing="0" width="540">
	<tr><td valign="top" style="padding:3px;" bgcolor="#FFFFFF"><img src="http://img.<<DOMAIN>>.com/images/trans.gif?WT.mc_id=Bm-10_per_dis-may5th2008&WT.mc_ev=openrate" width="1" height="1" border="0" alt=""><p style="margin:0px; text-align:justify;"><font STYLE="font-family: Arial, MS Sans serif, Arial, Verdana, Helvetica; font-size: 9px; font-style: normal; text-align: justify; text-transform: none; color: #A6A6A6;">You are a BharatMatrimony.com Member. This email comes to you in accordance with BharatMatrimony.com\'s Privacy Policy. <a href="http://mailer.bharatmatrimony.com/unsubscribe.php?eid=<<EMAIL>>&catg=MU"><font color="#A6A6A6">Click here</font></a> to unsubscribe. BharatMatrimony.com is not responsible for content other than its own and makes no warranties or guarantees about the products or services that are advertised.</td></tr>
</table>
</BODY>
</HTML>
';

        $HEADERS = "MIME-Version: 1.0\n";
        $HEADERS .= "Content-type: text/html; charset=iso-8859-1\n";
        $HEADERS .= "From: info@bharatmatrimony.com <info@bharatmatrimony.com>\n";
		$HEADERS .= "Reply-To: payment@bharatmatrimony.com\n";
		echo $TO."--";
	 if(mail($TO,$SUBJECT,$MSG,$HEADERS))
					{
			 echo "mail sent";
					}
					else
					{ echo "mail not sent";}
/*echo "\nSending...";
sleep(10); //sleep for every 1000 records.*/
  //$insertCnt=0;
        }//end if counter
        }
}

}
echo "BM MAILER...".$total;
?>
