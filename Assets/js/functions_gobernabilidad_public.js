document.addEventListener('DOMContentLoaded', function() {
    // Código para la página de gobernabilidad pública
    // En esta versión básica, solo aseguramos que los acordeones funcionen correctamente
    
    // Seleccionar todos los botones de acordeón
    const accordionButtons = document.querySelectorAll('[data-bs-toggle="collapse"]');
    
    accordionButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Esta función se ejecuta cuando se hace clic en un botón de acordeón
            const targetId = this.getAttribute('data-bs-target');
            const targetElement = document.querySelector(targetId);
            
            // Si el acordeón se está abriendo (no tiene la clase 'show')
            if (!targetElement.classList.contains('show')) {
                // Agregar animación o efecto si es necesario
                console.log('Abriendo acordeón:', targetId);
            } else {
                console.log('Cerrando acordeón:', targetId);
            }
        });
    });
    
    // Asegurar que los enlaces de descarga funcionen correctamente
    const downloadLinks = document.querySelectorAll('.download-link');
    downloadLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const filePath = this.getAttribute('href');
            console.log('Descargando archivo:', filePath);
            // Aquí podríamos agregar analytics o contadores de descarga
        });
    });
});