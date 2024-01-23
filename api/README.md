# Aplicação desenvolvida para processo seletivo da Jukebox (API)

```plaintext
Verifique se as portas utilizadas pela aplicação definidas no arquivo docker-compose.yml estão sendo utilizadas por outra aplicação. Se estiverem sendo utilizadas troque para portas disponíveis na sua máquina.
```
- Clone o repositório

```bash
git clone git@github.com:MatheusHonorato/teste-tecnico-jukebox.git
```

- Acesse o diretório api

```bash
cd api
```

- Gere o arquivo .env a partir de .env.example

```bash
cp .env.example .env
```
- Agora crie um arquivo com o nome 'firebase_credentials.json' na raiz do diretório 'api' e cole todas as informações do arquivo que baixou do firebase ao gerar chave privada na etapa de configuração do firebase.

- Instale as dependências com composer no diretório 'api' (Se você não tem o composer configurado pode configura-lo de acordo com a documentação em: [https://getcomposer.org](https://getcomposer.org))

```bash
composer install
```

- Inicie os containers (garanta que está no diretório 'api' - vc pode verificar o diretório atual rodando o comando 'pwd' no linux). Obs: este processo pode ser demorado na primeira vez por que o docker precisa baixar e fazer o build de todas as imagens necessárias.

```bash
./vendor/bin/sail up -d
```

- Roder as migrations e seeders para inicializar a base de dados (Se você voltar na visão geral do seu projeto no item 'Authentication' no firebase perceberá que usuários foram criados. Obs: a senha de todos os usuários é 'password')

```bash
./vendor/bin/sail artisan migrate --seed
```

- Para listar os nomes das rotas gerados pelo resources acesso o diretório api e rode o comando a seguir:

```bash
./vendor/bin/sail artisan route:list --name
```

### Obs:

Na raiz do diretório api existe uma collection insomnia v4 em json para testes (insomnia.json).

- Para enviar uma notifiação de testes siga o exemplo Notification da coleção insomnia. (Lembre-se que as notificações devem estar habilitadas no navegador -  Você pode habilita-las clicando no icone ao lado esquerdo do endereço da pagina).

- Para enviar uma notificação você precisa de um access_token valido. Inspecione o front-end e pegue o access_token na aba 'Aplicativo', adicione o access token na sua requisição no insomnia na aba 'Bearer'.

- A rota de envio é a apenas para teste. Em uma solução mais próxima do real você pode a qualquer momento carregar um usuário e enviar a notificação para o dispositivo cadastrado na coluna fcm_token.

### Debug e ferramentas

- Configuração do xebug de acordo com: https://www.youtube.com/watch?v=iHad9TH9mOA

```json
"configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9000,
      "log": false,
      "externalConsole": false,
      "pathMappings": {
        "/var/www/html": "${workspaceFolder}"
      },
      "ignore": [
        "**/vendor/**/*.php"
      ]
    },
```

### Pontos de melhoria

- Aplicar camada resources para formatar retornos da api;
- Documentar api com swagger;
- Criar testes unitários e de integração.

