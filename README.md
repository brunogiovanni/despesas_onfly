# Controle de despesas

Teste aplicado pela OnFly

**Requisitos:**
- PHP 8.1
- Composer
- Docker

Crie o arquivo .env antes de continuar, preenchendo os valores de usuário e senha do banco de dados. O restante, deixe igual ao .env.example.


**Para executar os containers:**

`vendor/bin/sail up -d`

**Migrations:**

`vendor/bin/sail php artisan migrate`

**Queue:**

Para monitorar a fila do Redis:

`vendor/bin/sail php artisan queue:monitor redis:default`

Para executar a fila:

`vendor/bin/sail php artisan queue:work`