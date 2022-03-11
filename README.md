# Controle de despesas

**Requisitos:**
- PHP 8.1
- Composer
- Docker

#
**Já vem com configuração básica para o VSCode poder abrir o projeto dentro de container**
> Para isso, basta ter a extensão ___Remote - Containers___ da Microsoft
#

Suba os containers e em seguida execute o `composer install` para instalar os pacotes necessários.

_Se abrir pela conexão remota de container do vscode, execute os comandos pelo terminal do próprio editor._

Crie o arquivo _.env_, preenchendo os valores de usuário e senha do banco de dados e as configurações de e-mail. O restante, deixe igual ao _.env.example_.

**Migrations:**

`php artisan migrate`

**Queue:**

Para monitorar a fila do Redis:

`php artisan queue:monitor redis:default`

Para executar a fila:

`php artisan queue:work`

**Testes**

`php artisan test`