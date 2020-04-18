<?php
require_once "../php/conexao.php";
session_start();
if (!isset($_SESSION['login']) and !isset($SESSION['senha'])) {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    echo "<script type='text/javascript'> alert('É preciso logar para acessar');window.location='../html/login.html'</script>";
}

//OBJETOS DA TELA
$nome = isset($_POST['nome']) ? $_POST['nome'] : NULL;
$data = isset($_POST['data']) ? $_POST['data'] : NULL;
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : NULL;
$telefone = isset($_POST['telefone']) ? $_POST['telefone'] : NULL;
$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$login = $_SESSION['login'];
$senha = isset($_POST['senha']) ? $_POST['senha'] : NULL;
$button_update = isset($_POST['button_update']) ? $_POST['button_update'] : NULL;

//CONEXAO COM BANCO
$connect = mysqli_connect($host, $user, $password);
$db = mysqli_select_db($connect, $database);

$query_update = "UPDATE Cadastro_Jogador SET senha='$senha', nome='$nome', telefone='$telefone', email='$email' WHERE login = '$login' ";
if ($button_update != NULL) {
    if (mysqli_query($connect, $query_update) == TRUE) {
        echo "<script type='text/javascript'> alert('Dados alterado com sucesso');window.location='../php/atualizaCad.php'</script>";
    } else {
        echo "ERROR: Could not able to execute $query_register. " . mysqli_error($connect);
    }
}
