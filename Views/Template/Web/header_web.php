<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= nameWeb() ?>
    </title>
    <link rel="shortcut icon" href="<?= media() ?>/images/icons/logoEPS.png" type="image/x-icon">
    <link href="<?= media() ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= media() ?>/css/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= media() ?>/css/stylepw.css">
    <link rel="stylesheet" href="<?= media() ?>/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/all.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/brands.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/regular.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/solid.min.css">

</head>
<style>
    #loading-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    #loading-spinner {
        border: 8px solid rgba(45, 62, 80, 0.3);
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    #loading-text {
        margin-top: 20px;
        font-size: 1.2em;
        color: #333;
    }

    #content {
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Estilos para hacer que el body tenga al menos 100vh y el footer siempre esté abajo */
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;

    }

    main {
        flex: 1;
    }

    /* Estilos para la galería de imágenes */
    .gallery-item {
        transition: transform 0.3s ease;
    }

    .gallery-item:hover {
        transform: scale(1.03);
    }

    .gallery-overlay {
        transition: opacity 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1 !important;
    }

    /* Estilos para las tarjetas de servicios */
    .service-card {
        transition: all 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .service-icon {
        transition: transform 0.3s ease;
    }

    .service-card:hover .service-icon {
        transform: scale(1.1);
    }

    /* Estilos para las tarjetas institucionales */
    .info-card {
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
    }
</style>


<!-- <script>
    var loadingContainer = document.querySelector('#loading-container');
</script> -->

<body>
    <!-- <div id="loading-container">
        <div id="loading-spinner"></div>
        <p id="loading-text">Cargando...</p>
    </div> -->

    <?php
    include_once "nav_web.php";
    ?>