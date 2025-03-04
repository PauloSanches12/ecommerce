# E-commerce

Projeto E-commerce. Utilizando Laravel 12, MySQL, PHP 8.4, Nginx e Docker.

## Pré-requisitos

Antes de iniciar, certifique-se de ter o Docker e o Docker Compose instalados em sua máquina.

## Passo a passo para rodar o backend

1. Clone o repositório:

    ```bash
    git clone git@github.com:PauloSanches12/ecommerce.git
    ```

2. Navegue até o diretório do projeto:

    ```bash
    cd ecommerce
    ```

3. Navegue até o diretório do backend:

    ```bash
    cd backend
    ```

4. Copie o arquivo de exemplo `.env.example` para criar seu próprio arquivo `.env`:

    ```bash
    cp .env.example .env
    ```

5. Construa e inicie os contêineres do Docker:

    ```bash
    docker-compose up --build -d
    ```

6. Acesse o contêiner do aplicativo:

    ```bash
    docker-compose exec app bash
    ```

7. Instale as dependências do Composer:

    ```bash
    composer install
    ```

8. Gere a chave da aplicação:

    ```bash
    php artisan key:generate
    ```

9. Execute as migrações do banco de dados:

    ```bash
    php artisan migrate
    ```
## Passo a passo para rodar o frontend

1. Navegue até o diretório do frontend:

    ```bash
    cd ecommerce
    cd frontend
    ```

2. Construa e inicie o contêiner do Docker:

    ```bash
    docker-compose up --build
    ```

3. Acesse a aplicação frontend em `http://localhost:5173`.

## Acessando a Aplicação Backend

Após seguir os passos acima, você pode acessar a aplicação em `http://localhost:8000`.

## Rotas da Aplicação Backend

### Todas as rotas precisam ter no `Headers` o `Accept: application/json`.

### Tabela de Rotas

| Rotas                              | Método | Descrição                                |
|-----------------------------------|--------|------------------------------------------|
| `/api/register`                   | POST   | Registrar um Usuário                     |
| `/api/login`                      | POST   | Login de Usuário                         |
| `/api/user`                       | GET    | Obter Dados do Usuário Logado            |
| `/api/logout`                     | POST   | Logout do Usuário                        |
| `/api/products`                   | GET    | Listar Produtos                          |
| `/api/products/{id}`              | GET    | Listar detalhes de um Produto            |
| `/api/products`                   | POST   | Criar Produto                            |
| `/api/products/{id}`              | PUT    | Atualizar Produto                        |
| `/api/products/{id}`              | DELETE | Excluir Produto                          |
| `/api/products?category={id}`     | GET    | Listar Produtos por Categoria            |
| `/api/products?search={query}`    | GET    | Listar Produtos por Nome ou Descrição    |
| `/api/categories`                 | GET    | Listar todas as Categorias               |
| `/api/categories`                 | POST   | Criar uma Categoria                      |
| `/api/categories/{id}`            | PUT    | Atualizar uma Categoria                  |
| `/api/categories/{id}`            | DELETE | Excluir uma Categoria                    |