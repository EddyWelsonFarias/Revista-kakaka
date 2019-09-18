<?php
	$servidor = "localhost";
	$porta = "3306";
	$usuario = "root";
	$senha = "";
	$banco = "kakaka";
	$conexao = mysqli_connect($servidor,$usuario,$senha,$banco,$porta) or die("Erro ao conectar!");
?>