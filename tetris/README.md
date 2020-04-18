#BANCO DE DADOS
Utilizamos o MySQL atráves do PhpMyAdmin

#CRIAR BANCO DE DADOS
Para criar o banco de dados basta executar o arquivo "scripDatabase.php" que está na pasta "php"

#CONEXAO COM O BANCO DE DADOS
Nossa conexão está centralizada no arquivo "conexao.php" que está na pasta "php", então basta alterar os dados neste arquivo que refletirá em todo o site

#FLUXO DO JOGO
- Na tela inicial pode-se logar ou efetuar um cadastro
- Após logar, deve-se escolher o tamanho do tabuleiro
- No tabuleiro temos:
    - Botão "ranking" que levará o usuário para uma página com um ranking global contendo as 10 maiores pontuações
    - Item "Posição no ranking" que mostra qual a posição do jogador logado no ranking global 
    - Toda vez que acontece um "game over" a pontuação e nível do jogo é salva
    