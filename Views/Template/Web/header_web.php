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
    
    <!-- Google Fonts: Manrope & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= media() ?>/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/all.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/brands.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/regular.min.css">
    <link rel="stylesheet" href="<?= media() ?>/css/solid.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>
<body>
    <!-- loading spinner is handled in css, HTML goes here if needed -->

    <?php
    include_once "nav_web.php";
    ?>