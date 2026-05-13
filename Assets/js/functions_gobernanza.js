// Función para cerrar todos los modales abiertos
function closeAllModals() {
    $('.modal').each(function() {
        if ($(this).hasClass('show')) {
            $(this).modal('hide');
        }
    });
}

$(document).ready(function() {
    // Inicializar la tabla de items
    tableGobernanza = $('#tableGobernanza').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": base_url + "/gobernanza/getItems",
            "dataSrc": function(json) {
                if (json.status) {
                    return json.data;
                } else {
                    return [];
                }
            }
        },
        "columns": [
            {"data": "id"},
            {"data": "nombre"},
            {"data": "descripcion"},
            {
                "data": "estado",
                "render": function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success">Activo</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactivo</span>';
                    }
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    var btnView = '';
                    var btnEdit = '';
                    var btnDelete = '';
                    var btnStructure = '';

                    if (data.estado == 1) {
                        btnView = '<button class="btn btn-info btn-sm btnViewGobernanza" onclick="fntViewGobernanza(' + data.id + ')" title="Ver item"><i class="far fa-eye"></i></button>';
                        btnEdit = '<button class="btn btn-primary btn-sm btnEditGobernanza" onclick="fntEditGobernanza(' + data.id + ')" title="Editar item"><i class="fas fa-pencil-alt"></i></button>';
                        btnStructure = '<button class="btn btn-secondary btn-sm btnStructureGobernanza" onclick="fntViewStructure(' + data.id + ')" title="Ver estructura"><i class="fas fa-sitemap"></i></button>';
                    }

                    if (data.estado == 1) {
                        btnDelete = '<button class="btn btn-danger btn-sm btnDelGobernanza" onclick="fntDelGobernanza(' + data.id + ')" title="Eliminar item"><i class="far fa-trash-alt"></i></button>';
                    }

                    return '<div class="text-center">' + btnView + ' ' + btnEdit + ' ' + btnStructure + ' ' + btnDelete + '</div>';
                }
            }
        ],
        "resonsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });

    // Evento para el formulario de items
    $('#formGobernanza').submit(function(e) {
        e.preventDefault();

        var strNombre = $('#txtNombre').val();
        var intEstado = $('#listEstado').val();

        if (strNombre == '' || intEstado == '') {
            swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/gobernanza/setItem';
        var formData = new FormData($('#formGobernanza')[0]);

        request.open("POST", ajaxUrl, true);
        request.send(formData);

        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormGobernanza').modal("hide");
                    $('#formGobernanza')[0].reset();
                    swal("Items de Gobernanza", objData.msg, "success");
                    tableGobernanza.ajax.reload();
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        }
    });

    // Evento para el formulario de indicadores
    $('#formIndicador').submit(function(e) {
        e.preventDefault();

        var intItemId = $('#txtItemIdIndicador').val();
        var strNombre = $('#txtNombreIndicador').val();
        var intEstado = $('#listEstadoIndicador').val();

        if (intItemId == '' || strNombre == '' || intEstado == '') {
            swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/gobernanza/setIndicador';
        var formData = new FormData($('#formIndicador')[0]);

        request.open("POST", ajaxUrl, true);
        request.send(formData);

        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormIndicador').modal("hide");
                    $('#formIndicador')[0].reset();
                    swal("Indicadores de Gobernanza", objData.msg, "success");
                    // Actualizar la estructura si se está mostrando
                    if ($('#modalEstructura').hasClass('show')) {
                        var itemId = $('#txtItemIdIndicador').val();
                        fntViewStructure(itemId);
                    }
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        }
    });

    // Evento para el formulario de archivos
    $('#formArchivo').submit(function(e) {
        e.preventDefault();

        var intIndicadorId = $('#txtIndicadorIdArchivo').val();
        var strTitulo = $('#txtTituloArchivo').val();
        var intEstado = $('#listEstadoArchivo').val();

        if (intIndicadorId == '' || strTitulo == '' || intEstado == '') {
            swal("Atención", "Todos los campos marcados con * son obligatorios.", "error");
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/gobernanza/setArchivo';
        var formData = new FormData($('#formArchivo')[0]);

        request.open("POST", ajaxUrl, true);
        request.send(formData);

        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormArchivo').modal("hide");
                    $('#formArchivo')[0].reset();
                    swal("Archivos de Gobernanza", objData.msg, "success");
                    // Actualizar la estructura si se está mostrando
                    if ($('#modalEstructura').hasClass('show')) {
                        var indicadorId = $('#txtIndicadorIdArchivo').val();
                        var itemId = $('#txtItemIdIndicador').val();
                        fntViewStructure(itemId);
                    }
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        }
    });
});

