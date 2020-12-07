# CakePHP

## 1. Instalando o CakePHP

### 1.1 PHP

É necessário habilitar no PHP as seguintes extensões:

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
Agora para criar a tabela execute o comando abaixo:

```bash
$ cake migrations migrate
```
Após gerar a table podemos conferir usando o comando:

```bash
$ cake bake all
```

## 3. Criando um CRUD completo para Users

Usando o comando abaixo podemos gerar o código do CRUD completo.

```bash
$ cake bake all users
```

### 3.2 Criando uma Paginação

Criando uma table para paginação.

```bash
$ cake bake migration CreatePages
```
Ao usar o comando acima é criado na pasta config é uma sub pasta Migrations com um arquivo xxxxx_CreatePages.php

Agora vamos informar os campos da tabela.

```php
<?php

use Migrations\AbstractMigration;

class CreatePages extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('pages');
        $table->addColumn('title', 'string');
        $table->addColumn('url', 'string');
        $table->addColumn('body', 'text');
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

Agora para criar a tabela execute o comando abaixo:

```bash
$ cake migrations migrate
```
Agora que já temos a tabela, vamos criar o CRUD.

```bash
$ cake bake model Pages
```
### 3.2 Em Model (Entity)

Vamos criar umas regras para os campos url e title.

```php
<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

...
class Page extends Entity
{
	...
	
	protected function _setUrl($url){
        $url = Text::slug($url);
        if(empty($url)){
            $url = Text::slug($this->_properties['title']);
        }
        return $url;
    }
    
    protected function _getTitle($title){
        $title = strtolower($title);
        return ucwords($title);
    }
    
    protected function _getTitleUrl($param) {
        $title = strtolower($title);
        return ucwords($title);
    }
}
```