var table;
var divLoading = document.querySelector("#divLoading");
if (divLoading) divLoading.style.display = "flex";

document.addEventListener("DOMContentLoaded", function () {
  loadTable();
  setTimeout(() => {
    openModalSave();
    openModalEdit();
    openModalFileEdit();
    save();
    update();
    updateEstado();
    updateFile();
    deleteIntegrante();
    loadImage();
    loadImgUpdate();
    if (divLoading) divLoading.style.display = "none";
  }, 1000);
});

document.addEventListener("click", () => {
  deleteIntegrante();
  updateEstado();
  openModalEdit();
  openModalFileEdit();
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
      sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
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
        sSortAscending: ": Activar para ordenar la columna de manera ascendente",
        sSortDescending: ": Activar para ordenar la columna de manera descendente",
      },
      buttons: {
        copy: "Copiar",
        colvis: "Visibilidad",
      },
    },
    ajax: {
      url: " " + base_url + "/Integrantessci/getIntegrantesSci",
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "i_foto" },
      { data: "i_nombres" },
      { data: "i_apellidos" },
      { data: "i_cargo" },
      { data: "i_dependencia" },
      { data: "i_correo" },
      { data: "i_celular" },
      { data: "i_estado" },
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
        titleAttr: "Exportar a Excel",
        className: "btn btn-success",
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fas fa-file-pdf'></i> PDF",
        titleAttr: "Exportar a PDF",
        className: "btn btn-danger",
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "Exportar a CSV",
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
        class: "col-1 text-center",
        targets: 1,
        render: function (data) {
          if (data) {
            return '<img src="' + base_url + '/Assets/upload/images/' + data + '" class="img-thumbnail" width="50" height="50">';
          } else {
            return '<img src="' + base_url + '/Assets/images/sinimagen.png" class="img-thumbnail" width="50" height="50">';
          }
        },
      },
      {
        class: "col-1",
        targets: 2,
      },
      {
        class: "col-1",
        targets: 3,
      },
      {
        class: "col-1",
        targets: 4,
      },
      {
        class: "col-1",
        targets: 5,
      },
      {
        class: "col-1",
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
        class: "col-1 text-center",
        targets: 9,
      },
    ],
  });
}

function openModalSave() {
  if (document.querySelector("#openModal")) {
    document.querySelector("#openModal").addEventListener("click", () => {
      document.querySelector("#formSave").reset();
      document.querySelector("#titleSave").innerHTML = "Agregar Nuevo Integrante SCI";
      document.querySelector("#btnText").innerHTML = "Guardar";
      document.querySelector("#btnActionForm").setAttribute("data-function", "save");
      document.querySelector("#file-img").src = base_url + "/Assets/images/sinimagen.png";
      $("#modalSave").modal("show");
    });
  }
}

function openModalEdit() {
  if (document.querySelectorAll(".btnEdit").length > 0) {
    document.querySelectorAll(".btnEdit").forEach((btn) => {
      btn.addEventListener("click", function () {
        document.querySelector("#titleEdit").innerHTML = "Editar Información del Integrante";
        document.querySelector("#btnText").innerHTML = "Actualizar";
        document.querySelector("#btnActionForm").setAttribute("data-function", "update");
        document.querySelector("#id_upd").value = this.getAttribute("data-id");
        document.querySelector("#txtNombres_upd").value = this.getAttribute("data-nombres");
        document.querySelector("#txtApellidos_upd").value = this.getAttribute("data-apellidos");
        document.querySelector("#txtCargo_upd").value = this.getAttribute("data-cargo");
        document.querySelector("#txtDependencia_upd").value = this.getAttribute("data-dependencia");
        document.querySelector("#txtCorreo_upd").value = this.getAttribute("data-correo");
        document.querySelector("#txtCelular_upd").value = this.getAttribute("data-celular");
        $("#modalEdit").modal("show");
      });
    });
  }
}

function openModalFileEdit() {
  if (document.querySelectorAll(".btnEditFile").length > 0) {
    document.querySelectorAll(".btnEditFile").forEach((btn) => {
      btn.addEventListener("click", function () {
        document.querySelector("#titleEditFile").innerHTML = "Editar Foto del Integrante";
        document.querySelector("#id_updFil").value = this.getAttribute("data-id");
        let image = this.getAttribute("data-image");
        if (image) {
          document.querySelector("#photo_file").src = base_url + "/Assets/upload/images/" + image;
          document.querySelector("#photoOld_updFil").value = image;
        } else {
          document.querySelector("#photo_file").src = base_url + "/Assets/images/sinimagen.png";
          document.querySelector("#photoOld_updFil").value = "";
        }
        $("#modalEditFile").modal("show");
      });
    });
  }
}

function save() {
  if (document.querySelector("#formSave")) {
    let formSave = document.querySelector("#formSave");
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
      let url = base_url + "/Integrantessci/saveIntegranteSci";
      try {
        if (divLoading) divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formSave.reset();
              if (divLoading) divLoading.style.display = "none";
              $("#modalSave").modal("hide");
              table.api().ajax.reload();
            } else {
              if (divLoading) divLoading.style.display = "none";
              swal("Ocurrió un error inesperado", response.msg, "error");
            }
          });
      } catch (error) {
        if (divLoading) divLoading.style.display = "none";
        console.error(error);
      }
    });
  }
}

