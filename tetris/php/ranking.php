<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="UTF-8" />
	<title>Cadastro em Javascript</title>
	<link rel="stylesheet" href="../css/style.css" />
	<link href="https://fonts.googleapis.com/css?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>

<body class="background">
	<div>
		<div class="grid-container-ranking">
			<div class="item1">
				<div class="fonteJogoTituloRanking">RANKING GLOBAL</div>
				<table>
					<thead>
						<tr>
							<th>
								<div class="fonteJogoRanking">Posição</div>
							</th>
							<th>
								<div class="fonteJogoRanking">Username</div>
							</th>
							<th>
								<div class="fonteJogoRanking">Pontuação</div>
							</th>
							<th>
								<div class="fonteJogoRanking">Nível máximo</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						require_once "../php/conexao.php";
						session_start();
						if (!isset($_SESSION['login']) and !isset($SESSION['senha'])) {
							unset($_SESSION['login']);
							unset($_SESSION['senha']);
							echo "<script type='text/javascript'> alert('É preciso logar para acessar');window.location='../html/login.html'</script>";
						}

						$connect = mysqli_connect($host, $user, $password);
						$db = mysqli_select_db($connect, $database);

						$query_ranking = "SELECT (ROW_NUMBER() OVER (ORDER BY score DESC)) AS posicao, login, score, nivel FROM Ranking ORDER BY score DESC LIMIT 10";

						try {
							$result = mysqli_query($connect, $query_ranking);

							while ($row = mysqli_fetch_assoc($result)) {
								echo
									"<tr>"
										. "<td><div class=fonteJogoRanking>" . $row['posicao'] . "</div></td>"
										. "<td><div class=fonteJogoRanking>" . $row['login'] . "</div></td>"
										. "<td><div class=fonteJogoRanking>" . $row['score'] . "</div></td>"
										. "<td><div class=fonteJogoRanking>" . $row['nivel'] . "</div></td>"
										. "</tr>";
							}
						} catch (Exception $e) {
							echo "Ocorreu um erro: " . $e->getMessage();
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>

</html>