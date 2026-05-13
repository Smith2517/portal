var table;
var divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener("DOMContentLoaded", function () {
  loadTable();
  setTimeout(() => {
    openModalSave();
    openModalEdit();
    openModalFileEdit();
    loadImage();
    activeSectionTexto();
    activeSectionTextoEdit();
    activeSectionBtn();
    activeSectionBtnEdit();
    updateEstado();
    save();
    delet();
    updateInfo();
    updateFile();
    loadIcon();
    divLoading.style.display = "none";
  }, 1000);
});
document.addEventListener("click", () => {
  delet();
  openModalEdit();
  openModalFileEdit();
  activeSectionTextoEdit();
  activeSectionBtnEdit();
  updateEstado();
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
      url: " " + base_url + "/Carousel/getCarousel",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "c_titulo" },
      { data: "c_descripcion" },
      { data: "c_estado" },
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
        class: "col-2",
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
        class: "col-3 text-center",
        targets: 4,
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
  const arrbtnEdit = document.querySelectorAll(".btnEdit");
  arrbtnEdit.forEach((element) => {
    element.addEventListener("click", () => {
      let sectionTextoSaveEdit = document.querySelector(
        "#sectionTextoSaveEdit"
      );
      let sectionBtnSaveEdit = document.querySelector("#sectionBtnSaveEdit");
      document.querySelector("#idCarousel").value =
        element.getAttribute("data-id");
      document.querySelector("#chbxConetenidoEdit").checked =
        element.getAttribute("data-estadoContent") == 1 ? true : false;
      if (element.getAttribute("data-estadoContent") == 1) {
        sectionTextoSaveEdit.classList.remove("d-none");
      } else {
        sectionTextoSaveEdit.classList.add("d-none");
      }
      document.querySelector("#chbxBtnEdit").checked =
        element.getAttribute("data-estadoBtn") == 1 ? true : false;
      if (element.getAttribute("data-estadoBtn") == 1) {
        sectionBtnSaveEdit.classList.remove("d-none");
      } else {
        sectionBtnSaveEdit.classList.add("d-none");
      }
      document.querySelector("#txtTituloEdit").value =
        element.getAttribute("data-titulo");
      document.querySelector("#txtDescripcionEdit").value =
        element.getAttribute("data-descripcion");
      document.querySelector("#txtBtnEdit").value =
        element.getAttribute("data-nameBtn");
      document.querySelector("#txtUrlBtnEdit").value =
        element.getAttribute("data-linkBtn");
      document.querySelector("#clrTituloEdit").value =
        element.getAttribute("data-colorTitulo");
      document.querySelector("#clrDescripcionEdit").value =
        element.getAttribute("data-colorDescripcion");
      document.querySelector("#clrBtnEdit").value =
        element.getAttribute("data-colorBtn");
      $("#modalEdit").modal("show");
    });
  });
}
function openModalFileEdit() {
  const arrbtnEditPhoto = document.querySelectorAll(".btnEditFile");
  arrbtnEditPhoto.forEach((element) => {
    element.addEventListener("click", () => {
      document.querySelector("#ip_updFil").value =
        element.getAttribute("data-id");
      document.querySelector("#photoOld_updFil").value =
        element.getAttribute("data-image");
      document.querySelector("#photo_file").src =
        base_url +
        "/Assets/upload/images/" +
        element.getAttribute("data-image");
      $("#modalEditFile").modal("show");
    });
  });
}
function loadImage() {
  let img = document.querySelector("#file_carousel");
  let input = document.querySelector("#flArchivo");
  input.addEventListener("change", (e) => {
    if (input.files[0]) {
      img.src = URL.createObjectURL(input.files[0]);
      img.onload = () => {
        var ancho = img.width;
        var alto = img.height;
      };
    }
  });
}
function activeSectionTexto() {
  let chcbxTexto = document.querySelector("#chcbxTexto");
  let sectionTextoSave = document.querySelector("#sectionTextoSave");
  let sectionBtnSave = document.querySelector("#sectionBtnSave");
  let chbxBtn = document.querySelector("#chbxBtn");

  chcbxTexto.addEventListener("change", () => {
    if (chcbxTexto.checked) {
      sectionTextoSave.classList.remove("d-none");
    } else {
      sectionTextoSave.classList.add("d-none");
      sectionBtnSave.classList.add("d-none");
      chbxBtn.checked = false;
    }
  });
}
function activeSectionTextoEdit() {
  let chbxConetenidoEdit = document.querySelector("#chbxConetenidoEdit");
  let sectionTextoSaveEdit = document.querySelector("#sectionTextoSaveEdit");
  let sectionBtnSaveEdit = document.querySelector("#sectionBtnSaveEdit");
  let chbxBtnEdit = document.querySelector("#chbxBtnEdit");

  chbxConetenidoEdit.addEventListener("change", () => {
    if (chbxConetenidoEdit.checked) {
      sectionTextoSaveEdit.classList.remove("d-none");
    } else {
      sectionTextoSaveEdit.classList.add("d-none");
      sectionBtnSaveEdit.classList.add("d-none");
      chbxBtnEdit.checked = false;
    }
  });
}
function activeSectionBtn() {
  let chbxBtn = document.querySelector("#chbxBtn");
  let sectionBtnSave = document.querySelector("#sectionBtnSave");
  chbxBtn.addEventListener("change", () => {
    if (chbxBtn.checked) {
      sectionBtnSave.classList.remove("d-none");
    } else {
      sectionBtnSave.classList.add("d-none");
    }
  });
}
function activeSectionBtnEdit() {
  let chbxBtnEdit = document.querySelector("#chbxBtnEdit");
  let sectionBtnSaveEdit = document.querySelector("#sectionBtnSaveEdit");
  chbxBtnEdit.addEventListener("change", () => {
    if (chbxBtnEdit.checked) {
      sectionBtnSaveEdit.classList.remove("d-none");
    } else {
      sectionBtnSaveEdit.classList.add("d-none");
    }
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
      let url = base_url + "/Carousel/saveCarousel";
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
      let titulo = element.getAttribute("data-titulo");
      let id = element.getAttribute("data-id");
      let file = element.getAttribute("data-file");
      swal(
        {
          title: "¿Estas seguro?",
          text: "Esta seguro de eliminar " + titulo,
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
            let url = base_url + "/Carousel/deleteCarousel";
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
function updateEstado() {
  const arrBtnEstado = document.querySelectorAll(".btnEstado");
  arrBtnEstado.forEach((element) => {
    element.addEventListener("click", () => {
      let titulo = element.getAttribute("data-titulo");
      let id = element.getAttribute("data-id");
      let estado = element.getAttribute("data-estado");
      swal(
        {
          title: "¿Estas seguro?",
          text:
            "Desea cambiar el estado de publicacion del carousel: " + titulo,
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
            data.append("estadoCarusel", estado);
            let encabezados = new Headers();
            let config = {
              method: "POST",
              headers: encabezados,
              mode: "cors",
              cache: "no-cache",
              body: data,
            };
            let url = base_url + "/Carousel/updateEstadoCarousel";
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
function updateInfo() {
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
      let url = base_url + "/Carousel/updateCarouselContent";
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
function loadIcon() {
  let img = document.querySelector("#photo_file");
  let input = document.querySelector("#flArchivo_updFil");
  input.addEventListener("change", (e) => {
    if (input.files[0]) {
      img.src = URL.createObjectURL(input.files[0]);
    }
  });
}
function updateFile() {
  if (document.querySelector("#formUpdateFile")) {
    formUpdateFile = document.querySelector("#formUpdateFile");
    formUpdateFile.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formUpdateFile);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Carousel/updateFileCarousel";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateFile.reset();
              divLoading.style.display = "none";
              $("#modalEditFile").modal("hide");
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
