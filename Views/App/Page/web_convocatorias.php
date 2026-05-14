<?php
headerWeb($data);
?>

<style>
/* Fondo general más institucional */
body {
    background-color: #f5f7fa;
}

/* Contenedor general */
.convocatorias-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 15px;
}

.main-title {
    text-align: center;
    color: #0b4f8a;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
    font-size: 1.8rem;
}

.linea-titulo {
    width: 50px;
    height: 4px;
    background-color: #0b4f8a;
    margin: 0 auto 40px auto;
    border-radius: 5px;
}

/* Tarjeta Principal */
.card-convocatoria {
    background: #ffffff;
    border-radius: 12px;
    margin-bottom: 35px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 18px rgba(0,0,0,0.04);
    overflow: hidden;
    transition: box-shadow 0.2s ease;
}

.card-convocatoria:hover {
    box-shadow: 0 10px 22px rgba(0,0,0,0.06);
}

/* Layout de 2 columnas */
.conv-card-grid{
    display: grid;
    grid-template-columns: 320px 1fr;
}

/* Sidebar */
.info-sidebar {
    background-color: #f9fbfd;
    border-right: 1px solid #e5e7eb;
    padding: 30px;
    display: flex;
    flex-direction: column;
    min-height: 100%;
}

/* Código de proceso */
.conv-code {
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 6px;
    font-weight: 600;
}

/* Estado */
.status-badge {
    display: inline-flex;
    align-items: center;
    background: #e6f0f8;
    color: #0b4f8a;
    padding: 5px 12px;
    border-radius: 16px;
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 15px;
    width: fit-content;
    border: 1px solid rgba(11,79,138,0.15);
    gap: 8px; 
}

/* Variantes opcionales */
.badge-vigente {
    background: #e6f4ea;
    color: #1e7e34;
}

.badge-cerrado {
    background: #f8d7da;
    color: #842029;
}

.badge-proceso {
    background: #fff3cd;
    color: #856404;
}

/* Título */
.conv-title {
    color: #1f2937;
    font-weight: 700;
    font-size: 1.4rem;
    line-height: 1.4;
    margin-bottom: 12px;
}

/* Fechas */
.date-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: auto;
}

.date-box {
    background: #ffffff;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.border-danger-light { 
    border-color: #f5c2c7; 
}

.date-label {
    display: block;
    font-size: 0.65rem;
    text-transform: uppercase;
    color: #6c757d;
    font-weight: 700;
    margin-bottom: 2px;
}

.date-value {
    font-size: 0.85rem;
    font-weight: 700;
    color: #212529;
}

/* Contenido */
.content-body {
    padding: 30px;
    background: #ffffff;
}

.section-label {
    font-size: 0.75rem;
    font-weight: 800;
    color: #adb5bd;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
}

.section-label::after {
    content: "";
    flex-grow: 1;
    height: 1px;
    background: #dee2e6;
    margin-left: 15px;
}

/* Hitos */
.item-box {
    border-left: 4px solid #0b4f8a;
    padding: 15px;
    padding-left: 18px;
    background: #fafafa;
    border-radius: 8px;
    margin-bottom: 20px;
}

.item-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: #343a40;
    margin-bottom: 4px;
    text-transform: uppercase;
}

/* Documentos */
.doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 10px;
    margin-top: 12px;
}

.doc-link {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    text-decoration: none !important;
    transition: background 0.2s ease, border 0.2s ease;
}

.doc-link:hover {
    background: #e6f0f8;
    border-color: #0b4f8a;
}

.doc-icon {
    width: 28px;
    height: 28px;
    background: #ffffff;
    color: #dc3545;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    margin-right: 10px;
    border: 1px solid #dee2e6;
}

.doc-text {
    font-size: 0.8rem;
    font-weight: 600;
    color: #495057;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
}

/* Utilidades */
.extra-small { 
    font-size: 0.75rem; 
    line-height: 1.4; 
}

/* Responsive */
@media (max-width: 991px) {
    .conv-card-grid { 
        grid-template-columns: 1fr; 
    }

    .info-sidebar {
        border-right: none;
        border-bottom: 1px solid #e5e7eb;
    }

    .date-row { 
        margin-top: 20px; 
    }
}

@media (max-width: 768px) {
    .main-title { 
        font-size: 1.5rem; 
    }

    .convocatorias-container { 
        margin: 20px auto; 
    }

    .content-body { 
        padding: 20px; 
    }

    .doc-grid { 
        grid-template-columns: 1fr; 
    }
}
</style>


<main>
  <?php headerPublic('fas fa-briefcase', 'Convocatorias de Trabajo', 'Oportunidades laborales y procesos de selección vigentes en la EPS RIOJA S.A.'); ?>
  
  <section class="convocatorias-container pt-3">

    <!-- Spinner -->
    <div id="spinnerConvocatorias" class="text-center my-5">
      <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="sr-only">Cargando...</span>
      </div>
      <p class="mt-3 text-muted font-italic">Buscando procesos vigentes...</p>
    </div>

    <!-- Contenedor dinámico (JS pinta aquí) -->
    <div id="listaConvocatorias"></div>
  </section>
</main>

<?php footerWeb($data); ?>
