# E-commerce

Projeto E-commerce. Utilizando React, TypeScript, Tailwind CSS, Laravel 12, MySQL, PHP 8.4, Nginx e Docker, autenticação com Laravel Sanctum.

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

#### Todas as rotas com exceção de `/api/login` e `/api/register` ao serem acessadas pelo insomnia/postman precisam ter no `Headers` o `Authorization Bearer Token` gerado ao realizar o login em `/api/login`. Todas as rotas precisam do `Accept: application/json` no `Headers`.

#### Obs: Antes de cadastrar um produto, é necessário criar uma `Categoria` pela `API` via insomnia/postman.

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

## Utilizando as Rotas da API

### Autenticação e Usuário

#### Registrar um Usuário

- **Rota:** `/api/register`
- **Método:** POST
- **Headers:**
  - `Accept: application/json`
- **JSON:**
  ```json
  {
    "name": "Seu Nome",
    "email": "seuemail@example.com",
    "password": "sua_senha",
    "password_confirmation": "sua_senha"
  }
  ```

#### Login de Usuário

- **Rota:** `/api/login`
- **Método:** POST
- **Headers:**
  - `Accept: application/json`
- **JSON:**
  ```json
  {
    "email": "seuemail@example.com",
    "password": "sua_senha"
  }
  ```

#### Logout de Usuário

- **Rota:** `/api/logout`
- **Método:** POST
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`

#### Obter Dados do Usuário Logado

- **Rota:** `/api/user`
- **Método:** GET
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`

### Produtos

#### Listar Produtos

- **Rota:** `/api/products`
- **Método:** GET
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`

#### Listar detalhes de um Produto

- **Rota:** `/api/products/{id}`
- **Método:** GET
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`

#### Criar Produto

- **Rota:** `/api/products`
- **Método:** POST
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`
- **JSON:**
  ```json
  {
    "name": "Nome do Produto",
    "description": "Descrição do Produto",
    "price": "Preço do Produto.",
    "image_url": "URL da Imagem do Produto",
    "category_id": 1
  }
  ```

#### Atualizar Produto

- **Rota:** `/api/products/{id}`
- **Método:** PUT
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`
- **JSON:**
  ```json
  {
    "name": "Nome do Produto Atualizado",
    "description": "Descrição Atualizada",
    "price": "Preço Atualizado",
    "image_url": "URL da Imagem Atualizada",
    "category_id": 1
  }
  ```

#### Excluir Produto

- **Rota:** `/api/products/{id}`
- **Método:** DELETE
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`

#### Listar Produtos por Categoria

- **Rota:** `/api/products?category={id}`
- **Método:** GET
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`

#### Listar Produtos por Nome ou Descrição

- **Rota:** `/api/products?search={query}`
- **Método:** GET
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`

### Categorias

#### Listar todas as Categorias

- **Rota:** `/api/categories`
- **Método:** GET
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`

#### Criar uma Categoria

- **Rota:** `/api/categories`
- **Método:** POST
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`
- **JSON:**
  ```json
  {
    "name": "Nome da Categoria"
  }
  ```

#### Atualizar uma Categoria

- **Rota:** `/api/categories/{id}`
- **Método:** PUT
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`
- **JSON:**
  ```json
  {
    "name": "Nome da Categoria Atualizada"
  }
  ```

#### Excluir uma Categoria

- **Rota:** `/api/categories/{id}`
- **Método:** DELETE
- **Headers:**
  - `Authorization: Bearer Token`
  - `Accept: application/json`