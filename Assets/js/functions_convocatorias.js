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
tableConvocatorias = $('#tableConvocatorias').DataTable({
  aProcessing: true,
  aServerSide: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
  },
  ajax: {
    url: base_url + "/convocatorias/getConvocatorias",
    dataSrc: function (json) {
      return (json && json.status) ? json.data : [];
    }
  },
  columns: [
    { data: "id" },
    { data: "titulo" },
    {
      data: "descripcion",
      render: function (data) {
        return (data && data.length > 50) ? data.substring(0, 50) + "..." : (data || "");
      }
    },
    { data: "fecha_inicio" },
    { data: "fecha_fin" },
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

        // ✅ SIEMPRE mostrar botones (activos e inactivos)
        var btnView = '<button class="btn btn-info btn-sm" onclick="fntViewConvocatoria(' + data.id + ')" title="Ver convocatoria"><i class="far fa-eye"></i></button>';

        var btnEdit = '<button class="btn btn-primary btn-sm" onclick="fntEditConvocatoria(' + data.id + ')" title="Editar convocatoria"><i class="fas fa-pencil-alt"></i></button>';

        var btnStructure = '<button class="btn btn-secondary btn-sm" onclick="fntViewStructure(' + data.id + ')" title="Ver estructura"><i class="fas fa-sitemap"></i></button>';

        var btnDelete = '<button class="btn btn-danger btn-sm" onclick="fntDelConvocatoria(' + data.id + ')" title="Eliminar convocatoria"><i class="far fa-trash-alt"></i></button>';

        return '<div class="text-center">' + btnView + ' ' + btnEdit + ' ' + btnStructure + ' ' + btnDelete + '</div>';
      }
    }
  ],
  responsive: true,
  bDestroy: true,
  iDisplayLength: 10,
  order: [[0, "desc"]]
});


  // Form Convocatorias
  $('#formConvocatoria').submit(function (e) {
    e.preventDefault();

    var strTitulo = $('#txtTitulo').val();
    var strFechaInicio = $('#txtFechaInicio').val();
    var strFechaFin = $('#txtFechaFin').val();
    var intEstado = $('#listEstado').val();

    if (strTitulo == '' || strFechaInicio == '' || strFechaFin == '' || intEstado == '') {
      swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
      return false;
    }

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/convocatorias/setConvocatoria';
    var formData = new FormData($('#formConvocatoria')[0]);

    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $('#modalFormConvocatoria').modal("hide");
          $('#formConvocatoria')[0].reset();
          swal("Convocatorias", objData.msg, "success");
          tableConvocatorias.ajax.reload();
        } else {
          swal("Error", objData.msg, "error");
        }
      }
    };
  });

  // Form Items
  $('#formItem').submit(function (e) {
    e.preventDefault();

    var intConvocatoriaId = $('#txtConvocatoriaIdItem').val();
    var strNombre = $('#txtNombreItem').val();
    var intEstado = $('#listEstadoItem').val();

    if (intConvocatoriaId == '' || strNombre == '' || intEstado == '') {
      swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
      return false;
    }

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/convocatorias/setItem';
    var formData = new FormData($('#formItem')[0]);

    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $('#modalFormItem').modal("hide");
          $('#formItem')[0].reset();
          swal("Items de Convocatoria", objData.msg, "success");

          // refrescar estructura si está abierta
          if ($('#modalEstructura').hasClass('show')) {
            var convocatoriaId = $('#txtConvocatoriaIdItem').val();
            fntViewStructure(convocatoriaId);
          }
        } else {
          swal("Error", objData.msg, "error");
        }
      }
    };
  });

  // Form Documentos
  $('#formDocumento').submit(function (e) {
    e.preventDefault();

    var intItemId = $('#txtItemIdDocumento').val();
    var strTitulo = $('#txtTituloDocumento').val();
    var intEstado = $('#listEstadoDocumento').val();

    if (intItemId == '' || strTitulo == '' || intEstado == '') {
      swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
      return false;
    }

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/convocatorias/setDocumento';
    var formData = new FormData($('#formDocumento')[0]);

    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $('#modalFormDocumento').modal("hide");
          $('#formDocumento')[0].reset();
          swal("Documentos de Convocatoria", objData.msg, "success");

          // refrescar estructura si está abierta
          if ($('#modalEstructura').hasClass('show')) {
            var itemId = $('#txtItemIdDocumento').val();
            // Buscar la convocatoria padre para refrescar la estructura
            var convocatoriaId = $('#txtConvocatoriaIdItem').val();
            if (!convocatoriaId) {
              // Si no está en el contexto del item, encontrarlo de otra manera
              convocatoriaId = $('#modalFormDocumento').data('convocatoria-id');
            }
            if (convocatoriaId) fntViewStructure(convocatoriaId);
          }

          // refrescar tabla de documentos si está abierta
          if ($('#modalDocumentosItem').hasClass('show')) {
            var currentItem = $('#modalDocumentosItem').data('item-id');
            if (currentItem) fntViewDocumentosItem(currentItem);
          }
        } else {
          swal("Error", objData.msg, "error");
        }
      }
    };
  });

});

