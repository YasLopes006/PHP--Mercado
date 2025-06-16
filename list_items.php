<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['error'] = "Você precisa fazer login primeiro";
    header("Location: ../auth/login.php");
    exit();
}

// Mensagens de feedback
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

try {
    $stmt = $conn->prepare("SELECT id, titulo, descricao FROM itens WHERE usuario_id = ?");
    $stmt->bind_param("i", $_SESSION['usuario_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $itens = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    $error = "Erro ao carregar itens: " . $e->getMessage();
}

include "../includes/header.php";
?>

<h2>Meus Produtos</h2>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="d-flex mb-3">
    <a href="add_item.php" class="btn btn-primary me-2">Novo Produto</a>
    <a href="../auth/logout.php" class="btn btn-secondary">Logout</a>
</div>

<?php if (!empty($itens)): ?>
    <?php foreach ($itens as $item): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($item['titulo']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($item['descricao']) ?></p>
                <a href="delete_item.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" 
                   onclick="return confirm('Tem certeza que deseja excluir este item?')">Excluir</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-info">Nenhum produto cadastrado ainda.</div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>