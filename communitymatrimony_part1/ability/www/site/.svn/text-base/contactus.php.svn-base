<?php
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.inc');
?>
<script language="javascript">

function showdivs(divid,link,pref)
{
	var i;
	var divid1,link1;
	var cl="",cl1="";
	for(i=1;i<=18;i++)
	{
		if(pref=="sc"){divid1="cdv"+i;link1="clk"+i;cl="clr bld";cl1="clr1";}
		else if(pref=="sa"){divid1="dv"+i;link1="lk"+i;cl="smalltxt clr bld";cl1="smalltxt clr1";}
		if(link==link1){document.getElementById(divid1).style.display="block";document.getElementById(link1).className=cl;}
		else {
				if(document.getElementById(divid1))
					{document.getElementById(divid1).style.display="none";}
				if(document.getElementById(link1))
					{document.getElementById(link1).className=cl1;}
		     }
	}

	if(document.getElementById('corpdiv')){hidediv('corpdiv');imgdisp('plus');}

	if(pref=='sa')
	{document.getElementById('tfree').innerHTML="Toll Free No. 1-800-3000-2222 ( India ).";}
	else {document.getElementById('tfree').innerHTML="+91-44-39115022.";}

}

function imgdisp(iname)
{
	if(iname=='plus')
		{document.getElementById('iconp').style.display='block';
		 document.getElementById('iconm').style.display='none';
	    }
	else {document.getElementById('iconm').style.display='block';
		  document.getElementById('iconp').style.display='none';	
		}
}
</script>
<style type="text/css">
.divbox{width:108px !important;width:120px;border:1px solid #cbcbcb;padding:3px 5px;background-color:#efefef;text-align:center;}
</style>
<div class="rpanel fleft">
	<div class="normtxt1 clr2 padb5"><font class="clr bld">Contact Us</font></div>
	<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div><br clear="all">
    <div class="padt10">
		<div class="normtxt clr lh20">
			<div class="tlleft"><a id="clk1" class="clr bld" onclick="showdivs('cdv1','clk1','sc');showdivs('dv1','lk1','sa');">INDIA</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="clk5" class="clr1" onclick="showdivs('cdv5','clk5','sc');">SINGAPORE</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="clk6" class="clr1" onclick="showdivs('cdv6','clk6','sc');">MALAYSIA</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="clk2" class="clr1" onclick="showdivs('cdv2','clk2','sc');">USA</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="clk3" class="clr1" onclick="showdivs('cdv3','clk3','sc');">UAE</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="clk4" class="clr1" onclick="showdivs('cdv4','clk4','sc');">AUSTRALIA</a><? if ($confValues["DOMAINCASTEID"]=='2503') { ?>&nbsp;&nbsp;&nbsp;&nbsp;<a id="clk7" class="clr1" onclick="showdivs('cdv7','clk7','sc');">BANGLADESH</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="clk8" class="clr1" onclick="showdivs('cdv8','clk8','sc');">PAKISTAN</a><?}?></div><br clear="all">
			<div class="content">You may call us or walk into any of our office to make payments or for any other assistance related to your partner search.
				<br clear="all">
				<br clear="all">
			<div id="cdv1" class="disblk" >
				<div class="divbox fleft"><a class="smalltxt clr1" id="lk1" onclick="showdivs('dv1','lk1','sa');">Andhra Pradesh</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk2" onclick="showdivs('dv2','lk2','sa');">Delhi</a></div><div class="fleft">&nbsp;&nbsp;</div>
				<div class="divbox fleft" style="display:none;"><a class="smalltxt clr1" id="lk3" onclick="showdivs('dv3','lk3','sa');">Goa</a></div><div class="divbox fleft"><a class="smalltxt clr1" id="lk4" onclick="showdivs('dv4','lk4','sa');">Gujarat</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft disnon"><a class="smalltxt clr1" id="lk5" onclick="showdivs('dv5','lk5','sa');">Haryana</a></div><div class="fleft disnon">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk18" onclick="showdivs('dv18','lk18','sa');">Jharkhand</a></div><div class="fleft">&nbsp;&nbsp;</div><br clear="all"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" /><br><div class="divbox fleft"><a class="smalltxt clr1" id="lk6" onclick="showdivs('dv6','lk6','sa');">Karnataka</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk7" onclick="showdivs('dv7','lk7','sa');">Kerala</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk8" onclick="showdivs('dv8','lk8','sa');">Madhya Pradesh</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk9" onclick="showdivs('dv9','lk9','sa');">Maharashtra</a></div><br clear="all"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" /><br><div class="divbox fleft"><a class="smalltxt clr1" id="lk10" onclick="showdivs('dv10','lk10','sa');">Orissa</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk11" onclick="showdivs('dv11','lk11','sa');">Pondicherry</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk12" onclick="showdivs('dv12','lk12','sa');">Punjab</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk13" onclick="showdivs('dv13','lk13','sa');">Rajasthan</a></div><br clear="all"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" /><br><div class="divbox fleft"><a class="smalltxt clr1" id="lk14" onclick="showdivs('dv14','lk14','sa');">TamilNadu</a></div><div class="fleft">&nbsp;&nbsp;</div>
				<div class="divbox fleft"><a class="smalltxt clr1" id="lk15" onclick="showdivs('dv15','lk15','sa');">Uttarakhand</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk16" onclick="showdivs('dv16','lk16','sa');">Uttar Pradesh</a></div><div class="fleft">&nbsp;&nbsp;</div><div class="divbox fleft"><a class="smalltxt clr1" id="lk17" onclick="showdivs('dv17','lk17','sa');">West Bengal</a></div><br clear="all"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="5" /><br>

				<div id="dv1" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv1');" class="pntr" /></div>
					<font class="normtxt1"><b>Andhra Pradesh</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Bhimavaram</b><br>
					Door No. 3-6-3, Town Railway Station Road,<br>
					Bhimavaram, West Godavari Distt 534202<br>
                    Phone: 08816 - 322523.<br>
					Email: <a href="mailto:bhimavaram@communitymatrimony.com" class="clr1">bhimavaram@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Guntur</b><br>
					Shop No: 6-14/34/1, New No: 123,<br>
					14th Line, Arundelpet Main Road,<br>
					Land Mark : Opp to kalanikathan.<br>
					Guntur - 522002.<br>
					Telephone: 0863 - 3243561.<br>
					Email: <a href="mailto:guntur@communitymatrimony.com" class="clr1">guntur@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Gajuwaka</b><br>
					Shop# 10-8-56, Ground Floor,<br>
					GBR Complex,<br>
					Land Mark : Near Fruirt Market, <br>
					Main Road , Gajuwaka - 1.<br>
					Visakhapatnam - 530 026.<br>
					Telephone: 0891-3260665.<br>
					Email: <a href="mailto:gajuwaka@communitymatrimony.com" class="clr1">gajuwaka@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Hyderabad</b><br>
					
					6-3-456/A/20, Ground Floor,<br />
					MARUTHI GRANDEUR, Besides Model House,<br />
					Dwarakapuri Colony, Punjagutta,<br />
					Hyderabad - 500082.<br />
					Telephone: 040 - 60603333, 040 - 60600291, 040 - 31003025.<br><br />

					Shop No 39/ B, Mahaboob Mansion,<br>
					Malakpet Gung, Srikrupa Market,<br>
					Land Mark : Opp. Orange Chevrolet Car Show Room<br>
					Malakpet, Hyderabad - 500036.<br>
					Telephone: 040 - 31003068.<br>
					Email: <a href="mailto:malkpet@communitymatrimony.com " class="clr1">malkpet@communitymatrimony.com</a><br><br />

					LG-3A, Lower Ground Floor, Maheshwari Mekins Meyank Plaza, <br>
					MCH NO. 6-3-866/A, Greenlands (Begumpet - Ameerpet Road ),<br>
					Hyderabad - 500 016.<br>
					Telephone: 040 - 31003070.<br>
					Email: <a href="mailto:hyderabad@communitymatrimony.com" class="clr1">hyderabad@communitymatrimony.com</a><br><br />
                    Shop No 12/A-1, Kalyan plaza,<br />
                    Near Sharada Theater Bus Stop,<br />
                    Land Mark : Opp. Hyderabad House, AS Rao Nagar Main Road,<br />
                    Hyderabad - 500094.<br />
                    Telephone: 040 - 42402274 / 31002986 / 31002987.<br>
                    Email: <a href="mailto:asraonagar@communitymatrimony.com" class="clr1">asraonagar@communitymatrimony.com </a><br><br />
					3-6-269, Ground Floor - 1<br />
					Hyderguda Road,<br />
					Land Mark : Diagonally Opp. Telugu Academy,<br />
					Besides ICICI Bank, Himayath Nagar.<br />
					Hyderabad - 500029.<br />
					Telephone: 040 - 31003098.<br>
					Email: <a href="mailto:himayathnagar@communitymatrimony.com" class="clr1">himayathnagar@communitymatrimony.com</a><br>
					
					</div>
					<div class="padt10"><b>Kadapa</b><br>
					D.No:2/403, Opp:CSI Central Church,<br>
					RS Road,Kadapa, Andhra Pradesh - 516001.<br>
                    Telephone: 08562 - 329235.<br>
                    Email: <a href="mailto:kadapa@communitymatrimony.com" class="clr1">kadapa@communitymatrimony.com</a><br>
                    </div>
					<div class="padt10"><b>Kakinada </b><br>
					Door No. 28-1-42, Main Road, Maszid Centre,<br>
					Land Mark : Besides Kotttaiah Sweets,<br>
					Kakinada - 533001.<br>
                    Telephone: 0884 - 3206647.<br>
                    Email: <a href="mailto:kakinada@communitymatrimony.com" class="clr1">kakinada@communitymatrimony.com</a><br>
                    </div>
                    <div class="padt10"><b>Kurnool</b><br>
					Door No. 40/437, Eswar Nagar,<br>
					Below State Bank Of India, Old Town Branch<br>
					Kurnool - 518001.<br>
                    Telephone: 08518 - 316489.<br>
                    Email: <a href="mailto:kurnool@communitymatrimony.com" class="clr1">kurnool@communitymatrimony.com</a><br>
                    </div>
                    <div class="padt10"><b>Karimnagar</b><br>
					Door No. 2-7-745, Opp Arts college,<br>
					Bus stand Road, Karimnagar - 505001.<br>
                    Telephone: 0878 - 3203398.<br>
                    Email: <a href="mailto:karimnagar@communitymatrimony.com" class="clr1">karimnagar@communitymatrimony.com</a><br>
                    </div>
                    <div class="padt10"><b>Rajahmundry</b><br>
					Door No. 46-12-23/2,<br>
					Opp. State Bank Of India Regional Business Office,<br>
					Danvaipeta, Rajahmundry -  533103.<br>
                    Telephone: 0883 - 3244706.<br>
                    Email: <a href="mailto:rajahmundry@communitymatrimony.com" class="clr1">rajahmundry@communitymatrimony.com</a><br>
                    </div>
					<div class="padt10"><b>Nizamabad</b><br>
					Shop No. 37, Khaleelwadi Sports Complex,<br>
					Station Road, Nizamabad (AP) 503001<br>
                    Telephone: 08462 - 312645.<br>
                    Email: <a href="mailto:nizamabad@communitymatrimony.com" class="clr1">nizamabad@communitymatrimony.com</a><br>
                    </div>
					<div class="padt10"><b>Vijayawada</b><br>
					Door #40-7-27, Donka Road,<br>
					Moghulrajpuram,<br>
					Land Mark: Near Jammi Chettu Centre,<br>
					Vijayawada - 520012<br>
					Telephone : 0866 - 3244392.<br>
					Email: <a href="mailto:vijayawada@communitymatrimony.com" class="clr1">vijayawada@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Vishakapatnam</b><br>
					Shop #1, Founta Plaza Shopping Complex<br>
					Door No. 30-15-189,<Br>
					Land Mark: Opp. Dolphin Gardens & Old Saraswathi Theatre<br>
					Suryabagh Junction, Visakhapatnam - 530020<br>
					Telephone: 0891 - 3260659.<br>
					Email: <a href="mailto:jagadamba@communitymatrimony.com" class="clr1">jagadamba@communitymatrimony.com</a><br><br>
					D.No:47-11-18/19, Flat No:4, 4th Floor, G.K.Towers, Dwarakanagar.<br> Opp:Kalaniketan, Visakhapatnam - 530016.<br>
					Telephone: 0891 - 60603333.<br>
					Email: <a href="mailto:visakhapatnam@communitymatrimony.com" class="clr1">visakhapatnam@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Tirupathi</b><br>
					20-1-136/D Maruthi Nagar<br>
					Kurlagunta Junction, Tirumala Bypass Road,<br>
					Tirupathi - 517501.<br>
					Telephone: 0877 - 3245864.<br>
					Email: <a href="mailto:tirupathi@communitymatrimony.com" class="clr1">tirupathi@communitymatrimony.com</a><br></div>
                    <div class="padt10"><b>Warangal</b><br>
					Door No. 2-5-617/1, Main Road,<br>
					Near Royal Function Hall, Subedari,<br>
					Hanamkonda, Warangal - 506001<br>
					Telephone: 0870 - 3195544.<br>
					Email: <a href="mailto:warangal@communitymatrimony.com" class="clr1">warangal@communitymatrimony.com  </a><br></div>

				</div>

				<div id="dv2" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv2');" class="pntr" /></div>
					<font class="normtxt1"><b>Delhi</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10">
					A-26/2, 1st Floor,<br>
					Mohan Cooperative Industrial Estate,<br>
					Mathura Road,<br>
					New Delhi - 110044.<br>
					Telephone: 011 - 32311103.<br>
					Email: <a href="mailto:delhi@communitymatrimony.com" class="clr1">delhi@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv3" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv3');" class="pntr" /></div>
					<font class="normtxt1"><b>Goa</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10">
					Shop No.71,First Floor, Alfran Plaza, Near Don Bosco School, <br>
					M.G. Road, Panaji, Goa.<br>
					Telephone: 0832 - 3269741.<br>
					Email: <a href="mailto:goa@communitymatrimony.com" class="clr1">goa@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv4" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv4');" class="pntr" /></div>
					<font class="normtxt1"><b>Gujarat</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Ahmedabad</b><br>
					No: 2/8, Gandhi Park Society, Opp Royal Enfield, Nr. Sahjanand College,<br>
					Nehurangar, Ahmedabad - 380 015.<br>
					Telephone: 079 - 32457475.<br>
					Email: <a href="mailto:ahmedabad@communitymatrimony.com" class="clr1">ahmedabad@communitymatrimony.com</a><br><br>
					Shop No. 4, Arth Complex, Next to Seema Hall,<br>
					Anandnagar Road, Satellite,<br>Ahmedabad - 380015<br>
					Telephone: 079 - 32457477.<br>
					Email: <a href="mailto:satellite@communitymatrimony.com" class="clr1">satellite@communitymatrimony.com</a><br>
					</div>
					<div class="padt10"><b>Bhavnagar</b><br>
					205-206, Hans Complex,<br />
                    Opp. Dipak Hall,<br />Sanskar Mandal Chowk,<br>
					Bhavnagar - 364001.<br>
					Telephone: 0278-3201275.<br>
                    Email: <a href="mailto:bhavnagar@communitymatrimony.com" class="clr1">bhavnagar@communitymatrimony.com</a><br>
                    </div>
					<div class="padt10"><b>Gandhidham</b><br>
					Shop No. 27&28, Aum Complex,<br />
                    Plot No. 336, 337, Ward 12/B,<br /> Opp: AXIS BANK,<br>
					Gandhidham - 370201.<br>
					Telephone: 028 - 36313027.<br>
                    Email: <a href="mailto:gandhidham@communitymatrimony.com" class="clr1">gandhidham@communitymatrimony.com</a><br>
                    </div>
                    <div class="padt10"><b>Jamnagar</b><br>
                    Venus Apartment, Shop No. 22<br />
                    Opp : Jain Pravashi Gruh ,<br>
                    Opp: Madhav Plaza, Lal Bunglow Road,<br />
                    Jamnagar - 361001<br>
                    Telephone: 0288 - 3211712.<br>
                    Email: <a href="mailto:jamnagar@communitymatrimony.com" class="clr1">jamnagar@communitymatrimony.com</a><br>
                    </div>
					<div class="padt10"><b>Mani Nagar</b><br>
                    Shop No. 2, Ground Floor, J. K. Plaza,<br />
                    Opp. Kissan Complex,<br />
					Mani Nagar Cross Roads,<br>
                    Mani Nagar, Ahmadabad - 380008.<br />
                    Telephone: 079-2457523.<br>
                    Email: <a href="mailto:maninagar@communitymatrimony.com" class="clr1">maninagar@communitymatrimony.com</a><br>
                    </div>
					<div class="padt10"><b>Mehesana</b><br>
                    Shop No:1, Ambizone complex,<br />
                    Opposite to Hari Nagar Society,<br />
					Near Modhera Cross Road,<br>
                    Mehesana - 384002.<br />
                    Telephone: 02762 - 311861.<br>
                    Email: <a href="mailto:mehesana@communitymatrimony.com" class="clr1">mehesana@communitymatrimony.com</a><br>
                    </div>
					<div class="padt10"><b>Rajkot</b><br>
					Abhayam Building, Chudasama Plot main Road, <br>
					Near Amrapali Railway Crossing, Rajkot - 360001.<br>
					Telephone: 0281 - 60603333.<br>
					Email: <a href="mailto:rajkot@communitymatrimony.com" class="clr1">rajkot@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Surat</b><br>
					2-3, Bhagwati Ashish Complex, City Light Main Road,<br>
					Opp Ashok Pan, City Light, Surat - 395002.<br>
					Telephone: 0261 - 3111032.<br>
					Email: <a href="mailto:surat@communitymatrimony.com" class="clr1">surat@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Vadodara</b><br>
					SB-30, "Windsor Plaza", R C Dutt Road,<br>
					Alkapuri, Baroda -390007.<br>
					Telephone: 0265 - 3264304.<br>
					Email: <a href="mailto:vadodara@communitymatrimony.com" class="clr1">vadodara@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv5" class="normtxt disnon brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv5');" class="pntr" /></div>
					<font class="normtxt1"><b>Haryana</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10">
					SCO No.2, Ankush Chambers, Opp. Dayal Singh College, Karnal - 132001.<br>
					Telephone: 0184 - 60603333.<br>
					Email: <a href="mailto:karnal@communitymatrimony.com" class="clr1">karnal@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv18" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv18');" class="pntr" /></div>
					<font class="normtxt1"><b>Jharkhand</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10">
					UG-13, SRI RAM PLAZA, BANK MORE, DHANBAD-826001.<br>
					Telephone: 9304821025, 9234302749, 0326-3242009.<br>
					Email: <a href="mailto:jharkhand@communitymatrimony.com" class="clr1">jharkhand@communitymatrimony.com</a><br></div>
				</div>	

				<div id="dv6" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv6');" class="pntr" /></div>
					<font class="normtxt1"><b>Karnataka</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Bangalore</b><br>
					Chandana  Buliding, No.13, Intermediate Ring Road,<br>
					Eji Pura Junction, Koramangala, Banglore - 5600047. <br />
					LM - Between HDFC Bank & Shelton Royal Hotel.<br>
					Telephone: 080 - 32557941.<br>
					Email: <a href="mailto:bangalore@communitymatrimony.com" class="clr1">bangalore@communitymatrimony.com</a><br>										
					</div>
					<div class="padt10"><b>Belgaum</b><br>
					No.3442,Ground Floor, Sulake Towers, Eastend Portion,<br>
					Samadevigalli Street, OPP to IDBI Bank, Belgaum 590002.<br>
					Telephone: 0831 - 3246684.<br>
					Email: <a href="mailto:belgaum@communitymatrimony.com" class="clr1">belgaum@communitymatrimony.com</a><br><br>
					Door No. 6, Ground Floor,<br>
					Swastik Chambers, Opp: Vanita Vidhyalaya, College Road, Belgaum 590001.<br>
					Telephone: 0831 - 3246684.<br>
					Email: <a href="mailto:belgaum@communitymatrimony.com" class="clr1">belgaum@communitymatrimony.com</a><br>					
					</div>

					<div class="padt10"><b>BTM Layout</b><br>
					Door No 76/1, 100ft, Ring Road,<br>
					Near Reliance Store, BTMLayout 2nd Stage,<br>
					Vysya Bank Colony, Bangalore - 560076.<br>
					Telephone: 080 - 32558074.<br>
					Email: <a href="mailto:btmlayout@communitymatrimony.com" class="clr1">btmlayout@communitymatrimony.com</a><br></div>

					<div class="padt10"><b>Davanagare</b><br>
					Ground Floor, Vasavi Bhavan,<br>
					Opp: Urban Bank, Pune Bangalore Road,<br>
					Near Gandhi Circle, Davanagare - 577002.<br>
					Telephone: 08192 - 310710.<br>
					Email: <a href="mailto:devangere@bharatmatrimony.com" class="clr1">devangere@bharatmatrimony.com</a><br></div>

					<div class="padt10"><b>HSR Layout</b><br>
					Site No14, Hosur Sarjapur Layout,<br>
					Sector-1(BDA), Bellandur, Bangalore - 560102.<br>
					Land Mark : Opp to meenakshi classic apartments  &amp; next to corporation bank<br>
					Telephone: 080 - 32557965.<br>
					Email: <a href="mailto:hsrlayout@comunitymatrimony.com" class="clr1">hsrlayout@comunitymatrimony.com</a><br></div>

					<div class="padt10"><b>JayaNagar</b><br>
					29-A, 1st Floor, 9th Main,<br>
					Jayanagar, 4th block,<br>
					LandMark: Janata Bazaar jayanagar 4th block complex,<br>
					Bangalore - 560011<br>
					Telephone: 080 - 32557962.<br>
					Email: <a href="mailto:jayanagar@communitymatrimony.com" class="clr1">jayanagar@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Mysore</b><br>
					9/2 (New L - 350), 1st floor, Silver Tower Opp. Clock Tower,<br>
					Ashoka Road, Mysore - 570001.<br>
					Telephone: 0821 - 60603333.<br>
					Email: <a href="mailto:mysore@communitymatrimony.com" class="clr1">mysore@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Malleswaram</b><br>
					Shop No 280/1, Anniamma Arcade,<br>
					Near Sampiege Road, 18th Cross Traffic Signal,<br>
					Malleswaram, Bangalore-560003.<br>
					Telephone: 080 - 32557955.<br>
					Email: <a href="mailto:malleshwaram@communitymatrimony.com" class="clr1">malleshwaram@communitymatrimony.com</a><br></div>

					<div class="padt10"><b>Mangalore</b><br>
					Shop No7, Brahma Samaj Complex,<br>
					Ground Floor, Near Navabharat circle,<br>
					Kodialbail, Mangalore-575003.<br>
					Nearest Land Mark: Opposite to Rambhavan complex and Regional Passport office.<br>
					Telephone: 0824 - 3201391.<br>
					Email: <a href="mailto:mangalore@communitytmatrimony.com" class="clr1">mangalore@communitytmatrimony.com</a><br></div>

					<div class="padt10"><b>Sanjaynagar</b><br>
					494/35,(oldno.156), Sanjay Nagar main Road,<br>
					Geddanahalli, Bangalore - 560094.<br>
					Land Mark : Opp to Orange cash and carry.<br>
					Telephone: 080 - 32557951.<br>
					Email: <a href="mailto:sanjaynagar@communitymatrimony.com" class="clr1">sanjaynagar@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Vijay Nagar</b><br>
					No. 69C, Pipeline Road,<br>
					Manuvana, Vijaya Nagar,<br>
					Bangalore - 560040.<br>
					Telephone: 080 - 32557954.<br>
					Email: <a href="mailto:vijaynagar@communitymatrimony.com" class="clr1">vijaynagar@communitymatrimony.com</a><br>
					</div>
				</div>

				<div id="dv7" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv7');" class="pntr" /></div>
					<font class="normtxt1"><b>Kerala</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Allapuzha</b><br>
					Room No.17/1424 DGround Floor,<br>
					JP Tower, VCSB Road,<br>
					Allapuzha - 688011.<br>
					Telephone: 0477 - 3297327.<br>
					Email: <a href="mailto:allapuzha@communitymatrimony.com" class="clr1">allapuzha@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Calicut</b><br>
					926/P Sunlight Towers, Kallai road,<br>
					Kozhikode - 673 002.<br>
					Telephone: 0495 - 3106095.<br></div>
					<div class="padt10"><b>Cochin</b><br>
					4th Floor, Muscat Tower, Kadavanthra,<br>
					S A Road, Cochin - 682020.<br>
					Telephone: 0484 - 3235900.<br>
					Email: <a href="mailto:kadavanthra@communitymatrimony.com" class="clr1">kadavanthra@communitymatrimony.com</a><br><br>
					1136/D1, II Floor, Chammany Towers, <br>
					Kaloor Junction, Cochin - 682017.<br>
					Telephone: 0484 - 3195758.<br>
					Email: <a href="mailto:cochin@communitymatrimony.com" class="clr1">cochin@communitymatrimony.com</a><br><br>
					G-5, Ground floor, PeeGees Mall,<br>
					Opp: Medical Trust Hospital, MG Road,<br>
					Cochin - 682 016.<br>
					Telephone: 0484 - 3195760.<br>
					Email: <a href="mailto:cochinmgroad@communitymatrimony.com" class="clr1">cochinmgroad@communitymatrimony.com</a><br>
					</div>
					<div class="padt10"><b>Kannur</b><br>
					SB 330 E, 1st Floor, Chenoli Building, Kakkadu Road,<br>
					South Bazar, Kannur - 670002.<br>
					Telephone: 0497 - 3241149.<br>
					Email: <a href="mailto:kannur@communitymatrimony.com" class="clr1">kannur@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Kollam</b><br>
					Room no.412D, Ground floor,<br>
					Amarjyothy building,<br>
					Kadappakada, Kollam - 691008.<br>
					Telephone: 0474 - 3224791.<br></div>
					<div class="padt10"><b>Kottayam</b><br>
					Room No.534 A, Parayil Building Ground Floor,<br>
					Nr.DarasanaTraining College,<br>
					Shastri Road, Kottayam - 686 001.<br>
					Telephone: 0481 - 3231890.<br>
					Email: <a href="mailto:kottayam@communitymatrimony.com" class="clr1">kottayam@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Malapuram</b><br>
					1 & 2, Room No - XXXII - 806 & 807, Ground floor,<br>
					Edaloli complex, Court Gate, Near - Head PO,<br>
					Manjeri, Malapuram - 676121.<br>
					Telephone: 0483 - 3213766.<br></div>
					<div class="padt10"><b>Muvattupuzha</b><br>
                    vettuvazhy plaza, Aramana Junction,<br>
                    Opposite to Aramana Complex, Muvattupuzha - 686661.<br />
					Telephone: 0485 - 3249593.<br>
					Email: <a href="mailto:muvattupuzha@communitymatrimony.com" class="clr1">muvattupuzha@communitymatrimony.com</a><br></div>

					<div class="padt10"><b>Palakkadu</b><br>
                    Ground Floor, ANR Complex,<br>
                    Priyadarshini Theatre Road, Palakkad - 678001.<br />
					Telephone: 0491 - 3267245.<br>
					Email: <a href="mailto:palakkadu@communitymatrimony.com" class="clr1">palakkadu@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Pathanamthitta</b><br>
					1st Floor, Aban Arcade, Aban Junction,<br>
					Kumbazha Road, Pathanamthitta - 689645<br>
					Telephone: 0468 - 3206585.<br>
                    Email: <a href="mailto:pathanamthitta@communitymatrimony.com" class="clr1">pathanamthitta@communitymatrimony.com</a><br>
                    </div>
					<div class="padt10"><b>Thrissur</b><br>
					No 29/857, first floor, S&S Complex,<br>
					Shornur Road, Thrissur - 680 001.<br>
					Telephone: 0487 - 3108946.<br>
					Email: <a href="mailto:thrissur@communitymatrimony.com" class="clr1">thrissur@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Trivandrum</b><br>
					Shop No: 212 & 213, 1st Floor, Annas Arcade, Spencer Junction,<br>
					M G ROAD, Thiruvananthapuram - 695 001.<br>
					Telephone: 0471 - 3273379.<br>
					Email: <a href="mailto:tvm@communitymatrimony.com" class="clr1">tvm@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Vadakara</b><br>
					No 19/328-C, Ground floor, R.K.Complex,<br>
					Edodi PO, Vadakara - 673101.<br>
					Telephone: 0496 - 3224138.<br>
					Email: <a href="mailto:vadakara@communitymatrimony.com" class="clr1">vadakara@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv8" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv8');" class="pntr" /></div>
					<font class="normtxt1"><b>Madhya Pradesh</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10">
					Treasure Island Mall<br>
					RES2, 5th Floor,<br>
					Nr. Scary House, M.G. Road,<br>
					Indore - 452001.<br>
					Telephone: 0731 - 3228603.<br>
					Email: <a href="mailto:indore@communitymatrimony.com" class="clr1">indore@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv9" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv9');" class="pntr" /></div>
					<font class="normtxt1"><b>Maharashtra</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Mumbai</b><br>
					Office No.404-410 A, Chintamani Plaza<br />Chakala, Andheri-Kurla Road, Andheri (East), MUMBAI 400 099<br>
					Telephone: 022 - 31928891, 60603333, 42416900, 9320256665.<br>
					Email: <a href="mailto:mumbai@communitymatrimony.com" class="clr1">mumbai@communitymatrimony.com</a><br><br />
                    Priyanka Apartment Co-op. Premises Society Ltd,<br />
                    Opp. Maitri Park, Sion-Trombay Road,<br />
                    Chembur. Mumbai - 400 071.<br />
                    Telephone: 022 - 31928890.<br>
                    Email: <a href="mailto:Chembur@communitymatrimony.com" class="clr1">Chembur@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Borivali</b><br>
					Shop No-9, Shailesh Apartments,<br>
					S.V.P Road, Borivali (W), Mumbai - 400 103.<br>
					Telephone: 022 - 31928879.<br>
					Email: <a href="mailto:borivali@communitymatrimony.com" class="clr1">borivali@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Nagpur</b><br>
					Plot no- 4,101 First Floor, Tajshree Business Centre,<br>
					Gandhiputla , Chitroli chowk, C.A road, Nagpur-440002.<br>
					Telephone: 0712 - 3223950.<br>
					Email: <a href="mailto:nagpur@communitymatrimony.com" class="clr1">nagpur@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Pune</b><br>
                    4th Floor, Thube IT Park,<br />
                    Kundan Chambers, Near Sancheti Hospital,<br />
                    Shivaji Nagar, Pune - 411005.<br />
                    Telephone: 020 - 32319975.<br><br />
                    Shop No-06, Landmark Centre Bldg,<br>
                    Opp City Pride, Pune - Satara Road, Pune - 411009.<br>
					Telephone: 020 - 32319974.<br>
					Email: <a href="mailto:pune@communitymatrimony.com" class="clr1">pune@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Thane</b><br>
					Aga Khan Estate, 3 Petrol pump,<br>
					Above Sagarlaminates Shop,<br>
					Opp.Kotak Life Insurance Office, LBS Marg Naupada Thane West,<br>
					Mumbai - 400602.<br>
					Telephone: 022 - 31928893.<br>
					Email: <a href="mailto:thane@communitymatrimony.com" class="clr1">thane@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv10" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv10');" class="pntr" /></div>
					<font class="normtxt1"><b>Orissa</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Bhubaneshwar</b><br>
					Samasti Arcade, Plot no 85/A, First floor,<br>
					Infront of Govt U.P school, Backside of Bazar Kolkata<br>
					Bapujinagar, Bhubaneshwar - 751009.<br>
					Telephone: 0674 - 3274911.<br>
					Email: <a href="mailto:bhubaneshwar@communitymatrimony.com" class="clr1">bhubaneshwar@communitymatrimony.com</a><br><br>
					A-53, Saheed Nagar [ground floor],<br>
					Bhubaneshwar - 751007.<br>
					Telephone: 0661 - 3203367.<br>
					Email: <a href="mailto:sahidnagar@communitymatrimony.com" class="clr1">sahidnagar@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Rourkela</b><br>
					1st Floor, Triveni Complex, Opp. Hotel Sukh Sagar,<br>
					Madhusudan Marg, Rourkela - 769 001.<br>
					Telephone: 0661 - 3203367.<br>
					Email: <a href="mailto:rourkela@communitymatrimony.com" class="clr1">rourkela@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv11" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv11');" class="pntr" /></div>
					<font class="normtxt1"><b>Pondicherry</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10">
					No. 294 A, Maraimalai Adigal Salai, Nellithope Signal,<br>
					Pondicherry - 605013.<br>
					Telephone: 0413 - 3248996.<br>
					Email: <a href="mailto:pondicherry@communitymatrimony.com" class="clr1">pondicherry@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv12" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv12');" class="pntr" /></div>
					<font class="normtxt1"><b>Punjab</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Chandigarh</b><br>
					S.C.O-35, 2nd floor, Sector 16 D, Chandigarh - 160015.<br>
					Telephone: 0172 - 3262256.<br>
					Email: <a href="mailto:chandigarh@communitymatrimony.com" class="clr1">chandigarh@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Ludhiana</b><br>
					BXX-2707, Navrang Electronics Building, First Floor,<br>
					Opposite Nehru Sidhant Kendra, Bhai Bala Chowk,<br>
					Pakhowal Road, Ludhiana - 141001.<br>
					Telephone: 0161 - 3232160.<br>
					Email: <a href="mailto:ludhiana@communitymatrimony.com" class="clr1">ludhiana@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv13" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv13');" class="pntr" /></div>
					<font class="normtxt1"><b>Rajasthan</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Jaipur</b><br>
					105, Aishwarya complex, Ajmer road,<br>
					Near hotel hawamahal, Jaipur - 302006.<br>
					Telephone: 0141 - 3158281.<br>
					Email: <a href="mailto:jaipur@communitymatrimony.com" class="clr1">jaipur@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Udaipur</b><br>
					Flat No. S-8, Second Floor, Business Centre, 1-C,<br>
					Madhuban, Udaipur - 313001.<br>
					Telephone: 0294 - 3209650.<br>
					Email: <a href="mailto:udaipur@communitymatrimony.com" class="clr1">udaipur@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv14" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv14');" class="pntr" /></div>
					<font class="normtxt1"><b>TamilNadu</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Chennai</b><br>
					<div class="padt10 padl25"><b>Pondy Bazaar</b><br>
					Old No. 6, New No. 9, Thyagaraya road, <br>
					Opp to GRT Grand Days & Kasi Arcade,<br>
					Pondy Bazaar, Chennai - 600017.<br>
					Telephone: 044 - 32217547.<br>
					Email: <a href="mailto:tnagar@communitymatrimony.com" class="clr1">tnagar@communitymatrimony.com</a><br></div>
					<div class="padt10 padl25"><b>Vadapalani</b><br>
					Shop No. 12, Ist floor, Block - D, Doshi Gardens,<br>
					No. 174, Arcot Road (N. S. K. Salai), (Opp. to Vadapalani Bus Terminus),<br>
					Vadapalani, Chennai - 600026.<br>
					Telephone:044 - 32211769.<br>
					Email: <a href="mailto:vadapalani@communitymatrimony.com" class="clr1">vadapalani@communitymatrimony.com</a><br></div>
					<div class="padt10 padl25"><b>Adyar</b><br>
					No:57, 1st Main Road, Gandhi Nagar,<br>
					Adyar, Chennai 600020.<br>
					Telephone: 044 - 32211783.<br>
					Email: <a href="mailto:adyar@communitymatrimony.com" class="clr1">adyar@communitymatrimony.com</a><br></div>
					<div class="padt10 padl25"><b>Anna Nagar</b><br>
					AH-7,Shanthi Colony, 4th Avenue,<br>
					Anna Nagar, Chennai 600040.<br>
					Telephone: 044 - 32211935.<br>
					Email: <a href="mailto:annanagar@communitymatrimony.com" class="clr1">annanagar@communitymatrimony.com</a><br></div>
					<div class="padt10 padl25"><b>Royapettah</b><br>
					SL-18,First Basement, Express Avenue,<br>
					Whites Road, Royapettah,<br>
					Chennai-600014<br>
					Telephone: 044 - 32213215.<br>
					Email: <a href="mailto:royapettah@communitymatrimony.com" class="clr1">royapettah@communitymatrimony.com</a><br></div>
					<div class="padt10 padl25"><b>Royapuram</b><br>
					No. 546 (Old No. 126), S N Street,<br>
					Royapuram, Chennai 600013.<br>
					Telephone: 044 - 32211933.<br>
					Email: <a href="mailto:royapuram@communitymatrimony.com" class="clr1">royapuram@communitymatrimony.com</a><br></div>
					<div class="padt10 padl25"><b>Porur</b><br>
					No: 80A, K.M.Janakiram Complex, Arcot Road,<br>
					Karambakkam,Porur.<br>
					Lmk - Nr to Porur Police Booth.<br>
					Telephone: 044 - 32217325.<br>
					Email: <a href="mailto:porur@communitymatrimony.com" class="clr1">porur@communitymatrimony.com</a><br></div>
					<div class="padt10 padl25"><b>Purasaivakkam</b><br>
					Ground Floor, Old No. 17, New No. 43, Thana Street,<br>
					Purasawalkam, Chennai - 600007.<br>
                    Lmk - Next to Narayana hospital.<br>
					Telephone: 044 - 32211936.<br>
					Email: <a href="mailto:purasaivakkam@communitymatrimony.com" class="clr1">purasaivakkam@communitymatrimony.com</a><br></div>
					<div class="padt10 padl25"><b>Velachery</b><br>
					Door No. 7, 7th Main Road, 8th Avenue, Dhandeeswaram,<br>
					Velachery, Chennai 600042.<br>
					Telephone: 044 - 31909123.<br>
					Email: <a href="mailto:velachery@communitymatrimony.com" class="clr1">velachery@communitymatrimony.com</a><br></div>
                    <div class="padt10 padl25"><b>Madipakkam</b><br>
                    Rajparis Mansoravar Flats, Medavakkam Main Road,<br>
					Ullogarem, Chennai 600091.<br>
					Telephone: 044 - 32212315.<br>
					Email: <a href="mailto:madipakkam@communitymatrimony.com" class="clr1">madipakkam@communitymatrimony.com</a><br></div>
                    <div class="padt10 padl25"><b>Perambur</b><br>
                    No.231, Paper Mills Road,<br>
					Perambur, Chennai 600011.<br>
					Telephone: 044 - 32212378.<br>
					Email: <a href="mailto:perambur@communitymatrimony.com" class="clr1">perambur@communitymatrimony.com</a><br></div>
                    <div class="padt10 padl25"><b>K.K.Nagar</b><br>
                    No.55, Anna Main Road,<br />
					MGR Nagar, Near - DATA UDIPI HOTEL,<br>
                    K.K.Nagar,Chennai - 600 078.<br />
					Telephone: 044 - 32217552.<br>
					Email: <a href="mailto:kknagar@communitymatrimony.com" class="clr1">kknagar@communitymatrimony.com</a><br></div>
                    <div class="padt10 padl25"><b>Thuraipakkam</b><br>
                    No: 5, Rajivi Gandhi Salai,<br />
                    Kottivakkam, OMR,<br>
                    Chennai - 41.<br />
					Telephone: 044 - 32212368.<br>
					Email: <a href="mailto:thuraipakkam@communitymatrimony.com" class="clr1">thuraipakkam@communitymatrimony.com</a><br></div>
                    <div class="padt10 padl25"><b>Thiruvidanthai</b><br>
                    No: 2.38, Sanadhi st, Thiruvidandhai,<br />
                    Chennai - 603112.<br />
                    Landmark - Nithya Kalyani Temple.<br />
					Telephone: 044 - 32211768.<br>
					Email: <a href="mailto:thiruvidanthai@communitymatrimony.com" class="clr1">thiruvidanthai@communitymatrimony.com</a><br></div>

					</div>
					<div class="padt10"><b>Kancheepuram</b><br>
					New No. 32, Old No. 549, Gandhi Road,<br>
					Kancheepuram - 631501.<br>
					Telephone: 044 - 37213799.<br>
					Email: <a href="mailto:kancheepuram@communitymatrimony.com" class="clr1">kancheepuram@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Coimbatore</b><br>
					1st floor, No 320 N S R road, Saibaba Colony,<br>
					Upstairs (Bombay Dyeing show room),<br>
					Coimbatore - 641 011.<br>
					Telephone: 0422 - 3221347.<br><br>
					113A, Dr.Rajendra prasad 100 feet road, Coimbatore - 641 012.<br>
					Telephone: 0422 - 3221347.<br>
					Email: <a href="mailto:coimbatore@communitymatrimony.com" class="clr1">coimbatore@communitymatrimony.com</a><br></div>

					
					<div class="padt10"><b>Pollachi</b><br>
					No.4, RajaMill Road,<br>
					New Bus Stand Backside,<br>
					Pollachi - 642001.<br>
					Telephone: 04259 - 311090.<br>
					Email: <a href="mailto:pollachi@communitymatrimony.com" class="clr1">pollachi@communitymatrimony.com</a><br></div>

					<div class="padt10"><b>Erode</b><br>
					69, Sakthi Road, opposite PRR & sons,<br>
					Erode - 638003.<br>
					Telephone: 0424 - 3249792.<br>
					Email: <a href="mailto:erode@communitymatrimony.com" class="clr1">erode@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Madurai</b><br>
					No: 96, Vakkil New Street, Simmakkal, Madurai - 625 001.<br>
					Telephone: 0452 - 3277689.<br>
					Email: <a href="mailto:madurai@communitymatrimony.com" class="clr1">madurai@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Nagercovil</b><br>
					N.B Complex, No : 655, (Land mark Near BSNL Office,)<br>
					Trivandrum (MS) Road, Vadasery, Nagercovil-629 001.<br>
					Telephone : 04652-314456.<br>
					Email: <a href="mailto:nagercovil@communitymatrimony.com" class="clr1">nagercovil@communitymatrimony.com</a><br>
					</div>
                    <div class="padt10"><b>Karur</b><br>
					Shop no 1 & 2, 31/a, North Pradhakshnam Road,<br>
					Shubash complex, Near G.C. Hospital,<br />
                    Karur-639001.<br>
					Telephone : 04324-319413.<br>
					Email: <a href="mailto:karur@communitymatrimony.com " class="clr1">karur@communitymatrimony.com </a><br>
					</div>
					<div class="padt10"><b>Salem</b><br>
					KRR Towers NO:69-B367/368, Cherry Road,<br>
					next to Rudramurthy Hospital, opposite Gandhi Road bus stop,<br>
					Salem - 636007.<br>
					Telephone: 0427 - 3257271.<br>
					Email: <a href="mailto:salem@communitymatrimony.com" class="clr1">salem@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Tirunelveli</b><br>
					#180 - A, 1st Floor (above Universal Showroom),<br>
					Landmark Plaza, (opp to Sripuram Busstop) SN High road,<br>
					Sripuram, Tirunelveli Town.<br>
					Telephone: 0462 - 3240059.<br>
					Email: <a href="mailto:tirunelveli@communitymatrimony.com" class="clr1">tirunelveli@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Tirupur</b><br>
					No:512, Dharapuram road, Near Aranmanai Pudur bus stop,<br>
					Tirupur - 641604.<br>
					Telephone: 0421 - 3211305.<br>
					Email: <a href="mailto:tirupur@communitymatrimony.com" class="clr1">tirupur@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Trichy</b><br>
					No.6 - A, Ground Floor,(next to P.OR.R & Sons),<br>
					Vignesh Plaza, Salai Road, Thillai Nagar, Trichy - 620 018.<br>
					Telephone: 0431 - 3253139.<br>
					Email: <a href="mailto:trichy@communitymatrimony.com" class="clr1">trichy@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Thanjavur</b><br>
					No.203, Mangalapuram,Near Mangalapuram Bus-stop,<br>
					(Land mark - Next to Bombay Sweets), Medical College Road,<br>
					Thanjavur - 613 007.<br>
					Telephone: 04362 - 319244.<br>
					Email: <a href="mailto:tanjore@communitymatrimony.com" class="clr1">tanjore@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Vellore</b><br>
					71/2, Katpadi Road,<br>Thottapalayam,<br>Vellore - 632004.<br>
					Telephone: 0416 - 3268379.<br>
					Email: <a href="mailto:vellore@communitymatrimony.com" class="clr1">vellore@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv15" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv15');" class="pntr" /></div>
					<font class="normtxt1"><b>Uttarakhand</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10">
					City Business center, 6th cross road,<br>
					1st floor ( opposite Main Branch- SBI),<br>
					Dehradun, Uttarakhand - 248 001.<br>
					Telephone: 0135 - 3277457.<br>
					Email: <a href="mailto:dehradun@communitymatrimony.com" class="clr1">dehradun@communitymatrimony.com</a><br></div>
				</div>

				<div id="dv16" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv16');" class="pntr" /></div>
					<font class="normtxt1"><b>Uttar Pradesh</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Kanpur</b><br>
					14/123 -A, 2nd Floor, Gopala Chamber,<br>
					Mall Road, Kanpur - 208001.<br>
					Telephone: 0512 - 3230483.<br>
					Email: <a href="mailto:kanpur@communitymatrimony.com" class="clr1">kanpur@communitymatrimony.com</a><br></div>
					<div class="padt10"><b>Lucknow</b><br>
                    1st Floor, Satya Business Park,<br>
                    Naval Kishore Road,<br>
                    Opp Lila Cinema, Above Canara bank.<br />
					Hazaratganj, Lucknow - 226001.<br>
					Telephone: 0522 - 3223621.<br>
					</div>
				</div>

				<div id="dv17" class="normtxt disblk brdr pad10" style="line-height:17px; display:none;">
					<div class="fright"><img src="<?=$confValues['IMGSURL']?>/close.gif" onclick="javascript:hidediv('dv17');" class="pntr" /></div>
					<font class="normtxt1"><b>West Bengal</b></font><br>
					<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
					<div class="padt10"><b>Kolkata</b><br>
					Devi Market, 2nd Floor 83, S.P. Mukherjee Road<br>
					Kalighat Kolkata - 700 026.<br>
					Telephone: 033 - 4060 5515/5517.<br><br>
					P-126, C.I.T. Road, Scheme - VI (M), <br>
					(Near Kankurgachi/ V.I.P.Market), Kolkata - 700 054.<br>
					Telephone: 033 - 2468775.<br>
					Email: <a href="mailto:kolkata@communitymatrimony.com" class="clr1">kolkata@communitymatrimony.com</a><br><br />
                    1648, Garia Main Road, P.S.- Sonarpur,<br />
                    South 24 - Parganas, Distt. Kolkata - 700084.<br />
                    Telephone: 033 - 32468788.<br>
                    Email: <a href="mailto:garia@communitymatrimony.com" class="clr1">garia@communitymatrimony.com</a><br />
                    </div>
				</div>
			</div>
				<div style="width:450px;" class="tlleft disnon brdr pad10" id="cdv2">
					<b>Consim Info USA Inc,</b><br>
				3228 Route 27 North, 2nd Floor,<br>
				Kendall Park, NJ 08824. USA. <br />
                <b>Toll Free No.</b>&nbsp;1 - 877 - 496 - 2779</div>
				<div style="width:450px;" class="tlleft disnon brdr pad10" id="cdv3">
				<b>Mr. Randhir Singh.</b><br>
				M03, NBQ building<br>
				Khalid Bin Al Waleed Street,<br>
				P.O.Box 46094,Dubai,<br>
				United Arab Emirates.<br>
				<?if($varDomainPart2=='muslimmatrimony'){?>Ph: +971 4 3831008.<?}else{?>Ph: +971-4-3968637.<?}?></div>
                <div style="width:450px;" class="tlleft disnon brdr pad10" id="cdv4">
					<b>Toll Free No.</b>&nbsp;1800093053</div>
                <div style="width:450px;" class="tlleft disnon brdr pad10" id="cdv5">
					<b>Toll Free No.</b>&nbsp;8001012537</div>

                 <div style="width:450px;" class="tlleft disnon brdr pad10" id="cdv6">
<!-- 				Kaamal,<br>
				387-A, Jalan Batu 2 1/2,<br>
				Jalan Ipoh, Kuala Lumpur,<br>
				Malaysia,<br>
				Postcode: 51200<br>
				Office: 006 03 40413505<br>
				HP : 006 0173581555<br>
				HP : 006 0162500004<br>
                Toll Free : 1800815588<br /><br> -->
				<b>Penang</b><br>
				No:99 Beach street, 10300<br><br>
				<b>JohorBaru</b><br>
				No:87 C 2 Jalan trus, 81000 JohorBaru.</div>
                <div style="width:450px;" class="tlleft disnon brdr pad10" id="cdv7">
				Shahed / Amita Krishna,<br>
				Leisure line ltd., House#16 , Road# 14,<br>
				Sector# 4, Uttara Model Town, Uttara Dhaka,<br>
				Dhaka,<br>
				ZipCode 1230,<br>
				Contact Phone (+880-2) 8918657,8915874.<br><br>
				Payments made in cheques / pay order to be taken in favour of <br><b>"SHRAVAN DHANAPAL NAIDU"</b> payable at Dhaka
				</div>
                <div style="width:450px;" class="tlleft disnon brdr pad10" id="cdv8">
				P-189, Street No. 2, Gulbahar Colony,<br>
				Satayana Road , Faisalabad , Pakistan.<br>
				Azhar:  <img src="<?=$confValues['IMGSURL']?>/trans.gif" width="6" height="10">00 92 300 8668 463<br>
				Shahid: 00 92 300 6699 234<br>
				Office: <img src="<?=$confValues['IMGSURL']?>/trans.gif" width="4" height="1">00 92 41 262 1122, 00 92 41 2611112<br>
				Email ID:&nbsp;<a href="mailto:azhar_fcs@yahoo.com" class="clr1">azhar_fcs@yahoo.com</a>, &nbsp;
				<a href="mailto:mcmfsd@hotmail.com" class="clr1">mcmfsd@hotmail.com</a><br><br>

				<b>Bank Account Detail:</b><br>
				Account Title: <font class="smalltxt boldtxt"><b>MICRO COMPUTER MARKETING</b></font><br>
				Account No.: 0102029-7 <br>
				Bank Name: UBL (United Bank Limited )<br>
				Branch: Peoples Colony Branch, Faisalabad, Pakistan.
				</div>
				<br clear="all">
				<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" width="1" height="1" /></div>
				<div class="normtxt fleft padt10"><div class="fleft bld">Corporate Office &nbsp;&nbsp;</div><div id="iconp" class="fleft disnon" style="padding-top:4px;"><img src="<?=$confValues['IMGSURL']?>/plusicon.gif" border="0" alt="" onclick="showhidediv('corpdiv');imgdisp('minus');" style="cursor:pointer;" /></div><div id="iconm" class="fleft" style="padding-top:4px;"><img src="<?=$confValues['IMGSURL']?>/minusicon.gif" border="0" alt="" onclick="showhidediv('corpdiv');imgdisp('plus');" style="cursor:pointer;" /></div><br>
					<div id="corpdiv" style="display:block;">
					Consim Info Pvt Ltd<br>
					No:94, TVH Beliciaa Towers,10th Floor, Tower 2, MRC Nagar,<br>
					Mandaveli, Chennai - 600 028. Tamilnadu, India.<br>
					Phone: 044-24631500<br>
					Note: For queries related to payment or to your partner search, please contact <a href="/site/index.php?act=LiveHelp" class="clr1">24x7 Help</a>.	<br>
						Email ID: <a href="mailto:helpdesk@<?=strtolower($confValues['PRODUCTNAME'])?>.com" class="clr1">helpdesk@<?=strtolower($confValues['PRODUCTNAME'])?>.com</a><br>
						<div class="fleft">For payment related queries, <font class="bld">Call&nbsp; </div><div id="tfree" class="bld fleft"> Toll Free No. 1-800-3000-2222 ( India ).</div></font><br><br>
					</div><br>
				</div>
			</div>
		</div>
		</div>

</div>
