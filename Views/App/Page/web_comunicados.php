<?php
headerWeb($data);
?>

<style>
/* Contenedor general */
.comunicados-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 15px;
}

.main-title {
    text-align: center;
    color: #0a5ca8;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
    font-size: 2rem;
}

.linea-titulo {
    width: 60px;
    height: 5px;
    background-color: #0a5ca8;
    margin: 0 auto 40px auto;
    border-radius: 10px;
}

/* Grid de cards - Máximo 2 columnas */
.comunicados-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

/* Card de Comunicado */
.card-comunicado {
    background: #fff;
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.card-comunicado:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

/* Imagen del comunicado */
.comunicado-image {
    width: 100%;
    height: 220px;
    object-fit: cover;
    background: #f0f4f8;
}

/* Cuerpo de la card */
.comunicado-body {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Fecha */
.comunicado-date {
    display: flex;
    align-items: center;
    color: #6c757d;
    font-size: 0.85rem;
    margin-bottom: 12px;
}

.comunicado-date i {
    margin-right: 8px;
    color: #0a5ca8;
}

/* Título */
.comunicado-title {
    color: #1a202c;
    font-weight: 700;
    font-size: 1.25rem;
    line-height: 1.4;
    margin-bottom: 12px;
}

/* Descripción */
.comunicado-description {
    color: #4a5568;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
    flex: 1;
    white-space: pre-line;
}

/* Footer con botón de descarga */
.comunicado-footer {
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
    margin-top: auto;
}

.btn-descarga {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none !important;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(229, 62, 62, 0.3);
}

.btn-descarga:hover {
    background: linear-gradient(135deg, #c53030 0%, #9b2c2c 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(229, 62, 62, 0.4);
}

.btn-descarga i {
    margin-right: 8px;
}

/* Sin PDF */
.sin-pdf {
    color: #a0aec0;
    font-size: 0.85rem;
    font-style: italic;
}

/* Spinner */
.spinner-container {
    text-align: center;
    padding: 60px 20px;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

/* Mensaje sin datos */
.sin-datos {
    text-align: center;
    padding: 60px 20px;
    color: #718096;
    font-size: 1.1rem;
}

/* Adaptabilidad Móvil */
@media (max-width: 768px) {
    .main-title {
        font-size: 1.5rem;
    }

    .comunicados-container {
        margin: 20px auto;
    }

    .comunicados-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .comunicado-image {
        height: 200px;
    }
}
</style>

<main>
  <?php headerPublic('fas fa-bullhorn', 'Comunicados Oficiales', 'Manténgase informado con las últimas noticias y avisos de la EPS RIOJA S.A.'); ?>
  
  <section class="comunicados-container pt-3">

    <!-- Spinner -->
    <div id="spinnerComunicados" class="spinner-container">
      <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Cargando...</span>
      </div>
      <p class="mt-3 text-muted font-italic">Cargando comunicados...</p>
    </div>

    <!-- Contenedor dinámico -->
    <div id="listaComunicados" class="comunicados-grid"></div>
  </section>
</main>

<?php footerWeb($data); ?>
