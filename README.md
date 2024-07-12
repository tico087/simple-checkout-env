# Desafio Perfect-pay

Este é um sistema de processamento de pagamentos integrado ao ambiente de homologação do Asaas, utilizando Laravel 11. O sistema permite processar pagamentos via boleto, cartão de crédito e Pix, exibir informações relevantes na página de agradecimento, e segue as boas práticas de programação e git.

## 🚀 Começando

### 📋 Pré-requisitos

Você precisará das seguintes ferramentas instaladas na sua máquina para rodar o projeto:

* [Docker](https://www.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/install/)
* [Composer](https://getcomposer.org/)
* [uma conta no Serviço Asaas](https://sandbox.asaas.com/)

### 🔧 Instalação

Siga os passos abaixo para configurar o ambiente de desenvolvimento:

1. Clone o repositório:
via HTTP 
```
$ git clone https://github.com/usuario/perfect-pay-v2.git
```

Via SSH 
```
$ git clone git@github.com:tico087/perfect-pay-env.git
```
obs: via SSH é necessério adicionar uma chave pública (https://github.com/settings/ssh/new)

2. Vá para o diretótio onde o projeto foi clonado

```
$ cd perfect-pay-env
```
3. Copie o arquivo .env.example para .env e ajuste as variáveis de ambiente conforme necessário:

```
$ cp .env.example .env
```

4. Configure o banco de dados e a sua chave Asaas no .env 

```
DB_CONNECTION=mysql
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=perfect_pay
DB_USERNAME=root
DB_PASSWORD=123

ASAAS_API_KEY="SUA_API_KEY"
```

5. Dentro diretório do projeto rode o script setup_and_start.sh

```
bash setup_and_start.sh
```

este script irá iniciar o ambiente docker com todas suas dependencias 

o projeto irá se iniciar na url 

[http://(http://laravel:8000/](http://laravel:8000/)

ou 

[http://(http://localhost:8000/](http://localhost:8000/)

*obs: caso esteja rodando alguma VM no windows ex: WSL2, é necessário configurar o arquivo* hosts -> *C:\Windows\System32\drivers\etc\hosts* 

```
127.0.0.1   laravel
::1 	    laravel

```

## 🛠️ Construído com

Mencione as ferramentas que você usou para criar seu projeto

* [Laravel](https://laravel.com/) - Framework PHP - Versão 11.x
* [Docker](https://www.docker.com/) - Containerização
* [Composer](https://getcomposer.org//) - Composer - Gerente de Dependências
* [Asaas](https://sandbox.asaas.com/) - Integração de pagamentos
* [MariaDB](https://mariadb.org/) - Bancdo de dados
* [Vue](https://vuejs.org/) - Framework Javascript - Versão 3.x


## ✒️ Autores

* **Ismael Gonçalves (tico087)** - [tico087](https://github.com/tico087)

