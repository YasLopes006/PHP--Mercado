<?php
session_start();
require_once "../config/db.php";

$erro = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    
    try {
        if (empty($login) || empty($email) || empty($senha)) {
            $erro = "Todos os campos são obrigatórios!";
        } else {
            // Verifica se usuário já existe
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE login = ? OR email = ?");
            $stmt->bind_param("ss", $login, $email);
            $stmt->execute();
            
            if ($stmt->get_result()->num_rows > 0) {
                $erro = "Usuário ou email já cadastrado!";
            } else {
                $stmt = $conn->prepare("INSERT INTO usuarios (login, email, senha) VALUES (?, ?, ?)");
                $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
                $stmt->bind_param("sss", $login, $email, $hashed_password);
                $stmt->execute();
                
                $_SESSION['success'] = "Cadastro realizado com sucesso!";
                header("Location: login.php");
                exit();
            }
        }
    } catch (Exception $e) {
        $erro = "Erro ao cadastrar: " . $e->getMessage();
    }
}

include "../includes/header.php";
?>

<h2>Cadastro</h2>
<?php if (!empty($erro)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="POST">
    <input name="login" placeholder="Login" required class="form-control mb-2">
    <input name="email" type="email" placeholder="Email" required class="form-control mb-2">
    <input name="senha" type="password" placeholder="Senha" required class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>

<p><a href="login.php" class="btn btn-link">Já tem conta?</a></p>

<?php include "../includes/footer.php"; ?>