var divLoading = document.querySelector("#divLoading");
divLoading.style.display = "flex";
document.addEventListener(
  "DOMContentLoaded",
  function () {
    setTimeout(() => {
      flip();
      iniLogin();
      divLoading.style.display = "none";
    }, 2000);
  },
  false
);
document.addEventListener("click", () => {});
function flip() {
  $('.login-content [data-toggle="flip"]').click(function () {
    $(".login-box").toggleClass("flipped");
    return false;
  });
}

function iniLogin() {
  if (document.querySelector("#formLogin")) {
    formLogin = document.querySelector("#formLogin");
    formLogin.addEventListener("submit", (e) => {
      e.preventDefault();
      let data = new FormData(formLogin);
      let encabezados = new Headers();
      let config = {
        method: "POST",
        headers: encabezados,
        mode: "cors",
        cache: "no-cache",
        body: data,
      };
      var url = base_url + "/Login/loginUser";
      try {
        divLoading.style.display = "flex";
        fetch(url, config)
          .then((response) => response.json())
          .then((response) => {
            console.log(response);
            
            if (response.status) {
                // console.log(response);
              window.location = base_url + "/dashboard";
                return;
            } else {
              formLogin.reset();
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
