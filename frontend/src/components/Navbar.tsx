import { Link } from 'react-router-dom';

const Navbar = () => {
    return (
        <nav className="bg-blue-500 p-4">
            <div className="container mx-auto flex justify-between">
                <Link to="/" className="text-white">
                    Ecommerce
                </Link>
                <div>
                    <Link to="/login" className="text-white mr-4">
                        Login
                    </Link>
                    <Link to="/register" className="text-white">
                        Register
                    </Link>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;