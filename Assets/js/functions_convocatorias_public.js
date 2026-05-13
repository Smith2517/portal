/**
 * Lógica para la carga y renderizado de convocatorias (Versión Dashboard Abierta)
 * Muestra ACTIVAS e INACTIVAS en la web pública.
 * Orden: más nuevas primero (por ID DESC). Editar no cambia orden.
 */

$(function () {
  cargarConvocatorias();
});

function cargarConvocatorias() {
  $('#spinnerConvocatorias').show();
  $('#listaConvocatorias').empty();

  $.ajax({
    url: base_url + '/convocatorias/getEstructuraConvocatorias',
    type: 'GET',
    dataType: 'json',
    cache: false,
    timeout: 15000
  })
    .done(function (response) {
      if (typeof response !== 'object' || response === null || !response.status) {
        $('#listaConvocatorias').html('<div class="alert alert-warning text-center border-0 shadow-sm">No hay convocatorias disponibles por el momento.</div>');
        return;
      }

      const convocatoriasMap = procesarEstructura(response.data);

    
      const convocatorias = Object.values(convocatoriasMap).sort((a, b) => Number(b.id) - Number(a.id));

      renderizarHTML(convocatorias);
    })
    .fail(function (xhr, textStatus) {
      let msg = (textStatus === 'timeout')
        ? 'Tiempo de espera agotado.'
        : 'Error de conexión al cargar las convocatorias.';
      $('#listaConvocatorias').html(`<div class="alert alert-danger text-center shadow-sm">${msg}</div>`);
    })
    .always(function () {
      $('#spinnerConvocatorias').hide();
    });
}

function procesarEstructura(data) {
  let map = {};

  data.forEach(row => {
    if (!row.convocatoria_id) return;

    const convId = Number(row.convocatoria_id);
    const estadoConv = String(row.convocatoria_estado); 

    if (!map[convId]) {
      map[convId] = {
        id: convId, 
        titulo: row.convocatoria_titulo || '',
        descripcion: row.convocatoria_descripcion || '',
        fecha_inicio: row.convocatoria_fecha_inicio || '',
        fecha_fin: row.convocatoria_fecha_fin || '',
        estado: estadoConv,
        items: []
      };
    }

    // items/documentos solo activos (como lo tenías)
    if (row.item_id && String(row.item_estado) === '1') {
      let conv = map[convId];
      let item = conv.items.find(i => String(i.id) === String(row.item_id));

      if (!item) {
        item = {
          id: row.item_id,
          nombre: row.item_nombre || '',
          descripcion: row.item_descripcion || '',
          documentos: []
        };
        conv.items.push(item);
      }

      if (row.documento_id && String(row.documento_estado) === '1') {
        let ruta = (row.documento_ruta || '').trim().replace('Assets/files/', 'Assets/upload/');
        if (ruta) {
          item.documentos.push({
            id: row.documento_id,
            titulo: row.documento_titulo || '',
            ruta: ruta
          });
        }
      }
    }
  });

  return map;
}

function renderizarHTML(convocatorias) {
  if (convocatorias.length === 0) {
    $('#listaConvocatorias').html('<div class="alert alert-info text-center py-4 shadow-sm border-0">No se encontraron convocatorias.</div>');
    return;
  }

  let finalHtml = '';

  convocatorias.forEach(conv => {
    const badgeEstado = (String(conv.estado) === '1')
      ? `<span class="status-badge"><i class="fas fa-check-circle mr-1   "></i>   Activa</span>`
      : `<span class="status-badge" style="background:#fff5f5;color:#c53030;"><i class="fas fa-times-circle mr-1   "></i>   Finalizada</span>`;

    let itemsHtml = '';

    conv.items.forEach(item => {
      let docsHtml = (item.documentos.length > 0)
        ? item.documentos.map(doc => `
            <a href="${base_url}/${encodeURI(doc.ruta)}" target="_blank" class="doc-link">
              <div class="doc-icon"><i class="fas fa-file-pdf"></i></div>
              <div class="doc-text" title="${escapeHtml(doc.titulo)}">${escapeHtml(doc.titulo)}</div>
              <i class="fas fa-download ml-auto text-muted small"></i>
            </a>
          `).join('')
        : '<div class="col-12"><p class="text-muted small font-italic">No hay documentos disponibles.</p></div>';

      itemsHtml += `
        <div class="item-box">
          <div class="item-name">${escapeHtml(item.nombre)}</div>
         
          <div class="doc-grid">${docsHtml}</div>
        </div>
      `;
    });

    finalHtml += `
      <div class="card card-convocatoria shadow-sm">
        <div class="row no-gutters">
          <div class="col-lg-4 info-sidebar">
            ${badgeEstado}
            <h1 class="conv-title">${escapeHtml(conv.titulo)}</h1>
            <p class="text-muted extra-small mb-4">${escapeHtml(conv.descripcion)}</p>

            <div class="date-row">
              <div class="date-box">
                <span class="date-label">Inicio</span>
                <span class="date-value text-primary">${escapeHtml(conv.fecha_inicio)}</span>
              </div>
              <div class="date-box border-danger-light">
                <span class="date-label">Fin</span>
                <span class="date-value text-danger">${escapeHtml(conv.fecha_fin)}</span>
              </div>
            </div>
          </div>

          <div class="col-lg-8 content-body">
            <div class="section-label">Archivos del Proceso</div>
            <div class="items-wrapper">
              ${itemsHtml || '<p class="text-center text-muted small my-4">No se han definido etapas para este proceso.</p>'}
            </div>
          </div>
        </div>
      </div>
    `;
  });

  $('#listaConvocatorias').html(finalHtml);
}

function escapeHtml(str) {
  str = String(str ?? '');
  return str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
