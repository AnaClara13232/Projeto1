<html>
<head>
<title>Cadastro</title>
</head>
<body>  

<form method="post" action="">
    <label>Email/Celular/CPF: </label>
    <input name="emailcelularcpf" size="20" autocomplete="off" required>
    <br><br>

    <label>Senha: </label>
    <input name="senha" size="10" type="password" required>
    <br><br>

    <button type="submit" name="inserir">Cadastrar</button>
</form>

</body>
</html>

<?php
include "conexao.php";

function validarCPF($cpf) {
        //subistitui alguma coisa na string
    $cpf = preg_replace('/[^0-9]/', '', $cpf); // remove tudo o que não for numero

    if (strlen($cpf) != 11) return false; // verifica se tem 11 digitos

    if (preg_match('/(\d)\1{10}/', $cpf)) return false;
// calculo do ultimo digito
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;

        if ($cpf[$c] != $d) return false;
    }

    return true;
}

if (isset($_POST['inserir'])): // verifica se o usuario apertou o botão de enviar

    $entrada = trim($_POST['emailcelularcpf']);
    $senha = trim($_POST['senha']);

    // validar senha
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $senha)) {
        echo "senha invalida";
        exit;
    }

    $senha_crip = password_hash($senha, PASSWORD_DEFAULT);// critografa a senha

    // validações
    $emailValido = filter_var($entrada, FILTER_VALIDATE_EMAIL);// filtra a variavel sendo email. Se for filtrado: TRUE senão: FALSE
    $celularValido = preg_match('/^[0-9]{10,30}$/', $entrada); //valida o cell (tem que ter no minimo 10 e max 30) Se for filtrado: TRUE senão: FALSE
    $cpfValido = validarCPF($entrada);//Se for filtrado: TRUE senão: FALSE3

    if ($emailValido) {
        $valorFinal = $entrada;

    } elseif ($celularValido) {
        $valorFinal = $entrada;

    } elseif ($cpfValido) {
        $valorFinal = password_hash($entrada, PASSWORD_DEFAULT);//criptografa o cpf

    } else {
        echo "digite um email, celular ou cpf valido";
        exit;
    }

    $query = "INSERT INTO aula_4 (emailcelularcpf, senha) VALUES ('$valorFinal', '$senha_crip')";
    // comando que faz a inserção
    $resultado = mysqli_query($conexao, $query);

endif;
?>