// Ver convocatoria (usa el mismo modal de convocatoria, pero en modo lectura)
function fntViewConvocatoria(idConvocatoria) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/convocatorias/getConvocatoria/' + idConvocatoria;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;
        $('#idConvocatoria').val(data.id);
        $('#txtTitulo').val(data.titulo);
        $('#txtDescripcion').val(data.descripcion);
        $('#txtFechaInicio').val(data.fecha_inicio);
        $('#txtFechaFin').val(data.fecha_fin);
        $('#listEstado').val(data.estado);

        $('#modalFormConvocatoria .modal-title').html('Ver Convocatoria');
        $('#btnActionForm').hide();

        // Modo lectura
        $('#formConvocatoria').find('input, textarea').attr('readonly', true);
        $('#listEstado').attr('disabled', true);

        $('#modalFormConvocatoria').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Editar convocatoria
function fntEditConvocatoria(idConvocatoria) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/convocatorias/getConvocatoria/' + idConvocatoria;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;
        $('#idConvocatoria').val(data.id);
        $('#txtTitulo').val(data.titulo);
        $('#txtDescripcion').val(data.descripcion);
        $('#txtFechaInicio').val(data.fecha_inicio);
        $('#txtFechaFin').val(data.fecha_fin);
        $('#listEstado').val(data.estado);

        $('#modalFormConvocatoria .modal-title').html('Actualizar Convocatoria');
        $('#btnActionForm').show();

        // Modo edición
        $('#formConvocatoria').find('input, textarea').removeAttr('readonly');
        $('#listEstado').removeAttr('disabled');

        $('#modalFormConvocatoria').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Eliminar convocatoria
function fntDelConvocatoria(idConvocatoria) {
  swal({
    title: "Eliminar Convocatoria",
    text: "¿Realmente quiere eliminar esta convocatoria?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
    closeOnConfirm: false,
    closeOnCancel: true
  }, function (isConfirm) {
    if (isConfirm) {
      var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/convocatorias/delConvocatoria';
      var strData = "idConvocatoria=" + idConvocatoria;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.send(strData);

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            swal("Eliminar!", objData.msg, "success");
            tableConvocatorias.ajax.reload();
          } else {
            swal("Atención!", objData.msg, "error");
          }
        }
      };
    }
  });
}

// Nuevo convocatoria
function openModal() {
  document.querySelector('#idConvocatoria').value = "";
  $('#modalFormConvocatoria .modal-title').text("Nueva Convocatoria");
  $('#btnActionForm').show();
  $('#btnText').text("Guardar");

  // Reset modo edición
  $('#formConvocatoria')[0].reset();
  $('#formConvocatoria').find('input, textarea').removeAttr('readonly');
  $('#listEstado').removeAttr('disabled');

  $('#modalFormConvocatoria').modal('show');
}

