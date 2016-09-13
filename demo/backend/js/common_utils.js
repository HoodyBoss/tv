//Validate email

var defaultDateFormat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/; //Default date format is dd/mm/yyyy or dd-mm-yyyy
var emailFormat = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var numberFormat = /^-{0,1}\d*\.{0,1}\d+$/;

function submitForm(  varName , itemVal , target , frm , trgt )
{
	//var frm_ = document.frm;

	frm = frm == null ? document.frm : frm;

	target = target == null || target == "" ? frm.action : target;

	trgt = trgt == null || trgt == "" ? "" : trgt;

	for (ii=0;ii<varName.length;ii++)
	{
		var obj = document.getElementById(varName[ii]);
		obj.value = itemVal[ii];
	}
	frm.target = trgt;
	frm.action = target;
	frm.submit();
}

function validateForm( inputName , inputType , inputFormat , inputRequire , inputDesc )
{

	if ( 
		inputName.length == inputType.length
		&& inputType.length == inputFormat.length
		&& inputFormat.length == inputRequire.length
		&& inputRequire.length == inputDesc.length
		)
	{
		//Do nothing
	}
	else
	{
		var msg = "Some parameter is missing inputName : "+inputName.length;
		msg += " inputType : "+inputType.length;
		msg += " inputFormat : "+inputFormat.length;
		msg += " inputRequire : "+ inputRequire.length;
		msg += " inputDesc: "+inputDesc.length;

		alert(msg);
		return false;
	}

	var obj;
	for (var ii=0;ii<inputName.length ;ii++ )
	{
		obj = document.getElementById( inputName[ii] );
		if ( inputRequire[ii] == 1 && obj.value == "")
		{
			alert("Pleae fill in "+inputDesc[ii]);
			obj.focus();
			return false;
		}
		else
		{
			if (inputType[ii] == "number" && !isNumber(obj) )
			{
				alert("Pleae fill in "+inputDesc[ii]+" numeric value only.");
				obj.focus();
				return false;
			}
			else if (inputType[ii] == "email" && !validateEmail(obj) )
			{
				alert("Pleae fill in "+inputDesc[ii]+" email format only.");
				obj.focus();
				return false;
			}
		}
	}

	return true;

}

function validateEmail(obj)
{
	if ( obj == null || obj == "undefined")
	{
		alert("Invalid object : "+obj);
		return false;
	}

	if (!emailFormat.test(obj.value))
	{
		return false;
	}
	return true;
}

function isNumber(obj)
{
	if ( obj == null || obj == "undefined")
	{
		alert("Invalid object : "+obj);
		return false;
	}

	if (!numberFormat.test(obj.value))
	{
		return false;
	}
	return true;
}

function isDate( obj , dFormat)
{

	if ( obj == null || obj == "undefined")
	{
		alert("Invalid object : "+obj);
		return false;
	}

	dFormat = dFormat == null ?  defaultDateFormat : dFormat;

	if (!dFormat.test(obj.value))
	{
		return false;
	}

	return true;
}

//Validate data order from Begin date to End date 
function isDateOrder( d1 , d2 )
{
	 
	 var startDate = createDateObj(d1);
	 var endDate = createDateObj(d2);

	 if (startDate == null)
	 {
		 alert("Invalid date : "+d1);
		 return false;
	 }

	 if (endDate == null)
	 {
		 alert("Invalid date : "+d2);
		 return false;
	 }

	 if ( startDate > endDate )
	 {
		 return false;
	 }
	 else
		 return true;

}

function createDateObj( dateStr )
{
	var opera1 = dateStr.split('/');  
	var opera2 = dateStr.split('-');  
	lopera1 = opera1.length;  
	lopera2 = opera2.length;  
	  // Extract the string into month, date and year  
	if (lopera1>1)  
	{  
	  var pdate = inputText.value.split('/');  
	}  
	else if (lopera2>1)  
	{  
	   var pdate = inputText.value.split('-');  
	 }  
	 var dd = parseInt(pdate[0]);  
	 var mm  = parseInt(pdate[1]);  
	 var yy = parseInt(pdate[2]); 
     
	 var dt = new Date( yy , mm , dd );
	 return dt;

}

//Send date string format dd/mm/yyyy or dd-mm-yyyy
function validateDayOfMonth( dateStr )
{
	var dateObj = createDateObj( dateStr );

	var year = dateObj.getYear();
	var month = dateObj.getMonth()+1;
	var day = dateObj.getDate();

	if (month == 2) {
        if (day == 29) {
            if ((year % 4 != 0 || year % 100 == 0) && year % 400 != 0) {
               return false;
            }
        }
        else if (day > 28) {
            return false;
        }
    }
    else if (month == 4 || month == 6 || month  == 9 || month == 11) {
        if (day > 30) {
            return false;
        }
    }
    else {
        if (day > 31) {
           return false;
		}
    }

	return true;

}

function validateLength( obj , operator , len )
{
	operator = operator == null || operator == "" ? "=" : operator;

	if ( obj == null || obj == "undefined")
	{
		alert("Invalid object : "+obj);
		return false;
	}

	var val = obj.value;
	var bool = false;
	
	if (operator == "=" && val.length == len)
	{
		bool = true;
	}
	else if (operator == "<" && val.length < len)
	{
		bool = true;
	}
	else if (operator == ">" && val.length > len)
	{
		bool = true;
	}
	else if (operator == "<=" && val.length <= len)
	{
		bool = true;
	}
	else if (operator == ">=" && val.length >= len)
	{
		bool = true;
	}
	else if ( ( operator == "!=" || operator == "<>" ) && val.length != len)
	{
		bool = true;
	}

	return bool;
}