// Función para ver un item
function fntViewGobernanza(idItem) {
    closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/gobernanza/getItem/' + idItem;

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                var data = objData.data;
                $('#idItem').val(data.id);
                $('#txtNombre').val(data.nombre);
                $('#txtDescripcion').val(data.descripcion);
                $('#txtOrden').val(data.orden);
                $('#listEstado').val(data.estado);

                $('#modalFormGobernanza .modal-title').html('Ver Item');
                $('#btnActionForm').hide();
                $('#formGobernanza').find('input, textarea, select').attr('readonly', true);
                $('#formGobernanza').find('input[type="file"]').attr('disabled', true);
                $('#listEstado').attr('disabled', true);

                $('#modalFormGobernanza').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

// Función para editar un item
function fntEditGobernanza(idItem) {
    closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/gobernanza/getItem/' + idItem;

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                var data = objData.data;
                $('#idItem').val(data.id);
                $('#txtNombre').val(data.nombre);
                $('#txtDescripcion').val(data.descripcion);
                $('#txtOrden').val(data.orden);
                $('#listEstado').val(data.estado);

                $('#modalFormGobernanza .modal-title').html('Actualizar Item');
                $('#btnActionForm').show();
                $('#formGobernanza').find('input, textarea, select').removeAttr('readonly');
                $('#formGobernanza').find('input[type="file"]').removeAttr('disabled');
                $('#listEstado').removeAttr('disabled');

                $('#modalFormGobernanza').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

// Función para eliminar un item
function fntDelGobernanza(idItem) {
    swal({
        title: "Eliminar Item",
        text: "¿Realmente quiere eliminar este item?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/gobernanza/delItem';
            var strData = "idItem=" + idItem;

            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);

            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Eliminar!", objData.msg, "success");
                        tableGobernanza.ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

// Función para abrir el modal de nuevo item
function openModal() {
    closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
    document.querySelector('#idItem').value = "";
    document.querySelector('#modalFormGobernanza .modal-title').innerHTML = "Nuevo Item de Gobernanza";
    document.querySelector('#btnActionForm').className = document.querySelector('#btnActionForm').className.replace("btn-info", "btn-success");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#formGobernanza').reset();
    $('#modalFormGobernanza').modal('show');
}

// Función para ver la estructura jerárquica
function fntViewStructure(idItem) {
    closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/gobernanza/getIndicadoresByItem/' + idItem;

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
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

                    indicadores.forEach((indicador, index) => {
                        htmlEstructura += '<div class="card">';
                        htmlEstructura += '<div class="card-header" id="heading' + indicador.id + '">';
                        htmlEstructura += '<h5 class="mb-0">';
                        htmlEstructura += '<button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' + indicador.id + '" aria-expanded="true" aria-controls="collapse' + indicador.id + '">';
                        htmlEstructura += indicador.nombre;
                        htmlEstructura += '</button>';
                        htmlEstructura += '<div class="float-end">';
                        htmlEstructura += '<button class="btn btn-primary btn-sm" onclick="openModalIndicadorEdit(' + indicador.item_id + ',' + indicador.id + ')" title="Editar indicador"><i class="fas fa-pencil-alt"></i></button>';
                        htmlEstructura += '<button class="btn btn-danger btn-sm ms-1" onclick="fntDelIndicador(' + indicador.id + ')" title="Eliminar indicador"><i class="far fa-trash-alt"></i></button>';
                        htmlEstructura += '<button class="btn btn-info btn-sm ms-1" onclick="fntViewArchivosIndicador(' + indicador.id + ')" title="Ver archivos del indicador"><i class="fas fa-list"></i></button>';
                        htmlEstructura += '<button class="btn btn-success btn-sm ms-1" onclick="openModalArchivo(' + indicador.id + ')" title="Agregar archivo"><i class="fas fa-file-pdf"></i></button>';
                        htmlEstructura += '</div>';
                        htmlEstructura += '</h5>';
                        htmlEstructura += '</div>';

                        htmlEstructura += '<div id="collapse' + indicador.id + '" class="collapse" aria-labelledby="heading' + indicador.id + '" data-parent="#accordionIndicadores">';
                        htmlEstructura += '<div class="card-body">';
                        htmlEstructura += '<p>' + indicador.descripcion + '</p>';

                        // Mostrar un mensaje temporal mientras se cargan los archivos
                        htmlEstructura += '<div id="archivos-indicador-' + indicador.id + '">Cargando archivos...</div>';

                        // Cargar archivos del indicador de forma asíncrona
                        (function(indicadorId) {
                            $.get(base_url + '/gobernanza/getArchivosByIndicador/' + indicadorId, function(response) {
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
                                            archivosHtml += '<td>' + archivo.titulo + '</td>';
                                            archivosHtml += '<td>' + archivo.descripcion + '</td>';
                                            archivosHtml += '<td><a href="' + base_url + '/' + archivo.archivo_ruta + '" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-download"></i> Descargar</a></td>';
                                            archivosHtml += '<td>';
                                            archivosHtml += '<button class="btn btn-primary btn-sm" onclick="openModalArchivoEdit(' + archivo.indicador_id + ',' + archivo.id + ')" title="Editar archivo"><i class="fas fa-pencil-alt"></i></button>';
                                            archivosHtml += ' <button class="btn btn-danger btn-sm" onclick="fntDelArchivo(' + archivo.id + ')" title="Eliminar archivo"><i class="far fa-trash-alt"></i></button>';
                                            archivosHtml += '</td>';
                                            archivosHtml += '</tr>';
                                        });

                                        archivosHtml += '</tbody>';
                                        archivosHtml += '</table>';
                                        archivosHtml += '</div>';
                                    } else {
                                        archivosHtml += '<p class="mt-3"><em>No hay archivos para este indicador.</em></p>';
                                    }
                                } else {
                                    archivosHtml += '<p class="text-danger">Error al cargar archivos.</p>';
                                }

                                // Actualizar el contenido con los archivos
                                document.getElementById('archivos-indicador-' + indicadorId).innerHTML = archivosHtml;
                            }).fail(function() {
                                document.getElementById('archivos-indicador-' + indicadorId).innerHTML = '<p class="text-danger">Error de conexión al cargar archivos.</p>';
                            });
                        })(indicador.id); // Pasar el ID del indicador como parámetro

                        htmlEstructura += '</div>';
                        htmlEstructura += '</div>';
                        htmlEstructura += '</div>';
                    });

                    htmlEstructura += '</div>';
                } else {
                    htmlEstructura += '<p>No hay indicadores para este item.</p>';
                }

                htmlEstructura += '</div>';

                document.getElementById('estructuraGobernanza').innerHTML = htmlEstructura;
                $('#modalEstructura').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

