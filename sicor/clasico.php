<!DOCTYPE html> 
<html> 
<head>
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
<title>Botones con jQuery Mobile</title> 
<link rel="stylesheet" href="jquery.mobile-1.0.min.css" />
<script src="jquery-1.7.1.min.js"></script>
<script src="jquery.mobile-1.0.min.js"></script>
</head> 
<body>
<div data-role="page">
<div data-role="header"><h1>Botones</h1></div>
   <div data-role="content">
<a href="#" id ="boton" data-role="button" >Este es my buttton</a>
   <input type="button" data-role="button" value="Boton input"/>
   <input type="submit" data-role="button" value="Boton input con type submit"/>
   <a href="#" data-role="button" data-inline="true" >Tine el mismo ancho del texto</a>
   <a href="#" data-role="button" data-inline="true" data-theme="e" >Este boton es de otro color</a>
   <input type="submit" data-role="button" value="submit con otro color" data-theme="b"/>
   </div>
   <div data-role="footer"><h3>Botones</h3>
</div>
</body>
</html> 


