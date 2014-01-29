function launchIC( userID, destinationUserID )
{
	var popupWindowTest = window.open( "../messenger/icnew.php?strDestinationUserID=" + destinationUserID, "ICWindow_" + replaceAlpha(userID) + "_" + replaceAlpha(destinationUserID), "width=360,height=420" );
	if( popupWindowTest == null )
	{
		if( confirm( "Your popup blocker stopped an InstantCommunicator window from opening\nPlease disable it and then click 'ok'" ) )
		{
			launchIC( userID, destinationUserID );
		}
	}
}

function replaceAlpha( strIn )
{
	var strOut = "";
	for( var i = 0 ; i < strIn.length ; i++ )
	{
		var cChar = strIn.charAt(i);
		if( ( cChar >= 'A' && cChar <= 'Z' )
			|| ( cChar >= 'a' && cChar <= 'z' )
			|| ( cChar >= '0' && cChar <= '9' ) )
		{
			strOut += cChar;
		}
		else
		{
			strOut += "_";
		}
	}

	return strOut;
}