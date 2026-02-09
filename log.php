<?php
session_start();

require_once "Conection.php";
$db = new Conection();
$conn = $db->conect();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['uname'];
    $psw  = $_POST['psw'];

    $stmt = $conn->prepare("SELECT id, usuari, contrasenya FROM adc_usuaris WHERE usuari = ?");
    $stmt->bind_param("s", $name);  
    $stmt->execute();
    $stmt->bind_result($id, $usuari, $contrasenya_hash); 

    if ($stmt->fetch() && password_verify($psw, $contrasenya_hash)) {

        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $usuari;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time(); 

        header("Location: menu.php");
        exit();
    }

    $error = "Usuario o contraseña incorrectos";
}
?>

<!DOCTYPE html>
<html>
<body>


<?php if($error): ?>
    <p><?= $error ?></p>
<?php endif; ?>

</body>
</html>