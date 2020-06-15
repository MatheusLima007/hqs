<?php
    session_start();

    if (!isset($_SESSION["hqs"]["id"])) exit;
    
    $cpf = $_GET['cpf'] ?? "";
    $id = $_GET['id'] ?? "";

    if (empty ($cpf)) {
        echo "O cpf está vazio";
        exit;
    }

    include "config/conexao.php";
    include "functions.php";

    $msg = validaCPF($cpf);

    if ($msg != 1) {
        echo $msg;
        exit;
    }

    if (($id==0) or (empty($id))) {
        $sql = "SELECT id FROM cliente WHERE cpf = :cpf LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":cpf", $cpf);
    } else {
        $sql = "SELECT id FROM cliente WHERE cpf = :cpf AND id <> :id LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":id", $id);
    }

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (!empty ($dados->id)) {
        echo "Já existe um cliente cadastrado com este CPF";
        exit;
    }