// Ver estructura jerárquica (Items y Documentos)
function fntViewStructure(idConvocatoria) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/convocatorias/getItemsByConvocatoria/' + idConvocatoria;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var items = objData.data;
        var htmlEstructura = '<div class="estructura-container">';

        htmlEstructura += '<div class="d-flex justify-content-between align-items-center mb-3">';
        htmlEstructura += '<h5>Items de la Convocatoria</h5>';
        htmlEstructura += '<button type="button" class="btn btn-primary btn-sm" onclick="openModalItem(' + idConvocatoria + ')">';
        htmlEstructura += '<i class="fas fa-plus-circle"></i> Nuevo Item';
        htmlEstructura += '</button>';
        htmlEstructura += '</div>';

        if (items.length > 0) {
          htmlEstructura += '<div class="accordion" id="accordionItems">';

          items.forEach((item) => {
            htmlEstructura += '<div class="card">';
            htmlEstructura += '<div class="card-header" id="headingItem' + item.id + '">';
            htmlEstructura += '<h5 class="mb-0 d-flex justify-content-between align-items-center">';

            // ✅ Bootstrap 4: data-toggle / data-target
            htmlEstructura += '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseItem' + item.id + '" aria-expanded="false" aria-controls="collapseItem' + item.id + '">';
            htmlEstructura += item.nombre;
            htmlEstructura += '</button>';

            htmlEstructura += '<div class="text-right">';
            htmlEstructura += '<button class="btn btn-primary btn-sm" onclick="openModalItemEdit(' + item.convocatoria_id + ',' + item.id + ')" title="Editar item"><i class="fas fa-pencil-alt"></i></button>';
            htmlEstructura += '<button class="btn btn-danger btn-sm ml-1" onclick="fntDelItem(' + item.id + ')" title="Eliminar item"><i class="far fa-trash-alt"></i></button>';
            htmlEstructura += '<button class="btn btn-info btn-sm ml-1" onclick="fntViewDocumentosItem(' + item.id + ')" title="Ver documentos del item"><i class="fas fa-list"></i></button>';
            htmlEstructura += '<button class="btn btn-success btn-sm ml-1" onclick="openModalDocumento(' + item.id + ')" title="Agregar documento"><i class="fas fa-file-pdf"></i></button>';
            htmlEstructura += '</div>';

            htmlEstructura += '</h5>';
            htmlEstructura += '</div>';

            htmlEstructura += '<div id="collapseItem' + item.id + '" class="collapse" aria-labelledby="headingItem' + item.id + '" data-parent="#accordionItems">';
            htmlEstructura += '<div class="card-body">';
            htmlEstructura += '<p>' + (item.descripcion || '') + '</p>';

            htmlEstructura += '<div id="archivos-item-' + item.id + '">Cargando archivos...</div>';

            (function (itemId) {
              $.get(base_url + '/convocatorias/getDocumentosByItem/' + itemId, function (response) {
                var archivosHtml = '';

                if (response.status) {
                  var documentos = response.data;

                  if (documentos.length > 0) {
                    archivosHtml += '<h6 class="mt-3">Documentos:</h6>';
                    archivosHtml += '<div class="table-responsive">';
                    archivosHtml += '<table class="table table-striped table-bordered">';
                    archivosHtml += '<thead><tr><th>Título</th><th>Descripción</th><th>Archivo</th><th>Acciones</th></tr></thead>';
                    archivosHtml += '<tbody>';

                    documentos.forEach(documento => {
                      archivosHtml += '<tr>';
                      archivosHtml += '<td>' + (documento.titulo_documento || '') + '</td>';
                      archivosHtml += '<td>' + (documento.descripcion_documento || '') + '</td>';
                      var rutaFix = (documento.archivo_ruta || '').replace('Assets/files/', 'Assets/upload/');
                      archivosHtml += '<td>' + (rutaFix
                        ? '<a href="' + base_url + '/' + rutaFix + '" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-download"></i> Descargar</a>'
                        : '<span class="text-danger">Sin archivo</span>') + '</td>';
                      archivosHtml += '<td>';
                      archivosHtml += '<button class="btn btn-primary btn-sm" onclick="openModalDocumentoEdit(' + documento.item_id + ',' + documento.id + ')" title="Editar archivo"><i class="fas fa-pencil-alt"></i></button>';
                      archivosHtml += ' <button class="btn btn-danger btn-sm" onclick="fntDelDocumento(' + documento.id + ')" title="Eliminar archivo"><i class="far fa-trash-alt"></i></button>';
                      archivosHtml += '</td>';
                      archivosHtml += '</tr>';
                    });

                    archivosHtml += '</tbody></table></div>';
                  } else {
                    archivosHtml += '<p class="mt-3"><em>No hay documentos para este item.</em></p>';
                  }
                } else {
                  archivosHtml += '<p class="text-danger">Error al cargar documentos.</p>';
                }

                var el = document.getElementById('archivos-item-' + itemId);
                if (el) el.innerHTML = archivosHtml;
              }).fail(function () {
                var el = document.getElementById('archivos-item-' + itemId);
                if (el) el.innerHTML = '<p class="text-danger">Error de conexión al cargar documentos.</p>';
              });
            })(item.id);

            htmlEstructura += '</div></div></div>';
          });

          htmlEstructura += '</div>';
        } else {
          htmlEstructura += '<p>No hay items para esta convocatoria.</p>';
        }

        htmlEstructura += '</div>';

        document.getElementById('estructuraConvocatorias').innerHTML = htmlEstructura;
        $('#modalEstructura').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Nuevo item (NO cierra otros modales)
