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
- Agora crie um arquivo com o nome **firebase_credentials.json** na raiz do diretório **api** e cole todas as informações do arquivo que baixou do firebase ao gerar chave privada na etapa de configuração do firebase.

- Instale as dependências com composer no diretório **api** (Se você não tem o composer configurado pode configura-lo de acordo com a documentação em: [https://getcomposer.org](https://getcomposer.org))

```bash
composer install
```

- Inicie os containers (garanta que está no diretório **api** - vc pode verificar o diretório atual rodando o comando **pwd** no linux). Obs: este processo pode ser demorado na primeira vez por que o docker precisa baixar e fazer o build de todas as imagens necessárias.

```bash
./vendor/bin/sail up -d
```

- Rodar as migrations e seeders para inicializar a base de dados (Se você voltar na visão geral do seu projeto no item **Authentication** no firebase perceberá que usuários foram criados. Obs: a senha de todos os usuários é **password**)

```bash
./vendor/bin/sail artisan migrate --seed
```

- Rodar as migrations para inicializar a base de testes.

```bash
./vendor/bin/sail artisan --env=testing  migrate
```

- Para executar os testes rode o comando a seguir:

```bash
./vendor/bin/sail artisan test
```

- Para listar os nomes das rotas gerados pelo resources acesso o diretório api e rode o comando a seguir:

```bash
./vendor/bin/sail artisan route:list --name
```

- Para atualizar a documentação no sweagger.

```bash
./vendor/bin/sail artisan l5-swagger:generate
```

- Para utilizar a documentação do sweagger acesse: **http://localhost/docs**.
 
- O disparo de notificações está sendo enviado para uma fila. Para executar os jobs da fila que estamos utilizando rode o comando a seguir:

```bash
./vendor/bin/sail artisan queue:work --queue=firebase
```

- Se deseja trabalhar com filas utilizando o Horizon e acompanhar pelo dashboard rode o comando a seguir:

```bash
./vendor/bin/sail artisan horizon
```

- Para garantir o estilo de código PHP de acordo com as PSR's você pode acessar o container da aplicação e rodar o fixer Laravel Pint:

  - Rodando Laravel Pint
```bash
./vendor/bin/sail pint
```

### Obs:

- Para enviar uma notifiação de testes siga o exemplo Notification em /docs. (Lembre-se que as notificações devem estar habilitadas no navegador - Você pode habilita-las clicando no icone ao lado esquerdo do endereço da pagina).

- Para enviar uma notificação você precisa de um access_token valido. Inspecione o front-end e pegue o access_token na aba **Aplicativo**, adicione o access token no swagger.

- A rota de envio é a apenas para teste. Em uma solução mais próxima do real você pode a qualquer momento carregar um usuário e enviar a notificação para o dispositivo cadastrado na coluna **fcm_token**.

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

Observação: Se necessário executar algum comando dentro dos containers por meio de docker exec certifique-se de não executá-lo com o usuário root de dentro do container para evitar problemas de permissão ao acessr arquivos no sistema hospedeiro.

Sugestões de melhoria

- Implementação de testes de unidade
- Implementação de fluxo Gitflow utilizando branchs como: master, develop, feature, release, hotfix. Ex: https://www.youtube.com/watch?v=xC7frT2JPGE, https://www.youtube.com/watch?v=OYd7F-9qucc
- Implementação Git Semantic Versioning
- Implementação PHP Stan
- Implementação de SSL
- Implementação script CI/CD

explicação conventional commits: https://www.youtube.com/watch?v=sStBPj7JJpM