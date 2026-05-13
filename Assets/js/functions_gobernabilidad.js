// Función para cerrar todos los modales abiertos (déjala por si la necesitas manualmente)
function closeAllModals() {
  $('.modal').each(function () {
    if ($(this).hasClass('show')) {
      $(this).modal('hide');
    }
  });
}

// ===== Bootstrap 4: Modales apilados (modal sobre modal) =====
(function () {
  $(document).on('show.bs.modal', '.modal', function () {
    var openCount = $('.modal.show').length;
    var zIndexBase = 1040 + (openCount * 20); // backdrop 1040, modal 1050
    $(this).css('z-index', zIndexBase + 10);

    setTimeout(function () {
      $('.modal-backdrop').not('.modal-backdrop-stacked')
        .css('z-index', zIndexBase)
        .addClass('modal-backdrop-stacked');
    }, 0);
  });

  $(document).on('hidden.bs.modal', '.modal', function () {
    if ($('.modal.show').length) {
      $('body').addClass('modal-open');
    }
  });
})();

$(document).ready(function () {

  // DataTable
  tableGobernabilidad = $('#tableGobernabilidad').DataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    ajax: {
      url: base_url + "/gobernabilidad/getItems",
      dataSrc: function (json) {
        return (json && json.status) ? json.data : [];
      }
    },
    columns: [
      { data: "id" },
      { data: "nombre" },
      { data: "descripcion" },
      {
        data: "estado",
        render: function (data) {
          return (String(data) === "1")
            ? '<span class="badge badge-success">Activo</span>'
            : '<span class="badge badge-danger">Inactivo</span>';
        }
      },
      {
        data: null,
        orderable: false,
        render: function (data) {
          var btnView = '';
          var btnEdit = '';
          var btnDelete = '';
          var btnStructure = '';

          // Tus botones (mantengo tu lógica)
          if (data.estado == 1) {
            btnView = '<button class="btn btn-info btn-sm" onclick="fntViewGobernabilidad(' + data.id + ')" title="Ver item"><i class="far fa-eye"></i></button>';
            btnEdit = '<button class="btn btn-primary btn-sm" onclick="fntEditGobernabilidad(' + data.id + ')" title="Editar item"><i class="fas fa-pencil-alt"></i></button>';
            btnStructure = '<button class="btn btn-secondary btn-sm" onclick="fntViewStructure(' + data.id + ')" title="Ver estructura"><i class="fas fa-sitemap"></i></button>';
            btnDelete = '<button class="btn btn-danger btn-sm" onclick="fntDelGobernabilidad(' + data.id + ')" title="Eliminar item"><i class="far fa-trash-alt"></i></button>';
          }

          return '<div class="text-center">' + btnView + ' ' + btnEdit + ' ' + btnStructure + ' ' + btnDelete + '</div>';
        }
      }
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]]
  });

  // Form Items
  $('#formGobernabilidad').submit(function (e) {
    e.preventDefault();

    var strNombre = $('#txtNombre').val();
    var intEstado = $('#listEstado').val();

    if (strNombre == '' || intEstado == '') {
      swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
      return false;
    }

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/gobernabilidad/setItem';
    var formData = new FormData($('#formGobernabilidad')[0]);

    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $('#modalFormGobernabilidad').modal("hide");
          $('#formGobernabilidad')[0].reset();
          swal("Items de Gobernabilidad", objData.msg, "success");
          tableGobernabilidad.ajax.reload();
        } else {
          swal("Error", objData.msg, "error");
        }
      }
    };
  });

  // Form Indicadores
  $('#formIndicador').submit(function (e) {
    e.preventDefault();

    var intItemId = $('#txtItemIdIndicador').val();
    var strNombre = $('#txtNombreIndicador').val();
    var intEstado = $('#listEstadoIndicador').val();

    if (intItemId == '' || strNombre == '' || intEstado == '') {
      swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
      return false;
    }

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/gobernabilidad/setIndicador';
    var formData = new FormData($('#formIndicador')[0]);

    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $('#modalFormIndicador').modal("hide");
          $('#formIndicador')[0].reset();
          swal("Indicadores de Gobernabilidad", objData.msg, "success");

          // refrescar estructura si está abierta
          if ($('#modalEstructura').hasClass('show')) {
            var itemId = $('#txtItemIdIndicador').val();
            fntViewStructure(itemId);
          }
        } else {
          swal("Error", objData.msg, "error");
        }
      }
    };
  });

  // Form Archivos
  $('#formArchivo').submit(function (e) {
    e.preventDefault();

    var intIndicadorId = $('#txtIndicadorIdArchivo').val();
    var strTitulo = $('#txtTituloArchivo').val();
    var intEstado = $('#listEstadoArchivo').val();

    if (intIndicadorId == '' || strTitulo == '' || intEstado == '') {
      swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
      return false;
    }

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/gobernabilidad/setArchivo';
    var formData = new FormData($('#formArchivo')[0]);

    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $('#modalFormArchivo').modal("hide");
          $('#formArchivo')[0].reset();
          swal("Archivos de Gobernabilidad", objData.msg, "success");

          // refrescar estructura si está abierta
          if ($('#modalEstructura').hasClass('show')) {
            var itemId = $('#txtItemIdIndicador').val();
            if (itemId) fntViewStructure(itemId);
          }

          // refrescar tabla de archivos si está abierta
          if ($('#modalArchivosIndicador').hasClass('show')) {
            var currentIndicadorId = $('#modalArchivosIndicador').data('indicador-id');
            if (currentIndicadorId) fntViewArchivosIndicador(currentIndicadorId);
          }

        } else {
          swal("Error", objData.msg, "error");
        }
      }
    };
  });

});

