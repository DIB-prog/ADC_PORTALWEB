<?php 
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

require_once "Conection.php";
      
$db = new Conection();
$conn = $db->conect();
 $validEmail = true;
 $validDelete = true;


                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             

                    if (isset($_POST['confirmAdd'])) {

                        
      
                        $titulo = $_POST['titulo2'];
                        $descripcion = $_POST['descripcion2'];
                        $ubicacion = $_POST['ubicacion2'] ?? '';
                        $horas = $_POST['horas2'];
                        $informacion = $_POST['informacion2'];
                        $mail = $_POST['mail2'];
                        $modalidad = $_POST['modalidad2'];

                        $stmt = $conn->prepare("INSERT INTO adc_practicas (titulo, descripcion, ubicacion, horas, modalidad, mail, informacion) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssisss", $titulo, $descripcion, $ubicacion, $horas, $modalidad, $mail, $informacion);
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



                         $ubicacion = $_POST['ubicacion'] ?? '';
                         $horas = $_POST['horas'];
                         $informacion = $_POST['informacion'];

                         $mail = $_POST['mail'];
                         $modalidad = $_POST['modalidad'];

                        if (filter_var("$mail", FILTER_VALIDATE_EMAIL)) {
                            $validEmail = true;
                       
                         $stmt = $conn->prepare("UPDATE adc_practicas SET titulo = ?, descripcion = ?, ubicacion = ?, horas = ?, modalidad = ?, mail = ?, informacion = ? WHERE id = $idq");
                         $stmt->bind_param("sssisss", $titulo, $descripcion, $ubicacion, $horas, $modalidad, $mail, $informacion);
                         $stmt->execute();
              
                         if ($stmt->affected_rows > 0) {
                             echo "<script>alert('Datos enviados correctamente!');
                                    window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                              </script>";
                        } 
                    

                          } else {
                              $validEmail = false;
                          }
                     }
                        if (!$validEmail): ?>
                             <script>
                                alert("No se han enviado datos.\nInvalid email");
      
                            </script>
                     <?php endif;

                    } elseif (isset($_POST['confirmarEliminar'])) {
                       
                        $idToDelete = $_POST['idEliminar'];
                        echo $idToDelete;
                        $stmt = $conn->prepare("DELETE FROM adc_practicas WHERE id = ?");
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
    <title>Prácticas</title>
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

            <li class="li_ptacticas cabecera editable">
                <div class="titulo">Título</div>
                <div class="description">Descripción</div>
                <div class="ubication"><i class="fa-solid fa-location-dot"></i> Ubicación</div>
                <div class="horas">Horas</div>
                <div class="modalidad"> Modalidad</div>
                <div class="linkInfo"><i class="fa-solid fa-circle-info"></i></div>
                <div class="info"><i class="fa-solid fa-envelope"></i></div>
                <div class="editarPrac"><i class="fa-solid fa-pencil"></i></div>
                <div class="deletePractica"><i class="fa-regular fa-trash-can"></i></div>
              
            <?php
            
            $sql = "SELECT * FROM adc_practicas ORDER BY id ASC";
            $result = $conn->query($sql);
       
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
          
                    ?>
                    <li class="li_ptacticas editable" data-id="<?php echo $row['id']; ?>">
                        <div class="titulo " data-id="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['titulo']); ?></div>
                        <div class="description" data-id="<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars(trim($row['descripcion'])); ?>
                        </div>
                        <div class="ubication" data-id="<?php echo $row['id']; ?>"><i class="fa-solid fa-location-dot"></i>
                            <?php echo htmlspecialchars($row['ubicacion']); ?></div>
                        <div class="horas" data-id="<?php echo $row['id']; ?>"><i class="fa-solid fa-clock"></i>
                            <?php echo htmlspecialchars($row['horas']); ?></div>

                            <div class="modalidad" data-id="<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($row['modalidad']); ?></div>

                        <div class="linkInfo" data-id="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['informacion']); ?>
                        </div>
                        <div class="info" data-id="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['mail']); ?> </div>
                        <button class="editarPrac" data-id="<?php echo $row['id']; ?>">
                            <div class="info"><i class="fa-solid fa-pencil"></i></div>
                        </button>
                        <button class="deletePractica" data-id="<?php echo $row['id']; ?>">
                            <div class="info"><i class="fa-regular fa-trash-can"></i></div>
                        </button>
                    </li>
                    <?php
                }

            } else {
                echo "<li class='li_ptacticas'><div colspan='6'>No hay prácticas disponibles</div></li>";
            }
                $conn->close();
            ?>
        </ul>

        <div id="aviso">
            <p>Estas seguro que deseas eliminar esta práctica?</p>
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

                    <h5>Ubicación</h5>
                    <textarea name="ubicacion" id="" required></textarea>
                    </div>   

                    <div class="areaTitle">
                        <h5>Horas</h5>
                        <textarea name="horas" id="" required></textarea>
                    </div>

                    <div class="areaTitle">
                        <h5>Modalidad</h5>
                        <textarea name="modalidad" id="" required></textarea>
                    </div>


                    <div class="areaTitle">
                        <h5>Información</h5>
                        <textarea name="informacion" id="" required></textarea>
                    </div>  

                    <div class="areaTitle">
                        <h5>Email</h5>
                        <textarea class="last" name="mail" id="" required></textarea>
                    </div>

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
                    <div class="areaTitle">

                    <h5>Ubicación</h5>
                    <textarea name="ubicacion2" id="" required></textarea>
                    </div>   

                    <div class="areaTitle">
                        <h5>Horas</h5>
                        <textarea name="horas2" id="" required></textarea>
                    </div>

                    <div class="areaTitle">
                        <h5>Modalidad</h5>
                        <textarea name="modalidad2" id="" required></textarea>
                    </div>
                    


                    <div class="areaTitle">
                        <h5>Información</h5>
                        <textarea name="informacion2" id="" required></textarea>
                    </div>  

                    <div class="areaTitle">
                        <h5>Email</h5>
                        <textarea class="last" name="mail2" id="" required></textarea>
                    </div>


                </div>

                <div class="confirmEdit">
                    <button id="confirmaAdd" type="submit" name="confirmAdd">Confirmar</button>
                    <button id="cancelAdd" type="button" name="cancelAdd">Cancelar</button>
                </div>

                

            </form>
            
    </div>

    <div class="addLine">   
        <button class="butonLine" id="sumLinea">Añadir Línea</button>
    </div>

    </main>

    <div id="overlay"></div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
