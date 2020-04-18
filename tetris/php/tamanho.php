<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<?php
	require_once "../php/conexao.php";
	session_start();
	if (!isset($_SESSION['login']) and !isset($SESSION['senha'])) {
		unset($_SESSION['login']);
		unset($_SESSION['senha']);
		echo "<script type='text/javascript'> alert('É preciso logar para acessar');window.location='../html/login.html'</script>";
	}
	$logado = $_SESSION['login'];
	?>

	<meta charset="UTF-8">
	<script src="../js/tabuleiro.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<link href="https://fonts.googleapis.com/css?family=Press+Start+2P&display=swap" rel="stylesheet">
	<title>Tetris Prog Web</title>
</head>

<body class="background">
	<div class="divTamanho centralizar">
		<p class="fonte centralizar">SELECIONE O TAMANHO DO TABULEIRO</p>
		<div>
			<p class='fonte centralizar'>Usuário: <?php echo $logado ?></p>
			<button class="botaoTamanho" id="button" type="submit" name="button" onclick="verificarTamanho(1); location.href='../php/tabuleiro.php';">10x20</button>
			<button class="botaoTamanho" id="button2" type="submit" name="button2" onclick="verificarTamanho(2); location.href='../php/tabuleiro.php';">22x44</button>
			<form id="form_Logout" method="GET" action="../php/logout.php">
				<input class="botaoTamanho" type="submit" value="Sair" name="button_logout">
			</form>
		</div>
	</div>
</body>

</html>