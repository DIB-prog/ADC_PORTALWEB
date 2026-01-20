<?php
/* funcio per hashear contraseñas */
$password = "1234"; /*posar la que vols hashear*/  

$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Contraseña: " . $password . "<br>";
/*ficar aquest hash a la bd*/ 
echo "Hash: " . $hash . "<br>";

?>