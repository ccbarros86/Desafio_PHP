# Desafio PHP

Este repositório foi compartilhado para ser avaliado no Candidate Test.


## Contexto

Trata-se de uma aplicação PHP para ser executada via CLI.


## Infraestrutura

- Docker Desktop (para execução da aplicação via CLI do próprio container app-php)

- Docker-Compose

    Imagem     | Versão | Link | Obs.
    ---------- | ------ | ---- | ----
    MySQL      | Latest | N/A  | Porta 3306
    PHP        | Latest | DB   | N/A
    PHPMyAdmin | Latest | DB   | 80

    *Informações disponíveis no arquivo docker-compose.yml.*

- Acesso a internet para implantação das imagens e extensões via Command-Line.

- O equipamento onde foi criada a aplicação executa Windows 10, não tendo sido testada em outros SO.

## Instalação

Baixar o pacote em uma pasta local ou servidor, de preferência Windows. Após a instalação do Docker, abra o CMD ou PowerShell, navegue até a pasta onde descompactou os arquivos e entre na pasta \PHP. Em seguida execute o comando como no EXEMPLO abaixo:

```
C:\User\{nomedousuário}\Downloads\PHP> docker-compose up -d
```

Aguarde o download e carregamento das imagens. Ao término serão vistos 3 containers em execução: app-mysql, app-php e app-phpmyadmin.

Em seguida, ainda no CMD ou PowerShell, execute o comando abaixo para instalar o driver pdo_mysql:

```
C:\User\{nomedousuário}\Downloads\PHP> docker-compose exec php docker-php-ext-install mysqli pdo pdo_mysql
```

## Executando a aplicação e os testes automatizados

Para executar a aplicação, acesse o Docker Desktop e, na aba Containers/Apps, clique no botão CLI do container app-php e aguarde a abertura do console. Feito isso, execute os comandos abaixo para chegar à pasta onde é possível executar e testar a aplicação:

```
su
cd Desafio_PHP
```

### Testes

Para testar o comando de criação de usuário, digite o serviço abaixo e receba os testes de especificação de campo e de conexão com banco de dados, além da amostra de retorno JSON:

```
./ASP-TEST USER:CREATE-TEST
```

E para testar o comando de criação de senha para um usuário com dados modelos, recebendo a especificação e repetição da senha, além de testar a conexão com o banco de dados, digite:

```
./ASP-TEST USER:CREATE-PWD-TEST 99 (qualque ID pode ser usado para teste)
```

### Utilização real da aplicação

Para criar um usuário real, execute o seguinte comando:

```
./ASP-TEST USER:CREATE
```

E para criar a senha do usuário criado anteriormente, digite:

```
./ASP-TEST USER:CREATE-PWD {ID}
```

IMPORTANTE: Os IDs começam a partir do inteiro 1. A base de dados pode ser acessada através do PHPMyAdmin para verificação caso necessário (host: app-mysql, un/pw: admin).

## Autor

* **Carlos Cavalcante Barros** - ccbarros@msn.com
