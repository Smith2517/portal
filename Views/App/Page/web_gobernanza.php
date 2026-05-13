<?php headerWeb($data); ?>

<main class="main">
    <section class="section-full bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    
                    <h2 class="text-center mb-5 fw-bold">Gobernanza</h2>

                    <div class="accordion" id="accordionGobernanza">

                        <?php
                        if (isset($data['gobernanza']) && !empty($data['gobernanza'])) {
                            $items = $data['gobernanza'];
                            $itemCount = 0;

                            foreach ($items as $item) {
                                $itemCount++;
                                $isActive   = '';
                                $isExpanded = 'false';
                        ?>

                        <!-- ITEM PRINCIPAL -->
                        <div class="accordion-item shadow-sm">
                            <h2 class="accordion-header" id="headingItem<?= intval($item['id']); ?>">
                                <button class="accordion-button collapsed" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapseItem<?= intval($item['id']); ?>" 
                                        aria-expanded="<?= $isExpanded ?>" 
                                        aria-controls="collapseItem<?= intval($item['id']); ?>">

                                    <i class="fas fa-folder-open me-2 text-primary"></i>
                                    <?= htmlspecialchars($item['nombre']); ?>
                                </button>
                            </h2>

                            <div id="collapseItem<?= intval($item['id']); ?>" 
                                 class="accordion-collapse collapse <?= $isActive ?>" 
                                 data-bs-parent="#accordionGobernanza">

                                <div class="accordion-body p-2">

                                    <?php if (isset($item['indicadores']) && !empty($item['indicadores'])) { ?>

                                        <div class="accordion" id="accordionIndicadores<?= intval($item['id']); ?>">

                                            <?php foreach ($item['indicadores'] as $indicador) { ?>

                                                <!-- INDICADOR -->
                                                <div class="accordion-item border-0">
                                                    <h2 class="accordion-header" id="headingIndicador<?= intval($indicador['id']); ?>">
                                                        <button class="accordion-button collapsed bg-light"
                                                                type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseIndicador<?= intval($indicador['id']); ?>">

                                                            <i class="fas fa-chart-line me-2 text-success"></i>
                                                            <?= htmlspecialchars($indicador['nombre']); ?>
                                                        </button>
                                                    </h2>

                                                    <div id="collapseIndicador<?= intval($indicador['id']); ?>" 
                                                         class="accordion-collapse collapse">

                                                        <div class="accordion-body p-2">

                                                            <?php if (isset($indicador['archivos']) && !empty($indicador['archivos'])) { ?>

                                                                <div class="list-group list-group-flush">

                                                                    <?php foreach ($indicador['archivos'] as $archivo) { 
                                                                        $rutaArchivo = base_url() . '/' . $archivo['archivo_ruta'];
                                                                    ?>

                                                                        <div class="list-group-item d-flex justify-content-between align-items-center">

                                                                            <div>
                                                                                <i class="fas fa-file-pdf pdf-icon me-2"></i>
                                                                                <strong><?= htmlspecialchars($archivo['titulo']); ?></strong>

                                                                                <?php if (!empty($archivo['descripcion'])) { ?>
                                                                                    <p class="mb-0 mt-1 text-muted small">
                                                                                        <?= htmlspecialchars($archivo['descripcion']); ?>
                                                                                    </p>
                                                                                <?php } ?>
                                                                            </div>

                                                                            <a href="<?= $rutaArchivo; ?>" 
                                                                               target="_blank" 
                                                                               class="btn btn-sm btn-outline-primary download-link">

                                                                                <i class="fas fa-download"></i> Descargar
                                                                            </a>
                                                                        </div>

                                                                    <?php } ?>

                                                                </div>

                                                            <?php } else { ?>
                                                                <p class="text-muted p-3">No hay archivos disponibles.</p>
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


<style>

/* CONTENEDOR */
.accordion-item {
    border: none;
    margin-bottom: 12px;
    border-radius: 12px;
    overflow: hidden;
}

/* BOTÓN */
.accordion-button {
    font-weight: 600;
    font-size: 15px;
    background-color: #ffffff;
    transition: all 0.3s ease;
}

/* HOVER */
.accordion-button:hover {
    background-color: #f1f5f9;
}

/* ACTIVO */
.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: #fff;
}

/* ICONO FLECHA */
.accordion-button::after {
    filter: brightness(0.5);
}

.accordion-button:not(.collapsed)::after {
    filter: brightness(5);
}

/* INDICADORES */
#accordionIndicadores .accordion-item {
    background-color: #f8f9fa;
    margin: 8px;
    border-radius: 10px;
}

/* ARCHIVOS */
.list-group-item {
    border: none;
    border-bottom: 1px solid #eee;
    transition: all 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

/* PDF */
.pdf-icon {
    color: #e53935;
    font-size: 18px;
}

/* BOTÓN DESCARGA */
.download-link {
    border-radius: 20px;
    font-size: 13px;
    padding: 5px 12px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .accordion-button {
        font-size: 14px;
        padding: 10px;
    }

    .download-link {
        font-size: 11px;
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