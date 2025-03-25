import { useState, useEffect, useTransition } from 'react';
import { Link, useParams, useNavigate } from 'react-router-dom';
import api from '../services/axiosClient';
import { Product } from '../interfaces/product';
import Button from '../components/Button';

const ProductDetails = () => {
    const { id } = useParams<{ id: string }>();
    const [product, setProduct] = useState<Product | null>(null);
    const [error, setError] = useState<string | null>(null);
    const [isPending, startTransition] = useTransition();
    const navigate = useNavigate();

    useEffect(() => {
        // Função para buscar um produto pelo ID
        const fetchProduct = async () => {
            try {
                const response = await api.get<{ data: Product }>(`/api/products/${id}`);
                startTransition(() => {
                    setProduct(response.data.data);
                });
            } catch (err) {
                console.error('Erro ao buscar produto:', err);
                setError('Erro ao carregar o produto. Tente novamente mais tarde.');
            }
        };

        fetchProduct();
    }, [id]);

    const handleDelete = async () => {
        try {
            const response = await api.delete(`/api/products/${id}`);
            if (response.status === 204) {
                // Produto excluído com sucesso, redireciona para a lista de produtos
                navigate('/products');
                return;
            }

            setError('Erro ao excluir o produto. Tente novamente mais tarde.');
        } catch (err) {
            console.error('Erro ao excluir produto:', err);
            setError('Ocorreu um erro ao excluir o produto.');
        }
    };

    if (isPending) return <div className="text-gray-500">Carregando...</div>;
    if (error) return <div className="text-red-500">{error}</div>;
    if (!product) return <div className="text-gray-500">Produto não encontrado.</div>;

    return (
        <div className="container mx-auto p-4 flex flex-col items-center justify-center">
            <div className="mb-6 w-full text-left">
                <Link
                    to="/products"
                    className='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer'
                >
                    Voltar
                </Link>
            </div>
            <h1 className="text-2xl font-bold mb-4">{product.name}</h1>
            {product.image_url && (
                <img
                    src={product.image_url}
                    alt={product.name}
                    className="w-full max-w-md mx-auto mb-4 border border-black rounded"
                />
            )}
            <p className="text-lg text-center">{product.description}</p>
            <p className="text-xl font-semibold mt-2 text-center">Preço: R$ {product.price}</p>
            <p className="text-sm text-gray-600 mt-2 text-center">
                Categoria: <span className="font-medium">{product.category.name}</span>
            </p>

            <div className="flex mt-3">
                <Link to={`/products/${id}/edit`} className="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900 cursor-pointer">
                    Editar Produto
                </Link>
                <Button
                    onClick={handleDelete}
                    className="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 cursor-pointer">
                    Excluir Produto
                </Button>
            </div>
        </div>
    );
};

export default ProductDetails;