// Ver item (usa el mismo modal de item, pero en modo lectura)
function fntViewGobernabilidad(idItem) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/gobernabilidad/getItem/' + idItem;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;
        $('#idItem').val(data.id);
        $('#txtNombre').val(data.nombre);
        $('#txtDescripcion').val(data.descripcion);
        $('#txtOrden').val(data.orden);
        $('#listEstado').val(data.estado);

        $('#modalFormGobernabilidad .modal-title').html('Ver Item');
        $('#btnActionForm').hide();

        // Modo lectura
        $('#formGobernabilidad').find('input, textarea').attr('readonly', true);
        $('#listEstado').attr('disabled', true);

        $('#modalFormGobernabilidad').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Editar item
function fntEditGobernabilidad(idItem) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/gobernabilidad/getItem/' + idItem;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;
        $('#idItem').val(data.id);
        $('#txtNombre').val(data.nombre);
        $('#txtDescripcion').val(data.descripcion);
        $('#txtOrden').val(data.orden);
        $('#listEstado').val(data.estado);

        $('#modalFormGobernabilidad .modal-title').html('Actualizar Item');
        $('#btnActionForm').show();

        // Modo edición
        $('#formGobernabilidad').find('input, textarea').removeAttr('readonly');
        $('#listEstado').removeAttr('disabled');

        $('#modalFormGobernabilidad').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Eliminar item
function fntDelGobernabilidad(idItem) {
  swal({
    title: "Eliminar Item",
    text: "¿Realmente quiere eliminar este item?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
    closeOnConfirm: false,
    closeOnCancel: true
  }, function (isConfirm) {
    if (isConfirm) {
      var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/gobernabilidad/delItem';
      var strData = "idItem=" + idItem;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.send(strData);

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            swal("Eliminar!", objData.msg, "success");
            tableGobernabilidad.ajax.reload();
          } else {
            swal("Atención!", objData.msg, "error");
          }
        }
      };
    }
  });
}

// Nuevo item
function openModal() {
  document.querySelector('#idItem').value = "";
  $('#modalFormGobernabilidad .modal-title').text("Nuevo Item de Gobernabilidad");
  $('#btnActionForm').show();
  $('#btnText').text("Guardar");

  // Reset modo edición
  $('#formGobernabilidad')[0].reset();
  $('#formGobernabilidad').find('input, textarea').removeAttr('readonly');
  $('#listEstado').removeAttr('disabled');

  $('#modalFormGobernabilidad').modal('show');
}

