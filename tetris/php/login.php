<?php
require "../php/conexao.php";
session_start();

//OBJETOS DA TELA
$login = $_POST['login'];
$button_login = $_POST['button_login'];
$senha = $_POST['senha'];

//CONFIG BANCO
$query_login = "SELECT * FROM Cadastro_Jogador WHERE senha = '$senha' AND login = '$login' ";

//CONEXAO COM BANCO
$connect = mysqli_connect($host, $user, $password);
$db = mysqli_select_db($connect, $database);

if ($connect) {
	echo 'Conexão bem sucedida';
}

if (isset($button_login)) {
	$validacao = mysqli_query($connect, $query_login) or die("Erro ao logar");
	if (mysqli_num_rows($validacao) <= 0) {
		echo "<script type='text/javascript'> alert('Login e/ou senha incorreto(s)');window.location='../html/login.html'</script>";
	} else {
		$_SESSION['login'] = $login;
		$_SESSION['senha'] = $senha;

		header("Location:../php/tamanho.php");
	}
}
