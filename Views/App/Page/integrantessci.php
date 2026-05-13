<?php
headerWeb($data);
$arrIntegrantes = optIntegrantesSci();

?>

<main class="mb-5">

    <!-- ===== ENCABEZADO ===== -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bold mb-3">
                        <i class="fas fa-users text-primary"></i> Integrantes del Sistema de Control Interno
                    </h1>
                    <p class="text-muted mb-0">
                        Conozca a los miembros que conforman el Sistema de Control Interno (SCI) de nuestra institución
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== LISTADO DE INTEGRANTES ===== -->
    <section class="py-4">
        <div class="container">
            <div class="row">

                <?php if (count($arrIntegrantes) > 0): ?>
                    <?php foreach ($arrIntegrantes as $index => $value): ?>

                        <div class="col-12 col-sm-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow text-center">

                                <!-- FOTO -->
                                <div class="pt-4">
                                    <img
                                        src="<?= media() ?>/upload/images/<?= $value["i_foto"] ?>"
                                        class="rounded-circle img-thumbnail mx-auto d-block"
                                        alt="<?= $value['i_nombres'] . ' ' . $value['i_apellidos'] ?>"
                                        loading="lazy"
                                        width="120"
                                        height="120">
                                </div>

                                <!-- INFO -->
                                <div class="card-body">
                                    <h6 class="fw-bold mb-1">
                                        <?= $value['i_nombres'] . " " . $value['i_apellidos'] ?>
                                    </h6>

                                    <p class="mb-1 small text-primary fw-bold">
                                        <?= $value["i_cargo"] ?>
                                    </p>

                                    <?php if (!empty($value["i_dependencia"])): ?>
                                        <p class="mb-1 small text-muted">
                                            <i class="fas fa-building"></i> <?= $value["i_dependencia"] ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if (!empty($value["i_correo"]) || !empty($value["i_celular"])): ?>
                                        <div class="mt-3">
                                            <?php if (!empty($value["i_correo"])): ?>
                                                <button
                                                    class="btn btn-outline-primary btn-sm me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalCorreo<?= $index ?>">
                                                    <i class="fa-regular fa-envelope"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($value["i_celular"])): ?>
                                                <button
                                                    class="btn btn-outline-success btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalCelular<?= $index ?>">
                                                    <i class="fab fa-whatsapp"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>

                        <!-- ===== MODAL EMAIL ===== -->
                        <?php if (!empty($value["i_correo"])): ?>
                        <div class="modal fade" id="modalCorreo<?= $index ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header py-2">
                                        <h6 class="modal-title mb-0">Correo institucional</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        <i class="fa-regular fa-envelope text-primary mb-2" style="font-size: 2rem;"></i>
                                        <p class="mb-0 small">
                                            <a href="mailto:<?= $value["i_correo"] ?>">
                                                <?= $value["i_correo"] ?>
                                            </a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- ===== MODAL CELULAR ===== -->
                        <?php if (!empty($value["i_celular"])): ?>
                        <div class="modal fade" id="modalCelular<?= $index ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header py-2">
                                        <h6 class="modal-title mb-0">Número de celular</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        <i class="fab fa-whatsapp text-success mb-2" style="font-size: 2rem;"></i>
                                        <p class="mb-0 small">
                                            <a href="https://wa.me/51<?= $value["i_celular"] ?>" target="_blank" rel="noopener">
                                                <?= $value["i_celular"] ?>
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
                            <i class="fas fa-exclamation-triangle"></i> No hay integrantes registrados.
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

</main>

<?php footerWeb($data); ?>
