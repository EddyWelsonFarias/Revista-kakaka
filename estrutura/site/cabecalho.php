<!doctype html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="kakaka A melhor revista de entreterimento">
    <meta name="author" content="Eddy Welson Farias">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Revista KaKaKa</title>
    <link rel="shortcut icon" href="img/logo.png" type="image/x-png"/>

        <!-- Bootstrap core CSS -->
    <!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


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
          font-size: 3.5rem;  }

    </style>
    <!-- Custom styles for this template -->
    <link href="pricing.css" rel="stylesheet">

 
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal"><img src="img/logo.png"></h5>
  <nav class="my-2 my-md-0 mr-md-3">
    <a class="p-2 text-dark" href="index.php" title="Tela Principal">Principal</a>
    <a class="p-2 text-dark" href="filmes.php" title="Filmes">Filmes</a>
    <a class="p-2 text-dark" href="series.php" title="Series">Series</a>

    <?php

      if (isset($_SESSION['id_usuarioComentario'])) {
        $usuario = $_SESSION['id_usuarioComentario'];
        $query = "SELECT * FROM usuario WHERE id_usuario = $usuario";
        $execute = mysqli_query($conexao, $query);
        $dados = mysqli_fetch_assoc($execute);
        $nomeUsuario = explode(" ", $dados['nome']);

          //var_dump($dados);
    
    ?> 
    <?php 
        if($dados['perfil'] != 'c'){
    ?>
             <span class="p-2 text-dark">
              <a href="perfilUsuarioComenta.php">               
                  <img src="../cadastroUsuario/imagemPerfil/<?php echo $dados['foto'];?>" alt="<?php echo $dados['nome'];?>" title="<?php echo $dados['nome'];?>" width="40px" height="40px">
                  <?php echo $nomeUsuario[0];?></a> |       
                  <a class="p-2 text-dark" href="adm/sair.php?sair=OKCOMENTARIO" title="Deslogar">Sair</a>
             </span>
  <?php      } else{
    ?>
            <span class="p-2 text-dark">  
              <a href="perfilUsuarioComenta.php">           
                  <img src="cadastroUsuario/imagemPerfil/<?php echo $dados['foto'];?>" alt="<?php echo $dados['nome'];?>" title="<?php echo $dados['nome'];?>" width="40px" height="40px">
                  <?php echo $nomeUsuario[0];?></a> |       
                  <a class="p-2 text-dark" href="adm/sair.php?sair=OKCOMENTARIO" title="Deslogar">Sair</a>
             </span>
    <?php
    }  
    ?>  
       
    <?php    
      } else {
    ?>
      <a class="p-2 text-dark" href="loginComentario.php">Login</a>

    <?php
            }
    ?>
    
  </nav>  
</div>