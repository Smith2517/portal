(function () {
  "use strict";

  var treeviewMenu = $(".app-menu");

  // Toggle Sidebar
  $('[data-toggle="sidebar"]').click(function (event) {
    event.preventDefault();
    $(".app").toggleClass("sidenav-toggled");
  });

  // Activate sidebar treeview toggle
  $("[data-toggle='treeview']").click(function (event) {
    event.preventDefault();
    if (!$(this).parent().hasClass("is-expanded")) {
      treeviewMenu
        .find("[data-toggle='treeview']")
        .parent()
        .removeClass("is-expanded");
    }
    $(this).parent().toggleClass("is-expanded");
  });

  // Set initial active toggle
  $("[data-toggle='treeview.'].is-expanded")
    .parent()
    .toggleClass("is-expanded");

  // Activate bootstrap tooltips
  $("[data-toggle='tooltip']").tooltip();

  // ✅ Ocultar loader global SIEMPRE (aunque DOMContentLoaded ya pasó)
  (function hideLoader() {
    var loading = document.getElementById("loading-container");
    if (loading) loading.style.display = "none";
  })();

  // ✅ fallback por si el loader se inserta después (muy raro, pero útil)
  $(function () {
    var loading = document.getElementById("loading-container");
    if (loading) loading.style.display = "none";
  });
})();
