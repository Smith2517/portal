<?php
headerWeb($data);
$arrDocumentos = isset($data['page_documentos']) && is_array($data['page_documentos']) ? $data['page_documentos'] : array();
?>

<main class="mb-5">

    <!-- ===== ENCABEZADO ===== -->
    <?php headerPublic('fas fa-images', 'Material Didáctico', 'Afiches y material visual de apoyo para el Sistema de Control Interno (SCI)'); ?>

    <!-- ===== LISTADO DE MATERIALES ===== -->
    <section class="py-4">
        <div class="container">
            <div class="row" id="listaDocumentos">

                <?php if (isset($arrDocumentos) && count($arrDocumentos) > 0): ?>
                    <?php foreach ($arrDocumentos as $value): ?>

                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm hover-shadow h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-file-pdf text-danger" style="font-size: 4rem;"></i>
                                    </div>
                                    <h5 class="card-title text-primary mb-3">
                                        <?= $value['md_nombre'] ?>
                                    </h5>
                                    <div class="d-grid gap-2">
                                        <a href="<?= base_url() ?>/Assets/upload/documentos/<?= $value['md_archivo'] ?>"
                                           target="_blank"
                                           class="btn btn-danger btn-sm"
                                           title="Ver material PDF">
                                            <i class="fas fa-eye"></i> Ver Material
                                        </a>
                                        <a href="<?= base_url() ?>/Assets/upload/documentos/<?= $value['md_archivo'] ?>"
                                           download="<?= $value['md_archivo_original'] ?>"
                                           class="btn btn-outline-danger btn-sm"
                                           title="Descargar material">
                                            <i class="fas fa-download"></i> Descargar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle"></i> No hay material didáctico registrado.
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

</main>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}
</style>

<?php footerWeb($data); ?>
