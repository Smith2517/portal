<?php
headerWeb($data);
getModal('modalNormasMunicipales', $data);

$arrData = $data['page_arrData'];
$arrDescription = $arrData["description"];

if (empty($arrDescription)) {
    require_once("Controllers/Error.php");
    die();
}
?>

<main class="mb-4">

<!-- HEADER -->
<section class="pt-2 px-2 px-md-5">
    <div class="container">

        <img class="w-100 rounded shadow-sm mb-3"
             loading="lazy"
             src="<?= media() . "/upload/images/" . htmlspecialchars($arrDescription["tn_foto"]); ?>"
             alt="<?= htmlspecialchars($arrDescription["tn_descripcion"]); ?>">

        <h1 class="fw-bold">
            <?= htmlspecialchars($arrDescription["tn_nombre"]); ?>
            <?= ($arrData["thisYear"] > 0) ? " - " . $arrData["thisYear"] : "" ?>
        </h1>

        <p class="text-muted">
            <?= htmlspecialchars($arrDescription["tn_descripcion"]); ?>
        </p>

    </div>
</section>

<!-- CONTENIDO -->
<section class="mt-4 px-2 px-md-5">
<div class="container">

<?php if ($arrData["thisYear"] == 0): ?>

    <!-- GRID DE AÑOS -->
    <div class="row g-3">

        <?php if (!empty($arrData["year"])): ?>
            <?php foreach ($arrData["year"] as $value): ?>

                <div class="col-6 col-md-2">
                    <a href="<?= base_url(); ?>/page/normasmunicipales/<?= $arrData["id"]; ?>/<?= $value["a_anio"]; ?>"
                       class="card text-center text-decoration-none shadow-sm h-100 year-card">

                        <div class="card-body">
                            <h5 class="text-primary fw-bold">
                                <?= $value["a_anio"]; ?>
                            </h5>

                            <img src="<?= media(); ?>/images/icons/carpeta.png"
                                 class="img-fluid mb-2"
                                 style="max-height: 60px;">

                            <p class="small text-muted">
                                <?= ($value["total_nm"] > 1) ? $value["total_nm"] . " Docs." : $value["total_nm"] . " Doc."; ?>
                            </p>
                        </div>

                    </a>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>

    </div>

<?php else: ?>

    <!-- BOTÓN REGRESAR -->
    <div class="mb-4">
        <a href="<?= base_url(); ?>/page/normasmunicipales/<?= $arrData["id"]; ?>"
           class="btn btn-outline-primary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left"></i> Regresar
        </a>
    </div>

    <!-- TABLA -->
    <div class="table-responsive shadow-sm rounded">
        <table id="table" class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Documento</th>
                    <th>Año</th>
                    <th>Descripción</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script>
        let idTipoNorma = "<?= $arrData["id"] ?>";
        let year = "<?= $arrData["thisYear"] ?>";
    </script>

<?php endif; ?>

</div>
</section>

</main>

<?php footerWeb($data); ?>


<style>

/* TARJETAS DE AÑOS */
.year-card {
    border-radius: 12px;
    transition: all 0.3s ease;
}

.year-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* IMAGEN */
img {
    object-fit: cover;
}

</style>