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
  $login = $_SESSION['login'];
  $senha = $_SESSION['senha'];

  $connect = mysqli_connect($host, $user, $password);
  $db = mysqli_select_db($connect, $database);

  $query_ranking = "SELECT (ROW_NUMBER() OVER (ORDER BY score DESC)) AS posicao, login, score, nivel
  FROM Ranking ORDER BY score DESC";

  $result = mysqli_query($connect, $query_ranking);

  $posicao_ranking = 0;
  $jaRankeou = false;
  
  while ($row = mysqli_fetch_assoc($result)) {
    if($login === $row['login'] && !$jaRankeou) {
      $posicao_ranking = $row['posicao'];
      $jaRankeou = true;
    }
  }
  
  if ($posicao_ranking == 0) {
    $query_posicao = "SELECT ROW_COUNT() FROM Ranking";
    $result = mysqli_query($connect, $query_posicao);
    while ($row = mysqli_fetch_assoc($result)) {
      $posicao_ranking += 1;
    }
    $posicao_ranking += 1;
  }
  ?>

  <meta charset="UTF-8">
  <title>Tetris Prog Web</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css" />
  <link href="https://fonts.googleapis.com/css?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>

<body class="background">
  <div>
    <div class="grid-container">
      <div class="item1">
        <div class="botoesControle">
          <p class="fonteJogo">
            Usuário <br /><br />
            <?php echo $login ?>
            <br /><br />
          </p>
          <input class="stiloBotoes" id="congelar" type="submit" name="button" onclick="pararJogo()" value="Congelar" /> <br>
          <input class="stiloBotoes" id="retomar" type="submit" name="button" onclick="retornarJogo()" value="Retomar" />
          <form id="form_atualiza" method="GET" action="../php/atualizaCad.php">
            <input class="stiloBotoes" type="submit" value="Atualiza Cadastro" name="button_atualiza">
            <br><br>
          </form>
          <form id="form_atualiza_ranking" method="GET" action="../php/ranking.php">
            <input class="stiloBotoes" type="submit" value="Ranking" name="button_ranking">
            <br><br>
          </form>
        </div>
        <canvas id="tabuleiro" width="450" height="800"></canvas>
      </div>
      <div class="fonte">
        Pontuação
        <div class="itemRanking" id="pontuacao">0</div>
        <br /><br />

        Tempo de Jogo
        <div class="itemRanking" id="cronometro">00:00
        </div>
        <br /><br />

        Linhas eliminadas
        <div class="itemRanking" id="linhasEliminadas">0
        </div>
        <br /><br />

        Nível de dificuldade
        <div class="itemRanking" id="nivelDificuldade">0
        </div>
        <br /><br />

        Posição no ranking
        <div class="itemRanking" id="posicaoRanking"><?php echo $posicao_ranking ?>
        </div>

        <script>
          window.onload = function() {
            gerenciarCronometro("iniciar");
          }
        </script>
      </div>
    </div>
  </div>

  <script src="../js/tabuleiro.js"></script>

  <form method="GET" action="../php/logout.php">

    <input class="botaoStart" type="submit" value="Sair" name="button_logout">
    <br><br>
  </form>
</body>

</html>