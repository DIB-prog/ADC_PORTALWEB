<!DOCTYPE html>
<html>
<body>
<?php
require_once "Conection.php";
$db = new Conection();
$conn = $db->conect();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['uname'];
    $psw  = $_POST['psw'];

    // Preparar la consulta
    $stmt = $conn->prepare("SELECT id, usuari, contrasenya FROM adc_usuaris WHERE usuari = ? AND contrasenya = ?");
    $stmt->bind_param("ss", $name, $psw);
    $stmt->execute();

    // Ligar variables a las columnas seleccionadas
    $stmt->bind_result($id, $usuari, $contrasenya);

    $hay = false; // Para saber si hubo resultados
    while ($stmt->fetch()) {
        $hay = true;
        echo "id: " . $id . " - Name: " . $usuari . " " . $contrasenya . "<br>";
    }

    if (!$hay) {
        echo "No existe ";
    }

    $stmt->close();
}

$db->close();
?>
</body>
</html>