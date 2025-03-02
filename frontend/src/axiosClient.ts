import axios from 'axios';

const api = axios.create({
    baseURL: 'http://127.0.0.1:8000/',
    headers: {
        'Content-Type': 'application/json',
    },
});

// Adiciona um interceptor para adicionar o token de autenticação a cada requisição
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token'); // Substitua pela lógica de obtenção do token
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default api;