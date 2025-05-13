
document.addEventListener('DOMContentLoaded', () => {
    const images = [
        'url("./images/1.jpeg")',
        'url("./images/2.jpeg")',
        'url("./images/3.jpeg")'
    ];
    let currentIndex = 0;

    function changeBackground() {
        document.body.style.backgroundImage = images[currentIndex];
        currentIndex = (currentIndex + 1) % images.length;
    }

    // Cambiar la imagen cada 5 segundos
    setInterval(changeBackground, 5000);

    // Inicializa con la primera imagen
    changeBackground();

    // Prevenir navegación hacia atrás después de cerrar sesión
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
});
