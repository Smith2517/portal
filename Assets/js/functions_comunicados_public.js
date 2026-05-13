/**
 * Lógica para la carga y renderizado de comunicados (Vista Pública)
 * Muestra comunicados activos e inactivos en cards ordenadas.
 * Orden: más nuevos primero (por fecha_comunicado DESC, luego ID DESC).
 */

$(function () {
  cargarComunicados();
});

function cargarComunicados() {
  $("#spinnerComunicados").show();
  $("#listaComunicados").empty();

  $.ajax({
    url: base_url + "/comunicados/getComunicados",
    type: "GET",
    dataType: "json",
    cache: false,
    timeout: 15000,
  })
    .done(function (response) {
      if (
        typeof response !== "object" ||
        response === null ||
        !response.status
      ) {
        $("#listaComunicados").html(
          '<div class="sin-datos">No hay comunicados disponibles por el momento.</div>',
        );
        return;
      }

      const comunicados = response.data || [];

      // Ordenar: más nuevos primero (por fecha DESC, luego ID DESC)
      comunicados.sort((a, b) => {
        const fechaA = new Date(a.fecha_comunicado);
        const fechaB = new Date(b.fecha_comunicado);
        if (fechaB.getTime() !== fechaA.getTime()) {
          return fechaB.getTime() - fechaA.getTime();
        }
        return Number(b.id) - Number(a.id);
      });

      // Limitar a máximo 2 comunicados
      const comunicadosMostrar = comunicados.slice(0, 2);

      renderizarHTML(comunicadosMostrar);
    })
    .fail(function (xhr, textStatus) {
      let msg =
        textStatus === "timeout"
          ? "Tiempo de espera agotado."
          : "Error de conexión al cargar los comunicados.";
      $("#listaComunicados").html(
        `<div class="sin-datos text-danger">${msg}</div>`,
      );
    })
    .always(function () {
      $("#spinnerComunicados").hide();
    });
}

function renderizarHTML(comunicados) {
  if (comunicados.length === 0) {
    $("#listaComunicados").html(
      '<div class="sin-datos">No se encontraron comunicados.</div>',
    );
    return;
  }

  let finalHtml = "";

  comunicados.forEach((com) => {
    // Imagen
    let imagenSrc =
      'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="350" height="220" viewBox="0 0 350 220"%3E%3Crect fill="%23f0f4f8" width="350" height="220"/%3E%3Ctext fill="%23a0aec0" font-family="Arial" font-size="16" x="50%25" y="50%25" text-anchor="middle" dy=".3em"%3ESin imagen%3C/text%3E%3C/svg%3E';
    if (com.imagen_ruta && com.imagen_ruta !== "") {
      let ruta = com.imagen_ruta.replace("Assets/files/", "Assets/upload/");
      imagenSrc = base_url + "/" + ruta;
    }

    // Botón de descarga PDF
    let btnDescarga = "";
    if (com.pdf_ruta && com.pdf_ruta !== "") {
      let rutaPdf = com.pdf_ruta.replace("Assets/files/", "Assets/upload/");
      btnDescarga = `
        <a href="${base_url}/${encodeURI(rutaPdf)}" target="_blank" class="btn-descarga">
          <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
      `;
    } else {
      btnDescarga =
        '<span class="sin-pdf"><i class="fas fa-info-circle"></i> Sin documento PDF adjunto</span>';
    }

    // Formatear fecha
    let fechaFormateada = com.fecha_comunicado;
    if (com.fecha_comunicado) {
      const fechaObj = new Date(com.fecha_comunicado + "T00:00:00");
      const opciones = { year: "numeric", month: "long", day: "numeric" };
      fechaFormateada = fechaObj.toLocaleDateString("es-ES", opciones);
    }

    finalHtml += `
      <div class="card-comunicado">
        <img src="${imagenSrc}" alt="${escapeHtml(com.titulo)}" class="comunicado-image" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;350&quot; height=&quot;220&quot; viewBox=&quot;0 0 350 220&quot;%3E%3Crect fill=&quot;%23f0f4f8&quot; width=&quot;350&quot; height=&quot;220&quot;/%3E%3Ctext fill=&quot;%23a0aec0&quot; font-family=&quot;Arial&quot; font-size=&quot;16&quot; x=&quot;50%25&quot; y=&quot;50%25&quot; text-anchor=&quot;middle&quot; dy=&quot;.3em&quot;%3EError imagen%3C/text%3E%3C/svg%3E'">
        
        <div class="comunicado-body">
          <div class="comunicado-date">
            <i class="far fa-calendar-alt"></i>
            <span>${fechaFormateada}</span>
          </div>
          
          <h3 class="comunicado-title">${escapeHtml(com.titulo)}</h3>
          
          <p class="comunicado-description">
            ${escapeHtml(com.descripcion).replace(/\r?\n/g, "<br>") || "Sin descripción."}
          </p>
          
          <div class="comunicado-footer">
            ${btnDescarga}
          </div>
        </div>
      </div>
    `;
  });

  $("#listaComunicados").html(finalHtml);
}

function escapeHtml(str) {
  str = String(str ?? "");
  return str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
