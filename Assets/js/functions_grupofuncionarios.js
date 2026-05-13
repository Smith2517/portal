var table;
var divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener("DOMContentLoaded", function () {
  loadTable();
  loadTableFuncionario();
  setTimeout(() => {
    openModalSave();
    openModalSaveAddFuncionario();
    openModalEdit();
    openModalEditFuncionarios();
    openModalFileEdit();
    openModalFileEditFuncionario();
    save();
    saveFuncionario();
    updat();
    updatFuncionario();
    updateEstado();
    updateEstadoFuncionario();
    updateFile();
    updateFileFuncionario();
    delet();
    deletFuncionarios();
    loadImage();
    loadImgUpdate();
    loadImgUpdateFuncionario();
    loadImageFuncionario();
    divLoading.style.display = "none";
  }, 1000);
});
document.addEventListener("click", () => {
  delet();
  deletFuncionarios();
  updateEstado();
  updateEstadoFuncionario();
  openModalEdit();
  openModalEditFuncionarios();
  openModalFileEdit();
  openModalFileEditFuncionario();
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
      url: " " + base_url + "/Funcionarios/getGruposFuncionarios",
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "gf_nombre" },
      { data: "gf_descripcion" },
      { data: "link" },
      { data: "gf_estado" },
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
        class: "col-4 text-center",
        targets: 2,
      },
      {
        class: "col-2 text-center",
        targets: 3,
      },
      {
        class: "col-1 text-center",
        targets: 4,
      },
      {
        class: "col-3 text-center",
        targets: 5,
      },
    ],
  });
}
function loadTableFuncionario() {
  if (typeof idGrupoFuncionarios != "undefined") {
    table = $("#table-funcionarios").dataTable({
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
        url:
          " " +
          base_url +
          "/Funcionarios/getFuncionariosId/" +
          idGrupoFuncionarios,
        dataSrc: "",
      },
      columns: [
        { data: "cont" },
        { data: "trabajador" },
        { data: "f_despendecia" },
        { data: "f_cargo" },
        { data: "f_estado" },
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
          class: "col-3",
          targets: 1,
        },
        {
          class: "col-2 text-center",
          targets: 2,
        },
        {
          class: "col-2 text-center",
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
      let url = base_url + "/Funcionarios/saveGrupoFuncionarios";
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
function saveFuncionario() {
  if (document.querySelector("#formSaveFuncionario")) {
    formSaveFuncionario = document.querySelector("#formSaveFuncionario");
    formSaveFuncionario.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formSaveFuncionario);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Funcionarios/saveFuncionario";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formSaveFuncionario.reset();
              divLoading.style.display = "none";
              $("#modalSaveAddFuncionarios").modal("hide");
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
function updat() {
  if (document.querySelector("#formUpdateGrupoFuncionario")) {
    formUpdateGrupoFuncionario = document.querySelector(
      "#formUpdateGrupoFuncionario"
    );
    formUpdateGrupoFuncionario.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formUpdateGrupoFuncionario);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Funcionarios/updateGrupoFuncionarios";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateGrupoFuncionario.reset();
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
function updatFuncionario() {
  if (document.querySelector("#formUpdateFuncionario")) {
    formUpdate = document.querySelector("#formUpdateFuncionario");
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
      let url = base_url + "/Funcionarios/updateFuncionario";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdate.reset();
              divLoading.style.display = "none";
              $("#modalEditFuncionarios").modal("hide");
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
          text: "Desea cambiar el estado de publicacion: " + titulo,
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
            let url = base_url + "/Funcionarios/updateEstadoGruposFuncionarios";
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
function delet() {
  const arrbtnDelRol = document.querySelectorAll(".btnDel");
  arrbtnDelRol.forEach((element) => {
    element.addEventListener("click", () => {
      let titulo = element.getAttribute("data-nombre");
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
            let url = base_url + "/Funcionarios/deleteGrupoFuncionarios";
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
function deletFuncionarios() {
  const arrbtnDelFuncionario = document.querySelectorAll(".btnDelFuncionario");
  arrbtnDelFuncionario.forEach((element) => {
    element.addEventListener("click", () => {
      let nombres = element.getAttribute("data-nombre");
      let id = element.getAttribute("data-id");
      let file = element.getAttribute("data-file");
      swal(
        {
          title: "¿Estas seguro?",
          text: "Esta seguro de eliminar al funcionario: " + nombres,
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
            let url = base_url + "/Funcionarios/deleteFuncionario";
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
function openModalSaveAddFuncionario() {
  if (document.querySelector(".openmodaladdfuncionarios")) {
    const openmodaladdfuncionarios = document.querySelector(
      ".openmodaladdfuncionarios"
    );
    openmodaladdfuncionarios.addEventListener("click", () => {
      $("#modalSaveAddFuncionarios").modal("show");
    });
  }
}
function openModalEdit() {
  const arrbtnEdit = document.querySelectorAll(".btnEdit");
  arrbtnEdit.forEach((element) => {
    element.addEventListener("click", () => {
      document.querySelector("#idgf_upd").value =
        element.getAttribute("data-id");
      document.querySelector("#txtNombregf_upd").value =
        element.getAttribute("data-nombre");
      document.querySelector("#txtDescripciongf_upd").value =
        element.getAttribute("data-descripcion");
      $("#modalEdit").modal("show");
    });
  });
}
function openModalEditFuncionarios() {
  const arrbtnEdit = document.querySelectorAll(".btnEditFuncionario");
  arrbtnEdit.forEach((element) => {
    element.addEventListener("click", () => {
      document.querySelector("#idF_upd").value =
        element.getAttribute("data-id");
      document.querySelector("#txtNombref_upd").value =
        element.getAttribute("data-nombres");
      document.querySelector("#txtApellidos_upd").value =
        element.getAttribute("data-apellidos");
      document.querySelector("#txtDependecia_upd").value =
        element.getAttribute("data-dependencia");
      document.querySelector("#txtCargo_upd").value =
        element.getAttribute("data-cargo");
      document.querySelector("#txtMail_upd").value =
        element.getAttribute("data-correo");
      document.querySelector("#txtPhone_upd").value =
        element.getAttribute("data-celular");
      $("#modalEditFuncionarios").modal("show");
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
function openModalFileEditFuncionario() {
  const arrbtnEditPhoto = document.querySelectorAll(".btnEditFileFuncionario");
  arrbtnEditPhoto.forEach((element) => {
    element.addEventListener("click", () => {
      document.querySelector("#ip_updFilFuncionario").value =
        element.getAttribute("data-id");
      document.querySelector("#photoOld_updFilFuncionario").value =
        element.getAttribute("data-image");
      document.querySelector("#photo_fileFuncionario").src =
        base_url +
        "/Assets/upload/images/" +
        element.getAttribute("data-image");
      $("#modalEditFileFuncionario").modal("show");
    });
  });
}
function loadImage() {
  let img = document.querySelector("#file-img");
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
function loadImageFuncionario() {
  let img = document.querySelector("#file-imgFuncionario");
  let input = document.querySelector("#flArchivoFuncionario");
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
function loadImgUpdate() {
  let img = document.querySelector("#photo_file");
  let input = document.querySelector("#flArchivo_updFil");
  input.addEventListener("change", (e) => {
    if (input.files[0]) {
      img.src = URL.createObjectURL(input.files[0]);
    }
  });
}
function loadImgUpdateFuncionario() {
  let img = document.querySelector("#photo_fileFuncionario");
  let input = document.querySelector("#flArchivo_updFilFuncionario");
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
      let url = base_url + "/Funcionarios/updateFileGroupFuncionarios";
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
function updateFileFuncionario() {
  if (document.querySelector("#formUpdateFileFuncionario")) {
    formUpdateFileFuncionario = document.querySelector(
      "#formUpdateFileFuncionario"
    );
    formUpdateFileFuncionario.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formUpdateFileFuncionario);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Funcionarios/updateFileFuncionario";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateFileFuncionario.reset();
              divLoading.style.display = "none";
              $("#modalEditFileFuncionario").modal("hide");
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
function updateEstadoFuncionario() {
  const btnEstadoFuncionario = document.querySelectorAll(
    ".btnEstadoFuncionario"
  );
  btnEstadoFuncionario.forEach((element) => {
    element.addEventListener("click", () => {
      let nombre = element.getAttribute("data-nombre");
      let id = element.getAttribute("data-id");
      let estado = element.getAttribute("data-estado");
      swal(
        {
          title: "¿Estas seguro?",
          text: "Desea cambiar el estado del registro: " + nombre,
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
            let url = base_url + "/Funcionarios/updateEstadoFuncionario";
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
