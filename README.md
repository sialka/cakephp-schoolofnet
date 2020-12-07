# CakePHP

## 1. Instalando o CakePHP

### 1.1 PHP

É necessario ter habilitado no php os seguintes extensões:

- ext-intl
- ext-mbstring

### 1.2 Instalando o CakePHP com o Composer (global)

```bash
$ composer create-project --prefer-dist cakephp/app:^3.5 app
```

## 2. Database

### 2.1 Criar o Banco de dados

Para criar o banco de dados, podemos executar o seguinte comando:

```sql
$ CREATE DATABASE cakephp_iniciante_34
```

### 2.2 Configurando o database

Para o cake reconhecer o database, no arquivo **app\config\app.php** em Datasources informe o usuário, senha e nome do banco de dados :

```php
	...
    'username' => 'root',
    'password' => '',
    'database' => 'cakephp_iniciante_34',
    ...
```

### 2.3 Criando a tabela users

Para criar uma tabela podemos usar o migrations.

```bash
$ cake migrations create CreateUsers
```
Ao usar o comando acima é criado na pasta config é uma sub pasta Migrations com um arquivo xxxxx_CreateUse.php

```php
<?php

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('users');
        $table->addColumn('username', 'string');
        $table->addColumn('password', 'string', [
            'limit' => 200
        ]);
        $table->addColumn('active', 'boolean', [
            'default' => 0,
            'null' => true
        ]);
        $table->addColumn('created', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP'
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->create();
    }

}
```
Agora para criar o arquivo execute o comando abaixo:

```bash
$ cake migrations migrate
```
Apos gerar a table podemos conferir usando o comando:

```bash
$ cake bake all
```

## 3. Criando os controllers

```bash
$ cake bake all users
```