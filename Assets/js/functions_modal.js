var table;
var divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener("DOMContentLoaded", function () {
  loadTable();
  setTimeout(() => {
    openModalSave();
    openModalEdit();
    embedEdit();
    sizeEdit();
    fechaEdit()
    validarFormularioEditar();
    configuracionFormularioModal();
    //editarConfigFecha();
    actualizarContenido();
    agregarInput();
    borrarUltimoInput();
    save();
    delet();
    updateEstadoAviso();
    updat();
    updatEmbed();
    updateSize();
    updateFecha();
    imagenEdit();
    updateImagen();
    divLoading.style.display = "none";
  }, 1000);
});
document.addEventListener("click", () => {
  updateEstadoAviso();
  delet();
  openModalEdit();
  embedEdit();
  sizeEdit();
  fechaEdit();
  imagenEdit();
});

function loadTable() {
  table = $("#table").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla =(",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
      buttons: {
        copy: "Copiar",
        colvis: "Visibilidad",
      },
    },
    ajax: {
      url: " " + base_url + "/Modal/getAvisos/",
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "a_Titulo" },
      { data: "a_Descripcion" },
      { data: "a_fechaInicio" },
      { data: "a_fechaFin" },
      { data: "acciones" },
    ],
    dom: "lBfrtip",
    buttons: [
      {
        extend: "copyHtml5",
        text: "<i class='far fa-copy'></i> Copiar",
        titleAttr: "Copiar",
        className: "btn btn-secondary",
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Esportar a Excel",
        className: "btn btn-success",
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fas fa-file-pdf'></i> PDF",
        titleAttr: "Esportar a PDF",
        className: "btn btn-danger",
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "Esportar a CSV",
        className: "btn btn-info",
      },
    ],
    resonsive: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    columnDefs: [
      {
        class: "col-1 text-center",
        targets: 0,
      },
      {
        class: "col-3",
        targets: 1,
      },
      {
        class: "col-4 text-justify",
        targets: 2,
      },
      {
        class: "col-1 text-center",
        targets: 3,
      },
      {
        class: "col-1 text-center",
        targets: 4,
      },
      {
        class: "col-2 text-center",
        targets: 5,
      },
    ],
  });
}
function save() {
  if (document.querySelector("#formSave")) {
    formSave = document.querySelector("#formSave");
    formSave.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formSave);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Modal/saveModal";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formSave.reset();
              // Limpiar preview imagen
              var prev = document.getElementById("previewImagenAviso");
              var imgPrev = document.getElementById("imgPreviewAviso");
              if (prev) prev.style.display = "none";
              if (imgPrev) imgPrev.src = "";
              divLoading.style.display = "none";
              $("#modalSave").modal("hide");
              table.api().ajax.reload();
            } else {
              divLoading.style.display = "none";
              swal("Ocurrio un error inesperado", response.msg, "error");
            }
          });
      } catch (error) {
        divLoading.style.display = "none";
        console.error(error);
      }
    });
  }
}
function delet() {
  const arrbtnDelRol = document.querySelectorAll(".btnDel");
  arrbtnDelRol.forEach((element) => {
    element.addEventListener("click", () => {
      let nombre = element.getAttribute("data-nombre");
      let id = element.getAttribute("data-id");
      swal(
        {
          title: "¿Estas seguro?",
          text: "Esta seguro de eliminar " + nombre,
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Si, eliminar!",
          cancelButtonText: "No, cancelar!",
          closeOnConfirm: false,
          closeOnCancel: true,
        },
        function (isConfirm) {
          if (isConfirm) {
            let data = new FormData();
            data.append("id", id);
            let encabezados = new Headers();
            let config = {
              method: "POST",
              headers: encabezados,
              mode: "cors",
              cache: "no-cache",
              body: data,
            };
            let url = base_url + "/Modal/deleteModal";
            try {
              divLoading.style.display = "flex";
              fetch(url, config)
                .then((response) => response.json())
                .then((response) => {
                  if (response.status) {
                    swal("Satisfactorio", response.msg, "success");
                    divLoading.style.display = "none";
                    table.api().ajax.reload();
                  } else {
                    divLoading.style.display = "none";
                    swal("Ocurrio un error inesperado", response.msg, "error");
                  }
                });
            } catch (error) {
              console.error(error);
            }
          }
        }
      );
    });
  });
}
function updateEstadoAviso() {
  const btnEstadoFooter = document.querySelectorAll(".btnEstatus");
  btnEstadoFooter.forEach((element) => {
    element.addEventListener("click", () => {
      let titulo = element.getAttribute("data-nombre");
      let id = element.getAttribute("data-id");
      let estado = element.getAttribute("data-estado");
      swal(
        {
          title: "¿Estas seguro?",
          text: "Desea cambiar el estado del aviso: " + titulo,
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Si, cambiar!",
          cancelButtonText: "No, cancelar!",
          closeOnConfirm: false,
          closeOnCancel: true,
        },
        function (isConfirm) {
          if (isConfirm) {
            let data = new FormData();
            data.append("id", id);
            data.append("estado", estado);
            let encabezados = new Headers();
            let config = {
              method: "POST",
              headers: encabezados,
              mode: "cors",
              cache: "no-cache",
              body: data,
            };
            let url = base_url + "/Modal/estadoAviso";
            try {
              divLoading.style.display = "flex";
              fetch(url, config)
                .then((response) => response.json())
                .then((response) => {
                  if (response.status) {
                    swal("Satisfactorio", response.msg, "success");
                    divLoading.style.display = "none";
                    table.api().ajax.reload();
                  } else {
                    divLoading.style.display = "none";
                    swal("Ocurrio un error inesperado", response.msg, "error");
                  }
                });
            } catch (error) {
              console.error(error);
            }
          }
        }
      );
    });
  });
}
function openModalSave() {
  if (document.querySelector(".openmodal")) {
    const openmodal = document.querySelector(".openmodal");
    openmodal.addEventListener("click", () => {
      $("#modalSave").modal("show");
    });
  }
}

