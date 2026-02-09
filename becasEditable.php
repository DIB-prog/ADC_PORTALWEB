<?php 
require_once "Conection.php";

session_start();
if ( $_SESSION['login_time'] + 3600 < time() ) {

    session_unset();
    session_destroy();
    header("Location: login.html");
    exit();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.html");
    exit();
}

      
$db = new Conection();
$conn = $db->conect();
 $validEmail = true;
 $validDelete = true;

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['confirmAdd'])) {
                        $titulo = $_POST['titulo2'];
                        $descripcion = $_POST['descripcion2'];
                    
               
                        $informacion = $_POST['informacion2'];
                        $mail = $_POST['mail2'];
                     
                        $importe = $_POST['importe2'];

                        $stmt = $conn->prepare("INSERT INTO adc_becas (titulo, Descripcion, Importe, Informacion, mail) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("ssiss", $titulo, $descripcion, $importe, $informacion, $mail);
                          if ($stmt->execute()) {
                            if ($stmt->affected_rows > 0) {
                                echo "<script>alert('Datos enviados correctamente!');
                                 window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                           
                                </script>";
                            }
                        }   
                    } elseif (isset($_POST['confirmar'])) {



                     $confirmar = isset($_POST['confirmar']) ? true : false;

if ($confirmar) {

    $idq = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $mail = $_POST['mail'];
    $importe = $_POST['importe'] ?? '';
    $informacion = $_POST['informacion'];

 
    if (filter_var("$mail", FILTER_VALIDATE_EMAIL)) {
        $validEmail = true;

        $stmt = $conn->prepare("UPDATE adc_becas 
                                SET titulo=?, Descripcion=?, Importe=?, Informacion=?, mail=? 
                                WHERE ID=?");
        $stmt->bind_param("ssissi", $titulo, $descripcion, $importe, $informacion, $mail, $idq);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Datos enviados correctamente!');
                  window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                  </script>";
        }

    } else {
        $validEmail = false;
        echo "<script>alert('El email no es válido');</script>";
    }
}


                    } elseif (isset($_POST['confirmarEliminar'])) {
                       
                        $idToDelete = $_POST['idEliminar'];
                        echo $idToDelete;
                        $stmt = $conn->prepare("DELETE FROM adc_becas WHERE id = ?");
                        $stmt->bind_param("i", $idToDelete);
                        $stmt->execute();

                        if ($stmt->affected_rows > 0 ){
                            $validDelete = true;
                          
                            echo "<script>alert('Práctica eliminada correctamente!');
                                  window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                                  </script>";
                        } else {
                            $validDelete = false;
                           
                        }
                    }
                    if (!$validDelete): ?>
                        <script>
                            alert("Error al eliminar la práctica.");
                        </script>       
                    <?php $validDelete = true; endif;
                }
            

               ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Becas</title>
    <!-- Estilos principales -->
    <!-- <link rel="stylesheet" href="CSS/style2.css"> -->
    <!-- Fuentes modernas -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS para animaciones -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

</head>

