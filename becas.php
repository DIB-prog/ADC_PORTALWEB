<?php 
session_start();
$comunidad = isset($_GET['comunidad']) ? $_GET['comunidad'] : '';   

$asociados = [];
$total = 0;
$errorMsg = '';
$config = parse_ini_file('.env');
        if ($config === false) {
            die("Error: No se pudo cargar el archivo .env");
        }

if(!empty($comunidad)) {
    $_SESSION['comunidad'] = $comunidad;
    $url = "https://andece.org/wp-json/andece/v1/comunidad?comunidad=" . urlencode($comunidad);

    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n" ."X-API-KEY: ". $config['API_KEY']."\r\n"

        ]
    ];
 
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
   
    if($response !== false) {
        $data = json_decode($response, true);
        if (isset($data['asociados'])) {
            $asociados = $data['asociados'];
            $total = isset($data['total']) ? $data['total'] : count($asociados);
          
        }else if (isset($data['error'])) {
            $errorMsg = $data['error'];

        } else {
            $errorMsg = 'No se encontraron asociados para la comunidad especificada.';
        }
    } else {
        $errorMsg = 'Error al obtener los datos de la API.';
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asiociados</title>
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
    <link rel="icon" href="/img/favicon.jpg" type="image/jpg">
</head>
<body data-page="practicas">
    <header>
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
    </header>
    <main>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; align-items: center;">

            <h3  class="associados-titulo" style="justify-self: start; margin-top: 20px; font-family: 'Poppins', sans-serif;">
            <?= !empty($comunidad) ? "Total: " . count($asociados) : "" ?>
            </h3>

            <h3 class="associados-titulo" style="justify-self: center; margin-top: 20px; font-family: 'Poppins', sans-serif;">
            <?= !empty($comunidad) ? $comunidad : "Seleccione una comunidad" ?>
            </h3>

        </div>
        
          <ul class="ul_practicas">

            <li class="li_ptacticas cabecera">
          
                <div class="">Asociado</div>
                <div class="">Provincia</div>
                <div class="">Población</div>
            </li>
            <?php
            
            if (empty($errorMsg)) {
                 foreach ($asociados as $asociado) {
                    echo "<li class='li_ptacticas asociado' data-id='" . htmlspecialchars($asociado['id']) . "'>";
                    //echo "<div class='titulo'>" . htmlspecialchars($asociado['id']) . "</div>";
                    echo "<div class=''>" . html_entity_decode($asociado['nombre'], ENT_QUOTES | ENT_HTML5, 'UTF-8') . "</div>";
                    echo "<div class=''>" . html_entity_decode($asociado['provincia'], ENT_QUOTES | ENT_HTML5, 'UTF-8') . "</div>";
                    echo "<div class=''>" . html_entity_decode($asociado['poblacion'], ENT_QUOTES | ENT_HTML5, 'UTF-8') . "</div>";
                    echo "</li>";
                }
            } else {
                $errorMsg =!empty($errorMsg) ? $errorMsg : 'No se encontraron asociados para la comunidad especificada.';
                echo "<li class='li_ptacticas'><div class='error'>$errorMsg</div></li>";
            }
            
            ?> 
            </ul>

    </main>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
     <script src="js/script.js"></script>
    
</body>
</html>