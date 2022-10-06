# Backend Challenge 20220626


## Introdução

Nesse desafio trabalharemos no desenvolvimento de uma REST API que utilizará os dados do projeto Open Food Facts, um banco de dados aberto com informação nutricional de diversos produtos alimentícios.

O projeto tem como objetivo dar suporte a equipe de nutricionistas da empresa Fitness Foods LC para que possam comparar de maneira rápida a informação nutricional dos alimentos da base do Open Food Facts.

## Como instalar?

- Faça o download ou o clone do projeto;
- Execute o comando ```composer install```;
- Configure o ```.env``` do projeto duplicando o arquivo ```.env.example``` e ajustando as configurações de Banco de Dados;

### Instalando o Laravel Sail em aplicações já existentes

Você deverá instalar o Sail usando o gerenciador de pacotes do Composer. Obviamente, essas etapas pressupõem que seu ambiente de desenvolvimento local existente permite que você instale as dependências do Composer:

```composer require laravel/sail --dev```

Após a instalação do Sail, você pode executar o comando do artisan ```sail:install```. Este comando publicará o arquivo docker-compose.yml do Sail na raiz do projeto:

```php artisan sail:install```

Finalmente, você pode iniciar o Sail. Para continuar aprendendo a usar o Sail, continue lendo o restante desta documentação:

```./vendor/bin/sail up```

**ATENÇÃO:** 

Normalmente, os comandos do terminal do Laravel seriam executados usando o prefixo **php**, por exemplo: ```php artisan migrate```.

Com o Sail instalado, os próximos comandos do Laravel e ou composer deverão ser executados usando o prefixo ```./vendor/bin/sail 'comando aqui'```.

###  Configurando o .env para produção

No arquivo ```.env``` colocamos as configurações do ambiente específico que vamos rodar a aplicação. Em ambiente de produção dois itens desse arquivo devem obrigatoriamente ser alterados para a segurança da aplicação:

```APP_ENV=production```
```APP_DEBUG=false```

O ```APP_ENV``` informa qual o nome do ambiente que estamos executando a aplicação. O aconselhável em produção é definir o valor ```production```. Isso porque o Laravel tem uma serie de proteção quando ele está configurado assim.

O ```APP_DEBUG``` indica para o Laravel se ele deve mostrar erros no navegador. Exibir informações de erro é extremamente perigoso, um usuário mal intencionado pode obter diversas informações a partir dele. Por esse motivo sempre devemos deixar como **false**, assim ele mostrará apenas a mensagem informando que aconteceu algo de errado.

Se precisar saber quais erros estão acontecendo em produção pode verificar o arquivo de log do Laravel.


### Instalando as dependências

Ao clonar a aplicação para nosso servidor de produção, a primeira coisa que precisamos fazer é executar o composer para baixar as dependências do projeto. Quando estamos em produção podemos passar dois parâmetros extras, veja como fica o comando:

```sail composer install --optimize-autoload --no-dev```

**–optimize-autoload**: gera uma versão das regras do PSR-4/PSR-0 em um arquivo PHP único, evitando que a linguagem tenha que o olhar no sistema de arquivos. Esse arquivo de classmap pode ser facilmente cacheado pelo opcache tornando a obtenção dos caminhos muito mais rápido.

**–no-dev**: ignora as dependências exclusivas do ambiente de desenvolvimento

### Cacheando os arquivos de configuração

Acessar o arquivo ```.env``` toda hora é muito custoso, uma vez que ele é um arquivo de texto e não pode ser cacheado pelo opcache. Baseado nisso, o Laravel possui um comando que copia as configurações dele para um arquivo php único diminuindo assim o custo de acesso. Para isso temos o comando:

```sail artisan config:cache```

Único detalhe que devemos ficar atentos quando executamos esse comando. Como as configurações do arquivo de configuração ```.env``` são carregados para o arquivo único, não é aconselhável usar o helper ```env()``` do Laravel que pega as configurações do arquivo ```.env``` já que ele pode não ser carregado.

### Cacheando as rotas

O Laravel possui um comando que serializa todas as rotas da aplicação. Esses dados são passados para um único método em um arquivo cacheado. Isso diminui o tempo de carregamento das rotas da aplicação:

```sail artisan route:cache```

## Bibliotecas utilizadas

### Laravel Goutte (Facade)

Muitas vezes, precisamos de dados de sites que não foram construídos por nós, podemos precisar desses dados para alguma pesquisa, para algumas análises ou até mesmo para tópicos complexos como aprendizado de máquina. Esses dados podem ser facilmente obtidos usando um processo chamado web scraping.

Goutte é um pacote Laravel que facilita a captura de dados de sites da web.

### Laravel Telescope

O Telescope fornece informações sobre as solicitações que chegam ao sistema, exceções, entradas de log, consultas de banco de dados, jobs em fila, e-mail, notificações, operações de cache, tarefas agendadas, dumps de variáveis e muito mais.

Será instalada no projeto ao rodar o comando ```sail composer install```

### Laravel Sail

O Laravel Sail é uma interface de linha de comando leve (assim como o artisan) e simples de usar. Seu foco é abstrair todo o uso do Docker para que seja mais simples durante o dia a dia.

>  This is a challenge by [Coodesh](https://coodesh.com/)