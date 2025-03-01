import React from "react";

interface PaginationProps {
    currentPage: number;
    lastPage: number;
    onPageChange: (page: number) => void;
    hasPrevPage: boolean;
    hasNextPage: boolean;
}

const Pagination: React.FC<PaginationProps> = ({ currentPage, lastPage, onPageChange, hasPrevPage, hasNextPage }) => {
    return (
        <div className="flex justify-center mt-6">
            <button
                className={`px-4 py-2 mr-2 border rounded ${hasPrevPage ? "bg-gray-200 cursor-pointer" : "bg-gray-100 cursor-not-allowed"}`}
                disabled={!hasPrevPage}
                onClick={() => onPageChange(currentPage - 1)}
            >
                Anterior
            </button>
            <span className="px-4 py-2 border rounded bg-gray-300">
                Página {currentPage} de {lastPage}
            </span>
            <button
                className={`px-4 py-2 ml-2 border rounded ${hasNextPage ? "bg-gray-200 cursor-pointer" : "bg-gray-100 cursor-not-allowed"}`}
                disabled={!hasNextPage}
                onClick={() => onPageChange(currentPage + 1)}
            >
                Próxima
            </button>
        </div>
    );
};

export default Pagination;