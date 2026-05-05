<?php
include "conexao.php";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT * FROM user WHERE email_telefone_cpf = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        header("Location: hub.php");
        exit;
    } else {
        echo "<p style='color:red;'>Login inválido</p>";
    }
}
?>

<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form method="post">
    <label>Email:</label>
    <input type="email" name="email" required>
    <br><br>

    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br><br>

    <button type="submit" name="login">Entrar</button>
</form>

<p><a href="cadastro.php">Não tem conta? Cadastre-se</a></p>

</body>
</html>
