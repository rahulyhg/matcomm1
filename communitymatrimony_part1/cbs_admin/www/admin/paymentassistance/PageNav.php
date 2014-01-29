<?php
/*
	******************************************************************************
	AUTHOR:			Kumaran K.M.
	DESCRIPTION:
	This is comman class for all paging in the site.

	MODIFICATION HISTORY:
	******************************************************************************
	Version 	Date			Author					Remarks
	******************************************************************************
	(0.1		15/11/2005		Kumaran K.M.		Initial Version)
	(0.2		6/12/2005		Hemachandran.K		Modified Version)
	******************************************************************************
*/
?>
<?
    class PageNav // [Class : Controls all Functions for Prev/Next Nav Generation]
    {
		
		var $limit, $execute, $query, $totcount;

        function execute($query,$dbplink='') // [Function : mySQL Query Execution]
        {
            //print $query;
			(!isset($_GET[$this->offset])) ? $GLOBALS[$this->offset] = 0 : $GLOBALS[$this->offset] = $_GET[$this->offset];
            //$this->sql_result = mysql_query($query);
            $this->total_result = $this->totcount;
			//$this->total_result = mysql_num_rows($this->sql_result);

            if(isset($this->limit))
            {
				$qry = trim($query);
				$sub_qry = substr ($qry,0,6);
				if (trim(strtolower($sub_qry)) != 'select' ) {
					$err_msg='No Result Found';
					////header("Location: http://".$_SERVER['SERVER_NAME']."/cgi-bin/error_landing.php?err_msg=$err_msg");
				}

				//echo "Inlimit:".$this->limit;
                $query .= " LIMIT " . $GLOBALS[$this->offset] . ", $this->limit";
				//echo $query;
				//echo "<br> str pos - ".strrpos($query," LIMIT");
				/*
				if($dbplink!='')
				{
                $this->sql_result = mysql_query($query,$dbplink);
				}
				else
				{
                $this->sql_result = mysql_query($query);
				}
				*/
                $this->num_pages = ceil($this->total_result/$this->limit);
            }
			//echo $query;
			$this->postquery=$query;
        }

        function show_num_pages($frew = '', $rew = '', $ffwd = '', $fwd = '', $separator = '|', $objClass = '',$qurstr1='') // [Function : Generates Prev/Next Links]
        {
            $current_pg = $GLOBALS[$this->offset]/$this->limit+1;
            if ($current_pg > 5)
            {
                $fgp = $current_pg - 5 > 0 ? $current_pg - 5 : 1;
                $egp = $current_pg+4;
                if ($egp > $this->num_pages)
                {
                    $egp = $this->num_pages;
                    $fgp = $this->num_pages - 9 > 0 ? $this->num_pages  - 9 : 1;
                }
            }
            else {
                $fgp = 1;
                $egp = $this->num_pages >= 10 ? 10 : $this->num_pages;
            }

            if($this->num_pages > 1) {
                // searching for http_get_vars
                foreach ($GLOBALS[HTTP_GET_VARS] as $_get_name => $_get_value) {
                    if ($_get_name != $this->offset) {
                        $this->_get_vars .= "&$_get_name=$_get_value";
                    }
                }
                $this->successivo = $GLOBALS[$this->offset] + $this->limit;
                $this->precedente = $GLOBALS[$this->offset] - $this->limit;
                $this->theClass = $objClass;
                if (!empty($rew)) {
                    $return .= ($GLOBALS[$this->offset] > 0) ? "[<a href=\"$GLOBALS[PHP_SELF]?$qurstr1&$this->offset=0\" $this->theClass>$frew</a>] <a href=\"$GLOBALS[PHP_SELF]?$qurstr1&$this->offset=$this->precedente\" $this->theClass>$rew</a> $separator " : "[$frew] $rew $separator ";
                }

                // showing pages
                if ($this->show_pages_number || !isset($this->show_pages_number))
                {
                    for($this->a = $fgp; $this->a <= $egp; $this->a++)
                    {
                        $this->theNext = ($this->a-1)*$this->limit;
                        $_ss_k = floor($this->theNext/26);
                        if ($this->theNext != $GLOBALS[$this->offset])
                        {
                            $return .= " <a href=\"$GLOBALS[PHP_SELF]?$qurstr1&$this->offset=$this->theNext\" $this->theClass> ";
                            if ($this->number_type == 'alpha')
                            {
                                 if($_ss_k>0)
                                 {
                                    $theLink = chr(64 + ($_ss_k));
                                    for($b = 0; $b < $_ss_k; $b++)
                                    {
                                       $theLink .= chr(64 + ($this->theNext%26)+1);
                                    }
                                    $return .= $theLink;
                                 } else {
                                 $return .= chr(64 + ($this->a));
                                 }
                            } else {
                                $return .= $this->a;
                            }
                            $return .= "</a> ";
                        } else {
                            if ($this->number_type == 'alpha')
                            {
                                 if($_ss_k>0)
                                 {
                                    $theLink = chr(64 + ($_ss_k));
                                    for($b = 0; $b < $_ss_k; $b++)
                                    {
                                       $theLink .= chr(64 + ($this->theNext%26)+1);
                                    }
                                    $return .= $theLink;
                                 } else {
                                 $return .= chr(64 + ($this->a));
                                 }
                            } else {
                                $return .= $this->a;
                            }
                            $return .= ($this->a < $this->num_pages) ? " $separator " : " ";
                        }
                    }
                    $this->theNext = $GLOBALS[$this->offset] + $this->limit;
                    if (!empty($fwd)) {
                        $offset_end = ($this->num_pages-1)*$this->limit;
                        $return .= ($GLOBALS[$this->offset] + $this->limit < $this->total_result) ? "$separator <a href=\"$GLOBALS[PHP_SELF]?$qurstr1&$this->offset=$this->successivo\" $this->theClass>$fwd</a> [<a href=\"$GLOBALS[PHP_SELF]?$qurstr1&$this->offset=$offset_end\" $this->theClass>$ffwd</a>]" : "$separator $fwd [$ffwd]";
                    }
                }
            }
            return $return;
        }

        function show_num_pages1($frew = '', $rew = '', $ffwd = '', $fwd = '', $separator = '|', $objClass = '',$qurstr='') // [Function : Generates Prev/Next Links]
        {
            $current_pg = $GLOBALS[$this->offset]/$this->limit+1;
            if ($current_pg > 5)
            {
                $fgp = $current_pg - 5 > 0 ? $current_pg - 5 : 1;
                $egp = $current_pg+4;
                if ($egp > $this->num_pages)
                {
                    $egp = $this->num_pages;
                    $fgp = $this->num_pages - 9 > 0 ? $this->num_pages  - 9 : 1;
                }
            }
            else {
                $fgp = 1;
                $egp = $this->num_pages >= 10 ? 10 : $this->num_pages;
            }

            if($this->num_pages > 1) {
                // searching for http_get_vars
                foreach ($GLOBALS[HTTP_GET_VARS] as $_get_name => $_get_value) {
                    if ($_get_name != $this->offset) {
                        $this->_get_vars .= "&$_get_name=$_get_value";
                    }
                }
                $this->successivo = $GLOBALS[$this->offset] + $this->limit;
                $this->precedente = $GLOBALS[$this->offset] - $this->limit;
                $this->theClass = $objClass;
                if (!empty($rew)) {
                    $return .= ($GLOBALS[$this->offset] > 0) ? "[<a href=\"$GLOBALS[PHP_SELF]?$qurstr&$this->offset=0\" $this->theClass>$frew</a>] <a href=\"$GLOBALS[PHP_SELF]?$qurstr&$this->offset=$this->precedente\" $this->theClass>$rew</a> " : "[$frew] $rew  ";
                }

                // showing pages
                if ($this->show_pages_number || !isset($this->show_pages_number))
                {
                    for($this->a = $fgp; $this->a <= $egp; $this->a++)
                    {
                        $this->theNext = ($this->a-1)*$this->limit;
                        $_ss_k = floor($this->theNext/26);
                    }
                    $this->theNext = $GLOBALS[$this->offset] + $this->limit;
                    if (!empty($fwd)) {
                        $offset_end = ($this->num_pages-1)*$this->limit;
                        $return .= ($GLOBALS[$this->offset] + $this->limit < $this->total_result) ? "$separator&nbsp;<a href=\"$GLOBALS[PHP_SELF]?$qurstr&$this->offset=$this->successivo\" $this->theClass>$fwd</a> [<a href=\"$GLOBALS[PHP_SELF]?$qurstr&$this->offset=$offset_end\" $this->theClass>$ffwd</a>]" : "$separator $fwd [$ffwd]";
                    }
                }
            }
            return $return;
        }
        function show_num_pages_smiles($frew = '', $rew = '', $ffwd = '', $fwd = '', $separator = '<img src="../matrimonials/trans.gif" width="460" height="5">', $objClass = '') // [Function : Generates Prev/Next Links]
        {
            $current_pg = $GLOBALS[$this->offset]/$this->limit+1;
            if ($current_pg > 5)
            {
                $fgp = $current_pg - 5 > 0 ? $current_pg - 5 : 1;
                $egp = $current_pg+4;
                if ($egp > $this->num_pages)
                {
                    $egp = $this->num_pages;
                    $fgp = $this->num_pages - 9 > 0 ? $this->num_pages  - 9 : 1;
                }
            }
            else {
                $fgp = 1;
                $egp = $this->num_pages >= 10 ? 10 : $this->num_pages;
            }

            if($this->num_pages > 1) {
                // searching for http_get_vars
                foreach ($GLOBALS[HTTP_GET_VARS] as $_get_name => $_get_value) {
                    if ($_get_name != $this->offset) {
                        $this->_get_vars .= "&$_get_name=$_get_value";
                    }
                }
                $this->successivo = $GLOBALS[$this->offset] + $this->limit;
                $this->precedente = $GLOBALS[$this->offset] - $this->limit;
                $this->theClass = $objClass;
                if (!empty($rew)) {
                    $return .= ($GLOBALS[$this->offset] > 0) ? "<font class=\"smallbold\"><a href=\"$GLOBALS[PHP_SELF]?$this->offset=$this->precedente\" $this->theClass>$rew</a></font> " : "<font class=\"smallbold\">$rew</font> ";
                }
				$return.= "$separator";
                // showing pages
                if ($this->show_pages_number || !isset($this->show_pages_number))
                {
                    for($this->a = $fgp; $this->a <= $egp; $this->a++)
                    {
                        $this->theNext = ($this->a-1)*$this->limit;
                        $_ss_k = floor($this->theNext/26);
                    }
                    $this->theNext = $GLOBALS[$this->offset] + $this->limit;
                    if (!empty($fwd)) {
                        $offset_end = ($this->num_pages-1)*$this->limit;
                        $return .= ($GLOBALS[$this->offset] + $this->limit < $this->total_result) ? "<font class=\"smallbold\"><a href=\"$GLOBALS[PHP_SELF]?$this->offset=$this->successivo\" $this->theClass>$fwd</a></font>" : "<font class=\"smallbold\">$fwd</font>";
                    }
                }
            }
            return $return;
        }


        function show_info() // [Function : Showing the Information for the Offset]
        {
           if($this->total_result==0){
                   $return = "0";
                   return $return;
           }
           if($GLOBALS[$this->offset] >= $this->total_result || $GLOBALS[$this->offset] < 0) return false;
            $return .= "&nbsp;&nbsp;Total Results: <font class=\"smallbold\"><font color=\"#FB5004\">" .$this->total_result ."</font></font><img src=\"../matrimonials/pixel.gif\" width=\"260\" height=\"1\">";
            $_from = $GLOBALS[$this->offset] + 1;
            $GLOBALS[$this->offset] + $this->limit >= $this->total_result ? $_to = $this->total_result : $_to = $GLOBALS[$this->offset] + $this->limit;
            $return .= "Showing Results from  <font class=\"smallbold\"><font color=\"#FB5004\">" . $_from . "</font></font> to <font class=\"smallbold\"><font color=\"#FB5004\">" . $_to . "</font></font>";
            return $return;
        }



        function show_info1() // [Function : Showing the Information for the Offset]
        {
           if($this->total_result==0){
                   $return = "0";
                   return $return;
           }
           if($GLOBALS[$this->offset] >= $this->total_result || $GLOBALS[$this->offset] < 0) return false;
            $return .= "&nbsp;&nbsp;Total Results: <font class=\"smallbold\"><font color=\"#FB5004\">" .$this->total_result ."</font></font><img src=\"../matrimonials/pixel.gif\" width=\"300\" height=\"1\">";
            $_from = $GLOBALS[$this->offset] + 1;
            $GLOBALS[$this->offset] + $this->limit >= $this->total_result ? $_to = $this->total_result : $_to = $GLOBALS[$this->offset] + $this->limit;
            $return .= "Showing Results: <font class=\"smallbold\"><font color=\"#FB5004\">" . $_from . "</font></font> of <font class=\"smallbold\"><font color=\"#FB5004\">" . $this->total_result . "</font></font>";
            return $return;
        }
        function show_info_smile() // [Function : Showing the Information for the Offset]
        {
           if($this->total_result==0){
                   $return = "Showing Results: <font class=\"smallbold\"><font color=\"#FB5004\">0</font></font> to <font class=\"smallbold\"><font color=\"#FB5004\">0</font></font>";
                   return $return;
           }
           if($GLOBALS[$this->offset] >= $this->total_result || $GLOBALS[$this->offset] < 0) return false;
            $return .= "<img src=\"../matrimonials/pixel.gif\" width=\"400\" height=\"1\">";
            $_from = $GLOBALS[$this->offset] + 1;
            $GLOBALS[$this->offset] + $this->limit >= $this->total_result ? $_to = $this->total_result : $_to = $GLOBALS[$this->offset] + $this->limit;
            $return .= "Showing Results: <font class=\"smallbold\"><font color=\"#FB5004\">" . $_from . "</font></font> to <font class=\"smallbold\"><font color=\"#FB5004\">" . $_to . "</font></font>";
            return $return;
        }
        function show_info_mail() // [Function : Showing the Information for the Offset]
        {
           if($this->total_result==0){
                   $return = "Showing Results: <font class=\"smallbold\"><font color=\"#FB5004\">0</font></font> to <font class=\"smallbold\"><font color=\"#FB5004\">0</font></font> of <font class=\"smallbold\"><font color=\"#FB5004\">".$this->total_result."</font></font>";
                   return $return;
           }
           if($GLOBALS[$this->offset] >= $this->total_result || $GLOBALS[$this->offset] < 0) return false;
            //$return .= "<img src=\"../matrimonials/pixel.gif\" width=\"430\" height=\"1\">";
            $_from = $GLOBALS[$this->offset] + 1;
            $GLOBALS[$this->offset] + $this->limit >= $this->total_result ? $_to = $this->total_result : $_to = $GLOBALS[$this->offset] + $this->limit;
            $return .= "Showing Results: <font class=\"smallbold\"><font color=\"#FB5004\">" . $_from . "</font></font> to <font class=\"smallbold\"><font color=\"#FB5004\">" . $_to . "</font></font> of <font class=\"smallbold\"><font color=\"#FB5004\">".$this->total_result."</font></font>";
            return $return;
        }



		 function show_nav( $rew = '', $fwd = '', $separator = '|', $objClass = '',$qurstr='') // [Function : Generates Prev/Next Links]
        {
            $current_pg = $GLOBALS[$this->offset]/$this->limit+1;
				/*echo $current_pg;
			echo $this->num_pages;*/
            if ($current_pg > 5)
            {
                $fgp = $current_pg - 5 > 0 ? $current_pg - 5 : 1;
                $egp = $current_pg+4;
                if ($egp > $this->num_pages)
                {
                    $egp = $this->num_pages;
                    $fgp = $this->num_pages - 9 > 0 ? $this->num_pages  - 9 : 1;
                }
            }
            else {
                $fgp = 1;
                $egp = $this->num_pages >= 10 ? 10 : $this->num_pages;
            }
			
            if($this->num_pages > 1) {
                // searching for http_get_vars

/*			  foreach ($GLOBALS[HTTP_GET_VARS] as $_get_name => $_get_value) {
                    if ($_get_name != $this->offset) {
                        $this->_get_vars .= "&$_get_name=$_get_value";
                    }
                }*/
                $this->successivo = $GLOBALS[$this->offset] + $this->limit;
                $this->precedente = $GLOBALS[$this->offset] - $this->limit;
                $this->theClass = $objClass;
                if (!empty($rew)) {
//                    @$return .= ($GLOBALS[$this->offset] > 0) ? "<a href=\"$GLOBALS[PHP_SELF]?$qurstr&$this->offset=$this->precedente\" $this->theClass>$rew</a>&nbsp;$separator":"";
                    @$return .= ($GLOBALS[$this->offset] > 0) ? "<a href=\"http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?$qurstr&$this->offset=$this->precedente\" $this->theClass>$rew</a>&nbsp;$separator":"";
					if($current_pg == 1){ $return .= "$rew&nbsp;$separator"; }
                }

                // showing pages
                if (@$this->show_pages_number || !isset($this->show_pages_number))
                {
                    for($this->a = $fgp; $this->a <= $egp; $this->a++)
                    {
                        $this->theNext = ($this->a-1)*$this->limit;
                        $_ss_k = floor($this->theNext/26);
                    }
                    $this->theNext = $GLOBALS[$this->offset] + $this->limit;
                    if (!empty($fwd)) {
                        $offset_end = ($this->num_pages-1)*$this->limit;
                        //@$return .= ($GLOBALS[$this->offset] + $this->limit < $this->total_result) ? "&nbsp;<a href=\"$GLOBALS[PHP_SELF]?$qurstr&$this->offset=$this->successivo\" $this->theClass>$fwd</a>":"&nbsp;$fwd";
                        @$return .= ($GLOBALS[$this->offset] + $this->limit < $this->total_result) ? "&nbsp;<a href=\"http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?$qurstr&$this->offset=$this->successivo\" $this->theClass>$fwd</a>":"&nbsp;$fwd";
                    }
                }
            }
            return @$return;
        }

		 function show_page($frew = '', $rew = '', $ffwd = '', $fwd = '', $separator = '|', $left , $right , $objClass = '',$qurstr1='') // [Function : Generates Prev/Next Links]
        {
			$show = array();
			$label = "Pages : "; 

			$current_pg = $GLOBALS[$this->offset] / $this->limit+1;

            if ($current_pg > 3) 
            {
                $fgp = $current_pg - 3 > 0 ? $current_pg - 3 : 1;
                $egp = $current_pg+2;
                if ($egp > $this->num_pages)
                {
                    $egp = $this->num_pages; 
                    $fgp = $this->num_pages - 4 > 0 ? $this->num_pages  - 4 : 1;
                }
            }
            else { 
				$fgp = 1; 
                $egp = $this->num_pages >= 5 ? 5 : $this->num_pages;
            }
			
            if($this->num_pages > 1) {
     
                $this->successivo = $GLOBALS[$this->offset] + $this->limit;
                $this->precedente = $GLOBALS[$this->offset] - $this->limit;
                $this->theClass = $objClass;

				if (!empty($rew)) {
                    $nav .= ($GLOBALS[$this->offset] > 0) ? "<a href=\"http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?$qurstr1&$this->offset=$this->precedente\" $this->theClass'>$rew</a>&nbsp;$separator":"";
					if($current_pg == 1){ $nav .= "$rew&nbsp;$separator"; }

                }
                // showing pages  


                if ($this->show_pages_number || !isset($this->show_pages_number))
                {
                    for($this->a = $fgp; $this->a <= $egp; $this->a++)
                    { 
                        $this->theNext = ($this->a-1)*$this->limit;
                        $_ss_k = floor($this->theNext/26);
                        if ($this->theNext != $GLOBALS[$this->offset])
                        { 
                            $return .= " <a href=\"http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?$qurstr1&$this->offset=$this->theNext\" $this->theClass> ";
//									echo "aaaa<br>$GLOBALS[PHP_SELF]?";
                            if ($this->number_type == 'alpha')
                            {
                                 if($_ss_k>0)
                                 {
                                    $theLink = chr(64 + ($_ss_k));
                                    for($b = 0; $b < $_ss_k; $b++)
                                    {
                                       $theLink .= chr(64 + ($this->theNext%26)+1);
                                    }
                                    $return .= $theLink;
                                 } else {
                                 $return .= chr(64 + ($this->a));
                                 }
                            } else { 
                                $return .= $this->a;
                            }
                            $return .= "</a> ";
                        } else { 
                            if ($this->number_type == 'alpha')
                            {
                                 if($_ss_k>0)
                                 {
                                    $theLink = chr(64 + ($_ss_k));
                                    for($b = 0; $b < $_ss_k; $b++)
                                    {
                                       $theLink .= chr(64 + ($this->theNext%26)+1);
                                    }
                                    $return .= $theLink;
                                 } else {
                                 $return .= chr(64 + ($this->a));
                                 }
                            } else { 
                                $return .= $left." "."<font color=\"#286769\">".$this->a."</font>"."&nbsp;".$right;
                            }
                            $return .= ($this->a < $this->num_pages) ? "  " : " ";

                        }
                    }
                    $this->theNext = $GLOBALS[$this->offset] + $this->limit;
                    if (!empty($fwd)) {
						
                         $offset_end = ($this->num_pages-1)*$this->limit;
                        $nav .= ($GLOBALS[$this->offset] + $this->limit < $this->total_result) ? "&nbsp;<a href=\"http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?$qurstr1&$this->offset=$this->successivo\">$fwd</a>":"&nbsp;$fwd";
                    }
                }
            }
			if($this->num_pages <= 1){
				$show[0] = $this->num_pages."<FONT COLOR=\"#9A440D\"> of</FONT> <font class=\"smallttxtnormal\"><font color=\"#9A440D\">".$this->num_pages."</font></font>";
			}else{
				$show[0] = $return."<FONT COLOR=\"#9A440D\"> of</FONT> <font class=\"smallttxtnormal\"><font color=\"#9A440D\">".$this->num_pages."</font></font>";
			}
			$show[1] = $nav;
			$show[2] = $this->num_pages;
//			$show[2] = $this->num_pages;

            return $show;
        }
		 function msgr_show_nav($objClass = '',$qurstr='') // [Function : Generates Prev/Next Links]
        {
		$return=array();
            $current_pg = $GLOBALS[$this->offset]/$this->limit+1;
			/*echo $current_pg;
			echo $this->num_pages;*/
            if ($current_pg > 5)
            {
                $fgp = $current_pg - 5 > 0 ? $current_pg - 5 : 1;
                $egp = $current_pg+4;
                if ($egp > $this->num_pages)
                {
                    $egp = $this->num_pages;
                    $fgp = $this->num_pages - 9 > 0 ? $this->num_pages  - 9 : 1;
                }
            }
            else {
                $fgp = 1;
                $egp = $this->num_pages >= 10 ? 10 : $this->num_pages;
            }
			
            if($this->num_pages > 1) {
                // searching for http_get_vars
               /* foreach ($GLOBALS[HTTP_GET_VARS] as $_get_name => $_get_value) {
                    if ($_get_name != $this->offset) {
                        $this->_get_vars .= "&$_get_name=$_get_value";
                    }
                }*/
                $this->successivo = $GLOBALS[$this->offset] + $this->limit;
                $this->precedente = $GLOBALS[$this->offset] - $this->limit;
                $this->theClass = $objClass;
                    $return[0] = ($GLOBALS[$this->offset] > 0) ? "$GLOBALS[PHP_SELF]?$qurstr&$this->offset=$this->precedente":"";
					if($current_pg == 1){ $return[0] = ""; }

                // showing pages
                if ($this->show_pages_number || !isset($this->show_pages_number))
                {
                    for($this->a = $fgp; $this->a <= $egp; $this->a++)
                    {
                        $this->theNext = ($this->a-1)*$this->limit;
                        $_ss_k = floor($this->theNext/26);
                    }
                    $this->theNext = $GLOBALS[$this->offset] + $this->limit;
                        $offset_end = ($this->num_pages-1)*$this->limit;
                        $return[1] = ($GLOBALS[$this->offset] + $this->limit < $this->total_result) ? "$GLOBALS[PHP_SELF]?$qurstr&$this->offset=$this->successivo":"";
                }
            }
            return $return;
        }


		 function show_mail_info() // [Function : Showing the Information for the Offset]
        {
           if($this->total_result==0){
                   $return = "Mails : 0 to 0 of ".$this->total_result."";
                   return $return;
           }
           if($GLOBALS[$this->offset] >= $this->total_result || $GLOBALS[$this->offset] < 0) return false;
            //$return .= "<img src=\"../matrimonials/pixel.gif\" width=\"430\" height=\"1\">";
            $_from = $GLOBALS[$this->offset] + 1;
            $GLOBALS[$this->offset] + $this->limit >= $this->total_result ? $_to = $this->total_result : $_to = $GLOBALS[$this->offset] + $this->limit;
            @$return .= "Mails : " . $_from . " to " . $_to . " of ".$this->total_result."";
            return $return;
        }

		function show_photo_info() // [Function : Showing the Information for the Offset]
        {
           if($this->total_result==0){
                   $return = "Photo : <font class=\"smallbold\"><font color=\"#FB5004\">0</font></font> to <font class=\"smallbold\"><font color=\"#FB5004\">0</font></font> of <font class=\"smallbold\"><font color=\"#FB5004\">".$this->total_result."</font></font>";
                   return $return;
           }
           if($GLOBALS[$this->offset] >= $this->total_result || $GLOBALS[$this->offset] < 0) return false;
            //$return .= "<img src=\"../matrimonials/pixel.gif\" width=\"430\" height=\"1\">";
            $_from = $GLOBALS[$this->offset] + 1;
            $GLOBALS[$this->offset] + $this->limit >= $this->total_result ? $_to = $this->total_result : $_to = $GLOBALS[$this->offset] + $this->limit;
            $return .= "Photo : <font ><font class=\"serpagnavnum\" =\"#99CCFF\">" . $_from . "</font></font> to <font ><font class=\"serpagnavnum\">" . $_to . "</font></font> of <font ><font color=\"#99CCFF\" class=\"serpagnavnum\">".$this->total_result."</font></font>";
            return $return;
        }

    }


?>
