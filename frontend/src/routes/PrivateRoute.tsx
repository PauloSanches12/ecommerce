import { JSX, useContext } from 'react';
import { Navigate } from 'react-router-dom';
import { AuthContext } from '../contexts/AuthContext';

const PrivateRoute = ({ element }: { element: JSX.Element }) => {
    const { authToken } = useContext(AuthContext);
    return authToken ? element : <Navigate to="/login" />;
};

export default PrivateRoute;
