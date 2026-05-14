<?php
headerWeb($data);
$arrDescription = $data["page_infoCategoria"];
if (empty($arrDescription)) {
    require_once("Controllers/Error.php");
    die();
}
?>
<main class="mb-2">
    <!-- HEADER PUBLICO (TAILWIND BLOB-BG) -->
    <?php headerPublic('fas fa-folder', htmlspecialchars($arrDescription["c_Categoria"]), htmlspecialchars($arrDescription["c_Descripcion"])); ?>

    <section class="pt-1 px-1 px-md-5 bg-cover mt-4">
        <div class="container">
            <!-- IMAGEN DE LA CATEGORÍA -->
            <img class="w-100 rounded-4xl shadow-soft" loading="lazy" style="height: 300px; object-fit: cover;" src="<?= media() . "/upload/images/" . $arrDescription["c_Imagen"] ?>" alt="<?= htmlspecialchars($arrDescription["c_Descripcion"]) ?>">
        </div>
    </section>

    <section class="pt-2 mt-4 px-1 px-md-5">
        <div class="container">
            <div class="mb-4">
                <a href="<?= base_url() ?>/page/b" class="btn btn-hover btn-primary">
                    <i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Regresar</a>
            </div>
            <div id="card-list" class="row"></div>
            <div id="empty-message" class="alert alert-info mt-3" style="display: none;">
                No hay elementos para mostrar.
            </div>
            <div id="loading-message" class="alert alert-warning mt-3" style="display: none;">
                Cargando...
            </div>
            <button id="ver-mas" class="btn btn-primary mt-3">Ver más</button>
        </div>
    </section>
</main>
<script>
    const categoria = <?= $arrDescription["idCategoria"]  ?>
</script>
<?php
footerWeb($data);

?>