<?php
headerWeb($data);
$arrVideos = isset($data['page_documentos']) && is_array($data['page_documentos']) ? $data['page_documentos'] : array();
?>

<main class="mb-5">

    <!-- ===== ENCABEZADO ===== -->
    <?php headerPublic('fas fa-video', 'Videos Didácticos', 'Material audiovisual para el aprendizaje del Sistema de Control Interno (SCI)'); ?>

    <!-- ===== LISTADO DE VIDEOS ===== -->
    <section class="py-4">
        <div class="container">
            <div class="row" id="listaVideos">

                <?php if (isset($arrVideos) && count($arrVideos) > 0): ?>
                    <?php foreach ($arrVideos as $value): ?>

                        <?php
                        // Extraer ID del video para generar miniatura
                        $videoId = '';

                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $value['vd_enlace'], $matches)) {
                            $videoId = $matches[1];
                        }

                        // Definir thumbnail
                        if (!empty($value['vd_thumbnail'])) {
                            $thumbnail = $value['vd_thumbnail'];
                        } elseif (!empty($videoId)) {
                            $thumbnail = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                        } else {
                            $thumbnail = "https://via.placeholder.com/480x360?text=Video";
                        }
                        ?>

                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm hover-shadow h-100">
                                <div class="card-body p-0">

                                    <!-- Miniatura del video -->
                                    <div class="position-relative">
                                        <img src="<?= $thumbnail ?>"
                                             onerror="this.onerror=null;this.src='https://img.youtube.com/vi/<?= $videoId ?>/hqdefault.jpg';"
                                             class="card-img-top"
                                             alt="<?= $value['vd_nombre'] ?>"
                                             style="height: 200px; object-fit: cover;">

                                        <div class="play-button">
                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                    </div>

                                    <div class="card-body p-3">
                                        <h6 class="card-title text-primary mb-3 text-center">
                                            <?= $value['vd_nombre'] ?>
                                        </h6>

                                        <div class="d-grid">
                                            <a href="<?= $value['vd_enlace'] ?>"
                                               target="_blank"
                                               class="btn btn-danger btn-sm">
                                                <i class="fas fa-play"></i> Ver Video
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
                            <i class="fas fa-exclamation-triangle"></i> No hay videos didácticos registrados.
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </section>

</main>

<style>

.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.position-relative {
    position: relative;
    overflow: hidden;
    border-radius: 0.25rem 0.25rem 0 0;
}

.play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.9);
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    transition: all 0.3s ease;
}

.hover-shadow:hover .play-button {
    color: #fff;
    transform: translate(-50%, -50%) scale(1.1);
}

</style>

<?php footerWeb($data); ?>