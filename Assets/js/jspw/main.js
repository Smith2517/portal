document.addEventListener("DOMContentLoaded", function () {
  setTimeout(() => {
    navScroll();
  }, 1000);
});

function navScroll() {
  document.addEventListener("scroll", () => {
    scrolly = window.scrollY;
    if (scrolly > 14) {
      document.querySelector(".__nav-top").classList.add("d-md-none");
    } else if (scrolly < 15) {
      document.querySelector(".__nav-top").classList.remove("d-md-none");
    }
  });
}