function openModalEdit() {
  if (document.querySelector(".btnEdit")) {
    const btnEdit = document.querySelectorAll(".btnEdit")
    btnEdit.forEach(element => {
      element.addEventListener("click", () => {
        document.querySelector("#id_upd").value = element.getAttribute("data-id");
        document.querySelector("#tituloEditModal").value = element.getAttribute("data-titulo");
        document.querySelector("#txtDescripcion_upd").value = element.getAttribute("data-description");
        $("#modalEdit").modal("show")
      })
    });
  }
}
function embedEdit(){
  if (document.querySelector(".btnEditEmbed")) {
    const btnEditEmbed = document.querySelectorAll(".btnEditEmbed")
    btnEditEmbed.forEach(element =>{
      element.addEventListener("click", () => {
        document.querySelector("#id_upde").value = element.getAttribute("data-id");
        document.querySelector("#embedLinky").value = element.getAttribute("data-incrustacion");
        $("#modalEditEmbed").modal("show")
      })
    });
  }
}
function sizeEdit(){
  if (document.querySelector(".btnEditConfig")){
    const btnEditConfig = document.querySelectorAll(".btnEditConfig")
    btnEditConfig.forEach(element =>{
      element.addEventListener("click", () => {
        document.querySelector("#id_upds").value = element.getAttribute("data-id");
        document.querySelector("#tamAvi").value = element.getAttribute("data-sizeA");
        document.querySelector("#modalEstatic").checked = element.getAttribute("data-estatic") === "static"
        document.querySelector("#modalEscrol").checked = element.getAttribute("data-escrol") === "modal-dialog-scrollable";
      $("#modalEditSize").modal("show")
      })
    });
  }
}
function fechaEdit(){
  if (document.querySelector(".btnEditFecha")){
    const btnEditFecha = document.querySelectorAll(".btnEditFecha")
    btnEditFecha.forEach(element =>{
      element.addEventListener("click", () => {
        document.querySelector("#id_updfh").value = element.getAttribute("data-id");
        document.querySelector("#fechaIni").value = element.getAttribute("data-fechaIni");
        document.querySelector("#fechaEnd").value = element.getAttribute("data-fechaFinn"); 
      $("#modalEditFecha").modal("show")
      })
    });
  }
}

