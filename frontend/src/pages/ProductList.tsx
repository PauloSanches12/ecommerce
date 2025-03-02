import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import api from "../axiosClient";
import { Product, Category } from "../interfaces/product";
import { Meta, PaginationLinks } from "../interfaces/common";

const ProductList = () => {
    const [products, setProducts] = useState<Product[]>([]);
    const [categories, setCategories] = useState<Category[]>([]);
    const [selectedCategory, setSelectedCategory] = useState("");
    const [meta, setMeta] = useState<Meta | null>(null);
    const [links, setLinks] = useState<PaginationLinks | null>(null);
    const [currentPage, setCurrentPage] = useState(1);

    // Fetch produtos com paginação
    useEffect(() => {
        api.get(`/api/products?page=${currentPage}`).then((response) => {
            setProducts(response.data.data);
            setMeta(response.data.meta);
            setLinks(response.data.links);
        });
    }, [currentPage]);

    // Fetch categorias
    useEffect(() => {
        api.get("/api/categories").then((response) => {
            setCategories(response.data.data);
        });
    }, []);

    // Filtragem por categoria
    const filteredProducts = selectedCategory
        ? products.filter((product) => product.category.id === Number(selectedCategory))
        : products;

    return (
        <div className="container mx-auto p-4">
            {/* FILTRO POR CATEGORIA */}
            <div className="mb-4">
                <select
                    value={selectedCategory}
                    onChange={(e) => setSelectedCategory(e.target.value)}
                    className="border p-2"
                >
                    <option value="">Todas as Categorias</option>
                    {categories.map((category) => (
                        <option key={category.id} value={category.id}>
                            {category.name}
                        </option>
                    ))}
                </select>
            </div>

            {/* LISTA DE PRODUTOS */}
            <div>
                {filteredProducts.length === 0 ? (
                    <p className="text-gray-500">Nenhum produto encontrado.</p>
                ) : (
                    filteredProducts.map((product) => (
                        <div key={product.id} className="mb-4">
                            <Link to={`/products/${product.id}`} className="text-blue-500">
                                {product.name}
                            </Link>
                        </div>
                    ))
                )}
            </div>

            {/* CONTROLES DE PAGINAÇÃO */}
            {meta && (
                <div className="flex justify-center mt-6">
                    <button
                        className={`px-4 py-2 mr-2 border rounded ${links?.prev ? "bg-gray-200" : "bg-gray-100 cursor-not-allowed"}`}
                        disabled={!links?.prev}
                        onClick={() => setCurrentPage((prev) => Math.max(prev - 1, 1))}
                    >
                        Anterior
                    </button>
                    <span className="px-4 py-2 border rounded bg-gray-300">
                        Página {meta.current_page} de {meta.last_page}
                    </span>
                    <button
                        className={`px-4 py-2 ml-2 border rounded ${links?.next ? "bg-gray-200" : "bg-gray-100 cursor-not-allowed"}`}
                        disabled={!links?.next}
                        onClick={() => setCurrentPage((prev) => prev + 1)}
                    >
                        Próxima
                    </button>
                </div>
            )}
        </div>
    );
};

export default ProductList;
