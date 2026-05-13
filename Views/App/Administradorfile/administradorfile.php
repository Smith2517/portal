<?php
headerAdmin($data);
getModal('modalAdministradorFile', $data);
?>
<style>
    .custom-card {
        width: 100%;
        height: 100%;
        padding: 20px;
        margin: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .custom-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .empty-directory-message {
        margin-top: 30px;
        font-size: 36px;
        color: #FF5733;
    }

    .fi {
        font-family: 'Flat-Icons';
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;

        /* Use these styles to adjust the icon size */
        font-size: 48px;
        color: #FF5733;
    }
</style>
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
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/roles"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="container mt-4">
                        <?= $data['page_contenidoFile'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    let directorio_upload = "<?= path_upload() ?>"
</script>
<?php footerAdmin($data); ?>