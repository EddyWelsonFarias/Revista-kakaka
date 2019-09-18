

			<?php 
			session_start();
      //print_r($_SESSION);
      //session_destroy();
			include_once("../conexao.php");
			include_once("../estrutura/cabecalho.php");
        
	
			?>
<!doctype html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Eddy Welson Farias">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>STela de Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/">

    <!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <div style="

    //border: 1px solid #000;
    margin: 20px auto;
    width: 50%;

    ">
      <form class="form-signin col-md-12" action="valida.php" method="POST">    
        <h1 class="h3 mb-3 font-weight-normal">Area Restrita</h1>
        <br>
        <?php
                if (isset($_SESSION['msg']) ) {
                  if ($_SESSION['cor'] == 'azul') {
                     echo "<div class='alert alert-primary' role='alert'>
                          ".$_SESSION['msg']."
                      </div>";
                  }elseif ($_SESSION['cor'] == 'vermelha') {
                      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                          ".$_SESSION['msg']."
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                               <span aria-hidden='true'>&times;</span>
                          </button>
                      </div>";

                  } 
                  
                 unset($_SESSION['cor']);
                 unset($_SESSION['msg']);              
                }
            ?><br>
        <label for="inputEmail" class="sr-only">email</label>
          <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="login" required autofocus><br>
        <label for="inputPassword" class="sr-only">Senha</label>
          <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="senha" required>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Lembrar Senha
          </label>
        </div>
          <input type="submit" name="btnLogin" value="Entrar" class="btn btn-lg btn-primary btn-block"> 
          <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
     </form>
    </div>
</body>
</html>
