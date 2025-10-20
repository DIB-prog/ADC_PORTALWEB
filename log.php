<!DOCTYPE html>
<html>
<body>
<?php
$servername = "hostingmysql321.nominalia.com";
$username = "dibcli";
$password = "DibParaClientes";
$database = "clients";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, usuari, contrasenya FROM adc_usuaris";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["usuari"]. " " . $row["contrasenya"]. "<br>";
  }
} else {
  echo "0 results";
}

$sql2 = "INSERT INTO adc_usuaris (usuari, contrasenya, activo) VALUES ('Daniel', 'dgdsg', 1)";

if ($conn->query($sql2) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql2 . "<br>" . $conn->error;
}

$conn->close();
?>
</body>
</html>