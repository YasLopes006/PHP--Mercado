# Sistema de Mercado em PHP

## Instalação

1. Importe o seguinte SQL no phpMyAdmin:

```sql
CREATE DATABASE mercado;
USE mercado;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
```

2. Copie os arquivos para seu servidor local (ex: `htdocs/mercado/` no XAMPP)

3. Acesse `http://localhost/mercado/auth/register.php` para iniciar.
