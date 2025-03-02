import { useState, useEffect, useMemo } from 'react';
import { Link } from 'react-router-dom';
import api from '../axiosClient';

interface Category {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
}

interface Product {
    id: number;
    name: string;
    description: string;
    price: string;
    image_url: string | null;
    category: Category;
    created_at: string;
    updated_at: string;
}

const ProductList = () => {
    const [products, setProducts] = useState<Product[]>([]);
    const [categories, setCategories] = useState<Category[]>([]);
    const [selectedCategory, setSelectedCategory] = useState<string>('');

    useEffect(() => {
        fetchCategories();
        fetchProducts();
    }, []);

    const fetchProducts = async () => {
        try {
            const response = await api.get('/api/products');
            setProducts(response.data.data);
        } catch (error) {
            console.error('Erro ao buscar produtos:', error);
        }
    };

    const fetchCategories = async () => {
        try {
            const response = await api.get('/api/categories');
            setCategories(response.data.data);
        } catch (error) {
            console.error('Erro ao buscar categorias:', error);
        }
    };

    // useMemo evita recomputação desnecessária ao filtrar produtos
    const filteredProducts = useMemo(() => {
        return selectedCategory
            ? products.filter(product => product.category.id === Number(selectedCategory))
            : products;
    }, [selectedCategory, products]);

    return (
        <div className="container mx-auto p-4">
            <div className="mb-4">
                <select
                    value={selectedCategory}
                    onChange={e => setSelectedCategory(e.target.value)}
                    className="border p-2"
                >
                    <option value="">Todas as Categorias</option>
                    {categories.map(category => (
                        <option key={category.id} value={category.id}>
                            {category.name}
                        </option>
                    ))}
                </select>
            </div>
            <div>
                {filteredProducts.length > 0 ? (
                    filteredProducts.map(product => (
                        <div key={product.id} className="mb-4">
                            <Link to={`/products/${product.id}`} className="text-blue-500 hover:underline">
                                {product.name}
                            </Link>
                        </div>
                    ))
                ) : (
                    <p className="text-gray-500">Nenhum produto encontrado.</p>
                )}
            </div>
        </div>
    );
};

export default ProductList;