function updat() {
  if (document.querySelector("#formUpdate")) {
    formUpdate = document.querySelector("#formUpdate");
    formUpdate.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formUpdate);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Modal/updateInfo";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdate.reset();
              divLoading.style.display = "none";
              $("#modalEdit").modal("hide");
              table.api().ajax.reload();
            } else {
              divLoading.style.display = "none";
              swal("Ocurrio un error inesperado", response.msg, "error");
            }
          });
      } catch (error) {
        console.error(error);
      }
    });
  }
}
function updatEmbed() {
  if (document.querySelector("#formUpdateEmed")) {
    formUpdateEmed = document.querySelector("#formUpdateEmed");
    formUpdateEmed.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formUpdateEmed);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Modal/updateEmbed";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateEmed.reset();
              divLoading.style.display = "none";
              $("#modalEditEmbed").modal("hide");
              table.api().ajax.reload();
            } else {
              divLoading.style.display = "none";
              swal("Ocurrio un error inesperado", response.msg, "error");
            }
          });
      } catch (error) {
        console.error(error);
      }
    });
  }
}
function updateSize() {
  if (document.querySelector("#formupdateSize")) {
    formupdateSize = document.querySelector("#formupdateSize");
    formupdateSize.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formupdateSize);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Modal/updateSize";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formupdateSize.reset();
              divLoading.style.display = "none";
              $("#modalEditSize").modal("hide");
              table.api().ajax.reload();
            } else {
              divLoading.style.display = "none";
              swal("Ocurrio un error inesperado", response.msg, "error");
            }
          });
      } catch (error) {
        console.error(error);
      }
    });
  }
}
function updateFecha() {
  if (document.querySelector("#formUpdateFecha")) {
    formUpdateFecha = document.querySelector("#formUpdateFecha");
    formUpdateFecha.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formUpdateFecha);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Modal/updateFecha";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateFecha.reset();
              divLoading.style.display = "none";
              $("#modalEditFecha").modal("hide");
              table.api().ajax.reload();
            } else {
              divLoading.style.display = "none";
              swal("Ocurrio un error inesperado", response.msg, "error");
            }
          });
      } catch (error) {
        console.error(error);
      }
    });
  }
}

