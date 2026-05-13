<?php
headerWeb($data);
$arrDocumentos = isset($data['page_documentos']) && is_array($data['page_documentos']) ? $data['page_documentos'] : array();
?>

<main class="mb-5">

    <!-- ===== ENCABEZADO ===== -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bold mb-3">
                        <i class="fas fa-building text-primary"></i> Gobierno Corporativo
                    </h1>
                    <p class="text-muted mb-0">
                        Consulte los documentos de Gobierno Corporativo del Sistema de Control Interno (SCI)
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FILTROS ===== -->
    <section class="py-3">
        <div class="container">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="buscador" placeholder="🔍 Buscar por título o número...">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filtroCategoria">
                        <option value="">Todas las categorías</option>
                        <?php
                        $categorias = array();
                        if (isset($arrDocumentos) && is_array($arrDocumentos)) {
                            foreach ($arrDocumentos as $doc) {
                                if (!empty($doc['gc_categoria']) && !in_array($doc['gc_categoria'], $categorias)) {
                                    $categorias[] = $doc['gc_categoria'];
                                }
                            }
                        }
                        foreach ($categorias as $cat) {
                            echo '<option value="' . $cat . '">' . $cat . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filtroAnio">
                        <option value="">Todos los años</option>
                        <?php
                        $anios = array();
                        if (isset($arrDocumentos) && is_array($arrDocumentos)) {
                            foreach ($arrDocumentos as $doc) {
                                if (!empty($doc['gc_fecha'])) {
                                    $anio = date('Y', strtotime($doc['gc_fecha']));
                                    if (!in_array($anio, $anios)) {
                                        $anios[] = $anio;
                                    }
                                }
                            }
                            rsort($anios);
                            foreach ($anios as $anio) {
                                echo '<option value="' . $anio . '">' . $anio . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" onclick="resetFiltros()">
                        <i class="fas fa-sync-alt"></i> Limpiar
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== LISTADO DE DOCUMENTOS ===== -->
    <section class="py-4">
        <div class="container">
            <div class="row" id="listaDocumentos">

                <?php if (isset($arrDocumentos) && count($arrDocumentos) > 0): ?>
                    <?php foreach ($arrDocumentos as $value): ?>

                        <div class="col-12 mb-3 documento-item"
                             data-categoria="<?= $value['gc_categoria'] ?>"
                             data-anio="<?= !empty($value['gc_fecha']) ? date('Y', strtotime($value['gc_fecha'])) : '' ?>"
                             data-titulo="<?= strtolower($value['gc_titulo'] . ' ' . $value['gc_numero']) ?>">

                            <div class="card border-0 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-1 text-center">
                                            <i class="fas fa-file-pdf text-danger" style="font-size: 2.5rem;"></i>
                                        </div>
                                        <div class="col-md-7">
                                            <h5 class="card-title mb-1 text-primary">
                                                <?= $value['gc_titulo'] ?>
                                                <?php if (!empty($value['gc_numero'])): ?>
                                                    <small class="text-muted">(<?= $value['gc_numero'] ?>)</small>
                                                <?php endif; ?>
                                            </h5>

                                            <?php if (!empty($value['gc_categoria'])): ?>
                                                <span class="badge bg-secondary me-2">
                                                    <i class="fas fa-tag"></i> <?= $value['gc_categoria'] ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if (!empty($value['gc_fecha'])): ?>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($value['gc_fecha'])) ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if (!empty($value['gc_descripcion'])): ?>
                                                <p class="card-text mt-2 text-muted small">
                                                    <?= limitar_cadena($value['gc_descripcion'], 150, '...') ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                            <a href="<?= base_url() ?>/Assets/upload/documentos/<?= $value['gc_archivo'] ?>"
                                               target="_blank"
                                               class="btn btn-danger btn-sm me-2"
                                               title="Ver documento PDF">
                                                <i class="fas fa-eye"></i> Ver PDF
                                            </a>
                                            <a href="<?= base_url() ?>/Assets/upload/documentos/<?= $value['gc_archivo'] ?>"
                                               download="<?= $value['gc_archivo_original'] ?>"
                                               class="btn btn-outline-danger btn-sm"
                                               title="Descargar documento">
                                                <i class="fas fa-download"></i> Descargar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle"></i> No hay documentos de gobierno corporativo registrados.
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Mensaje de no resultados -->
            <div id="noResultados" class="text-center py-5" style="display: none;">
                <i class="fas fa-search text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3 text-muted">No se encontraron documentos</h4>
                <p class="text-muted">Intenta con otros términos de búsqueda o filtros</p>
            </div>
        </div>
    </section>

</main>

<script>
// Funciones de filtrado en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscador');
    const filtroCategoria = document.getElementById('filtroCategoria');
    const filtroAnio = document.getElementById('filtroAnio');

    function filtrarDocumentos() {
        const termino = buscador.value.toLowerCase();
        const categoria = filtroCategoria.value;
        const anio = filtroAnio.value;

        let visibles = 0;

        document.querySelectorAll('.documento-item').forEach(function(item) {
            const titulo = item.getAttribute('data-titulo');
            const itemCategoria = item.getAttribute('data-categoria');
            const itemAnio = item.getAttribute('data-anio');

            const coincideTermino = termino === '' || titulo.includes(termino);
            const coincideCategoria = categoria === '' || itemCategoria === categoria;
            const coincideAnio = anio === '' || itemAnio === anio;

            if (coincideTermino && coincideCategoria && coincideAnio) {
                item.style.display = 'block';
                visibles++;
            } else {
                item.style.display = 'none';
            }
        });

        // Mostrar mensaje de no resultados
        const noResultados = document.getElementById('noResultados');
        const listaDocumentos = document.getElementById('listaDocumentos');

        if (visibles === 0) {
            noResultados.style.display = 'block';
            listaDocumentos.style.display = 'none';
        } else {
            noResultados.style.display = 'none';
            listaDocumentos.style.display = 'block';
        }
    }

    buscador.addEventListener('input', filtrarDocumentos);
    filtroCategoria.addEventListener('change', filtrarDocumentos);
    filtroAnio.addEventListener('change', filtrarDocumentos);
});

function resetFiltros() {
    document.getElementById('buscador').value = '';
    document.getElementById('filtroCategoria').value = '';
    document.getElementById('filtroAnio').value = '';

    document.querySelectorAll('.documento-item').forEach(function(item) {
        item.style.display = 'block';
    });

    document.getElementById('noResultados').style.display = 'none';
    document.getElementById('listaDocumentos').style.display = 'block';
}
</script>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}
</style>

<?php footerWeb($data); ?>
