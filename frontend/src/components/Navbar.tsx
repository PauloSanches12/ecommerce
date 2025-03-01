import { useContext } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { AuthContext } from '../contexts/AuthContext';

const Navbar = () => {
    const { user, logout } = useContext(AuthContext);
    const navigate = useNavigate();

    const handleLogout = async () => {
        await logout();
        navigate('/'); 
    };

    return (
        <nav className="bg-blue-500 p-4">
            <div className="container mx-auto flex justify-between">
                <Link to="/products" className="text-white text-2xl">
                    E-commerce
                </Link>
                <div>
                    {user ? (
                        <>
                            <span className="text-white mr-4">{user.email}</span>
                            <button onClick={handleLogout} className="text-white cursor-pointer">
                                Logout
                            </button>
                        </>
                    ) : (
                        <>
                            <Link to="/login" className="text-white mr-4 cursor-pointer">
                                Login
                            </Link>
                                <Link to="/register" className="text-white cursor-pointer">
                                Register
                            </Link>
                        </>
                    )}
                </div>
            </div>
        </nav>
    );
};

export default Navbar;