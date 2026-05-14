<?php headerWeb($data); ?>

<main class="main">
<?php headerPublic('fas fa-landmark', 'Gobernabilidad', 'Transparencia y documentos de gestión institucional de la EPS RIOJA S.A.'); ?>

<section class="section-full bg-light py-5">
<div class="container">
<div class="row">
<div class="col-12">

<div class="accordion" id="accordionGobernabilidad">

<?php

if (isset($data['gobernabilidad']) && !empty($data['gobernabilidad'])) {

    foreach ($data['gobernabilidad'] as $item) {

        $itemId = isset($item['id']) ? $item['id'] : rand(1,9999);
?>

<!-- ITEM PRINCIPAL -->
<div class="accordion-item">

<h2 class="accordion-header" id="headingItem<?php echo $itemId; ?>">

<button class="accordion-button collapsed"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#collapseItem<?php echo $itemId; ?>"
        aria-expanded="false">

<i class="fas fa-folder-open me-2 text-primary"></i>
<?php echo htmlspecialchars($item['nombre']); ?>

</button>
</h2>

<div id="collapseItem<?php echo $itemId; ?>"
     class="accordion-collapse collapse"
     data-bs-parent="#accordionGobernabilidad">

<div class="accordion-body p-2">

<?php if (!empty($item['indicadores'])) { ?>

<div class="accordion" id="accordionIndicadores<?php echo $itemId; ?>">

<?php foreach ($item['indicadores'] as $indicador) {

    $indId = isset($indicador['id']) ? $indicador['id'] : rand(1,9999);
?>

<!-- INDICADOR -->
<div class="accordion-item">

<h2 class="accordion-header" id="headingIndicador<?php echo $indId; ?>">

<button class="accordion-button collapsed bg-light"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#collapseIndicador<?php echo $indId; ?>">

<i class="fas fa-chart-line me-2 text-success"></i>
<?php echo htmlspecialchars($indicador['nombre']); ?>

</button>
</h2>

<div id="collapseIndicador<?php echo $indId; ?>"
     class="accordion-collapse collapse">

<div class="accordion-body p-2">

<?php if (!empty($indicador['archivos'])) { ?>

<div class="list-group list-group-flush">

<?php foreach ($indicador['archivos'] as $archivo) {

    $rutaArchivo = base_url() . '/' . $archivo['archivo_ruta'];
?>

<div class="list-group-item d-flex justify-content-between align-items-center">

<div>
<i class="fas fa-file-pdf pdf-icon me-2"></i>
<strong><?php echo htmlspecialchars($archivo['titulo']); ?></strong>

<?php if (!empty($archivo['descripcion'])) { ?>
<p class="mb-0 mt-1 text-muted small">
<?php echo htmlspecialchars($archivo['descripcion']); ?>
</p>
<?php } ?>

</div>

<a href="<?php echo $rutaArchivo; ?>"
   target="_blank"
   class="btn btn-sm btn-outline-primary download-link">

<i class="fas fa-download"></i> Descargar
</a>

</div>

<?php } ?>

</div>

<?php } else { ?>
<p class="text-muted p-3">No hay archivos disponibles para este indicador.</p>
<?php } ?>

</div>
</div>
</div>

<?php } ?>

</div>

<?php } else { ?>
<p class="text-muted p-3">No hay indicadores disponibles.</p>
<?php } ?>

</div>
</div>
</div>

<?php
    }

} else {
    echo '<div class="alert alert-info text-center">No hay información disponible.</div>';
}
?>

</div>

</div>
</div>
</div>
</section>
</main>

<?php footerWeb($data); ?>


<!-- 🎨 ESTILO PRO -->
<style>

/* CONTENEDOR */
.accordion-item {
    border: none;
    margin-bottom: 16px;
    border-radius: 14px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    transition: all 0.25s ease;
}

.accordion-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.08);
}

/* BOTÓN */
.accordion-button {
    font-weight: 600;
    font-size: 15px;
    padding: 14px 18px;
    background: #ffffff;
    transition: all 0.3s ease;
}

/* HOVER */
.accordion-button:hover {
    background: #f4f7fb;
}

/* ACTIVO */
.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #0d6efd, #3a8bfd);
    color: #fff;
}

/* FLECHA */
.accordion-button::after {
    filter: brightness(0.6);
}

.accordion-button:not(.collapsed)::after {
    filter: brightness(5);
}

/* INDICADORES */
#accordionIndicadores .accordion-item {
    background: #f8fafc;
    margin: 10px;
    border-radius: 12px;
    box-shadow: none;
}

/* ARCHIVOS */
.list-group-item {
    border: none;
    border-bottom: 1px solid #edf2f7;
    padding: 12px 15px;
    transition: all 0.2s ease;
}

.list-group-item:hover {
    background: #f4f7fb;
    transform: scale(1.01);
}

/* PDF */
.pdf-icon {
    color: #e53935;
    font-size: 18px;
}

/* BOTÓN */
.download-link {
    border-radius: 50px;
    font-size: 12px;
    padding: 6px 14px;
    transition: all 0.3s ease;
}

.download-link:hover {
    background: #0d6efd;
    color: #fff !important;
}

/* MOBILE */
@media (max-width: 768px) {
    .accordion-button {
        font-size: 14px;
        padding: 12px;
    }

    .download-link {
        font-size: 11px;
        padding: 5px 10px;
    }
}

</style>


<script>
document.addEventListener('DOMContentLoaded', function() {

    let loadingContainer = document.getElementById('loading-container');
    if (loadingContainer) loadingContainer.style.display = 'none';

    let content = document.getElementById('content');
    if (content) content.style.display = 'flex';

});
</script>