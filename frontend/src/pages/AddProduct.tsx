import { useState, useContext } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../services/axiosClient';
import { AuthContext } from '../contexts/AuthContext';

const AddProduct = () => {
    const [name, setName] = useState('');
    const [description, setDescription] = useState('');
    const [price, setPrice] = useState('');
    const [imageUrl, setImageUrl] = useState('');
    const [categoryId, setCategoryId] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const { authToken } = useContext(AuthContext);

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setError('');

        if (!authToken) {
            setError('Você precisa estar logado para adicionar um produto.');
            return;
        }

        try {
            const response = await api.post('/api/products', {
                name,
                description,
                price: parseFloat(price),
                image_url: imageUrl,
                category_id: parseInt(categoryId, 10),
            });

            if (response.status === 201) {
                navigate('/products');
            } else {
                setError('Erro ao adicionar produto. Tente novamente.');
            }
        } catch (error) {
            setError('Erro ao adicionar produto. Verifique os dados e tente novamente.');
        }
    };

    return (
        <div className="container mx-auto p-4">
            <h1 className="text-2xl mb-4">Adicionar Produto</h1>
            {error && <p className="text-red-500">{error}</p>}
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
                </div>
                <div className="mb-4">
                    <label className="block mb-2">Descrição</label>
                    <input
                        type="text"
                        value={description}
                        onChange={(e) => setDescription(e.target.value)}
                        className="border p-2 w-full"
                        required
                    />
                </div>
                <div className="mb-4">
                    <label className="block mb-2">Preço</label>
                    <input
                        type="number"
                        step="0.01"
                        value={price}
                        onChange={(e) => setPrice(e.target.value)}
                        className="border p-2 w-full"
                        required
                    />
                </div>
                <div className="mb-4">
                    <label className="block mb-2">URL da Imagem</label>
                    <input
                        type="url"
                        value={imageUrl}
                        onChange={(e) => setImageUrl(e.target.value)}
                        className="border p-2 w-full"
                        required
                    />
                </div>
                <div className="mb-4">
                    <label className="block mb-2">ID da Categoria</label>
                    <input
                        type="number"
                        value={categoryId}
                        onChange={(e) => setCategoryId(e.target.value)}
                        className="border p-2 w-full"
                        required
                    />
                </div>
                <button type="submit" className="bg-blue-500 text-white p-2 w-full">
                    Cadastrar Produto
                </button>
            </form>
        </div>
    );
};

export default AddProduct;