import { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import api from '../axiosClient';
import { Product } from '../interfaces/product';

const ProductDetails = () => {
    const { id } = useParams<{ id: string }>();
    const [product, setProduct] = useState<Product | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchProduct = async () => {
            try {
                const response = await api.get<{ data: Product }>(`/api/products/${id}`);
                setProduct(response.data.data);
            } catch (err) {
                console.error('Erro ao buscar produto:', err);
                setError('Erro ao carregar o produto. Tente novamente mais tarde.');
            } finally {
                setLoading(false);
            }
        };

        fetchProduct();
    }, [id]);

    if (loading) return <div className="text-gray-500">Carregando...</div>;
    if (error) return <div className="text-red-500">{error}</div>;
    if (!product) return <div className="text-gray-500">Produto não encontrado.</div>;

    return (
        <div className="container mx-auto p-4">
            <h1 className="text-2xl font-bold mb-4">{product.name}</h1>
            {product.image_url && (
                <img src={product.image_url} alt={product.name} className="w-full max-w-md mx-auto mb-4" />
            )}
            <p className="text-lg">{product.description}</p>
            <p className="text-xl font-semibold mt-2">Preço: R$ {product.price}</p>
            <p className="text-sm text-gray-600 mt-2">
                Categoria: <span className="font-medium">{product.category.name}</span>
            </p>
        </div>
    );
};

export default ProductDetails;
