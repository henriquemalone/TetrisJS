<?php
require_once "../php/conexao.php";
session_start();
if (!isset($_SESSION['login']) and !isset($SESSION['senha'])) {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    echo "<script type='text/javascript'> alert('É preciso logar para acessar');window.location='../html/login.html'</script>";
}

$login = $_SESSION['login'];
$senha =  $_SESSION['senha'];

//CONEXAO COM BANCO
$connect = mysqli_connect($host, $user, $password);
$db = mysqli_select_db($connect, $database);

$query_update = "SELECT * FROM Cadastro_Jogador WHERE senha = '$senha' AND login = '$login' ";

$result = mysqli_query($connect, $query_update);

while ($row = mysqli_fetch_assoc($result)) {
    $login = $row['login'];
    $senha = $row['senha'];
    $nome = $row['nome'];
    $data_nasc = $row['data_nascimento'];
    $cpf = $row['cpf'];
    $telefone = $row['telefone'];
    $email = $row['email'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <script src="../js/tabuleiro.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P&display=swap" rel="stylesheet">
    <title>Tetris Prog Web</title>
</head>

<body class="background">
    <div class="divTamanhoAtualizarCad centralizar">
        <p class="fonte centralizar">ATUALIZAR CADASTRO</p>
        <form class="centralizaFormCad" method="POST" action="../php/atualiza.php">
            <div class="fonteAtualizarCad">Nome</div>
            <input class="formLogin" type="text" name="nome" placeholder="Nome completo" value="<?php echo $nome ?>">
            <br><br>
            <div class="fonteAtualizarCad">Data de Nascimento</div>
            <input class="formLogin" type="date" name="data" value="<?php echo $data_nasc ?>" disabled>
            <br><br>
            <div class="fonteAtualizarCad">CPF</div>
            <input class="formLogin" type="text" name="cpf" placeholder="CPF" value="<?php echo $cpf ?>" disabled>
            <br><br>
            <div class="fonteAtualizarCad">Telefone</div>
            <input class="formLogin" type="text" name="telefone" placeholder="Telefone" value="<?php echo $telefone ?>">
            <br><br>
            <div class="fonteAtualizarCad">E-mail</div>
            <input class="formLogin" type="email" name="email" value="<?php echo $email ?>">
            <br><br>
            <div class="fonteAtualizarCad">Username</div>
            <input class="formLogin" type="text" name="login" placeholder="Username" value="<?php echo $login ?>" disabled>
            <br><br>
            <div class="fonteAtualizarCad">Senha</div>
            <input class="formLogin" type="password" name="senha" placeholder="Senha" value="<?php echo $senha ?>">
            <br><br>
            <input class="centralBtnCad botaoCadastrar" name="button_update" type="submit" value="Atualizar">
        </form>
    </div>

</body>

</html>