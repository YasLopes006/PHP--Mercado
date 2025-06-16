<?php
session_start();
require_once "../config/db.php";

$erro = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $senha = $_POST['senha'];
    
    try {
        $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if (password_verify($senha, $row['senha'])) {
                $_SESSION['usuario_id'] = $row['id'];
                $_SESSION['success'] = "Login realizado com sucesso!";
                header("Location: ../items/list_items.php");
                exit();
            }
        }
        $erro = "Login ou senha inválidos!";
    } catch (Exception $e) {
        $erro = "Erro ao processar login: " . $e->getMessage();
    }
}

include "../includes/header.php";
?>

<h2>Login</h2>
<?php if (!empty($erro)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="POST">
    <input name="login" placeholder="Login" required class="form-control mb-2">
    <input name="senha" type="password" placeholder="Senha" required class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Entrar</button>
</form>

<p><a href="register.php" class="btn btn-link">Criar conta</a></p>

<?php include "../includes/footer.php"; ?>