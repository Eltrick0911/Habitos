import ApiService from './api.js';

// Función para manejar el login
async function handleLogin(event) {
    event.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await ApiService.login(email, password);
        if (response.token) {
            window.location.href = '/Habitos/dashboard';
        }
    } catch (error) {
        alert('Error en el inicio de sesión: ' + error.message);
    }
}

// Función para manejar el registro
async function handleRegister(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const userData = Object.fromEntries(formData.entries());

    try {
        const response = await ApiService.register(userData);
        alert('Registro exitoso');
        window.location.href = '/Habitos/login';
    } catch (error) {
        alert('Error en el registro: ' + error.message);
    }
}

// Función para cargar hábitos
async function loadHabits() {
    try {
        const habits = await ApiService.getHabits();
        const habitsList = document.getElementById('habits-list');
        habitsList.innerHTML = habits.map(habit => `
            <div class="habit-card">
                <h3>${habit.nombre}</h3>
                <p>${habit.descripcion}</p>
                <button onclick="editHabit(${habit.id})">Editar</button>
                <button onclick="deleteHabit(${habit.id})">Eliminar</button>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error al cargar hábitos:', error);
    }
}

// Función para crear un nuevo hábito
async function createHabit(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const habitData = Object.fromEntries(formData.entries());

    try {
        await ApiService.createHabit(habitData);
        alert('Hábito creado exitosamente');
        loadHabits(); // Recargar la lista de hábitos
    } catch (error) {
        alert('Error al crear hábito: ' + error.message);
    }
}

// Exportar funciones para su uso en HTML
window.handleLogin = handleLogin;
window.handleRegister = handleRegister;
window.loadHabits = loadHabits;
window.createHabit = createHabit;
