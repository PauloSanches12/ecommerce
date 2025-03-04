import { useState, useContext } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../services/axiosClient';
import { AuthContext } from '../contexts/AuthContext';

const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [errors, setErrors] = useState<{ email?: string, password?: string, general?: string }>({});
    const navigate = useNavigate();
    const { setAuthToken } = useContext(AuthContext);

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setErrors({});

        const newErrors: { email?: string, password?: string, general?: string } = {};

        if (!email) newErrors.email = 'Email é obrigatório.';
        if (!password) newErrors.password = 'Senha é obrigatória.';

        if (Object.keys(newErrors).length > 0) {
            setErrors(newErrors);
            return;
        }

        try {
            const response = await api.post('/api/login', { email, password });

            if (response.data?.access_token) {
                // Salva o token e o email do usuário no localStorage
                setAuthToken(response.data.access_token, { email });

                // Redireciona para a página de listagem de produtos
                navigate('/products');
            } else {
                setErrors({ general: 'Erro ao obter token. Tente novamente.' });
            }
        } catch (error) {
            setErrors({ general: 'Credenciais inválidas. Verifique seu email e senha.' });
        }
    };

    return (
        <div className="container mx-auto p-4">
            <h1 className="text-2xl mb-4">Login</h1>
            {errors.general && <p className="text-red-500">{errors.general}</p>}
            <form onSubmit={handleSubmit}>
                <div className="mb-4">
                    <label className="block mb-2">Email</label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        className="border p-2 w-full"
                    />
                    {errors.email && <p className="text-red-500">{errors.email}</p>}
                </div>
                <div className="mb-4">
                    <label className="block mb-2">Password</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        className="border p-2 w-full"
                    />
                    {errors.password && <p className="text-red-500">{errors.password}</p>}
                </div>
                <button type="submit" className="bg-blue-500 text-white p-2 w-full cursor-pointer">
                    Login
                </button>
            </form>
        </div>
    );
};

export default Login;