
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Becas</title>
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
                 <h2>Creo<span class="accent gris">Mi</span><span class="accent">Futuro</span></h2>
                </a>
            </div>
        </div>s
    </nav>

    </header>
    <main>
        <ul class="ul_practicas">

    <li class="li_ptacticas cabecera beca">
        <div class="titulo">Título</div>
        <div class="description">Descripción</div>
        <div class="importe">Importe</div>
        <div class="info"><i class="fa-solid fa-circle-info"></i></div> 
        <div class="contactanos">Contactanos</div>  
    </li>

    <?php
    require_once "Conection.php";
    $db = new Conection();
    $conn =  $db->conect();
    $sql = "SELECT * FROM adc_becas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <li class="li_ptacticas beca">
                <div class="titulo"><?php echo htmlspecialchars($row['titulo']); ?></div>
                <div class="description"><?php echo htmlspecialchars($row['Descripcion']); ?></div>
                <div class="importe"> <?php echo htmlspecialchars($row['Importe']); ?></div>
                <a href="<?php echo htmlspecialchars($row['informacion']); ?>" target="blank" ><div class="info"> <i class="fa-solid fa-circle-info"></i> </a></div>
                <a href="<?php echo htmlspecialchars($row['mail']); ?>"  target="blank"><div class="contactanos"><i class="fa-solid fa-envelope"></i></a></div>
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
 