// Ver estructura jerárquica (Indicadores)
function fntViewStructure(idItem) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/gobernabilidad/getIndicadoresByItem/' + idItem;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var indicadores = objData.data;
        var htmlEstructura = '<div class="estructura-container">';

        htmlEstructura += '<div class="d-flex justify-content-between align-items-center mb-3">';
        htmlEstructura += '<h5>Indicadores del Item</h5>';
        htmlEstructura += '<button type="button" class="btn btn-primary btn-sm" onclick="openModalIndicador(' + idItem + ')">';
        htmlEstructura += '<i class="fas fa-plus-circle"></i> Nuevo Indicador';
        htmlEstructura += '</button>';
        htmlEstructura += '</div>';

        if (indicadores.length > 0) {
          htmlEstructura += '<div class="accordion" id="accordionIndicadores">';

          indicadores.forEach((indicador) => {
            htmlEstructura += '<div class="card">';
            htmlEstructura += '<div class="card-header" id="heading' + indicador.id + '">';
            htmlEstructura += '<h5 class="mb-0 d-flex justify-content-between align-items-center">';

            // ✅ Bootstrap 4: data-toggle / data-target
            htmlEstructura += '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse' + indicador.id + '" aria-expanded="false" aria-controls="collapse' + indicador.id + '">';
            htmlEstructura += indicador.nombre;
            htmlEstructura += '</button>';

            htmlEstructura += '<div class="text-right">';
            htmlEstructura += '<button class="btn btn-primary btn-sm" onclick="openModalIndicadorEdit(' + indicador.item_id + ',' + indicador.id + ')" title="Editar indicador"><i class="fas fa-pencil-alt"></i></button>';
            htmlEstructura += '<button class="btn btn-danger btn-sm ml-1" onclick="fntDelIndicador(' + indicador.id + ')" title="Eliminar indicador"><i class="far fa-trash-alt"></i></button>';
            htmlEstructura += '<button class="btn btn-info btn-sm ml-1" onclick="fntViewArchivosIndicador(' + indicador.id + ')" title="Ver archivos del indicador"><i class="fas fa-list"></i></button>';
            htmlEstructura += '<button class="btn btn-success btn-sm ml-1" onclick="openModalArchivo(' + indicador.id + ')" title="Agregar archivo"><i class="fas fa-file-pdf"></i></button>';
            htmlEstructura += '</div>';

            htmlEstructura += '</h5>';
            htmlEstructura += '</div>';

            htmlEstructura += '<div id="collapse' + indicador.id + '" class="collapse" aria-labelledby="heading' + indicador.id + '" data-parent="#accordionIndicadores">';
            htmlEstructura += '<div class="card-body">';
            htmlEstructura += '<p>' + (indicador.descripcion || '') + '</p>';

            htmlEstructura += '<div id="archivos-indicador-' + indicador.id + '">Cargando archivos...</div>';

            (function (indicadorId) {
              $.get(base_url + '/gobernabilidad/getArchivosByIndicador/' + indicadorId, function (response) {
                var archivosHtml = '';

                if (response.status) {
                  var archivos = response.data;

                  if (archivos.length > 0) {
                    archivosHtml += '<h6 class="mt-3">Archivos:</h6>';
                    archivosHtml += '<div class="table-responsive">';
                    archivosHtml += '<table class="table table-striped table-bordered">';
                    archivosHtml += '<thead><tr><th>Título</th><th>Descripción</th><th>Archivo</th><th>Acciones</th></tr></thead>';
                    archivosHtml += '<tbody>';

                    archivos.forEach(archivo => {
                      archivosHtml += '<tr>';
                      archivosHtml += '<td>' + (archivo.titulo || '') + '</td>';
                      archivosHtml += '<td>' + (archivo.descripcion || '') + '</td>';
                      var rutaFix = (archivo.archivo_ruta || '').replace('Assets/files/', 'Assets/upload/');
archivosHtml += '<td>' + (rutaFix
  ? '<a href="' + base_url + '/' + rutaFix + '" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-download"></i> Descargar</a>'
  : '<span class="text-danger">Sin archivo</span>') + '</td>';archivosHtml += '<td>';
                      archivosHtml += '<button class="btn btn-primary btn-sm" onclick="openModalArchivoEdit(' + archivo.indicador_id + ',' + archivo.id + ')" title="Editar archivo"><i class="fas fa-pencil-alt"></i></button>';
                      archivosHtml += ' <button class="btn btn-danger btn-sm" onclick="fntDelArchivo(' + archivo.id + ')" title="Eliminar archivo"><i class="far fa-trash-alt"></i></button>';
                      archivosHtml += '</td>';
                      archivosHtml += '</tr>';
                    });

                    archivosHtml += '</tbody></table></div>';
                  } else {
                    archivosHtml += '<p class="mt-3"><em>No hay archivos para este indicador.</em></p>';
                  }
                } else {
                  archivosHtml += '<p class="text-danger">Error al cargar archivos.</p>';
                }

                var el = document.getElementById('archivos-indicador-' + indicadorId);
                if (el) el.innerHTML = archivosHtml;
              }).fail(function () {
                var el = document.getElementById('archivos-indicador-' + indicadorId);
                if (el) el.innerHTML = '<p class="text-danger">Error de conexión al cargar archivos.</p>';
              });
            })(indicador.id);

            htmlEstructura += '</div></div></div>';
          });

          htmlEstructura += '</div>';
        } else {
          htmlEstructura += '<p>No hay indicadores para este item.</p>';
        }

        htmlEstructura += '</div>';

        document.getElementById('estructuraGobernabilidad').innerHTML = htmlEstructura;
        $('#modalEstructura').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Nuevo indicador (NO cierra otros modales)
