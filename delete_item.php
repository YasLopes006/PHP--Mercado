<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['error'] = "Acesso não autorizado";
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM itens WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $_GET['id'], $_SESSION['usuario_id']);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Item excluído com sucesso!";
        } else {
            $_SESSION['error'] = "Item não encontrado ou você não tem permissão";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Erro ao excluir item: " . $e->getMessage();
    }
}

header("Location: list_items.php");
exit();
?>