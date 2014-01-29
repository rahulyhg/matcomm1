function disableCtrlKeyCombination(e)
{
//list all CTRL + key combinations you want to disable
var forbiddenKeys = new Array('a', 'n', 'c', 'x', 'v', 'j','r');
var key;
var isCtrl;
if(window.event)
{
 key = window.event.keyCode;     //IE
 if(window.event.ctrlKey)
 isCtrl = true;
 else
 isCtrl = false;
}
else
{
 key = e.which;     //firefox
 if(e.ctrlKey)
	{//alert('Ctrl key has been disabled');
	return false;}
 }
//if ctrl is pressed check if other key is in forbidenKeys array
if(isCtrl)
        {
                for(i=0; i<forbiddenKeys.length; i++)
                {
                        //case-insensitive comparation
                        if(forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
                        {
                                //alert('Key combination CTRL + '                                      +String.fromCharCode(key)                                        +' has been disabled.');
                                return false;
                        }
                }
        }


if(window.event && window.event.keyCode == 116 )
{
	saveCode=window.event.keyCode;
	window.event.keyCode = 507;
	if(window.event && window.event.keyCode == 507)
	{
	//alert('F5 has been disabled');
	return false;
	}
}
else
{
	key = e.which;//firefox
	if(key==116)
	{//alert('F5 has been disabled');
	return false;}
}
        return true;
}

//window.onKeyDown=return disableCtrlKeyCombination(event);
