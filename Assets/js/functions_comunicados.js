// ===== Bootstrap 4: Modales apilados =====
(function () {
  $(document).on('show.bs.modal', '.modal', function () {
    var openCount = $('.modal.show').length;
    var zIndexBase = 1040 + (openCount * 20);
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
  var tableComunicados = $('#tableComunicados').DataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    ajax: {
      url: base_url + "/comunicados/getComunicados",
      dataSrc: function (json) {
        return (json && json.status) ? json.data : [];
      }
    },
    columns: [
      { data: "id" },
      {
        data: "imagen_ruta",
        render: function (data) {
          if (!data || data === '') {
            return '<span class="text-muted">Sin imagen</span>';
          }
          var ruta = data.replace('Assets/files/', 'Assets/upload/');
          return '<img src="' + base_url + '/' + ruta + '" alt="Imagen" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">';
        }
      },
      { data: "titulo" },
      { data: "fecha_comunicado" },
      {
        data: "descripcion",
        render: function (data) {
          return (data && data.length > 50) ? data.substring(0, 50) + "..." : (data || "");
        }
      },
      {
        data: "pdf_ruta",
        render: function (data) {
          if (!data || data === '') {
            return '<span class="text-muted">Sin PDF</span>';
          }
          return '<i class="fas fa-file-pdf text-danger"></i> PDF';
        }
      },
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
          var btnView = '<button class="btn btn-info btn-sm" onclick="fntViewComunicado(' + data.id + ')" title="Ver comunicado"><i class="far fa-eye"></i></button>';
          var btnEdit = '<button class="btn btn-primary btn-sm" onclick="fntEditComunicado(' + data.id + ')" title="Editar comunicado"><i class="fas fa-pencil-alt"></i></button>';
          var btnDelete = '<button class="btn btn-danger btn-sm" onclick="fntDelComunicado(' + data.id + ')" title="Eliminar comunicado"><i class="far fa-trash-alt"></i></button>';

          return '<div class="text-center">' + btnView + ' ' + btnEdit + ' ' + btnDelete + '</div>';
        }
      }
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]]
  });

  // Form Comunicados
  $('#formComunicado').submit(function (e) {
    e.preventDefault();

    var strTitulo = $('#txtTitulo').val();
    var strFechaComunicado = $('#txtFechaComunicado').val();
    var intEstado = $('#listEstado').val();

    if (strTitulo == '' || strFechaComunicado == '' || intEstado == '') {
      swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
      return false;
    }

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/comunicados/setComunicado';
    var formData = new FormData($('#formComunicado')[0]);

    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $('#modalFormComunicado').modal("hide");
          $('#formComunicado')[0].reset();
          $('#imagenPreview').html('');
          $('#pdfPreview').html('');
          swal("Comunicados", objData.msg, "success");
          tableComunicados.ajax.reload();
        } else {
          swal("Error", objData.msg, "error");
        }
      }
    };
  });

});

// Ver comunicado
function fntViewComunicado(idComunicado) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/comunicados/getComunicado/' + idComunicado;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;
        $('#idComunicado').val(data.id);
        $('#txtTitulo').val(data.titulo);
        $('#txtDescripcion').val(data.descripcion);
        $('#txtFechaComunicado').val(data.fecha_comunicado);
        $('#listEstado').val(data.estado);

        // Mostrar imagen actual
        if (data.imagen_ruta && data.imagen_ruta !== '') {
          var imagenRuta = data.imagen_ruta.replace('Assets/files/', 'Assets/upload/');
          $('#imagenPreview').html('<img src="' + base_url + '/' + imagenRuta + '" alt="Imagen actual" style="max-width: 200px; border-radius: 8px;">');
        }

        // Mostrar PDF actual si existe
        if (data.pdf_ruta && data.pdf_ruta !== '') {
          var pdfRuta = data.pdf_ruta.replace('Assets/files/', 'Assets/upload/');
          $('#pdfPreview').html('<a href="' + base_url + '/' + pdfRuta + '" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-pdf"></i> Ver PDF actual</a>');
        }

        $('#modalFormComunicado .modal-title').html('Ver Comunicado');
        $('#btnActionForm').hide();

        // Modo lectura
        $('#formComunicado').find('input, textarea').attr('readonly', true);
        $('#listEstado').attr('disabled', true);
        $('#imagenComunicado').attr('disabled', true);
        $('#pdfComunicado').attr('disabled', true);

        $('#modalFormComunicado').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Editar comunicado
function fntEditComunicado(idComunicado) {
  var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/comunicados/getComunicado/' + idComunicado;

  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        var data = objData.data;
        $('#idComunicado').val(data.id);
        $('#txtTitulo').val(data.titulo);
        $('#txtDescripcion').val(data.descripcion);
        $('#txtFechaComunicado').val(data.fecha_comunicado);
        $('#listEstado').val(data.estado);

        // Mostrar imagen actual
        if (data.imagen_ruta && data.imagen_ruta !== '') {
          var imagenRuta = data.imagen_ruta.replace('Assets/files/', 'Assets/upload/');
          $('#imagenPreview').html('<img src="' + base_url + '/' + imagenRuta + '" alt="Imagen actual" style="max-width: 200px; border-radius: 8px;">');
        }

        // Mostrar PDF actual si existe
        if (data.pdf_ruta && data.pdf_ruta !== '') {
          var pdfRuta = data.pdf_ruta.replace('Assets/files/', 'Assets/upload/');
          $('#pdfPreview').html('<a href="' + base_url + '/' + pdfRuta + '" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-pdf"></i> Ver PDF actual</a>');
        }

        $('#modalFormComunicado .modal-title').html('Actualizar Comunicado');
        $('#btnActionForm').show();

        // Modo edición
        $('#formComunicado').find('input, textarea').removeAttr('readonly');
        $('#listEstado').removeAttr('disabled');
        $('#imagenComunicado').removeAttr('disabled');
        $('#pdfComunicado').removeAttr('disabled');

        $('#modalFormComunicado').modal('show');
      } else {
        swal("Error", objData.msg, "error");
      }
    }
  };
}

// Eliminar comunicado
function fntDelComunicado(idComunicado) {
  swal({
    title: "Eliminar Comunicado",
    text: "¿Realmente quiere eliminar este comunicado?",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar!",
    cancelButtonText: "No, cancelar!",
    closeOnConfirm: false,
    closeOnCancel: true
  }, function (isConfirm) {
    if (isConfirm) {
      var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/comunicados/delComunicado';
      var strData = "idComunicado=" + idComunicado;

      request.open("POST", ajaxUrl, true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.send(strData);

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            swal("Eliminar!", objData.msg, "success");
            tableComunicados.ajax.reload();
          } else {
            swal("Atención!", objData.msg, "error");
          }
        }
      };
    }
  });
}

// Nuevo comunicado
function openModal() {
  document.querySelector('#idComunicado').value = "";
  $('#modalFormComunicado .modal-title').text("Nuevo Comunicado");
  $('#btnActionForm').show();
  $('#btnText').text("Guardar");

  // Reset formulario
  $('#formComunicado')[0].reset();
  $('#imagenPreview').html('');
  $('#pdfPreview').html('');

  // Reset modo edición
  $('#formComunicado').find('input, textarea').removeAttr('readonly');
  $('#listEstado').removeAttr('disabled');
  $('#imagenComunicado').removeAttr('disabled');
  $('#pdfComunicado').removeAttr('disabled');

  $('#modalFormComunicado').modal('show');
}
