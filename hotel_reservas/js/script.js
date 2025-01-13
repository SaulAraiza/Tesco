// Mostrar un mensaje cuando se hace clic en el logo
//document.querySelector('.logo').addEventListener('click', function() {
 //   alert('¡Bienvenido a TESCO Beaches! Redirigiendo a la página de inicio de sesión...');
//});

// Cambiar el color del texto de contacto al pasar el mouse
const contactInfo = document.querySelector('.contact-info');

contactInfo.addEventListener('mouseover', function() {
    contactInfo.style.color = '#ffffff'; // Cambia el color a rojo tomate
});

contactInfo.addEventListener('mouseout', function() {
    contactInfo.style.color = 'black'; // Restaura el color blanco
});

