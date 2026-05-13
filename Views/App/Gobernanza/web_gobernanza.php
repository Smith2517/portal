<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobernanza - <?php echo nameWeb(); ?></title>
    <?php headerWeb($data); ?>
    <style>
        .accordion-button:not(.collapsed) {
            background-color: #e9ecef;
        }
        .file-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .file-item:last-child {
            border-bottom: none;
        }
        .download-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .download-link:hover {
            text-decoration: underline;
        }
        .pdf-icon {
            margin-right: 5px;
            color: #d32f2f;
        }
    </style>
</head>
<body>
    <?php headerWeb($data); ?>

    <main class="main">
        <section class="section-full bg-light py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center mb-5">Gobernanza</h2>

                        <div class="accordion" id="accordionGobernanza">
                            <?php
                            // Aquí iría la lógica para obtener los items de gobernanza
                            // Por ahora, pondremos un ejemplo estático que luego se reemplazará con datos dinámicos

                            // Simulamos que ya tenemos los datos de gobernanza
                            if (isset($data['gobernanza']) && !empty($data['gobernanza'])) {
                                $items = $data['gobernanza'];
                                $itemCount = 0;

                                foreach ($items as $item) {
                                    $itemCount++;
                                    $isActive = ($itemCount == 1) ? 'show' : '';
                                    $isExpanded = ($itemCount == 1) ? 'true' : 'false';

                                    echo '<div class="accordion-item">';
                                    echo '<h2 class="accordion-header" id="headingItem' . $item['id'] . '">';
                                    echo '<button class="accordion-button ' . (($itemCount == 1) ? '' : 'collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#collapseItem' . $item['id'] . '" aria-expanded="' . $isExpanded . '" aria-controls="collapseItem' . $item['id'] . '">';
                                    echo htmlspecialchars($item['nombre']);
                                    echo '</button>';
                                    echo '</h2>';
                                    echo '<div id="collapseItem' . $item['id'] . '" class="accordion-collapse collapse ' . $isActive . '" aria-labelledby="headingItem' . $item['id'] . '" data-bs-parent="#accordionGobernanza">';
                                    echo '<div class="accordion-body p-0">';

                                    // Aquí mostramos los indicadores del item
                                    if (isset($item['indicadores']) && !empty($item['indicadores'])) {
                                        echo '<div class="accordion" id="accordionIndicadores' . $item['id'] . '">';

                                        foreach ($item['indicadores'] as $indicador) {
                                            echo '<div class="accordion-item">';
                                            echo '<h2 class="accordion-header" id="headingIndicador' . $indicador['id'] . '">';
                                            echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIndicador' . $indicador['id'] . '" aria-expanded="false" aria-controls="collapseIndicador' . $indicador['id'] . '">';
                                            echo htmlspecialchars($indicador['nombre']);
                                            echo '</button>';
                                            echo '</h2>';
                                            echo '<div id="collapseIndicador' . $indicador['id'] . '" class="accordion-collapse collapse" aria-labelledby="headingIndicador' . $indicador['id'] . '" data-bs-parent="#accordionIndicadores' . $item['id'] . '">';
                                            echo '<div class="accordion-body p-0">';

                                            // Aquí mostramos los archivos del indicador
                                            if (isset($indicador['archivos']) && !empty($indicador['archivos'])) {
                                                echo '<div class="list-group list-group-flush">';

                                                foreach ($indicador['archivos'] as $archivo) {
                                                    $rutaArchivo = base_url() . '/' . $archivo['archivo_ruta'];
                                                    echo '<div class="list-group-item d-flex justify-content-between align-items-center">';
                                                    echo '<div>';
                                                    echo '<i class="fas fa-file-pdf pdf-icon"></i>';
                                                    echo '<strong>' . htmlspecialchars($archivo['titulo']) . '</strong>';
                                                    if (!empty($archivo['descripcion'])) {
                                                        echo '<p class="mb-0 mt-1 text-muted small">' . htmlspecialchars($archivo['descripcion']) . '</p>';
                                                    }
                                                    echo '</div>';
                                                    echo '<a href="' . $rutaArchivo . '" target="_blank" class="btn btn-sm btn-outline-primary download-link">';
                                                    echo '<i class="fas fa-download"></i> Descargar';
                                                    echo '</a>';
                                                    echo '</div>';
                                                }

                                                echo '</div>';
                                            } else {
                                                echo '<p class="p-3 text-muted">No hay archivos disponibles para este indicador.</p>';
                                            }

                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                        }

                                        echo '</div>';
                                    } else {
                                        echo '<p class="p-3 text-muted">No hay indicadores disponibles para este item.</p>';
                                    }

                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="alert alert-info text-center">No hay información de gobernanza disponible en este momento.</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php footerWeb($data); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Código adicional si es necesario
        });
    </script>
</body>
</html>