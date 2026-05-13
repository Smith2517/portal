let table;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener(
  "DOMContentLoaded",
  function () {
    loadTable();
    setTimeout(() => {
      openModalSave();
      openModalEdit();
      openModalView();
      save();
      update();
      delet();
      divLoading.style.display = "none";
    }, 1000);
  },
  false
);
document.addEventListener("click", () => {
  openModalEdit();
  openModalView();
  delet();
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
      url: " " + base_url + "/Usuarios/getUsuarios",
      dataSrc: "",
    },
    columns: [
      { data: "idpersona" },
      { data: "nombres" },
      { data: "apellidos" },
      { data: "email_user" },
      { data: "telefono" },
      { data: "nombrerol" },
      { data: "status" },
      { data: "options" },
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
  });
}
function openModalSave() {
  if (
    document.querySelector("#modalSave") &&
    document.querySelector("#btn-save")
  ) {
    const arrBtnSave = document.querySelector("#btn-save");
    arrBtnSave.addEventListener("click", () => {
      $("#modalSave").modal("show");
    });
  }
}
function openModalEdit() {
  if (document.querySelector("#modalEdit")) {
    const arrBtnEdit = document.querySelectorAll(".btnEdit");
    arrBtnEdit.forEach((element) => {
      element.addEventListener("click", () => {
        document.querySelector("#idEdit").value =
          element.getAttribute("data-id");
        document.querySelector("#txtIdentificacionEdit").value =
          element.getAttribute("data-dni");
        document.querySelector("#txtNombreEdit").value =
          element.getAttribute("data-nombre");
        document.querySelector("#txtApellidoEdit").value =
          element.getAttribute("data-apellidos");
        document.querySelector("#txtTelefonoEdit").value =
          element.getAttribute("data-telefono");
        document.querySelector("#txtEmailEdit").value =
          element.getAttribute("data-email");
        //cbx año
        let cbxRol = document.querySelector("#listRolidEdit");
        let attridRol = element.getAttribute("data-idRol");
        cbxRol[0].value = attridRol;
        cbxRol[0].innerHTML = element.getAttribute("data-nombreRol");
        cbxRol[0].selected = true;
        cbxRol[0].disabled = false;
        //end año
        //cbs estado
        let cbxStatus = document.querySelector("#listStatusEdit");
        let attrStatus = element.getAttribute("data-estado");
        cbxStatus =
          attrStatus == 1
            ? (cbxStatus[2].selected = true)
            : (cbxStatus[1].selected = true);
        //end estado
        $("#modalEdit").modal("show");
      });
    });
  }
}
function openModalView() {
  if (document.querySelector("#modalView")) {
    const arrBtnView = document.querySelectorAll(".btnView");
    arrBtnView.forEach((element) => {
      element.addEventListener("click", () => {
        document.querySelector("#viewIdentificacion").innerHTML =
          element.getAttribute("data-dni");
        document.querySelector("#viewNombre").innerHTML =
          element.getAttribute("data-nombre");
        document.querySelector("#viewApellido").innerHTML =
          element.getAttribute("data-apellidos");
        document.querySelector("#viewTelefono").innerHTML =
          element.getAttribute("data-telefono");
        document.querySelector("#viewEmail").innerHTML =
          element.getAttribute("data-email");
        document.querySelector("#viewTipoUsuario").innerHTML =
          element.getAttribute("data-nombreRol");
        document.querySelector("#viewEstado").innerHTML =
          element.getAttribute("data-estado") == 1 ? "Activo" : "Inactivo";
        document.querySelector("#viewFechaRegistro").innerHTML =
          element.getAttribute("data-fechaRegistro");
        $("#modalView").modal("show");
      });
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
      let url = base_url + "/Usuarios/regUsuario";
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
function update() {
  if (document.querySelector("#formEdit")) {
    formEdit = document.querySelector("#formEdit");
    formEdit.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formEdit);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Usuarios/updUsuario";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formEdit.reset();
              divLoading.style.display = "none";
              $("#modalEdit").modal("hide");
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
  if (document.querySelector(".btnDel")) {
    const arrBtnDel = document.querySelectorAll(".btnDel");
    arrBtnDel.forEach((element) => {
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
              data.append("idUsuario", id);
              let encabezados = new Headers();
              let config = {
                method: "POST",
                headers: encabezados,
                mode: "cors",
                cache: "no-cache",
                body: data,
              };
              let url = base_url + "/Usuarios/delUsuario";
              try {
                swal(
                  "Información",
                  "Un momento por favor estamos cargando la infomación",
                  "info"
                );
                divLoading.style.display = "flex";
                fetch(url, config)
                  .then((response) => response.json())
                  .then((response) => {
                    if (response.status) {
                      swal("Satisfactorio", response.msg, "success");
                      divLoading.style.display = "none";
                      table.api().ajax.reload();
                    } else {
                      swal(
                        "Ocurrio un error inesperado",
                        response.msg,
                        "error"
                      );
                      divLoading.style.display = "none";
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
}
