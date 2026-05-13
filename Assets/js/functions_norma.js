var table;
var divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener("DOMContentLoaded", function () {
  loadTable();
  setTimeout(() => {
    openModalSave();
    save();
    delet();
    openModalEdit();
    openModalUpload();
    updat();
    updatFile();
    divLoading.style.display = "none";
  }, 1000);
});
document.addEventListener("click", () => {
  delet();
  openModalEdit();
  openModalUpload();
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
      url: " " + base_url + "/Norma/getNorma/" + idTipoNorma,
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "nm_nombre" },
      { data: "nm_numeroDocumento" },
      { data: "a_anio" },
      { data: "nm_descripcion" },
      { data: "publicador" },
      { data: "nm_estado" },
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
        class: "col-2",
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
        class: "col-2 text-justify",
        targets: 4,
      },
      {
        class: "col-2 text-center",
        targets: 5,
      },
      {
        class: "col-1 text-center",
        targets: 6,
      },
      {
        class: "col-2 text-center",
        targets: 7,
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
      let url = base_url + "/Norma/saveNorma";
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
      let nombre = element.getAttribute("data-nombre");
      let id = element.getAttribute("data-id");
      let file = element.getAttribute("data-file");
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
            let url = base_url + "/Norma/deleteNorma";
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
      let url = base_url + "/Norma/updateNorma";
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
function openModalEdit() {
  const arrbtnEdit = document.querySelectorAll(".btnEdit");
  arrbtnEdit.forEach((element) => {
    element.addEventListener("click", () => {
      document.querySelector("#titleEdit").innerHTML =
        element.getAttribute("data-nombre");
      document.querySelector("#intNumeroDoc_upd").value =
        element.getAttribute("data-numDoc");
      document.querySelector("#txtNombre_upd").value =
        element.getAttribute("data-nombre");
      document.querySelector("#txtDescripcion_upd").value = element
        .getAttribute("data-descripcion")
        .replace(/«/g, '"');
      document.querySelector("#id_upd").value = element.getAttribute("data-id");
      //cbs estado
      let cbxStatus = document.querySelector("#cbxEstado_upd");
      let attrStatus = element.getAttribute("data-estado");
      cbxStatus =
        attrStatus == 1
          ? (cbxStatus[2].selected = true)
          : (cbxStatus[1].selected = true);
      //end estado
      //cbx año
      let cbxYear = document.querySelector("#cbxYear_upd");
      let attrYear = element.getAttribute("data-idYear");
      cbxYear[0].value = attrYear;
      cbxYear[0].innerHTML = element.getAttribute("data-year");
      cbxYear[0].selected = true;
      cbxYear[0].disabled = false;
      //end año
      $("#modalEdit").modal("show");
    });
  });
}
function openModalUpload() {
  const arrDataModalUpload = document.querySelectorAll(".btnUploadFile");
  arrDataModalUpload.forEach((element) => {
    element.addEventListener("click", () => {
      document.querySelector("#idFile_upd").value =
        element.getAttribute("data-id");
      document.querySelector("#titleEditFile").innerHTML =
        element.getAttribute("data-nombre");
      document.querySelector("#input-pdf").src =
        base_url + "/Assets/upload/" + element.getAttribute("data-file");
      $("#modalEditUpload").modal("show");
    });
  });
}
function updatFile() {
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
      let url = base_url + "/Norma/updateNormaFile";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateFile.reset();
              divLoading.style.display = "none";
              $("#modalEditUpload").modal("hide");
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
