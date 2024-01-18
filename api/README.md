# Aplicação desenvolvida para processo seletivo da Jukebox (API)

* Para inicializar o projeto corretamente utilizando Laravel Sail você deve ter docker e docker-compose instalados e já ter configurado um app no firebase. (Logo a seguir é mostrado como configurar o app).

Passo a passo para instalar o docker em seu sistema operacional

[https://www.docker.com/get-started](https://www.docker.com/get-started)

Após a instalação do docker você pode configurar o seu app no firebase de acordo com os passos a seguir:

- Crie uma conta no firebase (ou autentique com sua conta google);
- Após autenticado selecione a opção adicionar projeto;
- Dê um nome ao seu projeto;
- Não é necessario ativar o google analytics para estes testes;
- Clique em 'Criar projeto';
- A visão geral do seu projeto será carregada;
- Aclique no botão '</>' para iniciar uma integração com nosso app web;
- De um apelido a integração e clique em registrar app;
- Agora serão exibidos os seus dados de autenticação no firebase;
- Guarde as chaves contidads na constante 'firebaseConfig' (Precisaremos utiliza-las posteriormente);
- Clique em continuar no console;
- No botão ao lado esquerdo de '+ Adicionar app' selecione a sua integração;
- Acesse a aba 'Cloud Messaging';
- Clique em 'Generate key pair';
- Guarde a chave exibida (Precisaremos utiliza-las posteriormente);
- Agora acesse novamente 'Configurações do projeto' e acesse a aba 'Contas de serviço', clique em gerar nova chave privada e confirme (Guarde o arquivo gerado pois precisaremos mais tarde);
- Agora habilitaremos a autenticação na nossa integração: Acesse a visão geral do projeto, clique em 'Authentication' na lateral esquerda e confirme;
- Dentro de 'Authentication' acesse a aba 'Sign-in method' e habilite a autenticação por e-mail e senha.

Passo a passo para rodar a api

- Verifique se as portas utilizadas pela aplicação definidas no arquivo docker-compose.yml estão sendo utilizadas por outra aplicação. Se estiverem sendo utilizadas troque para portas disponíveis na sua máquina.

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

- Para enviar uma notificação você precisa de um access_token valido. Inspecione o front-end e pegue o access_token na aba 'Aplicativo', adicione o access token  na sua requisição no insomnia na aba 'Bearer'.

- A rota de envio é a apenas para teste. Em uma solução mais próxima do real você pode a qualquer momento carregar um usuário e enviar a notificação para o dispositivo cadastrado na coluna fcm_token.

### Pontos de melhoria

- Aplicar camada resources para formatar retornos da api;
- Documentar api com swagger;
- Criar testes unitários e de integração.

