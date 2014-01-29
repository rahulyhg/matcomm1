<?php
$allowed_html = '<strong><small><p><br><a><b><u><i><img><code><ul><ol><li>';

define('MAX_SUGGESTIONS', 10);

$usePersonalDict = true;
$editablePersonalDict = true;
$path_to_personal_dictionary = dirname(__FILE__) . "/personal_dictionary/personal_dictionary.txt";

if(!function_exists('pspell_suggest'))
{

	define('ASPELL_BIN','/usr/bin/aspell');
	require_once ("pspell_comp.php");
}

$pspell_config = pspell_config_create("en");
pspell_config_mode($pspell_config, PSPELL_FAST);

if($usePersonalDict)
{
	pspell_config_personal($pspell_config, $path_to_personal_dictionary);
}

$pspell_link = pspell_new_config($pspell_config);

require_once("cpaint/cpaint2.cil14.php"); //AJAX library file

$cp = new cpaint();
$cp->register('showSuggestions');
$cp->register('spellCheck');
$cp->register('switchText');
$cp->register('addWord');
$cp->start();
$cp->return_data();

function showSuggestions($word, $id)
{
	global $editablePersonalDict;
	global $pspell_link; 
	global $cp; 
	
	$retVal = "";
	
	$suggestions = pspell_suggest($pspell_link, $word);  
	
	$numSuggestions = count($suggestions);
	$tmpNum = min($numSuggestions, MAX_SUGGESTIONS);
			
	if($tmpNum > 0)
	{
		for($i=0; $i<$tmpNum; $i++)
		{
			$retVal .= "<div class=\"suggestion\" onclick=\"replaceWord('" . addslashes_custom($id) . "', '" . addslashes($suggestions[$i]) . "'); return false;\">" . $suggestions[$i] . "</div>";
		}
	
		if($editablePersonalDict)
		{
			//$retVal .= "<div class=\"addtoDictionary\" onclick=\"addWord('" . addslashes_custom($id) . "'); return false;\">Add To Dictionary</div>";
			$retVal .= "<div  onclick=\"replaceWord('" . addslashes_custom($id) . "', '" . $word . "'); return false;\"><font style='font-family:verdana;font-size:11px;color:#ff0000;cursor:pointer'>Ignore</div>";
		}
	}
	else
	{
		$retVal .= "No Suggestions";
	}
	
	$cp->set_data($retVal);
	
} 


function spellCheck($string, $varName)
{
	global $pspell_link; 
	global $cp; 
	$retVal = "";
   
   	$string = remove_word_junk($string);

	$string = preg_replace("/\r?\n/", "\n", $string);
   
   	$words = preg_split("/(<[^<>]*>)/", $string, -1, PREG_SPLIT_DELIM_CAPTURE);
	   
   	$numResults = count($words); //the number of elements in the array.

	$misspelledCount = 0;	
   
	for($i=0; $i<$numResults; $i++){
		if(($i & 1) == 0) 
		{
			$words[$i] = preg_split("/(\s+)/", $words[$i], -1, PREG_SPLIT_DELIM_CAPTURE); //then split it on the spaces

			$numWords = count($words[$i]);
			for($j=0; $j<$numWords; $j++)
			{
				preg_match("/[A-Z']{1,16}/i", $words[$i][$j], $tmp); //get the word that is in the array slot $i
				$tmpWord = $tmp[0];
				
				if(!pspell_check($pspell_link, $tmpWord))
				{
					$onClick = "onmouseover=\"setCurrentObject(" . $varName . "); showSuggestions('" . addslashes($tmpWord) . "', '" . $varName . "_" . $misspelledCount . "_" . addslashes($tmpWord) . "'); return false;\"";
					$words[$i][$j] = str_replace($tmpWord, "<span " . $onClick . " id=\"" . $varName . "_" . $misspelledCount . "_" . $tmpWord . "\" class=\"highlight\">" . stripslashes($tmpWord) . "</span>", $words[$i][$j]); 
					$misspelledCount++;
				}
				
				$words[$i][$j] = str_replace("\n", "<br />", $words[$i][$j]); //replace any breaks with <br />'s, for html display
			}
		}
		
		else
		{
			$words[$i] = str_replace("<", "<!--<", $words[$i]);
			$words[$i] = str_replace(">", ">-->", $words[$i]);
		}
	}

	$words = flattenArray($words);
	$numResults = count($words);
  	
	$string = ""; 
   
	if($misspelledCount == 0)
	{
		$string = "0";
	}
	else 
	{
   		$string = "1";
   	}
	$string .= implode('', $words);

	$string = preg_replace("/<!--<br( [^>]*)?>-->/i", "<br />", $string);
	$string = preg_replace("/<!--<p( [^>]*)?>-->/i", "<p>", $string);
	$string = preg_replace("/<!--<\/p>-->/i", "</p>", $string);
	$string = preg_replace("/<!--<b( [^>]*)?>-->/i", "<b>", $string);
	$string = preg_replace("/<!--<\/b>-->/i", "</b>", $string);
	$string = preg_replace("/<!--<strong( [^>]*)?>-->/i", "<strong>", $string);
	$string = preg_replace("/<!--<\/strong>-->/i", "</strong>", $string);
	$string = preg_replace("/<!--<i( [^>]*)?>-->/i", "<i>", $string);
	$string = preg_replace("/<!--<\/i>-->/i", "</i>", $string);
	$string = preg_replace("/<!--<small( [^>]*)?>-->/i", "<small>", $string);
	$string = preg_replace("/<!--<\/small>-->/i", "</small>", $string);
	$string = preg_replace("/<!--<ul( [^>]*)?>-->/i", "<ul>", $string);
	$string = preg_replace("/<!--<\/ul>-->/i", "</ul>", $string);
	$string = preg_replace("/<!--<li( [^>]*)?>-->/i", "<li>", $string);
	$string = preg_replace("/<!--<\/li>-->/i", "</li>", $string);
	$string = preg_replace("/<!--<img (?:[^>]+ )?src=\"?([^\"]*)\"?[^>]*>-->/i", "<img src=\"\\1\" />", $string);
		
	$cp->set_data($string);  //return value - string containing all the markup for the misspelled words.

} 

