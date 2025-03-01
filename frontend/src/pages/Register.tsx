import { useState, FormEvent } from 'react';
import api from '../services/axiosClient';
import { useNavigate } from 'react-router-dom';
import Button from '../components/Button';

const Register = () => {
    const [name, setName] = useState<string>('');
    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const [passwordConfirmation, setPasswordConfirmation] = useState<string>('');
    const [errors, setErrors] = useState<{ name?: string, email?: string, password?: string, passwordConfirmation?: string }>({});
    const navigate = useNavigate();

    const handleSubmit = async (e: FormEvent) => {
        e.preventDefault();

        const newErrors: { name?: string, email?: string, password?: string, passwordConfirmation?: string } = {};

        if (!name) newErrors.name = 'Nome é obrigatório.';
        if (!email) newErrors.email = 'Email é obrigatório.';
        if (!password) newErrors.password = 'Senha é obrigatória.';
        if (password !== passwordConfirmation) newErrors.passwordConfirmation = 'As senhas não coincidem.';

        setErrors(newErrors);

        if (Object.keys(newErrors).length > 0) {
            return;
        }

        try {
            await api.post('/api/register', { name, email, password, password_confirmation: passwordConfirmation });
            navigate('/login');
        } catch (error) {
            console.error('Falha no registro', error);
        }
    };

    return (
        <div className="container mx-auto p-4">
            <h1 className="text-2xl mb-4">Novo Registro</h1>
            <form onSubmit={handleSubmit}>
                <div className="mb-4">
                    <label className="block mb-2">Nome</label>
                    <input
                        type="text"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        className="border p-2 w-full"
                        required
                    />
                    {errors.name && <p className="text-red-500">{errors.name}</p>}
                </div>
                <div className="mb-4">
                    <label className="block mb-2">Email</label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        className="border p-2 w-full"
                        required
                    />
                    {errors.email && <p className="text-red-500">{errors.email}</p>}
                </div>
                <div className="mb-4">
                    <label className="block mb-2">Senha</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        className="border p-2 w-full"
                        required
                    />
                    {errors.password && <p className="text-red-500">{errors.password}</p>}
                </div>
                <div className="mb-4">
                    <label className="block mb-2">Confirmar Senha</label>
                    <input
                        type="password"
                        value={passwordConfirmation}
                        onChange={(e) => setPasswordConfirmation(e.target.value)}
                        className="border p-2 w-full"
                        required
                    />
                    {errors.passwordConfirmation && <p className="text-red-500">{errors.passwordConfirmation}</p>}
                </div>
                <Button type="submit" className="bg-blue-500 text-white p-2 w-full cursor-pointer">
                    Registrar
                </Button>
            </form>
        </div>
    );
};

export default Register;