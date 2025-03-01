import { useState, useEffect, useContext } from 'react';
import { Link, useParams, useNavigate } from 'react-router-dom';
import api from '../services/axiosClient';
import { AuthContext } from '../contexts/AuthContext';
import { Product } from '../interfaces/product';
import Button from '../components/Button';

const EditProduct = () => {
    const { id } = useParams<{ id: string }>();
    const [name, setName] = useState('');
    const [description, setDescription] = useState('');
    const [price, setPrice] = useState('');
    const [imageUrl, setImageUrl] = useState('');
    const [categoryId, setCategoryId] = useState('');
    const [errors, setErrors] = useState<{ name?: string, description?: string, price?: string, imageUrl?: string, categoryId?: string, general?: string }>({});
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    const { authToken } = useContext(AuthContext);

    useEffect(() => {
        // Função para buscar um produto pelo ID
        const fetchProduct = async () => {
            try {
                const response = await api.get<{ data: Product }>(`/api/products/${id}`);
                const product = response.data.data;
                setName(product.name);
                setDescription(product.description);
                setPrice(product.price.toString());
                setImageUrl(product.image_url ?? '');
                setCategoryId(product.category.id.toString());
            } catch (err: any) {
                console.error('Erro ao buscar produto:', err);
                setErrors({ general: 'Erro ao carregar o produto. Tente novamente mais tarde.' });
            } finally {
                setLoading(false);
            }
        };

        fetchProduct();
    }, [id]);

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setErrors({});

        const newErrors: { name?: string, description?: string, price?: string, imageUrl?: string, categoryId?: string, general?: string } = {};

        if (!name) newErrors.name = 'Nome é obrigatório.';
        if (!description) newErrors.description = 'Descrição é obrigatória.';
        if (!price) newErrors.price = 'Preço é obrigatório.';
        if (!imageUrl) newErrors.imageUrl = 'URL da Imagem é obrigatória.';
        if (!categoryId) newErrors.categoryId = 'ID da Categoria é obrigatório.';

        if (Object.keys(newErrors).length > 0) {
            setErrors(newErrors);
            return;
        }

        if (!authToken) {
            setErrors({ general: 'Você precisa estar logado para editar um produto.' });
            return;
        }

        try {
            const response = await api.put(`/api/products/${id}`, {
                name,
                description,
                price: parseFloat(price),
                image_url: imageUrl,
                category_id: parseInt(categoryId, 10),
            });

            if (response.status === 200) {
                navigate('/products');
                return;
            }

            setErrors({ general: 'Erro ao editar produto. Tente novamente.' });
        } catch (error: any) {
            if (error.response && error.response.status === 404) {
                setErrors({ categoryId: 'ID da Categoria não existe.' });
                return;
            }
            console.error('Erro ao editar produto:', error);
            setErrors({ general: 'Ocorreu um erro ao editar o produto.' });
        }
    };

    if (loading) return <div className="text-gray-500">Carregando...</div>;
    if (errors.general) return <div className="text-red-500">{errors.general}</div>;

    return (
        <div className="container mx-auto p-4">
            <div className='mb-6'>
                <Link
                    to="/products"
                    className='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer'
                >
                    Voltar
                </Link>
            </div>
            <h1 className="text-2xl mb-4">Editar Produto</h1>
            {errors.general && <p className="text-red-500">{errors.general}</p>}
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
                    <label className="block mb-2">Descrição</label>
                    <input
                        type="text"
                        value={description}
                        onChange={(e) => setDescription(e.target.value)}
                        className="border p-2 w-full"
                        required
                    />
                    {errors.description && <p className="text-red-500">{errors.description}</p>}
                </div>
                <div className="mb-4">
                    <label className="block mb-2">Preço</label>
                    <input
                        type="number"
                        step="0.01"
                        value={price}
                        onChange={(e) => setPrice(e.target.value)}
                        className="border p-2 w-full"
                        min={0}
                        required
                    />
                    {errors.price && <p className="text-red-500">{errors.price}</p>}
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
                    {errors.imageUrl && <p className="text-red-500">{errors.imageUrl}</p>}
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
                    {errors.categoryId && <p className="text-red-500">{errors.categoryId}</p>}
                </div>
                <Button type="submit" className="bg-blue-500 text-white p-2 w-full cursor-pointer">
                    Atualizar Produto
                </Button>
            </form>
        </div>
    );
};

export default EditProduct;