<body data-page="practicas">
    <header>

        <nav class="navbar" id="navbar">
            <div class="nav-container nopad">

                <div class="nav-img">

                    <a href="menu.php" target="_blank">
                        <i class="fa-solid fa-arrow-left fa-2x"></i>
                    </a>
                    <a href="menu.php" target="_blank">
                        <img src="img/Logo2019_500.png" alt="Logo">
                    </a>

                </div>

                <div class="nav-toggle" id="nav-toggle">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
                <div class="nav-logo">
                    <a href="/" target="_blank">
                        <h2>Creo<span class="accent gris">Mi</span><span class="accent">Futuro</span></h2>
                    </a>
                </div>

            </div>
        </nav>

    </header>
    <main class="petit">
        <ul class="ul_practicas">

      
                <li class="li_ptacticas cabecera editable beca">
                    <div class="titulo">Título</div>
                    <div class="description">Descripción</div>
                    <div class="importe">Importe</div>
                    <div class="linkInfo"><i class="fa-solid fa-circle-info"></i></div>
                    <div class="info trans"><i class="fa-solid fa-envelope"></i></div>
                    <div class="editarPracB"><i class="fa-solid fa-pencil"></i></div>
                    <div class="deletePractica"><i class="fa-regular fa-trash-can"></i></div>
     
                </li>
            <?php
            $sql = "SELECT * FROM adc_becas ORDER BY id ASC";
            $result = $conn->query($sql);
       
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
          
                    ?>
                    <li class="li_ptacticas editable beca" data-id="<?php echo $row['id']; ?>">
                        
                        <div class="titulo" data-id="<?php echo $row['ID']; ?>"> <?php echo htmlspecialchars($row['titulo']); ?></div>
                        <div class="description" data-id="<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['Descripcion']); ?></div>
                        <div class="importe" data-id="<?php echo $row['ID']; ?>"> <?php echo htmlspecialchars($row['Importe']); ?></div>
                        <div class="linkInfo" data-id="<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['Informacion']); ?></div>
                         <div class="info" data-id="<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['mail']); ?> </div>
                        <button class="editarPracB der" data-id="<?php echo $row['ID']; ?>">
                            <div class="info"><i class="fa-solid fa-pencil"></i></div>
                        </button>
                        <button class="deletePractica" data-id="<?php echo $row['ID']; ?>">
                            <div class="info"><i class="fa-regular fa-trash-can"></i></div>
                        </button>
           
                  
                    </li>
                    <?php
                }

            } else {
                echo "<li class='li_ptacticas'><div colspan='6'>No hay becas disponibles</div></li>";
            }
                $conn->close();
            ?>
        </ul>

        <div id="aviso">
            <p>Estas seguro que deseas eliminar esta beca?</p>
            <div class="botones">

                <form class="confirmDelete" action="" method="post">
                    <input type="hidden" name="idEliminar" id="idEliminar">
                <button id="confirmarEliminar" class="confirmarDelete" name = "confirmarEliminar">Confirmar</button>
                <button id="cancelarEliminar" type="button" class="cancelar">Cancelar</button>
                </form>
            </div>
        </div>

        <div id="editar" class="editar">
            <form class="informacion" method="post">
                <div class="areasInput">
                    <input type="hidden" name="id" id="idEditar">


                    <div class="areaTitle">
                        <h5>Título</h5>
                        <textarea name="titulo" id="" required></textarea>
                    </div>

                    <div class="areaTitle" > 
                        <h5>Descripción</h5>
                        <textarea name="descripcion" id="" required></textarea>
                    </div>
                    

                
                    <div class="areaTitle">
                        <h5>Importe</h5>
                        <textarea name="importe" id="" required></textarea>
                    </div>


                    <div class="areaTitle ">
                        <h5>Información</h5>
                        <textarea name="informacion" class="last" id="" required></textarea>
                    </div>  

                    <div class="areaTitle">
                        <h5>Email</h5>
                        <textarea name="mail" class="last" id="" required></textarea>
                    </div>
<!-- 
                    <div class="areaTitle">
                        <h5>Email</h5>
                        <textarea class="last" name="mail" id="" required></textarea>
                    </div> -->

                </div>

                <div class="confirmEdit">
                    <button id="confirmarEdicio" type="submit" name="confirmar">Confirmar</button>
                    <button id="cancelarEdicio" type="button" name="cancelar">Cancelar</button>
                </div>

            </form>
        
        </div>
   
  <div id="textEmpty" class="editar2">
    <form class="informacion" method="post">
                <div class="areasInput">
                   <div class="areaTitle">
                        <h5>Título</h5>
                        <textarea name="titulo2" id="" required></textarea>
                    </div>

                    <div class="areaTitle" > 
                        <h5>Descripción</h5>
                        <textarea name="descripcion2" id="" required></textarea>
                    </div>

                   <!-- <div class="areaTitle">

                     <h5>Ubicación</h5>
                    <textarea name="ubicacion2" id="" required></textarea>
                    </div>     

                    <div class="areaTitle">
                        <h5>Horas</h5>
                        <textarea name="horas2" id="" required></textarea>
                    </div>  -->

                    <div class="areaTitle">
                        <h5>Importe</h5>
                        <textarea name="importe2" id="" required></textarea>
                    </div>
                    
                    <div class="areaTitle">
                        <h5>Información</h5>
                        <textarea name="informacion2" class="last" id="" required></textarea>
                    </div>  
                     <div class="areaTitle">
                        <h5>Email</h5>
                        <textarea name="mail2" class="last" id="" required></textarea>
                    </div>

                    <!-- <div class="areaTitle">
                        <h5>Email</h5>
                        <textarea class="last" name="mail2" id="" required></textarea>
                    </div> -->

                </div>

                <div class="confirmEdit">
                    <button id="confirmaAdd" type="submit" name="confirmAdd">Confirmar</button>
                    <button id="cancelAdd" type="button" name="cancelAdd">Cancelar</button>
                </div>
            </form>  
    </div>

    <div class="addLine">   
        <button class="butonLine" id="sumLineaB" >Añadir Línea</button>
    </div>

    </main>

    <div id="overlay"></div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
