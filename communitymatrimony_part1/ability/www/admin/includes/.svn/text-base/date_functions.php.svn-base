<?

    // Create Day string

$day_arr=array( "0>dd", "01>01", "02>02", "03>03", "04>04", "05>05", "06>06", "07>07", "08>08", "09>09",
 "10>10", "11>11", "12>12", "13>13", "14>14", "15>15", "16>16", "17>17", "18>18", "19>19", "20>20",
 "21>21", "22>22", "23>23", "24>24", "25>25", "26>26", "27>27", "28>28", "29>29", "30>30", "31>31");

$day_str="<option value=". implode( "</option>\n<option value=", $day_arr) ."</option></select>";

    // Create Month string

$mon_arr=array( "mmm>mmm", "01>Jan", "02>Feb", "03>Mar", "04>Apr", "05>May",
 "06>Jun", "07>Jul", "08>Aug", "09>Sep", "10>Oct", "11>Nov", "12>Dec");

$mon_str="<option value=". implode( "</option>\n<option value=", $mon_arr) ."</option></select>";

    // Create Year string

$year_arr=array("0>YYYY","2005>2005","2006>2006","2007>2007","2008>2008","2009>2009","2010>2010","2011>2011");
$year_str="<option value=". implode( "</option>\n<option value=", $year_arr) ."</option></select>";	
	

function show_date( $var, $date_val)
{
    if( $date_val)
    {
       $sel_day=date( "d", $date_val);

       $sel_mon=date( "M", $date_val);

       $sel_year=date( "Y", $date_val);

    }  else  {

       $sel_day="dd";  $sel_mon="mmm";  $sel_year="yyyy";
    }
        // select day

    $find=">$sel_day<";   $repl=" selected$find";

    $ret_str ="<select style='width:50px;font-family: MS Sans serif, arial, Verdana, sans-serif;font-size : 9pt' name=". $var ."day>";

    $ret_str.=ereg_replace( $find, $repl, $GLOBALS[day_str]);

        //  select month

    $find=">$sel_mon<";   $repl=" selected$find";

    $ret_str.=" <select style='width:50px;font-family: MS Sans serif, arial, Verdana, sans-serif;font-size : 9pt' name=". $var ."mon>";

    $ret_str.=ereg_replace( $find, $repl, $GLOBALS[mon_str]);

        //  select year

    $find=">$sel_year<";    $repl=" selected$find";

    $ret_str.=" <select style='width:50px;font-family: MS Sans serif, arial, Verdana, sans-serif;font-size : 9pt' name=". $var ."year>";

    $ret_str.=ereg_replace( $find, $repl, $GLOBALS[year_str]);

    return $ret_str;
}

?>