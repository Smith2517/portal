<?php
headerWeb($data);
if (!optFuncionario()) {
    notFound();
    die();
}
$arrFuncionario = $data['page_funcionarios']['info'];
?>

<main class="mb-5">

    <!-- ===== ENCABEZADO ===== -->
    <section class="py-2 bg-light">
        <div class="container">

            <div class="card border-0 shadow-sm mb-4">
                <img 
                    src="<?= media() ?>/upload/images/<?= $arrFuncionario['gf_foto'] ?>" 
                    class="card-img-top img-fluid rounded-top"
                    alt="<?= $arrFuncionario['gf_nombre'] ?>"
                    loading="lazy">

                <div class="card-body text-center">
                    <h1 class="fw-bold mb-3">
                        <?= $arrFuncionario['gf_nombre'] ?>
                    </h1>
                    <p class="text-muted mb-0">
                        <?= $arrFuncionario['gf_descripcion'] ?>
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- ===== LISTADO DE FUNCIONARIOS ===== -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">

                <?php if (count($data['page_funcionarios']['data']) > 0): ?>
                    <?php foreach ($data['page_funcionarios']['data'] as $index => $value): ?>

                        <div class="col-12 col-sm-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow text-center">

                                <!-- FOTO -->
                                <div class="pt-4">
                                    <img 
                                        src="<?= media() ?>/upload/images/<?= $value["f_fotoPerfil"] ?>"
                                        class="rounded-circle img-thumbnail mx-auto d-block"
                                        alt="<?= $value['f_nombres'] . ' ' . $value['f_apellidos'] ?>"
                                        loading="lazy"
                                        width="120"
                                        height="120">
                                </div>

                                <!-- INFO -->
                                <div class="card-body">
                                    <h6 class="fw-bold mb-1">
                                        <?= $value['f_nombres'] . " " . $value['f_apellidos'] ?>
                                    </h6>

                                    <p class="mb-1 small text-muted fst-normal">
                                        <?= $value["f_despendecia"] ?>
                                    </p>

                                    <p class="mb-3 small fst-normal">
                                        <?= $value["f_cargo"] ?>
                                    </p>

                                    <?php if (!empty($value["f_correo"])): ?>
                                        <button 
                                            class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalCorreo<?= $index ?>">
                                            <i class="fa-regular fa-envelope"></i> Ver correo
                                        </button>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>

                        <!-- ===== MODAL EMAIL ===== -->
                        <?php if (!empty($value["f_correo"])): ?>
                        <div class="modal fade" id="modalCorreo<?= $index ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header py-2">
                                        <h6 class="modal-title mb-0">Correo institucional</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        <i class="fa-regular fa-envelope text-primary mb-2"></i>
                                        <p class="mb-0 small">
                                            <a href="mailto:<?= $value["f_correo"] ?>">
                                                <?= $value["f_correo"] ?>
                                            </a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            No hay funcionarios registrados.
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

</main>

<?php footerWeb($data); ?>
