<?php
headerWeb($data);
?>
<main class="mb-2 ">
    <section class="pt-2 mt-4 px-1 px-md-5">
        <div class="container">
            <h2>Listado de categorias</h2>
            <hr>
            <div id="card-list" class="row"></div>
            <div id="empty-message" class="alert alert-info mt-3" style="display: none;">
                No hay elementos para mostrar.
            </div>
            <div id="loading-message" class="alert alert-warning mt-3" style="display: none;">
                Cargando...
            </div>
            <button id="ver-mas" class="btn btn-primary mt-3">Ver más</button>
        </div>
    </section>
</main>
<?php
footerWeb($data);

?>