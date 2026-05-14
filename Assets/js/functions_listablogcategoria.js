
const apiUrl = base_url + '/page/getBlogs';
const elementosPorPagina = 6;
let paginaActual = 0;
let cargando = false;
const cardListContainer = document.getElementById('card-list');
const emptyMessageContainer = document.getElementById('empty-message');
const loadingMessageContainer = document.getElementById('loading-message');
const verMasButton = document.getElementById('ver-mas');
document.addEventListener("DOMContentLoaded", function () {
    cargarElementos();
    setTimeout(() => {
        // Oculta la pantalla de carga y muestra el contenido
        var loadingContainer = document.getElementById('loading-container');
        if (loadingContainer) loadingContainer.style.display = 'none';
    }, 1000);
});
verMasButton.addEventListener('click', function () {
    if (!cargando) {
        cargarElementos();
    }

});
function cargarElementos() {
    cargando = true;
    loadingMessageContainer.style.display = 'block';
    fetch(`${apiUrl}?__cat=${categoria}&_page=${paginaActual}&_limit=${elementosPorPagina}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            loadingMessageContainer.style.display = 'none';

            if (data.length > 0) {
                mostrarElementosEnCards(data);
                paginaActual = paginaActual + data.length;
            } else {
                mostrarMensajeVacio();
                verMasButton.style.display = 'none';
            }
        })
        .catch(error => {
            loadingMessageContainer.style.display = 'none';
            console.error('Error al obtener datos de la API:', error);
        })
        .finally(() => {
            cargando = false;
        });
}
function mostrarElementosEnCards(elementos) {
    elementos.forEach(elemento => {
        const cardCol = document.createElement('div');
        cardCol.className = 'col-md-3 mb-4';
        const card = document.createElement('div');
        card.className = 'card';
        const cardBody = document.createElement('div');
        cardBody.className = 'card-body';
        const cardTitle = document.createElement('h5');
        cardTitle.className = 'card-title';
        cardTitle.textContent = elemento.b_Titulo;
        const cardText = document.createElement('p');
        cardText.className = 'card-text';
        cardText.textContent = elemento.b_Contenido;
        const cardImage = document.createElement('img');
        cardImage.className = 'card-img-top'; // Agrega la clase si necesitas estilos específicos para la imagen
        cardImage.src = base_url + "/Assets/upload/images/" + elemento.b_Imagen; // Reemplaza 'URL_DE_LA_IMAGEN' con la URL de tu imagen
        cardImage.alt = elemento.b_Contenido; // Agrega una descripción para la imagen
        const cardLink = document.createElement('a');
        cardLink.className = 'btn';
        cardLink.textContent = "Ver más";
        cardLink.href = base_url + "/page/b/" + elemento.idCategoria + "/" + elemento.b_tituloGuion;
        cardBody.appendChild(cardTitle);
        cardBody.appendChild(cardText);
        cardBody.appendChild(cardLink);
        card.appendChild(cardImage);
        card.appendChild(cardBody);
        cardCol.appendChild(card);
        // Agregar estilos de Bootstrap
        cardCol.classList.add('col-md-3', 'mb-4');
        card.classList.add('card', 'bg-white');
        cardImage.classList.add('card-img-top');
        cardBody.classList.add('card-body');
        cardTitle.classList.add('card-title', 'text-center');
        cardText.classList.add('card-text');
        cardLink.classList.add('btn-link');
        // Añadir el cardCol al contenedor deseado (reemplaza cardListContainer con tu contenedor real)
        cardListContainer.appendChild(cardCol);
    });

    emptyMessageContainer.style.display = 'none';
}
function mostrarMensajeVacio() {
    emptyMessageContainer.style.display = 'block';
}