<?php

  if ( !isset ( $pagina ) ) exit;
  
  $msg = NULL;

  if ( $_POST ) {
    $login = $senha = "";

    if ( isset ( $_POST["login"] ) )
      $login = trim ( $_POST["login"] );
    
    if ( isset ( $_POST["senha"] ) )
      $senha = trim ( $_POST["senha"] );

    if ( empty ( $login ) )
      $msg = '<p class="alert alert-danger">Preencha o campo Login</p>';
    else if ( empty ( $senha ) ) 
      $msg = '<p class="alert alert-danger">Preencha o campo Senha</p>';
    else {

      $sql = "SELECT id, nome, login, senha, foto FROM usuario WHERE login = ? LIMIT 1";

      $consulta = $pdo->prepare($sql);

      $consulta->bindParam(1, $login);

      $consulta->execute();

      $dados = $consulta->fetch(PDO::FETCH_OBJ);

      if ( empty ( $dados->id ) ) 
        $msg = '<p class="alert alert-danger">O usuário não existe!</p>';

      else if ( !password_verify($senha, $dados->senha) )
        $msg = '<p class="alert alert-danger">Senha incorreta</p>';

      else {
        $_SESSION["hqs"] = 
          array("id"  => $dados->id,
                "nome"=> $dados->nome,
                "foto"=> $dados->foto);
  
        $msg = 'Deu certo!';

        echo '<script>location.href="paginas/home";</script>';
        exit;
      }
    }
  }
?>
<div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bem-vindo ao Sistema</h1>
                  </div>
                  <?=$msg;?>
                  <form class="user" name="login" method="post" data-parsley-validate>
                    <div class="form-group">
                      <input type="text" 
                      name="login" 
                      class="form-control form-control-user" id="login" placeholder="Digite o seu login" required
                      data-parsley-required-message="Preencha o Login">
                    </div>
                    <div class="form-group">
                      <input type="password"
                      name="senha" 
                      class="form-control form-control-user" id="senha" placeholder="Digite sua senha" required
                      data-parsley-required-message="Preencha a senha">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="lembrar">
                        <label class="custom-control-label" for="lembrar">Lembrar meu login</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>