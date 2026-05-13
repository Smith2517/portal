<?php
// Función para calcular el porcentaje completado
function calcularPorcentajeCompletado($fechaInicio, $fechaFin, $fechaActual)
{
  $tiempoTotal = $fechaFin->getTimestamp() - $fechaInicio->getTimestamp();
  $tiempoTranscurrido = $fechaActual->getTimestamp() - $fechaInicio->getTimestamp();
  $porcentaje = ($tiempoTranscurrido / $tiempoTotal) * 100;

  // Redondear el porcentaje a dos decimales
  return $porcentaje >= 0 ? $porcentaje : 0;
}
headerWeb($data);
?>
<main class="mb-2">
  <!--carousel-->
  <?php
  if (count(getCarousel()) > 0) {
  ?>
    <section>
      <div id="carouselMain" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <?php
          $cont = 0;
          foreach (getCarousel() as $key => $value) {          ?>
            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="<?= $cont ?>" class="<?= ($cont > 0) ? null : "active"; ?>" <?= ($cont > 1) ? null : 'aria-current="true"'; ?> aria-label="Slide <?= $cont ?>"></button>
          <?php
            $cont++;
          } ?>
        </div>
        <div class="carousel-inner">
          <?php
          $cont = 0;
          foreach (getCarousel() as $key => $value) {          ?>
            <div class="carousel-item <?= ($cont > 0) ? null : "active"; ?>">
              <img src="<?= media() ?>/upload/images/<?= $value["c_archivo"] ?>" class="d-block w-100" alt="<?= $value["c_titulo"] ?>">
              <?php
              if ($value["c_textoOculto"]) {
              ?>
                <div class="carousel-caption">
                  <h5 style="color: <?= $value["c_colorTitulo"] ?>;"><?= $value["c_titulo"] ?></h5>
                  <p style="color: <?= $value["c_colorDescripcion"] ?>;"><?= $value["c_descripcion"] ?></p>
                  <?php
                  if ($value["c_botonOculto"]) {
                  ?>
                    <a class="btn" style="background-color: <?= $value["c_colorBoton"] ?> !important;" href="<?= $value["c_linkBoton"] ?>" target="_Blank"><?= $value["c_nombreBoton"] ?></a>
                  <?php
                  }
                  ?>
                </div>
              <?php
              }
              ?>

            </div>
          <?php
            $cont++;
          }
          ?>

        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselMain" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselMain" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
      </div>
    </section>
  <?php
  }
  ?>
  <!--end carousel-->

  <?php
  // Mostrar contenido dinámico si existe
  if (isset($data['page_infoPage']) && !empty($data['page_infoPage']['p_contenido'])) {
      echo $data['page_infoPage']['p_contenido'];
  } else {
  ?>

  <!-- Sección de Bienvenida -->
  <section class="py-5 bg-light">
  <div class="container">
    <div class="row align-items-center">

      <!-- TEXTO -->
      <div class="col-lg-6">
        <h2 class="display-5 fw-bold text-primary">
          Bienvenidos a EPS RIOJA S.A.
        </h2>

        <p class="lead">
          Somos una empresa prestadora de servicios de agua potable y saneamiento,
          comprometida con el desarrollo sostenible y la calidad de vida de nuestros usuarios.
        </p>

        <p>
          Nuestra misión es brindar servicios de agua potable y saneamiento de calidad,
          con eficiencia, responsabilidad social y respeto al medio ambiente,
          contribuyendo al desarrollo integral de la región.
        </p>

        <a href="#" class="btn btn-primary btn-lg">
          Conoce más
        </a>
      </div>


      <div class="col-lg-6 mt-4 mt-lg-0">
        <img
          src="<?= base_url() ?>/Assets/upload/files/epsrioja.png"
          alt="EPS RIOJA S.A."
          class="img-fluid rounded shadow"
        />
      </div>

    </div>
  </div>
</section>


<section class="py-5">
  <div class="container">


    <div class="text-center mb-5">
      <h2 class="display-6 fw-bold">Nuestros Servicios</h2>
      <p class="text-muted">
        Servicios de alta calidad para nuestros usuarios
      </p>
    </div>

    <div class="row g-4">


      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 service-card">
          <div class="card-body text-center">
            <div class="service-icon mx-auto mb-3">
              <i class="fas fa-tint fa-3x text-primary"></i>
            </div>
            <h5 class="card-title">Agua Potable</h5>
            <p class="card-text">
              Suministro de agua potable de calidad a hogares y empresas.
            </p>
          </div>
        </div>
      </div>

 
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 service-card">
          <div class="card-body text-center">
            <div class="service-icon mx-auto mb-3">
              <i class="fas fa-shower fa-3x text-primary"></i>
            </div>
            <h5 class="card-title">Alcantarillado</h5>
            <p class="card-text">
              Gestión integral de sistemas de alcantarillado y saneamiento.
            </p>
          </div>
        </div>
      </div>


      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 service-card">
          <div class="card-body text-center">
            <div class="service-icon mx-auto mb-3">
              <i class="fas fa-recycle fa-3x text-primary"></i>
            </div>
            <h5 class="card-title">Tratamiento de Aguas</h5>
            <p class="card-text">
              Plantas de tratamiento para la reutilización responsable del agua.
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<section class="py-5 bg-primary text-white">
  <div class="container">
    <div class="row align-items-center">

      <!-- TEXTO -->
      <div class="col-md-8">
        <h3 class="display-6 fw-bold">Últimas Noticias</h3>
        <p>
          Mantente informado sobre nuestras actividades, proyectos y anuncios importantes.
        </p>
      </div>

      <!-- BOTÓN -->
      <div class="col-md-4 text-md-end">
        <a href="#" class="btn btn-light">
          Ver todas las noticias
        </a>
      </div>

    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">

    <!-- TÍTULO -->
    <div class="text-center mb-5">
      <h2 class="fw-bold">Contáctanos</h2>
      <p class="text-muted">
        Estamos para atenderte y brindarte un mejor servicio
      </p>
    </div>

    <!-- FILA: CONTACTO + MAPA -->
    <div class="row">

      <!-- INFORMACIÓN DE CONTACTO -->
      <div class="col-lg-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body">

            <h5 class="fw-bold mb-4">Información de Contacto</h5>

            <p class="mb-3">
              <i class="fas fa-map-marker-alt text-primary me-2"></i>
              Jr. Santo Toribio N° 212 – Rioja, San Martín
            </p>

            <p class="mb-3">
              <i class="fas fa-phone-alt text-primary me-2"></i>
              (042) 591323
            </p>

            <p class="mb-3">
              <i class="fas fa-envelope text-primary me-2"></i>
              mesadepartes@epsrioja.com.pe
            </p>

            <p class="mb-0">
              <i class="fas fa-clock text-primary me-2"></i>
              Lunes a Viernes: 07:30 a.m. – 12:30 p.m.
            </p>
            <p class="mb-0">
              <i class="fas fa-clock text-primary me-2"></i>
              Lunes a Viernes: 02:15 p.m. – 05:15 p.m.
            </p>
            <p class="mb-0">
              <i class="fas fa-clock text-primary me-2"></i>
              Sábados: 07:30 a.m. – 01:00 p.m.
            </p>

          </div>
        </div>
      </div>

      <!-- MAPA -->
      <div class="col-lg-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body p-0">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.560313996005!2d-77.16914799999999!3d-6.0548907!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91b727bda8390a25%3A0x5d5c49001a46c790!2sEPS%20-%20Rioja!5e0!3m2!1ses!2spe!4v1769175083982!5m2!1ses!2spe"
              width="100%"
              height="100%"
              style="border:0; min-height: 350px;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
      </div>

    </div>

    <!-- FILA: RECLAMOS Y CONSULTAS -->
    <div class="row g-3 mt-2">

      <!-- RECLAMOS -->
      <div class="col-md-6">
        <a href="http://216.244.171.122/reclamos/index.php" 
        target="_blank"
           rel="noopener noreferrer"
           class="text-decoration-none">
          <div class="card h-100 border-0 shadow-sm service-card">
            <div class="card-body text-center">

              <div class="mb-3">
                <i class="fas fa-exclamation-circle fa-3x text-primary"></i>
              </div>

              <h5 class="fw-bold text-dark">Reclamos</h5>

              <p class="text-muted mb-3">
                Registra tu reclamo de manera rápida, segura y transparente.
              </p>

              <span class="btn btn-outline-primary w-100">
                Registrar reclamo
              </span>

            </div>
          </div>
        </a>
      </div>

      <!-- CONSULTAS -->
      <div class="col-md-6">
        <a href="http://216.244.171.122/consultaweb"
           target="_blank"
           rel="noopener noreferrer"
           class="text-decoration-none">
          <div class="card h-100 border-0 shadow-sm service-card">
            <div class="card-body text-center">

              <div class="mb-3">
                <i class="fas fa-search fa-3x text-primary"></i>
              </div>

              <h5 class="fw-bold text-dark">Consultas en Línea</h5>

              <p class="text-muted mb-3">
                Realiza consultas sobre tus recibos y servicios desde casa.
              </p>

              <span class="btn btn-outline-primary w-100">
                Ver consultas
              </span>

            </div>
          </div>
        </a>
      </div>

    </div>

  </div>
</section>


  <?php } // Fin del else ?>
