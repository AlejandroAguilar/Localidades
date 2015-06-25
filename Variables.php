<?php
session_start();
$_SESSION['estado']=$_REQUEST['estado'];
$_SESSION['municipio']=$_REQUEST['municipio'];
$_SESSION['tabla']=$_REQUEST['tabla'];
?>
<?php
//$conexion=mysqli_connect('localhost','mario','yastrib7');
//mysqli_select_db($conexion,"cdavid_rainlife");
// https://www.googleapis.com/fusiontables/v1/query?sql=SELECT * FROM 1g8OxWNVxNo2B6fqNjjuWUoNVVS8ljTJ32qkf9oE where idINEGI=44&key=AIzaSyDMsshUXDV__vJaR20WsjOa0rTEZMatx04
//$folio = "SELECT id_user,id_nivel,aprobado FROM usrniv WHERE id_user=".$_POST['folio']." AND (id_nivel=2 OR id_nivel=3 OR id_nivel=4) AND id_suc=".$idselec;
//$consulta= "SELECT * FROM 1g8OxWNVxNo2B6fqNjjuWUoNVVS8ljTJ32qkf9oE where idINEGI=44&key=AIzaSyDMsshUXDV__vJaR20WsjOa0rTEZMatx04";

//$r = new HttpRequest('https://www.googleapis.com/fusiontables/v1/query?sql=SELECT * FROM 1g8OxWNVxNo2B6fqNjjuWUoNVVS8ljTJ32qkf9oE where idINEGI=44&key=AIzaSyDMsshUXDV__vJaR20WsjOa0rTEZMatx04', HttpRequest::METH_POST);
//$r = new Http_get("https://www.googleapis.com/fusiontables/v1/query?sql=SELECT * FROM 1g8OxWNVxNo2B6fqNjjuWUoNVVS8ljTJ32qkf9oE where idINEGI=44&key=AIzaSyDMsshUXDV__vJaR20WsjOa0rTEZMatx04");
//$result=mysqli_query($consulta);

//$url = 'https://www.googleapis.com/fusiontables/v1/query?sql=SELECT * FROM 1g8OxWNVxNo2B6fqNjjuWUoNVVS8ljTJ32qkf9oE where idINEGI=44&key=AIzaSyDMsshUXDV__vJaR20WsjOa0rTEZMatx04';
    //create the httprequest object
//$result = new httpRequest($url, HTTP_METH_POST);
//$_SESSION['resultado'] = $result;
?>
<html>
<head>
<title>Variables</title>
	<script language="JavaScript">
		location.href="Localidad.php"
	</script>
</head>
<body> 
</body>
</html> 