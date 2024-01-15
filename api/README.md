# Aplicação desenvolvida para processo seletivo da Jukebox

* Para inicializar o projeto utilizando Laravel Sail você deve ter docker e docker-compose instalados

Passo a passo para rodar a aplicação

- Verifique se as portas utilizadas pela aplicação definidas no arquivo docker-compose.yml estão sendo utilizadas por outra aplicação. Se estiverem sendo utilizadas troque para portas disponíveis na sua máquina.

- Clone o repositório

```bash
git clone git@github.com:MatheusHonorato/teste-tecnico-jukebox.git
```

- Acesse o diretório api

```
cd api
```

- Renomeie o arquivo .env-example para .env

```
cp .env-example .env
```

- Inicie os containers

```bash
./vendor/bin/sail artisan up -d
```

- Instale as dependências

```bash
./vendor/bin/sail composer install
```

- Roder as migrations e seeders para inicializar a base de dados

```bash
./vendor/bin/sail artisan migrate --seed
```

- Para listar os nomes das rotas gerados pelo resources acesso o diretório api e rode o comando a seguir:

```bash
./vendor/bin/sail artisan route:list --name
```