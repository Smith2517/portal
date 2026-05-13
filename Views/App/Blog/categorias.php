<?php
headerAdmin($data);
getModal('modalCategorias', $data);
?>
<div id="contentAjax"></div>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-tag"></i>
                <?= $data['page_title'] ?>
                <?php if ($_SESSION['permisosMod']['w']) { ?>
                    <button class="btn btn-primary openmodal" id="openModal" type="button"><i class="fas fa-plus-circle"></i>
                        Nuevo</button>
                <?php } ?>
            </h1>
        </div>
    </div>
    <a href="<?= base_url() ?>/page/b" class="btn btn-primary mb-5" target="_blank" rel="noopener noreferrer">Ver pagina de categorias</a>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive overflow-auto">
                        <table class="table-bordered dataTable table-striped table-hover table-sm w-100" id="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Categoria</th>
                                    <th>Url</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php footerAdmin($data); ?>