<!-- <main>
         <div class="courses-featured">
    <h3>Cursos Destacados</h3>
    
    <div class="parent">
        <div class="div1 course-card">
            <section class='FlexContainer'>
                <div>
                    <h4>título del curso</h4>
                </div>
                <div>
                    <p>Descripción breve del curso que destaca sus beneficios y objetivos principales.</p>
                </div>
                <div class="course-info">
                    <span><i class="fas fa-map-marker-alt"></i> Barcelona</span>
                    <span><i class="fas fa-globe"></i> Online</span>
                </div>
                <div class="course-info">
                    <span><i class="fas fa-clock"></i> 99 horas</span>
                </div>

                <div class="course-info">
                    <a href="#" class="btn btn-primary"> Información </a>
                    <a href="#" class="btn btn-primary">Mail</a>
                </div>
            </section>
               
        </div>

        <div class="div2 course-card">
            <section class='FlexContainer'>
                <div>
                    <h4>título del curso</h4>
                </div>
                <div>
                    <p>Descripción breve del curso que destaca sus beneficios y objetivos principales. Descripción breve del curso que destaca sus beneficios y objetivos principales</p>
                </div>
              
                <div class="course-info">
                    <span><i class="fas fa-map-marker-alt"></i> Barcelona</span>
                    <span><i class="fas fa-globe"></i> Online</span>
                </div>
                <div class="course-info">
                    <span><i class="fas fa-clock"></i> 99 horas</span>
                </div>


                <div class="course-boton">
                    <a href="#" class="btn btn-primary"> Información </a>
                    
                    <a href="#" class="btn btn-primary">Mail</a>
                </div>
            </section>
               
        </div>

        <div class="div3 course-card">
            <section class='FlexContainer'>
                <div>
                    <h4>título del curso</h4>
                </div>
                <div>
                    <p>Descripción breve del curso que destaca sus beneficios y objetivos principales.</p>
                </div>

                <div class="course-info">
                    <span><i class="fas fa-map-marker-alt"></i> Barcelona</span>
                    <span><i class="fas fa-globe"></i> Online</span>
                </div>
                <div class="course-info">
                    <span><i class="fas fa-clock"></i> 99 horas</span>
                </div>


                <div class="course-info">
                    <a href="#" class="btn btn-primary size"> Información </a>
                    <a href="#" class="btn btn-primary size">Mail</a>
                </div>
            </section>
               
        </div>

        <div class="div4 course-card">
            <section class='FlexContainer'>
                <div>
                    <h4>título del curso</h4>
                </div>
                <div>
                    <p>Descripción breve del curso que destaca sus beneficios y objetivos principales.</p>
                </div>
                <div class="course-info">
                    <span><i class="fas fa-map-marker-alt"></i> Barcelona</span>
                    <span><i class="fas fa-industry"></i> Presencial</span>
                </div>
                <div class="course-info">
                    <span><i class="fas fa-clock"></i> 99 horas</span>
                </div>


                <div class="course-boton">
                    <a href="#" class="btn btn-primary size"> Info </a>
                    <a href="#" class="btn btn-primary size">Mail</a>
                </div>
            </section>
               
        </div>

        <div class="div5 course-card">
            <section class='FlexContainer'>
                <div>
                    <h4>título del curso</h4>
                </div>
                <div>
                    <p>Descripción breve del curso que destaca sus beneficios y objetivos principales.</p>
                </div>
                <div class="course-info">
                    <p>Barcelona</p>
                    <p>Presencial</p>
                </div>
                <div class="course-info">
                    <p>99 horas</p>
                </div>

                <div class="course-info">
                    <a href="#" class="btn btn-primary"> Info </a>
                    <a href="#" class="btn btn-primary">Mail</a>
                </div>
            </section>
               
        </div>

        <div class="div6 course-card">
            <section class='FlexContainer'>
                <div>
                    <h4>título del curso</h4>
                </div>
                <div>
                    <p>Descripción breve del curso que destaca sus beneficios y objetivos principales.</p>
                </div>
                <div class="course-info">
                    <p>Barcelona</p>
                    <p>Presencial</p>
                </div>
                <div class="course-info">
                    <p>99 horas</p>
                </div>

                <div class="course-info">
                    <a href="#" class="btn btn-primary"> Info </a>
                    <a href="#" class="btn btn-primary">Mail</a>
                </div>
            </section>
               
        </div>

        <div class="div7 course-card">
            <section class='FlexContainer'>
                <div>
                    <h4>título del curso</h4>
                </div>
                <div>
                    <p>Descripción breve del curso que destaca sus beneficios y objetivos principales.</p>
                </div>
                <div class="course-info">
                    <p>Barcelona</p>
                    <p>Presencial</p>
                </div>
                <div class="course-info">
                    <p>99 horas</p>
                </div>

                <div class="course-info">
                    <a href="#" class="btn btn-primary"> Info </a>
                    <a href="#" class="btn btn-primary">Mail</a>
                </div>
            </section>
               
        </div>

        <div class="div8 course-card">
            <section class='FlexContainer'>
                <div>
                    <h4>título del curso</h4>
                </div>
                <div>
                    <p>Descripción breve del curso que destaca sus beneficios y objetivos principales.</p>
                </div>
                <div class="course-info">
                    <p>Barcelona</p>
                    <p>Presencial</p>
                </div>
                <div class="course-info">
                    <p>99 horas</p>
                </div>

                <div class="course-info">
                    <a href="#" class="btn btn-primary"> Info </a>
                    <a href="#" class="btn btn-primary">Mail</a>
                </div>
            </section>
               
        </div>

       
        </div>

    </div>
