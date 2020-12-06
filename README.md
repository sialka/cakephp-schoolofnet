# CakePHP

## Instalando o CakePHP

### 1. PHP

É necessario ter habilitado no php os seguintes extensões:

- ext-intl
- ext-mbstring

### Instalando o CakePHP com o Composer (global)

```bash
$ composer create-project cakephp/app
composer create-project --prefer-dist cakephp/app:^3.5 app
```

## 2. Database

Para criar o banco de dados na query do mysql digite o comando:

```sql
$ CREATE DATABASE cakephp_iniciante_34
```

### Configurando o database no cakephp

Em app\config\app.php em Datasources adicione:

```php
    'username' => 'root',
    'password' => '',
    'database' => 'cakephp_iniciante_34',
```

