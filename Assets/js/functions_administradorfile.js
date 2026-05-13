var divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(() => {
    openModalSave();
    save();
    openModalDetail();
    delet();
    divLoading.style.display = "none";
  }, 1000);
});
document.addEventListener("click", () => {
  openModalDetail();
  delet();
});

function openModalSave() {
  if (document.querySelector(".openmodal")) {
    const openmodal = document.querySelector(".openmodal");
    openmodal.addEventListener("click", () => {
      $("#modalSave").modal("show");
    });
  }
}
function openModalDetail() {
  if (document.querySelector(".openDetail")) {
    const openmodal = document.querySelectorAll(".openDetail");
    openmodal.forEach((element) => {
      element.addEventListener("click", () => {
        document.querySelector("#titleDetail").innerHTML =
          element.getAttribute("data-nombre");
        document.querySelector("#name-file").innerHTML =
          element.getAttribute("data-nombre");
        document.querySelector("#ubicacion-file").innerHTML =
          directorio_upload + element.getAttribute("data-nombre");
        document.querySelector("#url-file").href =
          base_url +
          "/Assets/upload/files/" +
          element.getAttribute("data-nombre");
        document.querySelector("#extension-file").innerHTML =
          element.getAttribute("data-extension");
        $("#modalDatail").modal("show");
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
      let url = base_url + "/Administradorfile/uploadFiles";
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
              location.reload();
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
      let file = element.getAttribute("data-file");
      swal(
        {
          title: "¿Estas seguro?",
          text: "Esta seguro de eliminar el archivo: " + file,
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
            data.append("file", file);
            let encabezados = new Headers();
            let config = {
              method: "POST",
              headers: encabezados,
              mode: "cors",
              cache: "no-cache",
              body: data,
            };
            let url = base_url + "/Administradorfile/eliminarArchivo";
            try {
              divLoading.style.display = "flex";
              fetch(url, config)
                .then((response) => response.json())
                .then((response) => {
                  if (response.status) {
                    swal("Satisfactorio", response.msg, "success");
                    divLoading.style.display = "none";
                    location.reload();
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
