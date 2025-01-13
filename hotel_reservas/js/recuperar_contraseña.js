document.getElementById('form-recuperacion').addEventListener('submit', function (event) {
    event.preventDefault();

    const email = document.getElementById('email').value;

    // Simula petición a verificar_correo.php
    fetch('verificar_correo.php', {
        method: 'POST',
        body: new URLSearchParams({ email })
    })
        .then(response => response.text())
        .then(data => {
            if (data === 'encontrado') {
                document.getElementById('mensaje').textContent = "Correo encontrado. Enviamos un código a tu correo.";
                document.getElementById('form-codigo').style.display = 'block';
            } else {
                document.getElementById('mensaje').textContent = "Correo no registrado.";
                document.getElementById('registro-link').style.display = 'block';
            }
        });
});

function verificarCodigo() {
    const codigo = document.getElementById('codigo').value;

    // Simula validación del código
    if (codigo === '1234') { // Reemplaza por la validación real
        document.getElementById('form-cambiar-password').style.display = 'block';
    } else {
        alert('Código incorrecto.');
    }
}

function actualizarPassword() {
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password-confirm').value;

    if (password !== passwordConfirm) {
        alert('Las contraseñas no coinciden.');
        return;
    }

    // Aquí se enviaría la nueva contraseña al backend
    alert('Contraseña actualizada. Redirigiendo al login...');
    window.location.href = 'login.html';
}
