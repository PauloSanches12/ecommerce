export interface Category {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
}

export interface Product {
    id: number;
    name: string;
    description: string;
    price: string;
    image_url: string | null;
    category: Category;
    created_at: string;
    updated_at: string;
}
