<?php
headerWeb($data);
$arrIntegrantes = optIntegrantesSci();

?>

<main class="mb-5">

    <!-- ===== ENCABEZADO ===== -->
    <section class="py-5 bg-white blob-bg position-relative overflow-hidden border-bottom border-slate-100">
        <div class="container position-relative z-1">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-up">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-water-50 text-water-600 mb-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h1 class="display-5 font-heading fw-bold text-water-900 mb-3">
                        Integrantes del Sistema de Control Interno
                    </h1>
                    <p class="lead text-slate-500 mb-0 mx-auto" style="max-width: 600px;">
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

                        <div class="col-12 col-sm-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                            <div class="card h-100 border-0 shadow-soft service-card text-center">

                                <!-- FOTO -->
                                <div class="pt-4">
                                    <div class="d-inline-block rounded-circle p-2 bg-water-50">
                                        <img
                                            src="<?= media() ?>/upload/images/<?= $value["i_foto"] ?>"
                                            class="rounded-circle img-fluid"
                                            alt="<?= $value['i_nombres'] . ' ' . $value['i_apellidos'] ?>"
                                            loading="lazy"
                                            style="width: 120px; height: 120px; object-fit: cover;">
                                    </div>
                                </div>

                                <!-- INFO -->
                                <div class="card-body">
                                    <h5 class="font-heading fw-bold text-water-900 mb-1">
                                        <?= $value['i_nombres'] . " " . $value['i_apellidos'] ?>
                                    </h5>

                                    <p class="mb-2 text-water-600 fw-bold small">
                                        <?= $value["i_cargo"] ?>
                                    </p>

                                    <?php if (!empty($value["i_dependencia"])): ?>
                                        <p class="mb-4 small text-slate-500">
                                            <i class="fas fa-building me-1"></i> <?= $value["i_dependencia"] ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if (!empty($value["i_correo"]) || !empty($value["i_celular"])): ?>
                                        <div class="d-flex justify-content-center gap-2 mt-auto">
                                            <?php if (!empty($value["i_correo"])): ?>
                                                <button
                                                    class="btn btn-outline rounded-full"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalCorreo<?= $index ?>" title="Ver Correo">
                                                    <i class="fa-regular fa-envelope"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($value["i_celular"])): ?>
                                                <button
                                                    class="btn btn-primary rounded-full text-white"
                                                    style="background-color: var(--eco-500); border: none;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalCelular<?= $index ?>" title="Contactar por WhatsApp">
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