// Función para abrir el modal de nuevo indicador
function openModalIndicador(idItem) {
    closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
    document.querySelector('#idIndicador').value = "";
    document.querySelector('#txtItemIdIndicador').value = idItem;
    document.querySelector('#modalFormIndicador .modal-title').innerHTML = "Nuevo Indicador";
    document.querySelector('#btnActionFormIndicador').className = document.querySelector('#btnActionFormIndicador').className.replace("btn-info", "btn-success");
    document.querySelector('#btnTextIndicador').innerHTML = "Guardar";
    document.querySelector('#formIndicador').reset();
    // Asegurarse de que el campo oculto tenga el valor correcto
    $('#txtItemIdIndicador').val(idItem);
    $('#modalFormIndicador').modal('show');
}

// Función para abrir el modal de edición de indicador
function openModalIndicadorEdit(idItem, idIndicador) {
    closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/gobernanza/getIndicador/' + idIndicador;

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
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

                $('#modalFormIndicador .modal-title').html('Actualizar Indicador');
                $('#btnActionFormIndicador').className = document.querySelector('#btnActionFormIndicador').className.replace("btn-success", "btn-info");
                $('#btnTextIndicador').html('Actualizar');

                $('#modalFormIndicador').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

// Función para eliminar un indicador
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
    }, function(isConfirm) {
        if (isConfirm) {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/gobernanza/delIndicador';
            var strData = "idIndicador=" + idIndicador;

            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);

            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Eliminar!", objData.msg, "success");
                        // Actualizar la estructura si se está mostrando
                        var itemId = $('#txtItemIdIndicador').val();
                        if ($('#modalEstructura').hasClass('show')) {
                            fntViewStructure(itemId);
                        }
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

// Función para abrir el modal de nuevo archivo
function openModalArchivo(idIndicador) {
    closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
    document.querySelector('#idArchivo').value = "";
    document.querySelector('#txtIndicadorIdArchivo').value = idIndicador;
    document.querySelector('#modalFormArchivo .modal-title').innerHTML = "Nuevo Archivo";
    document.querySelector('#btnActionFormArchivo').className = document.querySelector('#btnActionFormArchivo').className.replace("btn-info", "btn-success");
    document.querySelector('#btnTextArchivo').innerHTML = "Guardar";
    document.querySelector('#formArchivo').reset();
    $('#modalFormArchivo').modal('show');
}

// Función para abrir el modal de edición de archivo
function openModalArchivoEdit(idIndicador, idArchivo) {
    closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/gobernanza/getArchivo/' + idArchivo;

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
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

                $('#modalFormArchivo .modal-title').html('Actualizar Archivo');
                $('#btnActionFormArchivo').className = document.querySelector('#btnActionFormArchivo').className.replace("btn-success", "btn-info");
                $('#btnTextArchivo').html('Actualizar');

                $('#modalFormArchivo').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

// Función para eliminar un archivo
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
    }, function(isConfirm) {
        if (isConfirm) {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/gobernanza/delArchivo';
            var strData = "idArchivo=" + idArchivo;

            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);

            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Eliminar!", objData.msg, "success");
                        // Actualizar la estructura si se está mostrando
                        var indicadorId = $('#txtIndicadorIdArchivo').val();
                        var itemId = $('#txtItemIdIndicador').val();
                        if ($('#modalEstructura').hasClass('show')) {
                            fntViewStructure(itemId);
                        }
                        // Actualizar la tabla de archivos si se está mostrando
                        if ($('#modalArchivosIndicador').hasClass('show')) {
                            var currentIndicadorId = $('#modalArchivosIndicador').data('indicador-id');
                            fntViewArchivosIndicador(currentIndicadorId);
                        }
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            }
        }
    });
}

