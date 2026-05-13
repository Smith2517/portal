var table;
var divLoading = document.querySelector("#divLoading");
if (divLoading) divLoading.style.display = "flex";

document.addEventListener("DOMContentLoaded", function () {
  loadTable();
  setTimeout(() => {
    openModalSave();
    openModalEdit();
    save();
    update();
    updateEstado();
    deleteDocumento();
    if (divLoading) divLoading.style.display = "none";
  }, 1000);
});

document.addEventListener("click", () => {
  deleteDocumento();
  updateEstado();
  openModalEdit();
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
      url: " " + base_url + "/Videosdidacticos/getVideosdidacticos",
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "vd_nombre" },
      { data: "vd_enlace" },
      { data: "vd_orden" },
      { data: "vd_estado" },
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
    order: [[3, "asc"]],
    columnDefs: [
      {
        class: "col-1 text-center",
        targets: 0,
      },
      {
        class: "col-3",
        targets: 1,
        render: function (data) {
          return '<span title="' + data + '">' + (data && data.length > 40 ? data.substring(0, 40) + '...' : data) + '</span>';
        },
      },
      {
        class: "col-3",
        targets: 2,
        render: function (data) {
          return '<a href="' + data + '" target="_blank" class="text-truncate d-block" style="max-width: 250px;">' + data + '</a>';
        },
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
        class: "col-1 text-center",
        targets: 5,
      },
    ],
  });
}

function openModalSave() {
  if (document.querySelector("#openModal")) {
    document.querySelector("#openModal").addEventListener("click", () => {
      document.querySelector("#formSave").reset();
      document.querySelector("#titleSave").innerHTML = "Agregar Nuevo Video";
      document.querySelector("#btnText").innerHTML = "Guardar";
      document.querySelector("#btnActionForm").setAttribute("data-function", "save");
      $("#modalSave").modal("show");
    });
  }
}

function openModalEdit() {
  if (document.querySelectorAll(".btnEdit").length > 0) {
    document.querySelectorAll(".btnEdit").forEach((btn) => {
      btn.addEventListener("click", function () {
        document.querySelector("#titleEdit").innerHTML = "Editar Información del Video";
        document.querySelector("#btnText").innerHTML = "Actualizar";
        document.querySelector("#btnActionForm").setAttribute("data-function", "update");
        document.querySelector("#id_upd").value = this.getAttribute("data-id");
        document.querySelector("#txtNombre_upd").value = this.getAttribute("data-nombre");
        document.querySelector("#txtEnlace_upd").value = this.getAttribute("data-enlace");
        document.querySelector("#txtOrden_upd").value = this.getAttribute("data-orden");
        $("#modalEdit").modal("show");
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
      let url = base_url + "/Videosdidacticos/saveVideosdidacticos";
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
      let url = base_url + "/Videosdidacticos/updateVideosdidacticos";
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

function updateEstado() {
  if (document.querySelectorAll(".btnEstado").length > 0) {
    document.querySelectorAll(".btnEstado").forEach((btn) => {
      btn.addEventListener("click", function () {
        let id = this.getAttribute("data-id");
        let nombre = this.getAttribute("data-nombre");
        let estado = this.getAttribute("data-estado");
        let texto = estado == 1 ? "activar" : "inactivar";
        swal({
          title: "¿Está seguro de " + texto + " el video: " + nombre + "?",
          text: "Esta acción cambiará el estado del video.",
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
            let url = base_url + "/Videosdidacticos/updateEstadoVideosdidacticos";
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

function deleteDocumento() {
  if (document.querySelectorAll(".btnDel").length > 0) {
    document.querySelectorAll(".btnDel").forEach((btn) => {
      btn.addEventListener("click", function () {
        let id = this.getAttribute("data-id");
        let nombre = this.getAttribute("data-nombre");
        swal({
          title: "¿Está seguro de eliminar el video: " + nombre + "?",
          text: "Esta acción eliminará permanentemente el video.",
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
            let encabezados = new Headers();
            let config = {
              method: "POST",
              headers: encabezados,
              mode: "cors",
              cache: "no-cache",
              body: data,
            };
            let url = base_url + "/Videosdidacticos/deleteVideosdidacticos";
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