function openModalIndicador(idItem) {
  $('#idIndicador').val('');
  $('#txtItemIdIndicador').val(idItem);
  $('#formIndicador')[0].reset();

  $('#modalFormIndicador .modal-title').text('Nuevo Indicador');
  $('#btnActionFormIndicador').removeClass('btn-info').addClass('btn-success');
  $('#btnTextIndicador').text('Guardar');

  $('#modalFormIndicador').modal('show');
}

// Editar indicador (NO cierra otros modales)
function openModalIndicadorEdit(idItem, idIndicador) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/gobernabilidad/getIndicador/' + idIndicador;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;

        $('#idIndicador').val(data.id);
        $('#txtItemIdIndicador').val(data.item_id);
        $('#txtNombreIndicador').val(data.nombre);
        $('#txtDescripcionIndicador').val(data.descripcion);
        $('#txtOrdenIndicador').val(data.orden);
        $('#listEstadoIndicador').val(data.estado);

        $('#modalFormIndicador .modal-title').text('Actualizar Indicador');
        $('#btnActionFormIndicador').removeClass('btn-success').addClass('btn-info');
        $('#btnTextIndicador').text('Actualizar');

        $('#modalFormIndicador').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Eliminar indicador
function fntDelIndicador(idIndicador) {
  swal({
    title: "Eliminar Indicador",
    text: "¿Realmente quiere eliminar este indicador?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
    closeOnConfirm: false,
    closeOnCancel: true
  }, function (isConfirm) {
    if (isConfirm) {
      var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/gobernabilidad/delIndicador';
      var strData = "idIndicador=" + idIndicador;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.send(strData);

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            swal("Eliminar!", objData.msg, "success");
            var itemId = $('#txtItemIdIndicador').val();
            if ($('#modalEstructura').hasClass('show') && itemId) {
              fntViewStructure(itemId);
            }
          } else {
            swal("Atención!", objData.msg, "error");
          }
        }
      };
    }
  });
}

// Nuevo archivo (NO cierra otros modales)
function openModalArchivo(idIndicador) {
  $('#idArchivo').val('');
  $('#txtIndicadorIdArchivo').val(idIndicador);
  $('#formArchivo')[0].reset();

  $('#modalFormArchivo .modal-title').text('Nuevo Archivo');
  $('#btnActionFormArchivo').removeClass('btn-info').addClass('btn-success');
  $('#btnTextArchivo').text('Guardar');

  $('#modalFormArchivo').modal('show');
}

// Editar archivo (NO cierra otros modales)
function openModalArchivoEdit(idIndicador, idArchivo) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/gobernabilidad/getArchivo/' + idArchivo;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;

        $('#idArchivo').val(data.id);
        $('#txtIndicadorIdArchivo').val(data.indicador_id);
        $('#txtTituloArchivo').val(data.titulo);
        $('#txtDescripcionArchivo').val(data.descripcion);
        $('#txtOrdenArchivo').val(data.orden);
        $('#listEstadoArchivo').val(data.estado);

        $('#modalFormArchivo .modal-title').text('Actualizar Archivo');
        $('#btnActionFormArchivo').removeClass('btn-success').addClass('btn-info');
        $('#btnTextArchivo').text('Actualizar');

        $('#modalFormArchivo').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Eliminar archivo
