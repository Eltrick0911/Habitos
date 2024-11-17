document.getElementById('loginForm').addEventListener('submit', function(event) {
    // Clear previous error messages
    document.getElementById('emailError').style.display = 'none';
    document.getElementById('passwordError').style.display = 'none';

    // Get form values
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    let valid = true;

    // Validate email
    if (!validateEmail(email)) {
        document.getElementById('emailError').textContent = 'Por favor, introduce un correo electrónico válido.';
        document.getElementById('emailError').style.display = 'block';
        valid = false;
    }

    // Validate password
    if (password.length < 6) {
        document.getElementById('passwordError').textContent = 'La contraseña debe tener al menos 6 caracteres.';
        document.getElementById('passwordError').style.display = 'block';
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }
});

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}