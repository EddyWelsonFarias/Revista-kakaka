<style type="text/css">
  
  .jumbotron{
    //border: 1px solid #000;
    margin-top: 29px;
    background-color: #fff;
  }

</style>
<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  
    <?php 
        
        include_once("../conexao.php");
        
         if (isset($_SESSION['id_usuario'])) {            
            $id = $_SESSION['id_usuario'];
            $query = "SELECT * FROM usuario where id_usuario = $id";
           // echo "ETEC ";exit;
            $exe = mysqli_query($conexao, $query);
              while ($exeUsuario = mysqli_fetch_assoc($exe)) {
                $usuario = $exeUsuario['nome'];
                $nivel = $exeUsuario['perfil'];
                $foto = "../cadastroUsuario/imagemPerfil/".$exeUsuario['foto'];
               // var_dump($nivel);
                $nome = explode(" ", $usuario);
    ?>
        <img src="<?php echo $foto;?>" alt="<?php echo $usuario;?>" title="<?php echo $usuario;?>" width="50px" heigth="50px" style="margin-right: 16px;">
        <a class="navbar-brand" href="../cadastroUsuario/editarUsuario.php?id_usuario=<?php echo $exeUsuario['id_usuario']?>&editar=1">
    <?php            
               // var_dump($usuario, $foto);exit;  
              
                //var_dump($exeUsuario);exit;
            
            //var_dump($nome);exit;
            echo ($nome[0]." |<a href='../adm/sair.php?sair=OKADM'>Sair</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
                        
         

          if ($nivel == 'a') {                    
          
       ?>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../adm/administrativo.php" title="Home">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active" >
        <a class="nav-link" href="../cadastroUsuario/listarUsuarios.php" title="Usuarios">Usuarios</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="../postagem/listaPost.php" title="Noticias">Noticias</a>
      </li> 
      <li class="nav-item active">
        <a class="nav-link" href="../comentarios/listaComentarios.php" title="Comentarios">Comentarios</a>
      </li>       
    </ul>
    <!--<form class="form-inline mt-2 mt-md-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
    </form>
  </div>
</nav>
<?php
          } else if($nivel == 'j') {
?>            
                </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../adm/administrativo.php" title="Home">Home <span class="sr-only">(current)</span></a>
      </li>     
      <li class="nav-item active">
        <a class="nav-link" href="../postagem/listaPost.php" title="Noticias">Noticias</a>
      </li> 
      <li class="nav-item active">
        <a class="nav-link" href="../comentarios/listaComentarios.php" title="Comentarios">Comentarios</a>
      </li> 
    </ul>

    <!--<form class="form-inline mt-2 mt-md-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
    </form>
  </div>
</nav>
<?php     
                              }
                    }
            }else{
  //$_SESSION['msg'] = "Usuário Deslogado!";
  header("Location: adm/login.php");
}
?>


<main role="main" class="container">
  <div class="jumbotron">