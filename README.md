Laravel Project (Docker + Redis + Xdebug)

Este projeto utiliza o Docker para padronizar o ambiente de desenvolvimento, garantindo que todos os serviços (PHP, Nginx, MySQL, Redis) rodem isoladamente.
🛠 Pré-requisitos
    Docker instalado.
    Docker Compose (geralmente já vem com o Desktop).
    
🏁 Passo a Passo Inicial
Siga estas etapas para colocar o projeto de pé:
1. Configurar Variáveis de Ambiente
    O projeto depende de um arquivo .env. Clone o exemplo padrão: cp .env.example .env

2. Ajuste o docker-composeyml
    Antes de rodar o container, precisa verificar as configurações do banco de dados em:
    <img width="512" height="258" alt="image" src="https://github.com/user-attachments/assets/e50bbd54-502a-403a-a21b-fcfb1aaaf2c3" />

    
3. Ajustar Nomes e Credenciais
    Abra o arquivo .env e verifique se as variáveis de conexão batem com o que você definiu no seu docker-compose.yml:
    - APP_NAME: O nome do seu projeto.
    - DB_HOST: Geralmente db ou mysql (o nome do serviço no docker-compose).
    - REDIS_HOST: Geralmente redis.
      <img width="207" height="141" alt="image" src="https://github.com/user-attachments/assets/2ff2e6de-3de4-455a-ae62-bc6fc75c2030" />


3. Subir os Containers
    - Execute o comando abaixo para construir as imagens e iniciar os serviços em segundo plano: docker-compose up -d

4. Instalar Dependências e Gerar Key
    Agora, rode os comandos do Composer e a chave da aplicação de dentro do container PHP:
        1. docker-compose exec app composer install
        2. docker-compose exec app php artisan key:generate
        3. docker-compose exec app php artisan migrate

🐞 Configuração do Xdebug (VS Code)
Para que o Xdebug funcione corretamente com o Docker, você precisará criar um arquivo .vscode/launch.json com a seguinte configuração:
    {
        "version": "0.2.0",
        "configurations": [
            {
                "name": "Listen for Xdebug",
                "type": "php",
                "request": "launch",
                "port": 9003,
                "pathMappings": {
                    "/var/www/html": "${workspaceRoot}"
                }
            }
        ]
    }

Observações: O docker depende do php/DockerFile. Mas deixei o mesmo configurado para executar o container. O mesmo serve para o xdebug que está configurado a porta e o host em php/xdebug.ini.
Dica: Certifique-se de que a porta no launch.json é a mesma configurada no seu arquivo de configuração do PHP/Xdebug (o padrão moderno é a 9003).

🌐 Acesso
    Aplicação: http://localhost
    Redis: Porta 6379 (se exposta no compose)
