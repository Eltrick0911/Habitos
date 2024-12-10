// Configuración base para la API
const API_BASE_URL = '/Habitos/api-rest';

// Clase para manejar las peticiones a la API
class ApiService {
    // Función para manejar errores
    static async handleResponse(response) {
        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.message || 'Error en la petición');
        }
        return response.json();
    }

    // Función para obtener headers comunes
    static getHeaders() {
        return {
            'Content-Type': 'application/json',
            'Authorization': localStorage.getItem('token') || ''
        };
    }

    // Autenticación
    static async login(email, password) {
        try {
            const response = await fetch(`${API_BASE_URL}/auth/login`, {
                method: 'POST',
                headers: this.getHeaders(),
                body: JSON.stringify({ email, password })
            });
            const data = await this.handleResponse(response);
            if (data.token) {
                localStorage.setItem('token', data.token);
            }
            return data;
        } catch (error) {
            console.error('Error en login:', error);
            throw error;
        }
    }

    // Registro
    static async register(userData) {
        try {
            const response = await fetch(`${API_BASE_URL}/auth/register`, {
                method: 'POST',
                headers: this.getHeaders(),
                body: JSON.stringify(userData)
            });
            return await this.handleResponse(response);
        } catch (error) {
            console.error('Error en registro:', error);
            throw error;
        }
    }

    // Hábitos
    static async getHabits() {
        try {
            const response = await fetch(`${API_BASE_URL}/habits`, {
                headers: this.getHeaders()
            });
            return await this.handleResponse(response);
        } catch (error) {
            console.error('Error al obtener hábitos:', error);
            throw error;
        }
    }

    static async createHabit(habitData) {
        try {
            const response = await fetch(`${API_BASE_URL}/habits/create`, {
                method: 'POST',
                headers: this.getHeaders(),
                body: JSON.stringify(habitData)
            });
            return await this.handleResponse(response);
        } catch (error) {
            console.error('Error al crear hábito:', error);
            throw error;
        }
    }

    static async updateHabit(habitId, habitData) {
        try {
            const response = await fetch(`${API_BASE_URL}/habits/update`, {
                method: 'PUT',
                headers: this.getHeaders(),
                body: JSON.stringify({ id: habitId, ...habitData })
            });
            return await this.handleResponse(response);
        } catch (error) {
            console.error('Error al actualizar hábito:', error);
            throw error;
        }
    }

    static async deleteHabit(habitId) {
        try {
            const response = await fetch(`${API_BASE_URL}/habits/${habitId}`, {
                method: 'DELETE',
                headers: this.getHeaders()
            });
            return await this.handleResponse(response);
        } catch (error) {
            console.error('Error al eliminar hábito:', error);
            throw error;
        }
    }

    // Comentarios
    static async getCommentsByGroup(groupId) {
        try {
            const response = await fetch(`${API_BASE_URL}/comments/group/${groupId}`, {
                headers: this.getHeaders()
            });
            return await this.handleResponse(response);
        } catch (error) {
            console.error('Error al obtener comentarios:', error);
            throw error;
        }
    }

    static async createComment(commentData) {
        try {
            const response = await fetch(`${API_BASE_URL}/comments/create`, {
                method: 'POST',
                headers: this.getHeaders(),
                body: JSON.stringify(commentData)
            });
            return await this.handleResponse(response);
        } catch (error) {
            console.error('Error al crear comentario:', error);
            throw error;
        }
    }
}

// Exportar la clase para su uso
export default ApiService;
