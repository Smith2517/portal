<?php
headerWeb($data);
if (!isset($data['page_infoPage'])) {
    notFound();
    die();
}
?>
<main class="mb-3 container">
    <section class="pt-2 mt-3 px-1 px-md-5 mb-3">
        <div class="container">
            <?= html_entity_decode($data['page_infoPage']['p_contenido'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>
        </div>
    </section>
</main>
<?php
footerWeb($data);
?>