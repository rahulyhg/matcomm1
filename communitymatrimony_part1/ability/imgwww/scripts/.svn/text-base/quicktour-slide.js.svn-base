	function qtpnumtab(dname, count) {
		for(var i=0; i<=count; i++)
		{
			var divid = "qtslide"+i;
			var tdivid = "pnumon"+i;
			var tdividc = "pnumoff"+i;			
			document.getElementById(divid).style.display="none";
			document.getElementById(tdivid).style.display="none";
			document.getElementById(tdividc).style.display="block";
		}

		for(var i=0; i<=count; i++)
		{
			var divid1 = "qtslide"+i;
			var tdivid = "pnumon"+i;
			var tdividc = "pnumoff"+i;
			if(divid1==dname)
			{		
				if(i==0)
				{
					document.getElementById('backbutton').style.display="none";
					document.getElementById('nextbutton').style.display="block";
					for(var j=0; j<=count; j++)
					{
						var tdivid = "pnumon"+j;
						var tdividc = "pnumoff"+j;
						document.getElementById(tdivid).style.display="none";
						document.getElementById(tdividc).style.display="none";
					}
					document.getElementById(divid1).style.display="block";
				}
				else if(i==count)
				{
					document.getElementById('nextbutton').style.display="none";
					document.getElementById(divid1).style.display="block";
					document.getElementById(tdivid).style.display = "block";
					document.getElementById(tdividc).style.display = "none";
					document.getElementById('backbutton').style.display="block";
				}
				else
				{
					document.getElementById(divid1).style.display = "block";
					document.getElementById(tdivid).style.display = "block";
					document.getElementById(tdividc).style.display = "none";
					document.getElementById('nextbutton').style.display="block";
					document.getElementById('backbutton').style.display="block";
				}
			}
		}
	}


	function qtclickbutton(c, count) {
		if(c=="nxt")
		{
			for(var i=0; i<=count; i++)
			{
				var divid = "qtslide"+i;
				var tdivid = "pnumon"+i;
				var tdividc = "pnumoff"+i;
				if(document.getElementById(divid).style.display=="block")
				{
					document.getElementById(divid).style.display="none";
					document.getElementById(tdivid).style.display="none";
					document.getElementById(tdividc).style.display="block";

					if(i==0)
					{
						document.getElementById('backbutton').style.display="block";
						for(var j=2; j<=count; j++)
						{
							var tdividc = "pnumoff"+j;
							document.getElementById(tdividc).style.display="block";
						}					
					}					
					i++;
					var divid1 = "qtslide"+i;
					document.getElementById(divid1).style.display="block";
					var tdivid = "pnumon"+i;
					var tdividc = "pnumoff"+i;
					document.getElementById(tdivid).style.display="block";
					document.getElementById(tdividc).style.display="none";

					if(i==count)
					{document.getElementById('nextbutton').style.display="none";}	
				}
			}
		}

		if(c=="prev")
		{
			for(var i=0; i<=count; i++)
			{
				var divid = "qtslide"+i;
				var tdivid = "pnumon"+i;
				var tdividc = "pnumoff"+i;
				if(document.getElementById(divid).style.display=="block")
				{
					document.getElementById(divid).style.display="none";
					document.getElementById(tdivid).style.display="none";
					document.getElementById(tdividc).style.display="block";
					
					i--;
					var divid1 = "qtslide"+i;
					document.getElementById(divid1).style.display="block";
					var tdivid = "pnumon"+i;
					var tdividc = "pnumoff"+i;
					document.getElementById(tdivid).style.display="block";
					document.getElementById(tdividc).style.display="none";

					if(i==(count-1))
					{document.getElementById('nextbutton').style.display="block";}

					if(i==0)
					{
						document.getElementById('backbutton').style.display="none";
						for(var j=0; j<=count; j++)
						{
							var tdivid = "pnumon"+j;
							var tdividc = "pnumoff"+j;
							document.getElementById(tdivid).style.display="none";
							document.getElementById(tdividc).style.display="none";
						}
					}					
				}
			}
		}
	}