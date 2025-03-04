import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import api from "../services/axiosClient";
import { Product, Category } from "../interfaces/product";
import { Meta, PaginationLinks } from "../interfaces/pagination";

const ProductList = () => {
    const [products, setProducts] = useState<Product[]>([]);
    const [categories, setCategories] = useState<Category[]>([]);
    const [selectedCategory, setSelectedCategory] = useState("");
    const [searchQuery, setSearchQuery] = useState("");
    const [meta, setMeta] = useState<Meta | null>(null);
    const [links, setLinks] = useState<PaginationLinks | null>(null);
    const [currentPage, setCurrentPage] = useState(1);

    // 🔹 Função para buscar produtos com filtros
    const fetchProducts = () => {
        // Cria um objeto URLSearchParams para enviar os parâmetros de busca
        const params = new URLSearchParams();
        params.append("page", currentPage.toString());


        // Adiciona os filtros de pesquisa e categoria
        if (searchQuery) params.append("search", searchQuery);
        if (selectedCategory) params.append("category_id", selectedCategory);

        // Faz a requisição para a API
        api.get(`/api/products?${params.toString()}`).then((response) => {
            setProducts(response.data.data);
            setMeta(response.data.meta);
            setLinks(response.data.links);
        });
    };

    // 🔹 Atualiza produtos quando a página ou a pesquisa mudam
    useEffect(() => {
        fetchProducts();
    }, [currentPage, searchQuery, selectedCategory]);

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
            
            {/* CAMPO DE PESQUISA */}
            <div className="mb-4">
                <input
                    type="text"
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    placeholder="Pesquisar produto por nome ou descrição..."
                    className="border p-2 w-full rounded"
                />
            </div>

            {/* FILTRO POR CATEGORIA + BOTÃO DE ADICIONAR */}
            <div className="mb-4 flex justify-between items-center">
                {/* Seleção de categoria */}
                <select
                    value={selectedCategory}
                    onChange={(e) => setSelectedCategory(e.target.value)}
                    className="border p-2 rounded"
                >
                    <option value="">Todas as Categorias</option>
                    {categories.map((category) => (
                        <option key={category.id} value={category.id}>
                            {category.name}
                        </option>
                    ))}
                </select>

                {/* Botão para adicionar produto */}
                <Link
                    to="/add-product"
                    className="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800 m-0"
                >
                    Novo Produto
                </Link>
            </div>
            
            {/* LISTA DE PRODUTOS */}
            <div className="flex flex-wrap gap-4 justify-center">
                {filteredProducts.length === 0 ? (
                    <p className="text-gray-500">Nenhum produto encontrado.</p>
                ) : (
                    filteredProducts.map((product) => (
                        <div key={product.id} className="mb-4 p-4 border rounded max-w-xs">
                            {product.image_url && (
                                <img
                                    src={product.image_url}
                                    alt={product.name}
                                />
                            )}
                            <Link to={`/products/${product.id}`} className="text-blue-500 text-lg font-semibold">
                                {product.name}
                            </Link>
                            <p className="text-gray-600">
                                {product.description}
                            </p>
                        </div>
                    ))
                )}
            </div>


            {/* CONTROLES DE PAGINAÇÃO */}
            {meta && products.length > 0 && (
                <div className="flex justify-center mt-6">
                    <button
                        className={`px-4 py-2 mr-2 border rounded ${links?.prev ? "bg-gray-200 cursor-pointer" : "bg-gray-100 cursor-not-allowed"}`}
                        disabled={!links?.prev}
                        onClick={() => setCurrentPage((prev) => Math.max(prev - 1, 1))}
                    >
                        Anterior
                    </button>
                    <span className="px-4 py-2 border rounded bg-gray-300">
                        Página {meta.current_page} de {meta.last_page}
                    </span>
                    <button
                        className={`px-4 py-2 ml-2 border rounded ${links?.next ? "bg-gray-200 cursor-pointer" : "bg-gray-100 cursor-not-allowed"}`}
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
