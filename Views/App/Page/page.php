<?php
headerWeb($data);
if (!isset($data['page_infoPage'])) {
    notFound();
    die();
}
?>
<main class="mb-5 bg-slate-50 pb-5">
    <?php headerPublic('fas fa-file-alt', htmlspecialchars($data['page_infoPage']['p_nombre']), ''); ?>
    
    <section class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="page-content bg-white p-4 p-md-5 rounded-4xl shadow-soft">
                    <?= html_entity_decode($data['page_infoPage']['p_contenido'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
footerWeb($data);
?>