function openModalItem(idConvocatoria) {
  $('#idItem').val('');
  $('#txtConvocatoriaIdItem').val(idConvocatoria);
  $('#formItem')[0].reset();

  $('#modalFormItem .modal-title').text('Nuevo Item');
  $('#btnActionFormItem').removeClass('btn-info').addClass('btn-success');
  $('#btnTextItem').text('Guardar');

  $('#modalFormItem').modal('show');
}

// Editar item (NO cierra otros modales)
function openModalItemEdit(idConvocatoria, idItem) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/convocatorias/getItem/' + idItem;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;

        $('#idItem').val(data.id);
        $('#txtConvocatoriaIdItem').val(data.convocatoria_id);
        $('#txtNombreItem').val(data.nombre);
        $('#txtDescripcionItem').val(data.descripcion);
        $('#txtOrdenItem').val(data.orden);
        $('#listEstadoItem').val(data.estado);

        $('#modalFormItem .modal-title').text('Actualizar Item');
        $('#btnActionFormItem').removeClass('btn-success').addClass('btn-info');
        $('#btnTextItem').text('Actualizar');

        $('#modalFormItem').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Eliminar item
function fntDelItem(idItem) {
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
      var ajaxUrl = base_url + '/convocatorias/delItem';
      var strData = "idItem=" + idItem;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.send(strData);

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            swal("Eliminar!", objData.msg, "success");
            var convocatoriaId = $('#txtConvocatoriaIdItem').val();
            if ($('#modalEstructura').hasClass('show') && convocatoriaId) {
              fntViewStructure(convocatoriaId);
            }
          } else {
            swal("Atención!", objData.msg, "error");
          }
        }
      };
    }
  });
}

// Nuevo documento (NO cierra otros modales)
function openModalDocumento(idItem) {
  $('#idDocumento').val('');
  $('#txtItemIdDocumento').val(idItem);
  $('#formDocumento')[0].reset();

  $('#modalFormDocumento .modal-title').text('Nuevo Documento');
  $('#btnActionFormDocumento').removeClass('btn-info').addClass('btn-success');
  $('#btnTextDocumento').text('Guardar');

  // Guardar el ID de la convocatoria para usarlo si es necesario
  $('#modalFormDocumento').data('convocatoria-id', $('#txtConvocatoriaIdItem').val());

  $('#modalFormDocumento').modal('show');
}

// Editar documento (NO cierra otros modales)
function openModalDocumentoEdit(idItem, idDocumento) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/convocatorias/getDocumento/' + idDocumento;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;

        $('#idDocumento').val(data.id);
        $('#txtItemIdDocumento').val(data.item_id);
        $('#txtTituloDocumento').val(data.titulo_documento);
        $('#txtDescripcionDocumento').val(data.descripcion_documento);
        $('#txtOrdenDocumento').val(data.orden);
        $('#listEstadoDocumento').val(data.estado);

        $('#modalFormDocumento .modal-title').text('Actualizar Documento');
        $('#btnActionFormDocumento').removeClass('btn-success').addClass('btn-info');
        $('#btnTextDocumento').text('Actualizar');

        $('#modalFormDocumento').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Eliminar documento
