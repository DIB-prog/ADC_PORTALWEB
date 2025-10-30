
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prácticas</title>
    <!-- Estilos principales -->
    <!-- <link rel="stylesheet" href="CSS/style2.css"> -->
    <!-- Fuentes modernas -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

                <a href="index.html" target="_blank">
                    <i class="fa-solid fa-arrow-left fa-2x"></i>
                </a>
                <a href="https://www.andece.org/" target="_blank" >
                <img src="img/Logo2019_500.png" alt="Logo">
                </a>

                
            </div>
            
           
           
            <div class="nav-logo">
                <a href="index.html" target="_blank">
                <h2>Crea<span class="accent">Futuro</span></h2>
                </a>
            </div>

             

            
        </div>
    </nav>

    </header>
    <main>
        <ul class="ul_practicas">

    <li class="li_ptacticas cabecera">
        <div class="titulo">Título</div>
        <div class="description">Descripción</div>
        <div class="ubication"><i class="fa-solid fa-location-dot"></i> Ubicación</div>
        <div class="horas">Horas</div>
        <div class="info"><i class="fa-solid fa-circle-info"></i></div>
        <div class="info"><i class="fa-solid fa-envelope"></i></div>
    </li>

    <?php
    require_once "Conection.php";
    $db = new Conection();
    $conn =  $db->conect();

    $sql = "SELECT * FROM adc_practicas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <li class="li_ptacticas">
                <div class="titulo"><?php echo htmlspecialchars($row['titulo']); ?></div>
                <div class="description"><?php echo htmlspecialchars($row['descripcion']); ?></div>
                <div class="ubication"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($row['ubicacion']); ?></div>
                <div class="horas"><i class="fa-solid fa-clock"></i> <?php echo htmlspecialchars($row['horas']); ?></div>
                <a href="<?php echo htmlspecialchars($row['informacion']); ?>" target="blank" ><div class="info"> <i class="fa-solid fa-circle-info"></i> </a></div>
                <a href=""  target="blank"><div class="info"><i class="fa-solid fa-envelope"></i></a></div>
            </li>
            <?php
        }
    } else {
        echo "<li class='li_ptacticas'><div colspan='6'>No hay prácticas disponibles</div></li>";
    }

    $conn->close();
    ?>
</ul>



    </main>
 

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