function configuracionFormularioModal() {
  // Script para habilitar/deshabilitar campos de fecha y mostrar SweetAlert
  document
    .getElementById("activarFechas")
    .addEventListener("change", function () {
      var fechaInicio = document.getElementById("fechaInicio");
      var fechaFin = document.getElementById("fechaFin");

      if (this.checked) {
        fechaInicio.removeAttribute("disabled");
        fechaFin.removeAttribute("disabled");

        // Agregar transición suave a los campos de fecha
        fechaInicio.classList.add("transition-opacity");
        fechaFin.classList.add("transition-opacity");

        // Mostrar SweetAlert
        swal({
          title: "Fechas Activadas",
          text: "Puedes ingresar valores en los campos de fecha.",
          type: "success",
          confirmButtonText: "Aceptar",
        });
      } else {
        fechaInicio.setAttribute("disabled", true);
        fechaFin.setAttribute("disabled", true);

        // Remover la transición suave al deshabilitar los campos de fecha
        fechaInicio.classList.remove("transition-opacity");
        fechaFin.classList.remove("transition-opacity");
      }
    });

  // Verificar que la fecha de fin no sea anterior a la fecha de inicio
  document
    .getElementById("fechaInicio")
    .addEventListener("change", function () {
      var fechaInicio = new Date(this.value);
      var fechaFin = new Date(document.getElementById("fechaFin").value);

      if (fechaInicio > fechaFin) {
        // Mostrar mensaje de error
        swal({
          title: "Error",
          text: "La fecha de inicio no puede ser posterior a la fecha de fin.",
          type: "error",
          confirmButtonText: "Aceptar",
        });

        // Restablecer el valor de la fecha de inicio
        this.value = "";
      }
    });

  // Verificar que la hora de fin no sea anterior a la hora de inicio
  document.getElementById("fechaFin").addEventListener("change", function () {
    var fechaInicio = new Date(document.getElementById("fechaInicio").value);
    var fechaFin = new Date(this.value);

    if (fechaInicio > fechaFin) {
      // Mostrar mensaje de error
      swal({
        title: "Error",
        text: "La hora de fin no puede ser anterior a la hora de inicio.",
        type: "error",
        confirmButtonText: "Aceptar",
      });

      // Restablecer el valor de la fecha de fin
      this.value = "";
    }
  });

  // Actualizar la fecha de fin mínima cuando se cambia la fecha de inicio
  document.getElementById("fechaFin").addEventListener("focus", function () {
    var fechaInicio = new Date(document.getElementById("fechaInicio").value);
    // Establecer la fecha de fin mínima 1 hora después de la fecha de inicio
    this.setAttribute(
      "min",
      new Date(fechaInicio.getTime() + 60 * 60 * 1000)
        .toISOString()
        .slice(0, -8)
    );
  });
}
/*function editarConfigFecha(){
    // Script para habilitar/deshabilitar campos de fecha y mostrar SweetAlert
    document
      .getElementById("activFechas")
      .addEventListener("change", function () {
        var fechaInicio = document.getElementById("fechaIni");
        var fechaFin = document.getElementById("fechaEnd");
  
        if (this.checked) {
          fechaInicio.removeAttribute("disabled");
          fechaFin.removeAttribute("disabled");
  
          // Agregar transición suave a los campos de fecha
          fechaInicio.classList.add("transition-opacity");
          fechaFin.classList.add("transition-opacity");
  
          // Mostrar SweetAlert
          swal({
            title: "Fechas Activadas",
            text: "Puedes ingresar valores en los campos de fecha.",
            type: "success",
            confirmButtonText: "Aceptar",
          });
        } else {
          fechaInicio.setAttribute("disabled", true);
          fechaFin.setAttribute("disabled", true);
  
          // Remover la transición suave al deshabilitar los campos de fecha
          fechaInicio.classList.remove("transition-opacity");
          fechaFin.classList.remove("transition-opacity");
        }
      });
  
    // Verificar que la fecha de fin no sea anterior a la fecha de inicio
    document
      .getElementById("fechaIni")
      .addEventListener("change", function () {
        var fechaInicio = new Date(this.value);
        var fechaFin = new Date(document.getElementById("fechaEnd").value);
  
        if (fechaInicio > fechaFin) {
          // Mostrar mensaje de error
          swal({
            title: "Error",
            text: "La fecha de inicio no puede ser posterior a la fecha de fin.",
            type: "error",
            confirmButtonText: "Aceptar",
          });
  
          // Restablecer el valor de la fecha de inicio
          this.value = "";
        }
      });
  
    // Verificar que la hora de fin no sea anterior a la hora de inicio
    document.getElementById("fechaEnd").addEventListener("change", function () {
      var fechaInicio = new Date(document.getElementById("fechaIni").value);
      var fechaFin = new Date(this.value);
  
      if (fechaInicio > fechaFin) {
        // Mostrar mensaje de error
        swal({
          title: "Error",
          text: "La hora de fin no puede ser anterior a la hora de inicio.",
          type: "error",
          confirmButtonText: "Aceptar",
        });
  
        // Restablecer el valor de la fecha de fin
        this.value = "";
      }
    });
  
    // Actualizar la fecha de fin mínima cuando se cambia la fecha de inicio
    document.getElementById("fechaEnd").addEventListener("focus", function () {
      var fechaInicio = new Date(document.getElementById("fechaIni").value);
      // Establecer la fecha de fin mínima 1 hora después de la fecha de inicio
      this.setAttribute(
        "min",
        new Date(fechaInicio.getTime() + 60 * 60 * 1000)
          .toISOString()
          .slice(0, -8)
      );
    });
}*/
function actualizarContenido() {
  var embedLinkInput = document.getElementById("embedLink");
  var embedContenidoIframe = document.getElementById("embedContenido");

  embedLinkInput.addEventListener("input", function () {
    var embedLinkValue = embedLinkInput.value;
    previsualizacionMensaje.style.display = "block";
    embedContenidoIframe.style.display = "none";
    // Actualizar el src del iframe dependiendo del tipo de contenido
    // Actualizar el src del iframe dependiendo del tipo de contenido
    if (esEnlaceYouTube(embedLinkValue)) {
      // Enlace de YouTube
      embedContenidoIframe.src = obtenerEnlaceIncrustadoYouTube(embedLinkValue);
    } /*else if (embedLinkValue.includes(".pdf")) {
      // Archivo PDF
      embedContenidoIframe.src =
        "https://docs.google.com/viewer?url=" + embedLinkValue;
    } */ else {
      // Otro tipo de contenido (por ejemplo, imágenes)
      embedContenidoIframe.src = embedLinkValue;
    }
    document.querySelector("#urls").value = embedContenidoIframe.src
  });
  embedContenidoIframe.onload = function () {
    previsualizacionMensaje.style.display = "none";
    embedContenidoIframe.style.display = "block";
  };
}
// Función para verificar si es un enlace de YouTube
function validarFormularioEditar() {
  var embedLinkInput = document.getElementById("embedLinky");
  var embedContenidoIframes = document.getElementById("embedContenidoo");

  embedLinkInput.addEventListener("input", function () {
    var embedLinkValue = embedLinkInput.value;
    previsualizacionMensajes.style.display = "block";
    embedContenidoIframes.style.display = "none";
    // Actualizar el src del iframe dependiendo del tipo de contenido
    if (esEnlaceYouTube(embedLinkValue)) {
      // Enlace de YouTube
      embedContenidoIframes.src = obtenerEnlaceIncrustadoYouTube(embedLinkValue);
    } /*else if (embedLinkValue.includes(".pdf")) {
      // Archivo PDF
      embedContenidoIframes.src =
        "https://docs.google.com/viewer?url=" + embedLinkValue;
    } */ else {
      // Otro tipo de contenido (por ejemplo, imágenes)
      embedContenidoIframes.src = embedLinkValue;
    }
    document.querySelector("#url").value = embedContenidoIframes.src
  });
  embedContenidoIframes.onload = function () {
    previsualizacionMensajes.style.display = "none";
    embedContenidoIframes.style.display = "block";
  };
}

