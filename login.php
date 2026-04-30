<?php
include "conexao.php";

function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11) return false;

    if (preg_match('/(\d)\1{10}/', $cpf)) return false;

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;

        if ($cpf[$c] != $d) return false;
    }

    return true;
}

if (isset($_POST['login'])) {

    $entrada = trim($_POST['emailcelularcpf']);
    $senha = trim($_POST['senha']);

    $emailValido = filter_var($entrada, FILTER_VALIDATE_EMAIL);
    $celularValido = preg_match('/^[0-9]{10,30}$/', $entrada);
    $cpfValido = validarCPF($entrada);

    if ($cpfValido) {
        $entrada = hash('sha256', $entrada);
    }

    $sql = "SELECT * FROM user WHERE email_telefone_cpf = :entrada LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':entrada', $entrada);
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
    <label>Email/Celular/CPF:</label>
    <input name="emailcelularcpf" required>
    <br><br>

    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br><br>

    <button type="submit" name="login">Entrar</button>
</form>

<p><a href="cadastro.php">Não tem conta? Cadastre-se</a></p>

</body>
</html>
