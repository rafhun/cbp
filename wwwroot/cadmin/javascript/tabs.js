/* integration example

	<a id="CLASSNAME_DIVNAME1" class="active" href="javascript:{}" onclick="selectTab(DIVNAME1)">DIVNAME1</a>
	<a id="CLASSNAME_DIVNAME2" href="javascript:{}" onclick="selectTab(DIVNAME2)">DIVNAME2</a>
	
	<div id="DIVNAME1" class="CLASSNAME"></div>
	<div id="DIVNAME2" class="CLASSNAME"></div>
*/

function selectTab(tabName)
{
	if(document.getElementById(tabName).style.display != "block")
	{
		document.getElementById(tabName).style.display = "block";
		strClass = document.getElementById(tabName).className;
		document.getElementById(strClass+"_"+tabName).className = "active";
		
		arrTags = document.getElementsByTagName("*");
		for (i=0;i<arrTags.length;i++)
		{
			if(arrTags[i].className == strClass && arrTags[i] != document.getElementById(tabName))
			{
				arrTags[i].style.display = "none";
				if (document.getElementById(strClass+"_"+arrTags[i].getAttribute("id"))) {
					document.getElementById(strClass+"_"+arrTags[i].getAttribute("id")).className = "";
				}
			}
		}
	}
}