function esEnlaceYouTube(enlace) {
  // Patrones de enlaces de YouTube admitidos
  var patronesYouTube = [
    /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/,
    // Otros patrones según formatos de enlaces de YouTube
  ];

  // Comprobar si el enlace coincide con alguno de los patrones
  return patronesYouTube.some(function (pat) {
    return pat.test(enlace);
  });
}
// Función para obtener el enlace incrustado de YouTube
function obtenerEnlaceIncrustadoYouTube(enlace) {
  var codigo = "";
  // Intentar extraer el código del video de YouTube desde el enlace
  var patronesYouTube = [
    /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/,
    // Otros patrones según formatos de enlaces de YouTube
  ];

  patronesYouTube.some(function (pat) {
    var coincidencia = enlace.match(pat);
    if (coincidencia && coincidencia[1]) {
      codigo = coincidencia[1];
      return true;
    }
    return false;
  });

  return "https://www.youtube.com/embed/" + codigo;
}
// Contador para numerar los inputs
var contadorInputs = 1;
// Función para agregar un nuevo input dinámicamente

function agregarInput() {
  document.querySelector("#addInput").addEventListener("click", () => {
    var dynamicInputsContainer = document.getElementById("dynamicInputs");

    // Crear una nueva etiqueta (label)
    var nuevoLabel = document.createElement("label");
    nuevoLabel.innerText = "Enlace " + contadorInputs + ":";

    // Crear un nuevo input
    var nuevoInput = document.createElement("input");
    nuevoInput.type = "text";
    nuevoInput.className = "form-control mt-2";
    nuevoInput.placeholder = "Nuevo Enlace";
    nuevoInput.name = "Enlace" + contadorInputs;
    nuevoInput.id = "Enlace" + contadorInputs;

    // Agregar el label y el nuevo input al contenedor
    dynamicInputsContainer.appendChild(nuevoLabel);
    dynamicInputsContainer.appendChild(nuevoInput);

    // Incrementar el contador
    contadorInputs++;
  });
}
// Función para borrar el último input agregado
function borrarUltimoInput() {
  document.querySelector("#removeInput").addEventListener("click", () => {
    var dynamicInputsContainer = document.getElementById("dynamicInputs");
    var elementos = dynamicInputsContainer.children;

    // Verificar si hay algún elemento para borrar
    if (elementos.length > 0) {
      // Borrar los últimos dos elementos (label e input)
      dynamicInputsContainer.removeChild(elementos[elementos.length - 1]);
      dynamicInputsContainer.removeChild(elementos[elementos.length - 1]);

      // Decrementar el contador
      contadorInputs--;
    }
  });
}

