<?php 
session_start();
$comunidad = isset($_SESSION['comunidad']) ? $_SESSION['comunidad'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';   

$errorMsg = '';
$config = parse_ini_file('.env');
        if ($config === false) {
            die("Error: No se pudo cargar el archivo .env");
        }

if(!empty($id)) {
   $url = "https://andece.org/wp-json/andece/v1/asociado/" . urlencode($id);

    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n" ."X-API-KEY: ". $config['API_KEY']."\r\n"

        ]
    ];
 
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    $data = json_decode($response, true);

    if (isset($data['id'])) {
        $asociado = $data;
    } elseif (isset($data['error'])) {
        $errorMsg = $data['error'];
    } else {
    $errorMsg = 'No se encontró el asociado.';  
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
    <?php var_dump($comunidad); ?>
    <header>
        <nav class="navbar" id="navbar">
            <div class="nav-container nopad">

                <div class="nav-img">
                      <a href="becas.php?comunidad=<?= urlencode($comunidad) ?>">
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
    <main class="item-main">
    
            <?php if (empty($errorMsg)) : ?>

                
            <?php else : ?>

    <?= htmlspecialchars($errorMsg) ?>

<?php endif; ?>
       <div class="Item-content">
    <div class="competition-card"
        style="display: flex; flex: 1; min-width: 300px; max-width: 600px; flex-direction: column; flex-wrap: nowrap; align-items: center; justify-content: space-between;">

        <div class="competition-header">
            <h3><?= htmlspecialchars($asociado['nombre']) ?></h3>
        </div>

        <div class="competition-content asociado-details">
           
            <ul class="competition-categories">
                <li><i class="fas fa-map"></i> <strong>Provincia:</strong> <?= htmlspecialchars($asociado['provincia']) ?></li>
                <li><i class="fas fa-city"></i> <strong>Población:</strong> <?= htmlspecialchars($asociado['poblacion']) ?></li>
                <li><i class="fas fa-home"></i> <strong>Dirección:</strong> <?= htmlspecialchars($asociado['direccion']) ?></li>
                <li><i class="fas fa-mail-bulk"></i> <strong>Código Postal:</strong> <?= htmlspecialchars($asociado['codigo_postal']) ?></li>
                <li><i class="fas fa-phone"></i> <strong>Teléfono:</strong> <?= htmlspecialchars($asociado['telefono']) ?></li>
                <li><i class="fas fa-envelope"></i> <strong>Email:</strong> <?= htmlspecialchars($asociado['email']) ?></li>
                <li><i class="fas fa-tags"></i> <strong>Categorias:</strong></li>
                <div class="competition-subcategories">
                   <p>
                    <?= htmlspecialchars(implode(', ', $asociado['categorias'])) ?>
                    </p>
                </div>
        </div>

        <div class="competition-buttons">
            <a href="<?= htmlspecialchars($asociado['sitio_web']) ?>"
               class="btn btn-primary"
               target="_blank"
               rel="<?= htmlspecialchars($asociado['sitio_web']) ?>">
                Visitar sitio web
            </a>
        </div>

    </div>
</div>
                
    </main>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
     <script src="js/script.js"></script>
    
</body>
</html>