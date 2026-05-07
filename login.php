<?php
include "conexao.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT * FROM user WHERE email_telefone_cpf = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($_SESSION['usuario_id']);
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $user['email_telefone_cpf'];
        header("Location: hub.php");
        exit;
    } else {
        echo "<p style='color:red;'>Email ou senha incorretos</p>";
    }
}
?>

<html>
<head><title>Login</title></head>
<body>

<h2>Login</h2>

<form method="post">
    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <label>Senha:</label>
    <input type="password" name="senha" required><br><br>

    <button type="submit" name="login">Entrar</button>
</form>

<p><a href="cadastro.php">Não tem conta? Cadastre-se</a></p>

</body>
</html>