function update() {
  if (document.querySelector("#formUpdate")) {
    let formUpdate = document.querySelector("#formUpdate");
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
      let url = base_url + "/Integrantessci/updateIntegranteSci";
      try {
        if (divLoading) divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdate.reset();
              if (divLoading) divLoading.style.display = "none";
              $("#modalEdit").modal("hide");
              table.api().ajax.reload();
            } else {
              if (divLoading) divLoading.style.display = "none";
              swal("Ocurrió un error inesperado", response.msg, "error");
            }
          });
      } catch (error) {
        if (divLoading) divLoading.style.display = "none";
        console.error(error);
      }
    });
  }
}

function updateFile() {
  if (document.querySelector("#formUpdateFile")) {
    let formUpdateFile = document.querySelector("#formUpdateFile");
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
      let url = base_url + "/Integrantessci/updateFileIntegranteSci";
      try {
        if (divLoading) divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              formUpdateFile.reset();
              if (divLoading) divLoading.style.display = "none";
              $("#modalEditFile").modal("hide");
              table.api().ajax.reload();
            } else {
              if (divLoading) divLoading.style.display = "none";
              swal("Ocurrió un error inesperado", response.msg, "error");
            }
          });
      } catch (error) {
        if (divLoading) divLoading.style.display = "none";
        console.error(error);
      }
    });
  }
}

function updateEstado() {
  if (document.querySelectorAll(".btnEstado").length > 0) {
    document.querySelectorAll(".btnEstado").forEach((btn) => {
      btn.addEventListener("click", function () {
        let id = this.getAttribute("data-id");
        let nombre = this.getAttribute("data-nombre");
        let estado = this.getAttribute("data-estado");
        let texto = estado == 1 ? "publicar" : "despublicar";
        swal({
          title: "¿Está seguro de " + texto + " el integrante: " + nombre + "?",
          text: "Esta acción cambiará el estado del integrante.",
          icon: "warning",
          buttons: {
            cancel: {
              text: "Cancelar",
              visible: true,
              closeModal: true,
            },
            confirm: {
              text: "Confirmar",
              value: true,
              visible: true,
              closeModal: true,
            },
          },
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
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
            let url = base_url + "/Integrantessci/updateEstadoIntegranteSci";
            try {
              if (divLoading) divLoading.style.display = "flex";
              fetch(url, config)
                .then((response) => response.json())
                .then((response) => {
                  if (response.status) {
                    swal("Satisfactorio", response.msg, "success");
                    if (divLoading) divLoading.style.display = "none";
                    table.api().ajax.reload();
                  } else {
                    if (divLoading) divLoading.style.display = "none";
                    swal("Ocurrió un error inesperado", response.msg, "error");
                  }
                });
            } catch (error) {
              if (divLoading) divLoading.style.display = "none";
              console.error(error);
            }
          }
        });
      });
    });
  }
}

function deleteIntegrante() {
  if (document.querySelectorAll(".btnDel").length > 0) {
    document.querySelectorAll(".btnDel").forEach((btn) => {
      btn.addEventListener("click", function () {
        let id = this.getAttribute("data-id");
        let file = this.getAttribute("data-file");
        let nombre = this.getAttribute("data-nombre");
        swal({
          title: "¿Está seguro de eliminar al integrante: " + nombre + "?",
          text: "Esta acción eliminará permanentemente los datos del integrante.",
          icon: "warning",
          buttons: {
            cancel: {
              text: "Cancelar",
              visible: true,
              closeModal: true,
            },
            confirm: {
              text: "Eliminar",
              value: true,
              visible: true,
              closeModal: true,
            },
          },
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
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
            let url = base_url + "/Integrantessci/deleteIntegranteSci";
            try {
              if (divLoading) divLoading.style.display = "flex";
              fetch(url, config)
                .then((response) => response.json())
                .then((response) => {
                  if (response.status) {
                    swal("Satisfactorio", response.msg, "success");
                    if (divLoading) divLoading.style.display = "none";
                    table.api().ajax.reload();
                  } else {
                    if (divLoading) divLoading.style.display = "none";
                    swal("Ocurrió un error inesperado", response.msg, "error");
                  }
                });
            } catch (error) {
              if (divLoading) divLoading.style.display = "none";
              console.error(error);
            }
          }
        });
      });
    });
  }
}

function loadImage() {
  if (document.querySelector("#flArchivo")) {
    document.querySelector("#flArchivo").addEventListener("change", function () {
      let file = this.files[0];
      if (file) {
        let reader = new FileReader();
        reader.onload = function (e) {
          document.querySelector("#file-img").src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  }
}

function loadImgUpdate() {
  if (document.querySelector("#flArchivo_upd")) {
    document.querySelector("#flArchivo_upd").addEventListener("change", function () {
      let file = this.files[0];
      if (file) {
        let reader = new FileReader();
        reader.onload = function (e) {
          document.querySelector("#photo_file").src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  }
}
