var table;
document.addEventListener("DOMContentLoaded", function () {
  loadTable();
  setTimeout(() => {
    openPdf();
    donwload();
    loadingContainer.style.display = 'none';
  }, 1000);
});
document.addEventListener("click", () => {
  openPdf();
});
function loadTable() {
  if (document.querySelector("#table")) {
    table = $("#table").DataTable({
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
        url: base_url + "/page/getnormas/" + idTipoNorma + "/" + year,
        dataSrc: "",
      },
      columns: [
        { data: "cont" },
        { data: "nm_nombre" },
        { data: "a_anio" },
        { data: "nm_descripcion" },
        { data: "nm_file" },
      ],
      resonsieve: "true",
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "asc"]],
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
          class: "col-1 text-center",
          targets: 2,
        },
        {
          class: "col-6 text-justify fs-6",
          targets: 3,
        },
        {
          class: "col-1 text-center",
          targets: 4,
        },
      ],
    });
  }
}
function openPdf() {
  const arrOpenPdf = document.querySelectorAll(".open-pdf");
  arrOpenPdf.forEach((element) => {
    element.addEventListener("click", () => {
      let urlFile =
        base_url + "/Assets/upload/" + element.getAttribute("data-url");
      document.querySelector("#titleView").innerHTML =
        element.getAttribute("data-nombre");
      document.querySelector("#description").innerHTML = element
        .getAttribute("data-description")
        .replace(/«/g, '"');
      document.querySelector("#input-pdf").src = urlFile;
      document.querySelector("#link-pdf").href = urlFile;
      document.querySelector("#publicador").innerHTML =
        element.getAttribute("data-publicador");
      document
        .querySelector("#link-donwload")
        .setAttribute("data-url", urlFile);
      document
        .querySelector("#link-donwload")
        .setAttribute("data-name", element.getAttribute("data-nombre"));
      $("#modalView").modal("show");
    });
  });
}
function donwload() {
  const linkDonwload = document.querySelector("#link-donwload");
  linkDonwload.addEventListener("click", (e) => {
    e.preventDefault();
    let fileDonwload = linkDonwload.getAttribute("data-url");
    let nombre = linkDonwload.getAttribute("data-name");
    let data = new FormData();
    data.append("fileDonwload", fileDonwload);
    data.append("nombre", nombre);
    let url = fileDonwload;
    try {
      fetch(url)
        .then((response) => response.blob())
        .then((response) => {
          // (C1) "FORCE DOWNLOAD"
          var url = window.URL.createObjectURL(response),
            anchor = document.createElement("a");
          anchor.href = url;
          anchor.download = nombre;
          anchor.click();
          // (C2) CLEAN UP
          window.URL.revokeObjectURL(url);
          document.removeChild(anchor);
        });
    } catch (error) {
      console.error(error);
    }
  });
}