function addWord($str)
{
	global $editablePersonalDict;
	global $pspell_link; //the global link to the pspell module
	global $cp; //the CPAINT object
	$retVal = "";
	pspell_add_to_personal($pspell_link, $str);
	if($editablePersonalDict && pspell_save_wordlist($pspell_link))
	{
		$retVal = "Save successful!";
	}
	
	else
	{
		$retVal = "Save Failed!";
	}
	
	$cp->set_data($retVal);
} // end addWord


function flattenArray($array)
{
	$flatArray = array();
	foreach($array as $subElement)
	{
    	if(is_array($subElement))
		{
			$flatArray = array_merge($flatArray, flattenArray($subElement));
		}
		else
		{
			$flatArray[] = $subElement;
		}
	}
	
	return $flatArray;
} 

function stripslashes_custom($string)
{
	if(get_magic_quotes_gpc())
	{
		return stripslashes($string);
	}
	else
	{
		return $string;
	}
} 

function addslashes_custom($string)
{
	if(!get_magic_quotes_gpc())
	{
		return addslashes($string);
	}
	else
	{
		return $string;
	}
} 

function remove_word_junk($t)
{
	$a=array(
	"\xe2\x80\x9c"=>'"',
	"\xe2\x80\x9d"=>'"',
	"\xe2\x80\x99"=>"'",
	"\xe2\x80\xa6"=>"...",
	"\xe2\x80\x98"=>"'",
	"\xe2\x80\x94"=>"---",
	"\xe2\x80\x93"=>"--",
	"\x85"=>"...",
	"\221"=>"'",
	"\222"=>"'",
	"\223"=>'"',
	"\224"=>'"',
	"\x97"=>"---",
	"\x96"=>"--"
	);

	foreach($a as $k=>$v){
		$oa[]=$k;
		$ra[]=$v;
	}
	
	$t=trim(str_replace($oa,$ra,$t));
	return $t;

}

function switchText($string)
{
	global $allowed_html;
	global $cp; 
	$string = remove_word_junk($string);
	$string = preg_replace("/<!--/", "", $string);
	$string = preg_replace("/-->/", "", $string);	
	$string = preg_replace("/\r?\n/", " ", $string);
	$string = stripslashes_custom($string);
	$string = strip_tags($string, $allowed_html);
	$string = preg_replace('{&lt;/?span.*?&gt;}i', '', $string);
	$string = html_entity_decode($string);
	$cp->set_data($string);
	
} 

?>