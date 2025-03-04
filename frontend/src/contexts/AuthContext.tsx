import { createContext, useState, useEffect } from 'react';
import api from '../services/axiosClient';
import { AuthContextType } from '../interfaces/authContext';

// Criação do contexto AuthContext
export const AuthContext = createContext<AuthContextType>({
    authToken: null,
    user: null,
    setAuthToken: () => { },
    logout: () => { },
});

// Criação do componente AuthProvider
export const AuthProvider = ({ children }: { children: React.ReactNode }) => {
    const [authToken, setAuthTokenState] = useState<string | null>(
        localStorage.getItem('authToken')
    );
    const [user, setUser] = useState<{ email: string } | null>(
        JSON.parse(localStorage.getItem('user') || 'null')
    );

    useEffect(() => {
        if (authToken) {
            api.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
        } else {
            delete api.defaults.headers.common['Authorization'];
        }
    }, [authToken]);

    // Função para salvar o token e o email do usuário
    const setAuthToken = (token: string | null, user: { email: string } | null) => {
        setAuthTokenState(token);
        setUser(user);
        if (token && user) {
            localStorage.setItem('authToken', token);
            localStorage.setItem('user', JSON.stringify(user));
        } else {
            localStorage.removeItem('authToken');
            localStorage.removeItem('user');
        }
    };

    // Função para fazer logout
    const logout = async () => {
        try {
            await api.post('/api/logout');
        } catch (error) {
            console.error('Erro ao fazer logout:', error);
        } finally {
            setAuthToken(null, null);
        }
    };

    return (
        <AuthContext.Provider value={{ authToken, user, setAuthToken, logout }}>
            {children}
        </AuthContext.Provider>
    );
};