// ——— Previsualización de imagen del aviso (crear) ———
document.addEventListener("DOMContentLoaded", function () {
  var inputImagen = document.getElementById("imagenAviso");
  if (inputImagen) {
    inputImagen.addEventListener("change", function () {
      var file = this.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById("imgPreviewAviso").src = e.target.result;
          document.getElementById("previewImagenAviso").style.display = "block";
        };
        reader.readAsDataURL(file);
      } else {
        document.getElementById("previewImagenAviso").style.display = "none";
        document.getElementById("imgPreviewAviso").src = "";
      }
    });
  }
  // Previsualización de imagen (editar)
  var inputImagenEdit = document.getElementById("imagenAvisoEdit");
  if (inputImagenEdit) {
    inputImagenEdit.addEventListener("change", function () {
      var file = this.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById("imgPreviewAvisoEdit").src = e.target.result;
          document.getElementById("previewImagenAvisoEdit").style.display = "block";
        };
        reader.readAsDataURL(file);
      } else {
        document.getElementById("previewImagenAvisoEdit").style.display = "none";
        document.getElementById("imgPreviewAvisoEdit").src = "";
      }
    });
  }
});

// Abre el modal de edición de imagen
function imagenEdit() {
  if (document.querySelector(".btnEditImagen")) {
    const btns = document.querySelectorAll(".btnEditImagen");
    btns.forEach(function(element) {
      element.addEventListener("click", function() {
        document.querySelector("#id_updimg").value = element.getAttribute("data-id");
        document.getElementById("previewImagenAvisoEdit").style.display = "none";
        document.getElementById("imgPreviewAvisoEdit").src = "";
        $("#modalEditImagen").modal("show");
      });
    });
  }
}

// Envía el formulario de edición de imagen
function updateImagen() {
  if (document.querySelector("#formUpdateImagen")) {
    var formUpdateImagen = document.querySelector("#formUpdateImagen");
    formUpdateImagen.addEventListener("submit", function(e) {
      e.preventDefault();
      var data = new FormData(formUpdateImagen);
      var url = base_url + "/Modal/updateImagen";
      try {
        divLoading.style.display = "flex";
        fetch(url, { method: "POST", body: data })
          .then(function(response) { return response.json(); })
          .then(function(response) {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateImagen.reset();
              document.getElementById("previewImagenAvisoEdit").style.display = "none";
              document.getElementById("imgPreviewAvisoEdit").src = "";
              divLoading.style.display = "none";
              $("#modalEditImagen").modal("hide");
              table.api().ajax.reload();
            } else {
              divLoading.style.display = "none";
              swal("Error", response.msg, "error");
            }
          });
      } catch (error) {
        divLoading.style.display = "none";
        console.error(error);
      }
    });
  }
}
