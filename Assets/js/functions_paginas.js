let table;
const divLoading = document.querySelector("#divLoading");

document.addEventListener("DOMContentLoaded", () => {
  loadTable();
  initEvents();
});

/* ===============================
   DATATABLE
================================ */
function loadTable() {
  table = $("#table").DataTable({
    ajax: {
      url: base_url + "/Paginas/getPaginas",
      dataSrc: ""
    },
    columns: [
      { data: "cont" },
      { data: "p_nombre" },
      { data: "p_descripcion" },
      { data: "link" },
      { data: "p_contenido" },
      { data: "p_estado" },
      { data: "acciones" }
    ],
    responsive: true,
    destroy: true,
    pageLength: 10,
    order: [[0, "desc"]],
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      sSearch: "Buscar:",
      oPaginate: {
        sNext: "Siguiente",
        sPrevious: "Anterior"
      }
    }
  });
}

/* ===============================
   EVENTOS GENERALES
================================ */
function initEvents() {

  // Eventos delegados
  document.addEventListener("click", (e) => {

    if (e.target.closest(".btnOpenModal")) {
      $("#modalSave").modal("show");
    }
    
    /* EDITAR */
    if (e.target.closest(".btnEdit")) {
      const btn = e.target.closest(".btnEdit");
      document.getElementById("id_upd").value = btn.dataset.id;
      document.getElementById("txtNombre_upd").value = btn.dataset.nombre;
      document.getElementById("txtDescripcion_upd").value = btn.dataset.descripcion;
      $("#modalEdit").modal("show");
    }

    /* ELIMINAR */
    if (e.target.closest(".btnDel")) {
      const btn = e.target.closest(".btnDel");
      deletePagina(btn.dataset.id, btn.dataset.nombre);
    }

    /* CAMBIAR ESTADO */
    if (e.target.closest(".btnEstado")) {
      const btn = e.target.closest(".btnEstado");
      updateEstado(btn.dataset.id, btn.dataset.estado, btn.dataset.titulo);
    }
  });

  // Formularios
  document.querySelector("#formSave")?.addEventListener("submit", savePagina);
  document.querySelector("#formUpdate")?.addEventListener("submit", updatePagina);
}

function savePagina(e) {
  e.preventDefault();
  sendForm(e.target, "/Paginas/savePagina", () => {
    $("#modalSave").modal("hide");
  });
}

/* ===============================
   ACTUALIZAR
================================ */
function updatePagina(e) {
  e.preventDefault();
  sendForm(e.target, "/Paginas/updatePagina", () => {
    $("#modalEdit").modal("hide");
  });
}

/* ===============================
   ELIMINAR
================================ */
function deletePagina(id, nombre) {
  swal({
    title: "¿Eliminar?",
    text: nombre,
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  }, (ok) => {
    if (ok) {
      let data = new FormData();
      data.append("id", id);
      fetchRequest("/Paginas/deletePagina", data);
    }
  });
}

/* ===============================
   CAMBIAR ESTADO
================================ */
function updateEstado(id, estado, titulo) {
  swal({
    title: "Cambiar estado",
    text: "Página: " + titulo,
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, cambiar",
    cancelButtonText: "Cancelar"
  }, (ok) => {
    if (ok) {
      let data = new FormData();
      data.append("id", id);
      data.append("estado", estado);
      fetchRequest("/Paginas/updateEstadoPagina", data);
    }
  });
}

/* ===============================
   FUNCIONES AUXILIARES
================================ */
function sendForm(form, url, callback) {
  divLoading.style.display = "flex";

  fetch(base_url + url, {
    method: "POST",
    body: new FormData(form)
  })
    .then(res => res.json())
    .then(res => {
      swal(res.status ? "Correcto" : "Error", res.msg, res.status ? "success" : "error");
      if (res.status) {
        form.reset();
        table.ajax.reload();
        if (callback) callback();
      }
    })
    .catch(err => console.error(err))
    .finally(() => divLoading.style.display = "none");
}

function fetchRequest(url, data) {
  divLoading.style.display = "flex";

  fetch(base_url + url, {
    method: "POST",
    body: data
  })
    .then(res => res.json())
    .then(res => {
      swal(res.status ? "Correcto" : "Error", res.msg, res.status ? "success" : "error");
      if (res.status) table.ajax.reload();
    })
    .catch(err => console.error(err))
    .finally(() => divLoading.style.display = "none");
}
