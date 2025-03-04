import axios from 'axios';

// Criação da instância do axios
const api = axios.create({
    baseURL: 'http://127.0.0.1:8000/',
    headers: {
        'Content-Type': 'application/json',
    },
});

// Interceptor para adicionar o token automaticamente às requisições
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('authToken'); // Obtém o token salvo no localStorage
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Interceptor para lidar com erros de resposta, como token expirado
api.interceptors.response.use(
    (response) => response, // Se a resposta for bem-sucedida, retorna normalmente
    (error) => {
        if (error.response?.status === 401) {
            // Se o usuário não estiver autenticado, remover token e redirecionar para login
            localStorage.removeItem('authToken');
            window.location.href = '/login'; // Redireciona para a tela de login
        }
        return Promise.reject(error);
    }
);

export default api;