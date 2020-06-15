<?php
	include "libs/functions.php";
	$cpf = "";
	if (isset($_GET["cpf"])) $cpf=trim($_GET["cpf"]);

	if ( empty ( $cpf ) ) {
		echo "Forneça um CPF";
		exit;
	} else if ( $cpf == "123.456.789-09" ) {
		echo "CPF inválido";
		exit;
	}

	echo validaCPF($cpf);