<?php
require_once "../php/conexao.php";
session_start();
if (!isset($_SESSION['login']) and !isset($SESSION['senha'])) {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    echo "<script type='text/javascript'> alert('É preciso logar para acessar');window.location='../html/login.html'</script>";
}

if (isset($_GET['score']) && isset($_GET['nivel'])) {
    $score = $_GET['score'];
    $nivel = $_GET['nivel'];
} else {
    $score = $nivel = null;
}

//OBJETOS DA TELA
$login = $_SESSION['login'];
$senha =  $_SESSION['senha'];

//CONEXAO COM BANCO
$connect = mysqli_connect($host, $user, $password);
$db = mysqli_select_db($connect, $database);

$query_score = "INSERT INTO Ranking (login, score, nivel) VALUES ((SELECT login FROM Cadastro_Jogador WHERE senha='$senha' AND login = '$login') , '$score', '$nivel')";

if (mysqli_query($connect, $query_score)) {
    $response = true;
    echo json_encode($response);
} else {
    echo "ERROR: Could not able to execute $query_score. " . mysqli_error($connect);
}
?>