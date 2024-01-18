# Aplicação desenvolvida para processo seletivo da Jukebox (Front-End)

* Para inicializar o projeto corretamente você precisa previamente configurar sua conta e app no firebase (De acordo com o README da api), feito isso podemos prosseguir.

Obs: Verifique se a porta 8080 da sua maquina já está sendo utilizada. Caso esteja atualize a porta.

- Gere o arquivo .env a partir de .env.example

```bash
cp .env.example .env
```

- Preencha as constantes do .env com os valores da constante 'firebaseConfig' obtida na etapa de configuração do firebase;
- A última constante do arquivo 'VUE_APP_FIREBASE_PUBLIC_KEYS' é preenchida com a chave publica da aplicação obtida na etapa de configuração do projeto na aba 'Cloud Messaging' da sessão 'Configurações do projeto'.

- Acesse o diretório public e gere o arquivo firebase-messaging-sw.js a partir de firebase-messaging-sw.example.js

```bash
cp firebase-messaging-sw.example.js firebase-messaging-sw.js
```

- Edite o arquivo firebase-messaging-sw.js adicionando as chaves de 'firebaseConfig' (O .env não é acessivel aqui por isso as chaves devem ser preenchidas de maneira literal).

- Volte a raiz do projeto 'front' e instale as dependências

```bash
npm i
```

- Rode a aplicação

```bash
npm run serve
```

- Acesse a aplicação em http://localhost:8080;

- Ao autenticar na aplicação se não for carregada uma task para o usuário autenticado pressione Ctrl+F5.

Obs: Se ao trocar de usuário for exibido task de outro provavelmente é cache do próprio navegador então pressione Ctrl + F5 para resolver o problema.

### Pontos de melhoria e ajustes

- Refatorar para typescript;
- Configurar um gerenciador de estado como vuex ou pinia;
- Cache no front-end gerando pequenos erros.
