<!DOCTYPE html>
<html>
<body>
<?php
// Iniciar sesión al principio para poder usar $_SESSION
session_start();

require_once "Conection.php";
$db = new Conection();
$conn = $db->conect();

$error = ""; // Variable para mensajes de error

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['uname'];
    $psw  = $_POST['psw'];

    $stmt = $conn->prepare("SELECT id, usuari, contrasenya FROM adc_usuaris WHERE usuari = ?");
    $stmt->bind_param("s", $name);  
    $stmt->execute();

    // Ligar variables a las columnas seleccionadas
    $stmt->bind_result($id, $usuari, $contrasenya_hash); 

    $hay = false;
    
   
    if ($stmt->fetch()) {
     
        if (password_verify($psw, $contrasenya_hash)) {
            $hay = true;
    
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $usuari;
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time(); 
            
            header("Location: menu.php");
            exit();
        }
    }
    
    // Si llegamos aquí, el login falló
    if (!$hay) {
        $error = "Usuario o contraseña incorrectos";
    }

    $stmt->close();
}

$db->close();
?>
</body>
</html>