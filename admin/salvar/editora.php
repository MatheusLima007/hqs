<?php
  if ( !isset ( $_SESSION["hqs"]["id"] ) ) exit;
  
  if ( $_POST ) {
  	$id = $nome = $site = "";

  	foreach ($_POST as $key => $value) {
  		$$key = trim ( $value );
  	}

  	if ( empty ( $nome ) ) {
  		echo '<script>alert("Preencha o nome");history.back();</script>';
  		exit;
  	}
  	else if ( !filter_var ( $site, FILTER_VALIDATE_URL ) ) {
  		echo '<script>alert("Preencha uma URL válida");history.back();</script>';
  		exit;
  	}

  	$sql = "SELECT id FROM editora WHERE nome = ? AND id <> ? LIMIT 1";
  	$consulta = $pdo->prepare($sql);
  	$consulta->bindParam(1, $nome);
  	$consulta->bindParam(2, $id);
  	$consulta->execute();
  	$dados = $consulta->fetch(PDO::FETCH_OBJ);

  	if ( !empty ( $dados->id ) ) {
  		echo '<script>alert("Já existe uma editora com este nome registrada");history.back();</script>';
  		exit;
  	}

  	if ( empty ( $id ) ) {
  		$sql = "INSERT INTO editora (nome, site) VALUES( ? , ? )";
  		$consulta = $pdo->prepare($sql);
  		$consulta->bindParam(1, $nome);
  		$consulta->bindParam(2, $site);

  	} else {  	
  		$sql = "UPDATE editora SET nome = ?, site = ? WHERE id = ? LIMIT 1";	
  		$consulta = $pdo->prepare($sql);
  		$consulta->bindParam(1, $nome);
  		$consulta->bindParam(2, $site);
  		$consulta->bindParam(3, $id);
  	}
  	if ( $consulta->execute() ) {
  		echo '<script>alert("Registro Salvo");location.href="listar/editora";</script>';
  	} else {
  		echo '<script>alert("Erro ao salvar");history.back();</script>';
  		exit;
  	}
  } else {
  	echo '<script>alert("Erro ao realizar requisição");history.back();</script>';
  }