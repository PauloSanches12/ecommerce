// import { useState } from 'react';
// import api from '../axiosClient';
// import { useNavigate } from 'react-router-dom';

const Register = () => {
    // const [name, setName] = useState('');
    // const [email, setEmail] = useState('');
    // const [password, setPassword] = useState('');
    // const navigate = useNavigate();

    // const handleSubmit = async (e) => {
    //     e.preventDefault();
    //     try {
    //         await api.post('/api/register', { name, email, password });
    //         navigate('/login');
    //     } catch (error) {
    //         console.error('Registration failed', error);
    //     }
    // };

    return (
        // <div className="container mx-auto p-4">
        //     <h1 className="text-2xl mb-4">Register</h1>
        //     <form onSubmit={handleSubmit}>
        //         <div className="mb-4">
        //             <label className="block mb-2">Name</label>
        //             <input
        //                 type="text"
        //                 value={name}
        //                 onChange={(e) => setName(e.target.value)}
        //                 className="border p-2 w-full"
        //             />
        //         </div>
        //         <div className="mb-4">
        //             <label className="block mb-2">Email</label>
        //             <input
        //                 type="email"
        //                 value={email}
        //                 onChange={(e) => setEmail(e.target.value)}
        //                 className="border p-2 w-full"
        //             />
        //         </div>
        //         <div className="mb-4">
        //             <label className="block mb-2">Password</label>
        //             <input
        //                 type="password"
        //                 value={password}
        //                 onChange={(e) => setPassword(e.target.value)}
        //                 className="border p-2 w-full"
        //             />
        //         </div>
        //         <button type="submit" className="bg-blue-500 text-white p-2">
        //             Register
        //         </button>
        //     </form>
        // </div>
        <h1>
            Register
        </h1>
    );
};

export default Register;