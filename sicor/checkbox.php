<html>
<script type="text/javascript">

function disableCheck(field, causer) 
{
	if (causer.checked) 
	{
	field.checked = false;
	field.disabled = true;
	}
	else 
	{
	field.disabled = false;
	}
}

function disableOthers(field) 
{
	disableCheck(formulario.dos, field);
	//disableCheck(formulario.tres, field);
}

function disableUno() 
{
	field = formulario.uno
	
	if (formulario.dos.checked) 
		{
		field.checked = false;
		field.disabled = true;
		}
	else {
		field.disabled = false;
		}
}

</script>
<body>
<form name="formulario">
<input type="checkbox" name="uno" onClick="disableOthers(this)"/><br/>
<input type="checkbox" name="dos" onClick="disableUno()"/><br/>
</form>
</body>
</html>
