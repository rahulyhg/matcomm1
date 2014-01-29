<?php
$varRootBasePath		= dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
include_once($varRootBasePath.'/conf/config.cil14');
?>

<div class="rpanel fleft">
		<div class="normtxt1 clr2 padb5 fleft" style="width:250px;"><font class="clr bld">About Us</font></div>
			<br clear="all">
		<div class="linesep"><img src="<?=$confValues['IMGSURL']?>/trans.gif" height="1" width="1" /></div>
			<div class="padt20">
				<div class="tljust">
					<div class="bld normtxt clr">Exclusive Matrimony Portal for the <?=ucfirst($arrDomainInfo[$varDomain][2])?>s</div><br>
					
					<div class="normtxt clr lh16">
					<?
if($varDomainPart2!='anycastematrimony' && $varDomainPart2!='defencematrimony')
{
?>
It is a proven fact that marriages within the community are happier and more stable. Married couples feel more comfortable in common social and cultural environments and are able to jointly celebrate traditions and values that were part of their upbringing. <br><br>
<?=$confValues['PRODUCTNAME']?> is an exclusive matrimony portal catering to the special matrimonial needs of the <?=ucfirst($arrDomainInfo[$varDomain][2])?> community across the globe. The portal offers several benefits to its members, primary being the pleasure of searching for a life partner within one's own community from across the globe at the click of a mouse. <?=$confValues['PRODUCTNAME']?> is powered by innovative tools and cutting-edge technologies to provide the best search experience for its users.<br><br>
<?
if($varDomainPart2=='muslimmatrimony')
{
?>
This portal brings together all sects of <?=ucfirst($arrDomainInfo[$varDomain][2])?>s who value tradition and are passionate about their roots and helps them in finding their respective matches.
<? } else { ?>
For <?=ucfirst($arrDomainInfo[$varDomain][2])?>s who value tradition and are passionate about their roots, this portal will help them connect with a partner from their community irrespective of whether they are from the same city or several thousand miles away, across continents.
<? } ?>
<? }
else {
if($varDomainPart2=='defencematrimony')
{
 ?>
 <?=$confValues['PRODUCTNAME']?> is an exclusive matrimony portal catering to the special matrimonial needs of the people in defence. The portal offers several benefits to its members, primary being the pleasure of searching for a life partner within one's own community from across the globe. This site is powered by innovative tools and cutting-edge technologies to provide the best search experience for its users.<br><br>
 This portal helps connect all families with a defence background irrespective of whether they are from the same city or several thousand miles away, across continents. With lakhs of prospective brides and grooms from the Army, Air Force and Navy, this can be the best place to find a life partner of your choice! 
<? }
else{
 ?>
<?=$confValues['PRODUCTNAME']?> is an exclusive matrimony site for people who look beyond the caste system and are willing to marry from any caste. Lakhs of people from totally different castes and lifestyle come together in their partner search on this site. <?=$confValues['PRODUCTNAME']?> is powered by innovative tools and cutting-edge technologies to provide the best search experience for its users.<br><br>This portal will help connect all people who are looking to marry out of their caste. Whether you are from India or several thousand miles away across continents, you can now find someone as broadminded as you are!
 <?}}?>
					
					</div><br>

					<div class="padt10 bld normtxt clr">Highlights of <?=$confValues['PRODUCTNAME']?>:</div>
					<div class="lh16 normtxt clr">
					<ul class="lh16" style="margin-left:10px !important;margin-left:16px; padding-left:5px !important;padding-left:0px;">
					<?
						if($varDomainPart2!='manglikmatrimony' && $varDomainPart2!='anycastematrimony' && $varDomainPart2!='defencematrimony' )
						{
					?>
					<li>Profiles from the <?=ucfirst($arrDomainInfo[$varDomain][2])?> community only!</li>
					<? } ?>

					<li>Global and wide set of profiles including NRIs.</li>
					<?
						if($varDomainPart2=='defencematrimony' )
						{
					?>
					<li>Free membership for the widows, war-affected and their families</li>
					<? } ?>
					<li>Free and easy profile registration.</li>
					<li>Safe and secure site. 100% privacy guaranteed</li>
					<li>Registered profiles are manually screened or validated to ensure they meet the norms of our site</li>
					<li>Innumerable privileges for premium members and standard benefits for free members.</li>
					<li>Registered members will receive matching profiles daily through e-mail based on their partner preference.* </li>
					<li>E-mail alerts when members contact each other.* </li>
					</ul>
					</div>
					<div class="padt10 normtxt clr">
						Interested in finding a life partner within your own community? Get started. Find a suitable match NOW.<br><br>
						<?
							if($varDomainPart2!='communitymatrimony')
							{
						?>
						<a class="clr1" href="<?=$confValues['SERVERURL']?>/register">Register Today</a>
						<? } ?>

					</div>
					<div class="padt20 smalltxt clr">
					* <font class="opttxt">Conditions Apply. Certain facilities are available only to premium members and subject to terms and conditions.</font>
					</div>
				</div>
			</div>
		</div>