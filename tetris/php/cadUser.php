<?php
require_once "../php/conexao.php";

if (empty($_POST['nome']) & empty($_POST['data']) & empty($_POST['cpf']) & empty($_POST['telefone']) & empty($_POST['email']) & empty($_POST['login']) & empty($_POST['senha'])) {
    echo "<script type='text/javascript'> alert('Preencha todos os campos do formulário ou faça login para continuar');window.location='../html/login.html'</script>";
}

//OBJETOS DA TELA
$nome = isset($_POST['nome']) ? $_POST['nome'] : NULL;
$data = isset($_POST['data']) ? $_POST['data'] : NULL;
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : NULL;
$telefone = isset($_POST['telefone']) ? $_POST['telefone'] : NULL;
$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$login = isset($_POST['login']) ? $_POST['login'] : NULL;
$senha = isset($_POST['senha']) ? $_POST['senha'] : NULL;
$button_register = $_POST['button_register'];
$button_voltar = $_POST['button_voltar'];

//CONEXAO COM BANCO
$connect = mysqli_connect($host, $user, $password);
$db = mysqli_select_db($connect, $database);

$query_register = "INSERT INTO Cadastro_Jogador (login, senha, nome, data_nascimento, cpf, telefone, email) VALUES ('$login', '$senha', '$nome', '$data', '$cpf', '$telefone', '$email')";

if (isset($button_register)) {
    if (mysqli_query($connect, $query_register)) {
        echo "<script type='text/javascript'> alert('Cadastrado com sucesso');window.location='../html/login.html'</script>";
    } else {
        echo "ERROR: Could not able to execute $query_register. " . mysqli_error($connect);
    }
} else if (isset($button_voltar)) {
    header("Location:../html/login.html");
}