function fntDelDocumento(idDocumento) {
  swal({
    title: "Eliminar Documento",
    text: "¿Realmente quiere eliminar este documento?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
    closeOnConfirm: false,
    closeOnCancel: true
  }, function (isConfirm) {
    if (isConfirm) {
      var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/convocatorias/delDocumento';
      var strData = "idDocumento=" + idDocumento;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.send(strData);

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            swal("Eliminar!", objData.msg, "success");
            var itemId = $('#txtItemIdDocumento').val();
            if ($('#modalEstructura').hasClass('show') && itemId) {
              // Obtener la convocatoria padre para refrescar la estructura
              var convocatoriaId = $('#txtConvocatoriaIdItem').val();
              if (convocatoriaId) fntViewStructure(convocatoriaId);
            }

            if ($('#modalDocumentosItem').hasClass('show')) {
              var currentItem = $('#modalDocumentosItem').data('item-id');
              if (currentItem) fntViewDocumentosItem(currentItem);
            }
          } else {
            swal("Atención!", objData.msg, "error");
          }
        }
      };
    }
  });
}

// Ver documentos por item (NO cierra otros modales)
function fntViewDocumentosItem(idItem) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/convocatorias/getDocumentosByItem/' + idItem;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var documentos = objData.data;
        var cuerpoTabla = document.getElementById('cuerpoTablaDocumentos');
        var tituloItem = document.getElementById('tituloItem');

        // Obtener nombre del item (síncrono como lo tenías)
        var itemRequest = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var itemAjaxUrl = base_url + '/convocatorias/getItem/' + idItem;
        itemRequest.open("GET", itemAjaxUrl, false);
        itemRequest.send();

        if (itemRequest.status == 200) {
          var itemData = JSON.parse(itemRequest.responseText);
          if (itemData.status) {
            tituloItem.innerHTML = 'Documentos del Item: ' + itemData.data.nombre;
          }
        }

        $('#modalDocumentosItem').data('item-id', idItem);
        cuerpoTabla.innerHTML = '';

        if (documentos.length > 0) {
          documentos.forEach(documento => {
            var fila = document.createElement('tr');
            var estadoTexto = (documento.estado == 1) ? 'Activo' : 'Inactivo';

            fila.innerHTML = `
              <td>${documento.id}</td>
              <td>${documento.titulo_documento || ''}</td>
              <td>${documento.descripcion_documento || ''}</td>
              <td>${
                (documento.archivo_ruta && documento.archivo_ruta.trim())
                  ? `<a href="${base_url}/${(documento.archivo_ruta || '').replace('Assets/files/', 'Assets/upload/')}" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-download"></i> Descargar</a>`
                  : `<span class="text-danger">Sin archivo</span>`
              }</td>
              <td>${estadoTexto}</td>
              <td>
                <button class="btn btn-primary btn-sm" onclick="openModalDocumentoEdit(${documento.item_id}, ${documento.id})" title="Editar archivo"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger btn-sm ml-1" onclick="fntDelDocumento(${documento.id})" title="Eliminar archivo"><i class="far fa-trash-alt"></i></button>
              </td>
            `;
            cuerpoTabla.appendChild(fila);
          });
        } else {
          var fila = document.createElement('tr');
          fila.innerHTML = `<td colspan="6" class="text-center">No hay documentos para este item.</td>`;
          cuerpoTabla.appendChild(fila);
        }

        $('#modalDocumentosItem').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Nuevo archivo desde el modal de documentos (NO cierra otros modales)
function openModalDocumentoPorItem() {
  var itemId = $('#modalDocumentosItem').data('item-id');

  if (itemId) {
    $('#idDocumento').val('');
    $('#txtItemIdDocumento').val(itemId);
    $('#formDocumento')[0].reset();

    $('#modalFormDocumento .modal-title').text('Nuevo Documento');
    $('#btnActionFormDocumento').removeClass('btn-info').addClass('btn-success');
    $('#btnTextDocumento').text('Guardar');

    $('#modalFormDocumento').modal('show');
  } else {
    swal("Error", "No se ha especificado un item válido.", "error");
  }
}
