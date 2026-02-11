# Multi Contact Management

Sistema web para gerenciamento de pessoas e seus contatos telefônicos com códigos de país.

## Sobre o Projeto

Aplicação Laravel que permite cadastrar pessoas e seus múltiplos contatos telefônicos. Cada contato inclui o código do país (obtido via API) e um número de telefone. O sistema também gera avatares aleatórios para cada pessoa usando Robohash.

## Requisitos

- PHP 8.1 ou superior
- Composer
- MySQL 5.7+ ou MariaDB
- Extensões PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath

## Instalação

### 1. Clone o repositório

```bash
git clone <seu-repositorio>
cd alfasoft-contact-management
```

### 2. Instale as dependências

```bash
composer install
```

### 3. Configure o ambiente

Copie o arquivo de exemplo e edite com suas configurações:

```bash
cp .env.example .env
nano .env  # ou use seu editor preferido
```

Configure pelo menos estas variáveis no `.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

AVATAR_API_URL=https://www.dnd5eapi.co
COUNTRIES_API_URL=https://restcountries.com/v3.1
```

### 4. Gere a chave da aplicação

```bash
php artisan key:generate
```

### 5. Execute as migrations

```bash
php artisan migrate
```

### 6. Popule o banco com dados iniciais

```bash
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=PeopleSeeder  # opcional, dados de exemplo
```

### 7. Crie o link simbólico do storage

```bash
php artisan storage:link
```

### 8. Inicie o servidor

```bash
php artisan serve --port=8080
```

Acesse: `http://localhost:8080`

## Acesso ao Sistema

**Credenciais padrão:**
- Email: `admin@admin.com`
- Senha: `123456`

## Deploy em Produção

### No servidor via SSH:

```bash
# Clone e entre no diretório
git clone <seu-repositorio> .
cd seu-projeto

# Instale dependências (sem dev)
composer install --no-dev --optimize-autoloader

# Configure o .env
cp .env.example .env
nano .env

# Configure estas variáveis para produção:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

# Gere a chave
php artisan key:generate

# Execute migrations e seeders
php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder --force

# Link do storage
php artisan storage:link

# Otimize a aplicação
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Ajuste permissões
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Funcionalidades

- Cadastro, edição, visualização e remoção de pessoas
- Soft delete (pessoas podem ser recuperadas)
- Cadastro de múltiplos contatos por pessoa
- Dropdown pesquisável de países com AJAX (Select2)
- Validação de números únicos por país
- Geração automática de avatares (API D&D Monsters)
- Sistema de autenticação (login/logout)
- Cache de países (1 hora)
- Responsivo e interface limpa

## Tecnologias

- **Laravel 10** - Framework PHP
- **MySQL/MariaDB** - Banco de dados
- **RestCountries API** - Códigos de países
- **D&D 5e API** - Geração de avatares
- **Select2** - Dropdown pesquisável
- **Blade** - Template engine

## Estrutura Importante

```
app/
├── Http/Controllers/
│   ├── PersonController.php      # CRUD de pessoas
│   ├── ContactController.php     # CRUD de contatos
│   └── Auth/LoginController.php  # Autenticação
├── Models/
│   ├── Person.php                # Model de pessoas
│   └── Contact.php               # Model de contatos
└── Services/
    ├── AvatarService.php         # Integração API avatares
    └── CountryService.php        # Integração API países

database/
├── migrations/                   # Estrutura do banco
└── seeders/                      # Dados iniciais

resources/views/
├── people/                       # Views de pessoas
├── contacts/                     # Views de contatos
└── auth/                         # Views de autenticação
```

## Troubleshooting

### Erro: "No application encryption key"
```bash
php artisan key:generate
```

### Erro de permissão em storage/
```bash
chmod -R 775 storage bootstrap/cache
```

### Cache de países não atualiza
```bash
php artisan cache:clear
```

### Problemas com composer no PHP 8.1
O projeto está configurado para usar PHP 8.1. O `composer.json` já tem `platform: php 8.1.33`.

## Licença

Projeto desenvolvido para teste técnico Alfasoft.
