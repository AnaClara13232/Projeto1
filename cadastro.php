<?php
include "conexao.php";

if (isset($_POST['cadastro'])) {

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $senha)) {
        echo "<p style='color:red;'>Senha fraca</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !str_ends_with("@estudante.ifgoiano.edu.br", $email)) {
        echo "<p style='color:red;'>Email inválido</p>";
    } else {

        $senha_crip = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "SELECT id FROM user WHERE email_telefone_cpf = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<p style='color:red;'>Usuário já existe</p>";
        } else {
            $sql = "INSERT INTO user (email_telefone_cpf, senha) VALUES (:email, :senha)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha_crip);
            $stmt->execute();

            echo "<p style='color:green;'>Conta criada!</p>";
        }
    }
}
?>

<html>
<head>
    <title>Cadastro</title>
</head>
<body>

<h2>Cadastro</h2>

<form method="post">
    <label>Email:</label>
    <input type="email" name="email" required>
    <br><br>

    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br><br>

    <button type="submit" name="cadastro">Cadastrar</button>
</form>

<p><a href="login.php">Já tem conta? Fazer login</a></p>

</body>
</html>
