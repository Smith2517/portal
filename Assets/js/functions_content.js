var divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(() => {
    formContent();
    divLoading.style.display = "none";
  }, 1000);
});
document.addEventListener("click", () => {});

function formContent() {
  if (document.querySelector("#formContent")) {
    const formContent = document.querySelector("#formContent");
    formContent.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formContent);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      let url = base_url + "/Paginas/saveContent";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            if (response.status) {
              swal("Satisfactorio", response.msg, "success");
              divLoading.style.display = "none";
              $("#modalSave").modal("hide");
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
