
document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault(); 

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;


    if (email === '' || password === '') {
        alert('Por favor, completa todos los campos.');
        return;
    }

    // Simulación de inicio de sesión
    alert(`Bienvenido, ${email}!`);
});