function fntDelArchivo(idArchivo) {
  swal({
    title: "Eliminar Archivo",
    text: "¿Realmente quiere eliminar este archivo?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
    closeOnConfirm: false,
    closeOnCancel: true
  }, function (isConfirm) {
    if (isConfirm) {
      var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/gobernabilidad/delArchivo';
      var strData = "idArchivo=" + idArchivo;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.send(strData);

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            swal("Eliminar!", objData.msg, "success");

            var itemId = $('#txtItemIdIndicador').val();
            if ($('#modalEstructura').hasClass('show') && itemId) {
              fntViewStructure(itemId);
            }

            if ($('#modalArchivosIndicador').hasClass('show')) {
              var currentIndicadorId = $('#modalArchivosIndicador').data('indicador-id');
              if (currentIndicadorId) fntViewArchivosIndicador(currentIndicadorId);
            }
          } else {
            swal("Atención!", objData.msg, "error");
          }
        }
      };
    }
  });
}

// Ver archivos por indicador (NO cierra otros modales)
function fntViewArchivosIndicador(idIndicador) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/gobernabilidad/getArchivosByIndicador/' + idIndicador;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var archivos = objData.data;
        var cuerpoTabla = document.getElementById('cuerpoTablaArchivos');
        var tituloIndicador = document.getElementById('tituloIndicador');

        // Obtener nombre del indicador (síncrono como lo tenías)
        var indicadorRequest = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var indicadorAjaxUrl = base_url + '/gobernabilidad/getIndicador/' + idIndicador;
        indicadorRequest.open("GET", indicadorAjaxUrl, false);
        indicadorRequest.send();

        if (indicadorRequest.status == 200) {
          var indicadorData = JSON.parse(indicadorRequest.responseText);
          if (indicadorData.status) {
            tituloIndicador.innerHTML = 'Archivos del Indicador: ' + indicadorData.data.nombre;
          }
        }

        $('#modalArchivosIndicador').data('indicador-id', idIndicador);
        cuerpoTabla.innerHTML = '';

        if (archivos.length > 0) {
          archivos.forEach(archivo => {
            var fila = document.createElement('tr');
            var estadoTexto = (archivo.estado == 1) ? 'Activo' : 'Inactivo';

            fila.innerHTML = `
              <td>${archivo.id}</td>
              <td>${archivo.titulo || ''}</td>
              <td>${archivo.descripcion || ''}</td>
             <td>${
  (archivo.archivo_ruta && archivo.archivo_ruta.trim())
    ? `<a href="${base_url}/${(archivo.archivo_ruta || '').replace('Assets/files/', 'Assets/upload/')}" target="_blank">${(archivo.archivo_ruta || '').split('/').pop()}</a>`
    : `<span class="text-danger">Sin archivo</span>`
}</td><td>${estadoTexto}</td>
              <td>
                <button class="btn btn-primary btn-sm" onclick="openModalArchivoEdit(${archivo.indicador_id}, ${archivo.id})" title="Editar archivo"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger btn-sm ml-1" onclick="fntDelArchivo(${archivo.id})" title="Eliminar archivo"><i class="far fa-trash-alt"></i></button>
              </td>
            `;
            cuerpoTabla.appendChild(fila);
          });
        } else {
          var fila = document.createElement('tr');
          fila.innerHTML = `<td colspan="6" class="text-center">No hay archivos para este indicador.</td>`;
          cuerpoTabla.appendChild(fila);
        }

        $('#modalArchivosIndicador').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Nuevo archivo desde el modal de archivos (NO cierra otros modales)
function openModalArchivoPorIndicador() {
  var indicadorId = $('#modalArchivosIndicador').data('indicador-id');

  if (indicadorId) {
    $('#idArchivo').val('');
    $('#txtIndicadorIdArchivo').val(indicadorId);
    $('#formArchivo')[0].reset();

    $('#modalFormArchivo .modal-title').text('Nuevo Archivo');
    $('#btnActionFormArchivo').removeClass('btn-info').addClass('btn-success');
    $('#btnTextArchivo').text('Guardar');

    $('#modalFormArchivo').modal('show');
  } else {
    swal("Error", "No se ha especificado un indicador válido.", "error");
  }
}
