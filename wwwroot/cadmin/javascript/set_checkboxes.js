/**
 * Checks/unchecks all checkboxes
 *
 * @param   string	objForm	the form name
 * @param	string	elCheckbox	the name of the checkbox(-es)
 * @param   boolean	do_check	whether to check or to uncheck the element
 *
 * @return  boolean  always true
 */
function changeCheckboxes(objForm, elCheckbox, do_check)
{
	with (document.forms[objForm])
	{	
	    var box      = elements[elCheckbox];
//	    alert(objForm.elCheckbox.value);
	                  
	    var box_cnt  = (typeof(box.length) != 'undefined')
	                  ? box.length
	                  : 0;
	                  
	    if (box_cnt) {
	        for (var i = 0; i < box_cnt; i++)  {
	            box[i].checked = do_check;
	        }
	    } else {
	        box.checked = do_check;
	    }	
	    return true;
	}	    
}

/**
* Checks if at least one of the checkboxes named strCheckbox is checked
* @param	string	strForm	name of the form
* @param	string	strCheckbox	name of the checkbox(-es)
* @return	boolean	true if at least one is checked, otherwise false
*/
function checkboxIsChecked(strForm,strCheckbox)
{
    var x = 0;
    for(var i = 0; i < document.getElementsByName(strForm)[0].elements.length; i++)
    {
        var objElement = document.getElementsByName(strForm)[0].elements[i];
        if(objElement.name == strCheckbox && objElement.checked == true)
        {
            x++;
        }
    }
    if(x > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}