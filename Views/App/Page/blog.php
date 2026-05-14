<?php
headerWeb($data);
$arrDescription = $data["page_infoBlog"];
if (empty($arrDescription)) {
    require_once("Controllers/Error.php");
    die();
}
?>
<style>
    .header {
        font-family: 'Libre Caslon Display', serif;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category {
        text-align: right;
        font-size: 12px;
    }

    .date {
        text-align: left;
        font-size: 12px;
    }

    .title {
        font-family: 'DM Serif Display', serif;
        font-weight: bold;
        font-size: 30px;
        text-align: center;
    }

    .introduction {
        font-family: 'DM Serif Display', serif;
        font-style: italic;
        font-size: 14px;
        margin-top: 10px;
        text-align: center;
    }

    .cover-image {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        margin-top: 20px;
    }

    .image-description {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: 11px;
        margin-top: 5px;
    }

    .divider {
        border-top: 1px solid #ccc;
        margin-top: 20px;
    }

    .publisher-info {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: 12px;
        display: flex;
        align-items: center;
        margin-top: 20px;
    }

    .publisher-image {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .publisher-name {
        font-family: 'Source Sans Pro', sans-serif;
        font-weight: bold;
        font-style: italic;
    }

    .publisher-role {
        font-family: 'Source Sans Pro', sans-serif;
        font-style: italic;
    }

    .publisher-email {
        font-family: 'Source Sans Pro', sans-serif;
        font-style: italic;
    }

    .highlighted-text {
        font-family: 'Arapey', serif;
        font-size: 16px;
        font-weight: bold;
        margin-top: 20px;
    }

    .cuerpo {
        font-family: 'Arapey', sans-serif;
        font-size: 12.5px;
    }

    .file-viewer {
        font-family: 'Arapey', sans-serif;
        font-size: 20px;
        max-width: 100%;
        height: auto;
        margin-top: 10px;
        align-items: center;
    }

    .closing-divider {
        border-top: 1px solid #ccc;
        margin-top: 10px;
    }

    .full-date {
        font-family: 'Lato', sans-serif;
        font-style: italic;
        font-size: 12px;
        margin-top: 5px;
        color: gray;
    }
</style>


<main class="mb-3">
    <!-- HEADER PUBLICO (TAILWIND BLOB-BG) -->
    <?php headerPublic('fas fa-newspaper', htmlspecialchars($arrDescription["b_Titulo"]), htmlspecialchars($arrDescription["b_subTitulo"])); ?>

    <section class="pt-2 mt-3 px-1 px-md-5 mb-3">
        <div class="container bg-white p-4 p-md-5 rounded-4xl shadow-soft">
            <div class="header border-bottom pb-3 mb-4">
                <div class="category badge bg-water-100 text-water-800 p-2 rounded-full"><i class="fas fa-tag me-1"></i><?= $arrDescription["c_Categoria"] ?></div>
                <div class="date text-muted"><i class="fas fa-calendar-alt me-1"></i><?= $arrDescription["b_fechaRegistro"] ?></div>
            </div>

            <img src="<?= base_url() . "/Assets/upload/images/" . $arrDescription["b_Imagen"] ?>" alt="Imagen de Portada" class="cover-image rounded-3xl w-100 mb-3" style="max-height: 400px; object-fit: cover;">

            <div class="image-description text-center text-muted mb-4"><?= $arrDescription["b_descripcionImagen"] ?></div>

            <div class="divider"></div>



            <div class="cuerpo">
                <!-- Cuerpo de la noticia -->
                <div class="highlighted-text"><?= $arrDescription["b_Titulo"] ?></div>
                <div>
                    <p class="fs-sm"><?= $arrDescription["b_Contenido"] ?></p>
                </div>

                <div class="file-viewer">

                    <!-- Para documentos PDF -->
                    <div class="mt-3">
                        <object data="<?= $arrDescription["b_Embed"] ?>" class="w-100" height="500px">
                            <p>El visualizador de PDFs no está disponible en tu navegador. Puedes descargar el archivo <a href="<?= $arrDescription["b_Embed"] ?>">aquí</a>.</p>
                        </object>
                    </div>
                </div>
            </div>
            <div class=" closing-divider">
            </div>
        </div>
    </section>
</main>

<?php
footerWeb($data);
?>