// Función para ver los archivos de un indicador específico
function fntViewArchivosIndicador(idIndicador) {
    closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/gobernanza/getArchivosByIndicador/' + idIndicador;

    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                var archivos = objData.data;
                var cuerpoTabla = document.getElementById('cuerpoTablaArchivos');
                var tituloIndicador = document.getElementById('tituloIndicador');
                
                // Obtener el nombre del indicador
                var indicadorRequest = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var indicadorAjaxUrl = base_url + '/gobernanza/getIndicador/' + idIndicador;
                
                indicadorRequest.open("GET", indicadorAjaxUrl, false); // Solicitud síncrona para obtener el nombre
                indicadorRequest.send();
                
                if (indicadorRequest.status == 200) {
                    var indicadorData = JSON.parse(indicadorRequest.responseText);
                    if (indicadorData.status) {
                        tituloIndicador.innerHTML = 'Archivos del Indicador: ' + indicadorData.data.nombre;
                    }
                }
                
                // Guardar el ID del indicador en el modal para futuras referencias
                $('#modalArchivosIndicador').data('indicador-id', idIndicador);
                
                // Limpiar la tabla
                cuerpoTabla.innerHTML = '';
                
                if (archivos.length > 0) {
                    archivos.forEach(archivo => {
                        var fila = document.createElement('tr');
                        
                        var estadoTexto = archivo.estado == 1 ? 'Activo' : 'Inactivo';
                        
                        fila.innerHTML = `
                            <td>${archivo.id}</td>
                            <td>${archivo.titulo}</td>
                            <td>${archivo.descripcion}</td>
                            <td><a href="${base_url}/${archivo.archivo_ruta}" target="_blank">${archivo.archivo_ruta.split('/').pop()}</a></td>
                            <td>${estadoTexto}</td>
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
    }
}

// Función para abrir el modal de nuevo archivo asociado a un indicador específico
function openModalArchivoPorIndicador() {
    var indicadorId = $('#modalArchivosIndicador').data('indicador-id');
    if (indicadorId) {
        closeAllModals(); // Cerrar todos los modales antes de abrir uno nuevo
        document.querySelector('#idArchivo').value = "";
        document.querySelector('#txtIndicadorIdArchivo').value = indicadorId;
        document.querySelector('#modalFormArchivo .modal-title').innerHTML = "Nuevo Archivo";
        document.querySelector('#btnActionFormArchivo').className = document.querySelector('#btnActionFormArchivo').className.replace("btn-info", "btn-success");
        document.querySelector('#btnTextArchivo').innerHTML = "Guardar";
        document.querySelector('#formArchivo').reset();
        $('#modalFormArchivo').modal('show');
    } else {
        swal("Error", "No se ha especificado un indicador válido.", "error");
    }
}