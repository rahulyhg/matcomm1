<?php

if ($handle = opendir('/home/product/community/ability/www/admin/paymentassistance/')) {
   
	/* This is the correct way to loop over the directory. */
    while (false !== ($filename = readdir($handle))) {

		$expFilename1 = explode(".",$filename);
		$expFilenameCount = count($expFilename1) - 1;
		if($expFilename1[$expFilenameCount] == "csv")
		{
			$file_handle = fopen($filename, "r");
			echo "<table width='100%'>";
			while (!feof($file_handle) )
			{
				$lineText = fgetcsv($file_handle, 1024);
				if($lineText[8] == "Call Matured" || $lineText[13] == "")
					echo  "<tr><td>".$lineText[2] . "</td><td>".$lineText[8] . "</td><td>".$lineText[13]."</td></tr>";

				if($lineText[8] == "" || ($lineText[13] == "INCOMPLETE_NUMBER" || $lineText[13] == "UNALLOCATED_NUMBER"))
					echo  "<tr><td>".$lineText[2] . "</td><td>".$lineText[8] . "</td><td>".$lineText[13]."</td></tr>";
			}
			echo "</table>";
			fclose($file_handle);

		    echo "$filename : ext - ";
			echo $expFilename1[$expFilenameCount]."<br>";
		}
    }
 
    closedir($handle);
}



?>