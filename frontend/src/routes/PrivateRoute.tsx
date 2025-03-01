import { JSX, useContext } from 'react';
import { Navigate } from 'react-router-dom';
import { AuthContext } from '../contexts/AuthContext';

const PrivateRoute = ({ element }: { element: JSX.Element }) => {
    const { authToken } = useContext(AuthContext);

    if (!authToken) {
        // Se não estiver autenticado, redireciona para a página de login
        return <Navigate to="/" replace />;
    }

    // Se estiver autenticado, renderiza o componente protegido
    return element;
};

export default PrivateRoute;