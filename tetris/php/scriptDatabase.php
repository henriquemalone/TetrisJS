<?php

require_once "../php/conexao.php";

//CONEXAO COM BANCO
$connect = mysqli_connect($host, $user, $password);
$db = mysqli_select_db($connect, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$query_db = "CREATE DATABASE IF NOT EXISTS baseteste2;";

$query_tableUser = "CREATE TABLE IF NOT EXISTS Cadastro_Jogador( login VARCHAR(20) PRIMARY KEY, senha CHAR(32), nome CHAR(40), data_nascimento DATE, cpf CHAR(14), telefone CHAR(14), email VARCHAR(50))";

$query_tableRanking = "CREATE TABLE IF NOT EXISTS Ranking( id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT, login VARCHAR(20), score INTEGER, nivel INTEGER, CONSTRAINT FK_Login FOREIGN KEY (login) REFERENCES Cadastro_Jogador(login) )";

if (mysqli_query($connect, $query_db)) {
    echo "Database criada com sucesso!<br>";
} else {
    echo "Não foi possível criar Database<br>";
}

$connect->select_db('baseteste2');

if (mysqli_query($connect, $query_tableUser)) {
    echo "Tabela usuario criada com sucesso!<br>";
} else {
    echo "Não foi possível criar Tabela usuario<br>";
}

if (mysqli_query($connect, $query_tableRanking)) {
    echo "Tabela ranking criada com sucesso!<br>";
} else {
    echo "Não foi possível criar Tabela ranking<br>";
}

mysqli_close($connect);
?>