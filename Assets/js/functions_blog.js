var table;
var divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener("DOMContentLoaded", function () {
  loadTable();
  setTimeout(() => {
    openModalSave();
    openModalEdit();
    OpenModalEditImg();
    OpenModalEditEmbed();
    delet();
    save();
    updat();
    updateFile();
    updatEmbed();
    updateEstadoAviso();
    actualizarContenido();
    cargarEmbedEdit();
    divLoading.style.display = "none";
  }, 1000);
});
document.addEventListener("click", () => {
  openModalSave();
  openModalEdit();
  OpenModalEditImg();
  OpenModalEditEmbed();
  delet();
  actualizarContenido();
  cargarEmbedEdit();
  updateEstadoAviso();
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
      url: " " + base_url + "/Blog/getBlog/" + idCategoria,
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "b_Titulo" },
      { data: "b_subTitulo" },
      { data: "b_Contenido" },
      { data: "link" },
      { data: "publicador" },
      { data: "b_fechaRegistro" },
      { data: "b_fechaUpdate" },
      { data: "b_Estado" },
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
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    columnDefs: [
      {
        class: "col-1 text-center",
        targets: 0,
      },
      {
        class: "col-1",
        targets: 1,
      },
      {
        class: "col-1 text-center",
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
      {
        class: "col-2 text-center",
        targets: 6,
      },
      {
        class: "col-1 text-center",
        targets: 7,
      },
      {
        class: "col-1 text-center",
        targets: 8,
      },
      {
        class: "col-2 text-center",
        targets: 9,
      },
    ],
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
        document.querySelector("#editTitulo").value = element.getAttribute("data-titulo");
        document.querySelector("#editSubtitulo").value = element.getAttribute("data-subtitulo");
        document.querySelector("#editContenido").value = element.getAttribute("data-contenido");
        $("#modalEdit").modal("show")
      })
    });
  }
}
function OpenModalEditImg() {
  if (document.querySelector(".btnEditImg")) {
    const btnEditImg = document.querySelectorAll(".btnEditImg")
    btnEditImg.forEach(element => {
      element.addEventListener("click", () => {
        document.querySelector("#id_updImg").value = element.getAttribute("data-id");
        document.querySelector("#editDescImg").value = element.getAttribute("data-descripcionI");
        document.querySelector("#photoOld_updFil").value = element.getAttribute("data-imagen");
        document.querySelector("#photo_file").src = base_url + "/Assets/upload/images/" + element.getAttribute("data-imagen");
        $("#modalEditImg").modal("show")
      })
    });
  }
}
function OpenModalEditEmbed() {
  if (document.querySelector(".btnEditEmbed")) {
    const btnEditEmbed = document.querySelectorAll(".btnEditEmbed")
    btnEditEmbed.forEach(element => {
      element.addEventListener("click", () => {
        document.querySelector("#id_updEmbed").value = element.getAttribute("data-id");
        document.querySelector("#embedLinky").value = element.getAttribute("data-enlace");
        $("#modalEditEmbed").modal("show")
      })
    });
  }
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
      let url = base_url + "/Blog/saveBlog";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formSave.reset();
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
      let nombre = element.getAttribute("data-titulo");
      let id = element.getAttribute("data-id");
      let file = element.getAttribute("data-Img");
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
            data.append("file", file);
            let encabezados = new Headers();
            let config = {
              method: "POST",
              headers: encabezados,
              mode: "cors",
              cache: "no-cache",
              body: data,
            };
            let url = base_url + "/Blog/deleteBlog";
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
      let titulo = element.getAttribute("data-titulo");
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
            let url = base_url + "/Blog/estadoBlog";
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
      let url = base_url + "/Blog/editarInfoBlog";
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
function updateFile() {
  if (document.querySelector("#formUpdateImg")) {
    formUpdateImg = document.querySelector("#formUpdateImg");
    formUpdateImg.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formUpdateImg);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Blog/editarImgBlog";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateImg.reset();
              divLoading.style.display = "none";
              $("#modalEditImg").modal("hide");
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
  if (document.querySelector("#formUpdateEmbed")) {
    formUpdateEmbed = document.querySelector("#formUpdateEmbed");
    formUpdateEmbed.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formUpdateEmbed);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Blog/editarEmbedBlog";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateEmbed.reset();
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
function cargarEmbedEdit() {
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
    document.querySelector("#link").value = embedContenidoIframes.src
  });
  embedContenidoIframes.onload = function () {
    previsualizacionMensajes.style.display = "none";
    embedContenidoIframes.style.display = "block";
  };
}
function loadIcon() {
  let img = document.querySelector("#photo_file");
  let input = document.querySelector("#editImg");
  input.addEventListener("change", (e) => {
    if (input.files[0]) {
      img.src = URL.createObjectURL(input.files[0]);
    }
  });
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