</main>
<?php
footerWeb($data);
if (!empty(getAvisos())) {
  $cont = 1;
  foreach (getAvisos() as $key => $value) {
    if (!empty($value["a_fechaInicio"]) && !empty($value["a_fechaFin"])) {
      $fechaHoraActual = new DateTime();
      $fechaHoraInicio = new DateTime($value["a_fechaInicio"]);
      $fechaHoraFin = new DateTime($value["a_fechaFin"]);
      // Calcular el porcentaje completado
      $porcentajeCompletado = calcularPorcentajeCompletado($fechaHoraInicio, $fechaHoraFin, $fechaHoraActual);
      if ($fechaHoraActual >= $fechaHoraInicio && $fechaHoraActual <= $fechaHoraFin) {
?>
        <!-- Modal Avisos -->
        <div class="modal fade" id="modalAnuncios<?= $cont ?>" <?= empty($value["a_Estatico"]) ? "" : 'data-bs-backdrop="' . $value["a_Estatico"] . '"' ?> data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-<?= $value["a_sizeAviso"] ?> modal-dialog-centered <?= $value["a_Escrollable"] ?>">
            <div class="modal-content">
              <div class="modal-header m-0 py-1">
                <h5 class="modal-title" id="staticBackdropLabel"><?= $value["a_Titulo"] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p style="text-align: justify;">
                  <?= $value["a_Descripcion"] ?>
                </p>
                <div class="ratio ratio-16x9">
                  <iframe src="<?= $value["a_Incrustacion"] ?>"></iframe>
                </div>
              </div>
              <div class="modal-footer m-0 p-1">
                <div>
                  <div class="m-0 p-0">
                    <p class="m-0 p-0" style="font-size: x-small;">Fecha Inicio : <?= $value["a_fechaInicio"] ?> | Fecha Fin : <?= $value["a_fechaFin"] ?></p>
                  </div>
                  <div class="progress m-0 p-0">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentajeCompletado; ?>%;" aria-valuenow="<?php echo $porcentajeCompletado; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $porcentajeCompletado; ?>%</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      }
    } else if (empty($value["a_fechaInicio"]) && empty($value["a_fechaFin"])) {
      ?>
      <!-- Modal Avisos -->
      <div class="modal fade" id="modalAnuncios<?= $cont ?>" <?= empty($value["a_Estatico"]) ? "" : 'data-bs-backdrop="' . $value["a_Estatico"] . '"' ?> data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-<?= $value["a_sizeAviso"] ?> modal-dialog-centered <?= $value["a_Escrollable"] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel"><?= $value["a_Titulo"] ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p style="text-align: justify;">
                <?= $value["a_Descripcion"] ?>
              </p>
              <div class="ratio ratio-16x9">
                <iframe src="<?= $value["a_Incrustacion"] ?>"></iframe>
              </div>
            </div>
            <div class="modal-footer">
              <p>Sin vencimiento</p>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal -->
  <?php
    }
    $cont++;
  }
  ?>
  <script>
    function cargaModalAviso() {
      <?php
      $cont = 1;
      foreach (getAvisos() as $key => $value) {
        if (!empty($value["a_fechaInicio"]) && !empty($value["a_fechaFin"])) {
          $fechaHoraActual = date("Y-m-d H:i:s");
          $fechaHoraInicio = date($value["a_fechaInicio"]);
          $fechaHoraFin = date($value["a_fechaFin"]);
          if ($fechaHoraActual >= $fechaHoraInicio && $fechaHoraActual <= $fechaHoraFin) { ?>
            $("#modalAnuncios<?= $cont ?>").modal("show")
          <?php
          }
        } else if (empty($value["a_fechaInicio"]) && empty($value["a_fechaFin"])) {
          ?>
          $("#modalAnuncios<?= $cont ?>").modal("show")
      <?php
        }
        $cont++;
      }
      ?>
    }
  </script>
<?php
}
?>