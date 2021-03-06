<?php

require_once 'config.php';

$id = $_GET["id"];

//Creamos la conexión
$conexion = mysqli_connect($server, $user, $password, $db) 
    or die("Ha sucedido un error inexperado en la conexion de la base de datos");

//Generamos la consulta
$sql = "SELECT e.id AS id_existencia, e.cantidad AS cantidad, p.id as id_producto, p.nombre_producto AS producto, l.nombre_localizacion AS localizacion, sl.nombre_sublocalizacion AS sublocalizacion, c.fecha_caducidad AS caducidad, p.otros_nombres FROM san_existencias AS e LEFT JOIN san_productos AS p ON (e.producto = p.id) LEFT JOIN san_localizaciones AS l ON (e.localizacion = l.id) LEFT JOIN san_sublocalizaciones AS sl ON (e.sublocalizacion = sl.id) LEFT JOIN san_caducidades AS c ON (e.caducidad = c.id) WHERE l.nombre_localizacion = 'Farmacia' AND p.id = '$id'";
mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($conexion, $sql)) die();

$clientes = array(); //creamos un array

while($row = mysqli_fetch_array($result)) 
{ 
    $id_existencia=$row['id_existencia']; 
    $id_producto=$row['id_producto'];
    $nombre_producto=$row['producto'];
    $nombre_localizacion=$row['localizacion'];
    $nombre_sublocalizacion=$row['sublocalizacion'];
    $fecha_caducidad=$row['caducidad'];
    $otros_nombres=$row['otros_nombres'];
    $cantidad=$row['cantidad'];
    

    $existencias[] = array('id_existencia'=> $id_existencia, 'cantidad' => $cantidad, 'id_producto' => $id_producto, 'nombre_producto' => $nombre_producto, 'nombre_localizacion' => $nombre_localizacion, 'nombre_sublocalizacion' => $nombre_sublocalizacion, 'fecha_caducidad' => $fecha_caducidad, 'otros_nombres' => $otros_nombres);

}

//desconectamos la base de datos
$close = mysqli_close($conexion) 
    or die("Ha sucedido un error inexperado en la desconexion de la base de datos");


//Creamos el JSON
$json_string = json_encode($existencias);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/


?>
