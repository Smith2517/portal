document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        // Oculta la pantalla de carga y muestra el contenido
        var loadingContainer = document.getElementById('loading-container');
        if (loadingContainer) loadingContainer.style.display = 'none';
    }, 1000);
});