</div>

    </main>
   <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Crea<span class="accent">Futuro</span></h3>
                    <p>El futuro del prefabricado de hormigón está en tus manos. Únete a la revolución.</p>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/company/andece1964/" target="_blank">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://www.youtube.com/channel/UCxxxxx" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://www.instagram.com/andece_oficial/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://twitter.com/andece" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Para Jóvenes</h4>
                    <ul>
                        <li><a href="#carreras">Carreras y Becas</a></li>
                        <li><a href="#academia">Academia Online</a></li>
                        <li><a href="#premios">Premios y Concursos</a></li>
                        <li><a href="#inspirate">Historias Inspiradoras</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Recursos</h4>
                    <ul>
                        <li><a href="#explora">Proyectos</a></li>
                        <li><a href="#linkedin">Blog</a></li>
                        <li><a href="#">Documentos Técnicos</a></li>
                        <li><a href="#">Normativas</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>ANDECE</h4>
                    <ul>
                        <li><a href="#sobre-andece">Quiénes Somos</a></li>
                        <li><a href="#">Empresas Asociadas</a></li>
                        <li><a href="#contacto">Contacto</a></li>
                        <li><a href="#">Política de Privacidad</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; 2025 ANDECE - Asociación Nacional de la Industria del Prefabricado de Hormigón. Todos los derechos reservados.</p>
                    <p class="footer-note">
                        Esta web está diseñada para inspirar a jóvenes profesionales a unirse al futuro de la construcción sostenible.
                    </p>
                </div>
            </div>
        </div>
    </footer> -->