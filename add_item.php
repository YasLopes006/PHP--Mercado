<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['error'] = "Você precisa fazer login primeiro";
    header("Location: ../auth/login.php");
    exit();
}

$erro = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    
    try {
        if (empty($titulo) || empty($descricao)) {
            $erro = "Preencha todos os campos!";
        } else {
            $stmt = $conn->prepare("INSERT INTO itens (titulo, descricao, usuario_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $titulo, $descricao, $_SESSION['usuario_id']);
            $stmt->execute();
            
            $_SESSION['success'] = "Produto adicionado com sucesso!";
            header("Location: list_items.php");
            exit();
        }
    } catch (Exception $e) {
        $erro = "Erro ao adicionar produto: " . $e->getMessage();
    }
}

include "../includes/header.php";
?>

<h2>Adicionar Produto</h2>

<?php if (!empty($erro)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="POST">
    <input name="titulo" placeholder="Nome do Produto" required class="form-control mb-2">
    <textarea name="descricao" placeholder="Descrição" required class="form-control mb-2" rows="3"></textarea>
    <button type="submit" class="btn btn-success me-2">Salvar</button>
    <a href="list_items.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include "../includes/footer.php"; ?>