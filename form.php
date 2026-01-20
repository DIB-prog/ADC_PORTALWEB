<?php
require_once "Conection.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new Conection();   // creas el objeto
$conn = $db->conect();   // abres la conexión


$nombre = $tel = $email = $asunto = $mensaje = $newsletter = $date = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? '';
    $tel = $_POST["telefono"] ?? '';
    $email = $_POST["email"] ?? '';
    $asunto = $_POST["asunto"] ?? '';
    $mensaje = $_POST["mensaje"] ?? '';
    $newsletter = $_POST["newsletter"] ?? '';

    if (filter_var("$email", FILTER_VALIDATE_EMAIL)) {

        
    date_default_timezone_set("Europe/Madrid"); 
    $date = date("Y-m-d H:i:s"); // Formato compatible con DATETIME en MySQL



    $stmt = $conn->prepare("INSERT INTO adc_peticions_formulari 
            (nombre, correo_electronico, telefono, asunto, mensaje, recibir_informacion, fecha)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nombre, $email, $tel ,$asunto, $mensaje, $newsletter, $date);
   $stmt->execute();
        if ($stmt->execute()) {
            echo "Datos registrados correctamente.";
        } else {
            echo "Error al registrar datos: " . $stmt->error;
        }

            $stmt->close();

    

    } else {
     echo "<h1>No se han enviado datos</h1>";
     echo 'Invalid email';
    
    }

 
    } else{
     echo "<h1>No se han enviado datos, formulario incorrecto. </h1>";
 
    }

    $db->close();

    header("Location: index.html")

?>
