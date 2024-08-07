# Contrato API

### Instalação

1. Crie os containers da aplicação:

```sh
docker-compose up --build
```

2. Instale as dependências da aplicação:

```sh
docker-compose exec -it app composer install
```

3. Crie as tabelas no banco de dados:

```sh
docker-compose exec -it app php bin/console doctrine:migrations:migrate
```

4. _(Opcional)_ Para atualizar a documentação, utilize o seguinte comando:

```sh
docker-compose exec -it app ./vendor/bin/openapi src/ -o openapi.json
```

### Exemplo de Uso

Para fazer o upload de um documento:

```sh
curl -X POST http://localhost/api/upload -F 'documento=@/caminho/para/seu/documento.png'
```

### Desenvolvimento

Para rodar a aplicação localmente, certifique-se de que os containers Docker estão em execução e acesse `http://localhost` no seu navegador.

#### Lista de serviços:

- **PHP**: porta `80`
- **MySQL**: porta `3306`
- **phpMyAdmin**: porta `8000`
- **Swagger**: porta `8080`

### Testes

Utilize os seguintes comandos:

1. Crie o banco de dados de teste:

```sh
docker-compose exec -it app php bin/console doctrine:database:create --env=test
```

2. Execute as migrações no banco de dados de teste:

```sh
docker-compose exec -it app php bin/console doctrine:migrations:migrate --env=test
```

3. Execute os testes:

```sh
docker-compose exec -it app php bin/phpunit
```
