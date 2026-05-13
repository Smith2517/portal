<?php
headerWeb($data);
$arrDescription = $data["page_infoCategoria"];
if (empty($arrDescription)) {
    require_once("Controllers/Error.php");
    die();
}
?>
<main class="mb-2 ">
    <section class="pt-1 px-1 px-md-5 bg-cover">
        <div class="container">
            <img class="w-100 object-cover h-20" loading="lazy" style="" src="<?= media() . "/upload/images/" . $arrDescription["c_Imagen"] ?>" alt="<?= $arrDescription["c_Descripcion"] ?>">
        </div>
        <div class="container px-1">
            <h1>
                <?= $arrDescription["c_Categoria"] ?>
            </h1>
            <p class="text-justify">
                <?= $arrDescription["c_Descripcion"] ?>
            </p>
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