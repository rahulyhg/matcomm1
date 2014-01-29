<?php
/* ______________________________________________________________________________________________________________________*/
/* Author 		: Ashok kumar
/* Date	        : 28 Aug 2009
/* Project		: Community Product Matrimony
/* Filename		: jat/conf.inc
/* ______________________________________________________________________________________________________________________*/
/* Description  : Auto generated community (or) domain config file : jat domain
/* ______________________________________________________________________________________________________________________*/

/* Segment & Discount */
$casteTag	= 'A';
$DiscountTag = 20; // Discount in %

/* Male Age Setting */

/* Female Age Setting */

/* Features Setting */
$_FeatureMaritalStatus	= 1;
$_FeatureReligion	= 1;
$_FeatureReligionTxt= 0;
$_FeatureCaste		= 1;
$_FeatureCasteTxt	= 0;
$_FeatureSubcaste	= 1;
$_FeatureSubcasteTxt= 0;
$_FeatureGothram	= 1;
$_FeatureGothramTxt	= 1;
$_FeatureStar		= 1;
$_FeatureRaasi		= 1;
$_FeatureHoroscope	= 1;
$_FeatureDosham		= 1;

/* Right Panel Feature */
$_RPSuccessStory	= 0;
$_RPZedoPanel		= 0;
$_RPGoogleAdsense	= 0;

/* Label Name Settings */
$_LabelMaritalStatus	= 'Marital Status';
$_LabelReligion	= 'Religion';
$_LabelCaste		= 'Caste';
$_LabelSubcaste	= 'Subcaste';
$_LabelGothram	= 'Gothra';
$_LabelMotherTongue		= 'Mother Tongue';
$_LabelStar		= 'Star';
$_LabelRaasi		= 'Raasi';
$_LabelHoroscope	= 'Horoscope';
$_LabelDosham		= 'Dosham';

/* Arrays */

/* Religion Array */
$arrReligionList	= array(1=>'Hindu',2=>'Muslim',4=>'Sikh');

/* Caste Array */
$arrCasteList	= array(67=>'Jat');

/* Gothram Array */
$arrGothramList = array();

/* Subcaste Array */
$arrDomainSubCaste	= array();
$arrDomainSubCaste	= array(1741=>"Achara",1742=>"Agah",1743=>"Agre",1744=>"Ahlawat",1745=>"Antil /Antal",1746=>"Arya",1747=>"Atwal",1748=>"Bagaria",1749=>"Bagri",1750=>"Bains",1751=>"Balhara",1752=>"Balyan",1753=>"Bamal",1754=>"Bana",1755=>"Barach",1756=>"Bargoti",1757=>"Beniwal",1758=>"Bhadu",1759=>"Bhakar",1760=>"Bhal",1761=>"Bhambu",1762=>"Budania",1763=>"Bugaliya",1764=>"Burdak",1765=>"Chahal",1766=>"Chaudhry",1767=>"Chauhan",1768=>"Chhikara Chikkara",1769=>"Chhillar",1770=>"Dabas",1771=>"Dagur",1772=>"Dahiya",1773=>"Dalal",1774=>"Dangi",1775=>"Dara",1776=>"Deshwal",1777=>"Dhaka",1778=>"Dhama",1779=>"Dhami",1780=>"Dhanda",1781=>"Dhankhar",1782=>"Dhariwal",1783=>"Dhatarwal",1784=>"Dhillon",1785=>"Dhonchak",1786=>"Dhoot",1787=>"Dhull",1788=>"Dollya",1789=>"Dudi",1790=>"Duhan",1791=>"Gahlot",1792=>"Garhwal",1793=>"Gehlawat",1794=>"Ghangas",1795=>"Gill",1796=>"Godara",1797=>"Grewal",1798=>"Gulia",1799=>"Heer",1800=>"Hooda",1801=>"Jaglan",1802=>"Jakhar",1803=>"Janu",1804=>"Jaswal",1805=>"Jatasra",1806=>"Jatrana",1807=>"Jewlia",1808=>"Kadian",1809=>"Kahlon",1810=>"Kajala",1811=>"Kakran",1812=>"Kaler",1813=>"Kaliramna",1814=>"Kalkhande",1815=>"Karwasra",1816=>"Kaswan",1817=>"Kataria",1818=>"Khalia",1819=>"Kharb",1820=>"Khatkar",1821=>"Kherwa",1822=>"Khichad",1823=>"Khokhar",1824=>"Kothari",1825=>"Kuhar",1826=>"Kulhari",1827=>"Kundu",1828=>"Kuntal",1829=>"Lakhlan",1830=>"Lakra",1831=>"Lamba",1832=>"Lamoria",1833=>"Lather",1834=>"Lathwal",1835=>"Latiyan",1836=>"Laur",1837=>"Lehga",1838=>"Maan",1839=>"Mahan",1840=>"Mahla",1841=>"Malhan",1842=>"Malik",1843=>"Mandhan",1844=>"Mangat",1845=>"Mann/Rai",1846=>"Meel",1847=>"Mehria",1848=>"Mohar",1849=>"Moond",1850=>"Mor More",1851=>"Nain",1852=>"Nandal",1853=>"Nara",1854=>"Natt Or Nat",1855=>"Nauhwar",1856=>"Nehra",1857=>"Nirwal",1858=>"Nitharwal",1859=>"Ola",1860=>"Pachehra",1861=>"Palsania",1862=>"Panghal",1863=>"Panwar",1864=>"Parihar",1865=>"Pattar",1866=>"Pawar",1867=>"Phalaswal",1868=>"Phogat",1869=>"Pilania",1870=>"Pooni",1871=>"Poria",1872=>"Punian",1873=>"Rahan",1874=>"Rajaura",1875=>"Rana",1876=>"Rangi",1877=>"Ranwa",1878=>"Rao",1879=>"Rathi",1880=>"Rawat",1881=>"Redhu",1882=>"Repswal",1883=>"Saharan",1884=>"Sandhu",1885=>"Sangwan",1886=>"Sansanwal",1887=>"Saran",1888=>"Saroha",1889=>"Sehrawat",1890=>"Sheokhand",1891=>"Sheoran",1892=>"Shokeen",1893=>"Sidhu",1894=>"Sikarwar",1895=>"Sindhu",1896=>"Singhal",1897=>"Sinsinwar",1898=>"Sirohi",1899=>"Siwach",1900=>"Solanki",1901=>"Sorot",1902=>"Suhag",1903=>"Sunda",1904=>"Takhar",1905=>"Tangar",1906=>"Tanwar",1907=>"Tarar",1908=>"Tevatia",1909=>"Thakran",1910=>"Thenua",1911=>"Thori",1912=>"Tokas",1913=>"Tomar",9997=>"Others");
$arrSubcasteList	= $arrDomainSubCaste + array(9998=>"Don't wish to specify",9999=>"Don't know my sub-caste"); // e.g. for registration usage
$arrDomainSubCaste[9998] = 'Not Specified';//Don't wish to specify
unset($arrDomainSubCaste[9999]);//Don't know my sub-caste
unset($arrDomainSubCaste[9997]);//Others
$arrSubCasteTrimmed = $arrDomainSubCaste; // e.g. for searvh form by removal non use values

/* Mother Tongue Array */
$arrMTDisplayOrder	= array();
$arrMTDisplayOrder = array(17=>"Hindi",41=>"Punjabi",15=>"Haryanvi",42=>"Rajasthani",34=>"Marwari");
if(!is_array($arrMotherTongueList)) {
  $arrMotherTongueList = array();
}
$arrMotherTongueList = $arrMTDisplayOrder + $arrMotherTongueList;

?>