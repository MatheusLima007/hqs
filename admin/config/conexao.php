<?php
	$servidor = "localhost";
	$usuario = "root";
	$senha = "";
	$banco = "hqs2020";

	try {
		$pdo = new PDO(
			"mysql:host=$servidor;dbname=$banco;charset=utf8",$usuario,$senha
		);
	} catch (PDOException $erro) {
		$msg = $erro->getMessage();
		echo "<p>Erro ao conectar no banco de dados: $msg </p>";
	}
