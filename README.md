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
Sistema de Gerenciamento de Mercado

Este projeto foi desenvolvido com o tema "mercado", criando um sistema completo para controle de produtos e itens de supermercado. Ele simula um ambiente real de gerenciamento de estoque, onde usuários podem:

Cadastrar itens (como produtos de mercearia, hortifruti, etc.)

Organizar descrições (informações como marca, peso, validade)

Controlar acesso (login seguro para funcionários ou administradores)

Recursos com Temática de Mercado:
✔ Cadastro de Produtos (nome, descrição detalhada)
✔ Listagem Organizada (como prateleiras virtuais)
✔ Exclusão Segura (controle de itens vencidos ou descontinuados)

O sistema usa cores e design que remetem a um supermercado moderno (verde = frescor, vermelho = alertas, cards = organização de produtos). Ideal para pequenos mercados ou como projeto de estudo para gestão comercial.

Ashilei vitoria da silva gomes

Yasmin Cristini Lopes Oliveira
