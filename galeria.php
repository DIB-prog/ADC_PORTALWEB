<?php
$dir = "\ADC\ADC_PORTALWEB\galeria";
$files = scandir($dir);
?>

<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería</title>
    <meta name="description" content="Únete a la revolución del hormigón prefabricado. Innovación, sostenibilidad y oportunidades para jóvenes arquitectos e ingenieros.">

    <!-- Fuentes modernas -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS para animaciones -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Estilos principales -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="/img/favicon.jpg" type="image/jpg">
</head>
<body data-page="galeria">
         <nav class="navbar" id="navbar">
            <div class="nav-container nopad">

                <div class="nav-img">

                    <a href="/" target="_blank">
                        <i class="fa-solid fa-arrow-left fa-2x"></i>
                    </a>
                    <a href="https://www.andece.org/" target="_blank">
                        <img src="img/Logo2019_500.png" alt="Logo">
                    </a>

                </div>

                <div class="nav-logo">
                    <a href="/" target="_blank">
                             <h2>Creo<span class="accent gris">Mi</span><span class="accent">Futuro</span></h2>
                    </a>
                </div>

            </div>
        </nav>
    
<section class="galeria-img">
    <div class="tittle-gal">    
        <div class="nav-logo">
            <h1 class="gale">Galería<span class="accent"> Completa</span></h1>
        </div> 
    </div>

<section class="galeria-img2">
    
<?php
foreach ($files as $file) {
    if (in_array(pathinfo($file, PATHINFO_EXTENSION), ["jpg","png","jpeg","gif"])) {
        echo "<img src='galeria/$file'/>";
    }
}
?>

    </section>

</section>

  

    
    
</body>

</html>