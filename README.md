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

4. Copie o arquivo de exemplo `.env` para criar seu próprio arquivo `.env`:

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

## Acessando a Aplicação

Após seguir os passos acima, você pode acessar a aplicação em `http://localhost:8000`.