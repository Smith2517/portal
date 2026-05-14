<?php
headerWeb($data);
if (!optFuncionario()) {
    notFound();
    die();
}
$arrFuncionario = $data['page_funcionarios']['info'];
?>

<main class="mb-5 bg-slate-50 pb-5">

    <!-- ===== ENCABEZADO ===== -->
    <section class="py-5 bg-white blob-bg position-relative overflow-hidden border-bottom border-slate-100">
        <div class="container position-relative z-1">

            <div class="card border-0 bg-transparent mb-4">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-center text-lg-start mb-4 mb-lg-0" data-aos="fade-right">
                        <img 
                            src="<?= media() ?>/upload/images/<?= $arrFuncionario['gf_foto'] ?>" 
                            class="img-fluid rounded-4xl shadow-soft floating-img"
                            alt="<?= $arrFuncionario['gf_nombre'] ?>"
                            loading="lazy"
                            style="border: 8px solid white;">
                    </div>
                    <div class="col-lg-8" data-aos="fade-left">
                        <h4 class="text-water-600 fw-bold text-uppercase tracking-wider mb-2" style="font-size: 0.875rem;">Nuestro Equipo</h4>
                        <h1 class="display-5 font-heading fw-bold text-water-900 mb-3">
                            <?= $arrFuncionario['gf_nombre'] ?>
                        </h1>
                        <p class="lead text-slate-500 mb-0">
                            <?= $arrFuncionario['gf_descripcion'] ?>
                        </p>
                    </div>
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

                        <div class="col-12 col-sm-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                            <div class="card h-100 border-0 shadow-soft service-card text-center">

                                <!-- FOTO -->
                                <div class="pt-4">
                                    <div class="d-inline-block rounded-circle p-2 bg-water-50">
                                        <img 
                                            src="<?= media() ?>/upload/images/<?= $value["f_fotoPerfil"] ?>"
                                            class="rounded-circle img-fluid"
                                            alt="<?= $value['f_nombres'] . ' ' . $value['f_apellidos'] ?>"
                                            loading="lazy"
                                            style="width: 120px; height: 120px; object-fit: cover;">
                                    </div>
                                </div>

                                <!-- INFO -->
                                <div class="card-body">
                                    <h5 class="font-heading fw-bold text-water-900 mb-1">
                                        <?= $value['f_nombres'] . " " . $value['f_apellidos'] ?>
                                    </h5>

                                    <p class="mb-2 text-water-600 fw-bold small">
                                        <?= $value["f_cargo"] ?>
                                    </p>

                                    <p class="mb-4 small text-slate-500">
                                        <i class="fas fa-building me-1"></i> <?= $value["f_despendecia"] ?>
                                    </p>

                                    <?php if (!empty($value["f_correo"])): ?>
                                        <button 
                                            class="btn btn-outline btn-sm rounded-full w-100"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalCorreo<?= $index ?>">
                                            <i class="fa-regular fa-envelope me-2"></i> Contactar
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
