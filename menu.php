<?php

session_start();
if ( $_SESSION['login_time'] + 3600 < time() ) {
    session_unset();
    session_destroy();
    header("Location: ./login.html");
    exit();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
       echo '<script>
            alert("Hola2");
        </script>';
    header("Location: ./login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andece</title>
        <!-- Fuentes modernas -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS para animaciones -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Estilos principales -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main-container">

    <nav class="navbar" id="navbar">
            <div class="nav-container nopad">

                <div class="nav-img">
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
        <div class="header">
             <div class="section-header">
                <h2>Portal<span class="accent"> empleados</span></h2>
                <p>Seleciona editar becas, prácticas o ir a las diferentes secciones de la web publicada</p>
            </div>
        </div>
        
        <div class="buttons-container">
  
            <a  href="becasEditable.php"  target="_blank" class="btn btn-primary" id="">
            
                <span>Editar Becas</span>
            </a>
            <a href="/" target="_blank" class="btn btn-menu" id="">

                <span>Web</span>
            </a>
            
            <a href="practicasEditable.php" target="_blank" class="btn btn-primary" id="">
          
                <span>Editar Prácticas</span>
            </a>
        </div>

        <div class="becas-practicas-link">
            <a href="becas.php"  target="_blank" class="btn btn-menu">Becas web</a>
            <a href="practicas.php" target="_blank" class="btn btn-menu">Prácticas web</a>
        </div>
</body>
</html>