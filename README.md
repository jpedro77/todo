## Acerda do Gerenciador de Tarefas

Projeto com o objetivo de criar uma aplicação que possa gerenciar tarefas (`TODO`). O sistema possui os métodos de criar, atualizar, remover e listar as tarefas de forma simples e prática.

## Instalação

### Criando os Serviços e instalando dependências

Na instalação irá gerar alguns serviços para funcionamento do Sistema, são eles: PostgreSql, Ngnix e PHP-FPM. No arquivo build do docker-compose (Dockerfile) exitem algumas pré-instalações e configurações, como o `npm install`.

```
docker-compose up -d --build
```

Agora será necessário executar o `composer install` para instalar as dependências do sistema

```
docker-compose exec app composer install
```

## Utilização

Após as configurações e instalações serem concluídas, basta ir em seu navegador e digitar a seguinte url

```
http://localhost:8000
```
