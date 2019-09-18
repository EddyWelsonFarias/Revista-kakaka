

			<?php 
			
      //print_r($_SESSION);     
			include_once("conexao.php");
      session_start();
			include_once("estrutura/site/cabecalho.php");
        
	
			?>
<!doctype html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Eddy Welson Farias">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Login - Kakaka</title>

    

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

        .container{
         // border: 1px solid #000;
        }


      }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>
  <body>
   <div class="container">     
      <div class="row">       
        <aside class="col-sm-6">          
             <div class="card">
                 <article class="card-body">
                      <h4 class="card-title mb-4 mt-1">Já tem conta?</h4>
                      <?php         

                      if (isset($_SESSION['msgLogar']) ) {
                               if ($_SESSION['corLogar'] == 'azul') {
                                 echo "<div class='alert alert-primary' role='alert'>
                                      ".$_SESSION['msgLogar']."
                                  </div>";
                               }else if ($_SESSION['corLogar'] == 'vermelha') {
                                  echo "<div class='alert alert-danger' role='alert'>
                                      ".$_SESSION['msgLogar']."
                                  </div>";
                               } 
                            
                           unset($_SESSION['corLogar']);
                           unset($_SESSION['msgLogar']);              
                          }
                       ?> 
                        <form method="POST" action="comentarios/validaComentarios.php">
                          <div class="form-group">                             
                               <input name="login" class="form-control" placeholder="Email" type="email" required="">
                          </div> <!-- form-group// -->
                          <div class="form-group">                           
                              <input name="senha" class="form-control" placeholder="******" type="password" required="">
                          </div> <!-- form-group// --> 
                          <div class="form-group row"> 
                             <div class="checkbox col-sm-6">
                                <label> 
                                    <input type="checkbox"> Lembrar-me                                      
                                </label>                                
                            </div> <!-- checkbox .// -->
                            <label class="col-sm-6">
                                  <a class="float-right" href="#">Esqueceu a senha?</a> 
                                </label>
                         </div> <!-- form-group// -->  
                            <div class="form-group">
                                <button type="submit" name="btnLogarComentario" class="btn btn-primary btn-block"> Acessar  </button>
                            </div> <!-- form-group// -->   
                        </form>                        
                 </article>
             </div> <!-- card.// -->
        </aside> <!-- col.// -->
        <aside class="col-sm-6">      
          <div class="card">
            <article class="card-body">               
                  <h4 class="card-title mb-4 mt-1">Cadastre-se</h4>
                  <?php         

                      if (isset($_SESSION['msgCadastrar']) ) {
                               if ($_SESSION['corCadastrar'] == 'azul') {
                                 echo "<div class='alert alert-primary' role='alert'>
                                      ".$_SESSION['msgCadastrar']."
                                  </div>";
                               }else if ($_SESSION['corCadastrar'] == 'vermelha') {
                                  echo "<div class='alert alert-danger' role='alert'>
                                      ".$_SESSION['msgCadastrar']."
                                  </div>";
                              } 
                            
                           unset($_SESSION['corCadastrar']);
                           unset($_SESSION['msgCadastrar']);              
                          }
                    ?> 
                      <form method="POST" action="comentarios/validaComentarios.php">
                        <div class="form-group">
                           <input type="text" name="nome" class="form-control" placeholder="Nome Completo" required="" >
                        </div> <!-- form-group// -->
                        <div class="form-group">
                           <input name="sexo" type="radio" value="f"> Feminino  
                            <input name="sexo" type="radio" value="m"> Masculino
                        </div> <!-- form-group// -->
                        <div class="form-group">
                           <input name="celular" class="form-control" placeholder="+55 11 1111-1111" type="text" required="">
                        </div> <!-- form-group// -->
                        <div class="form-group">
                           <input name="email" class="form-control" placeholder="ocara@ocara.com.br" type="email" required="">
                        </div> <!-- form-group// -->
                        <div class="form-group">
                            <input class="form-control" placeholder="******" type="password" name="senha" required="">
                        </div> <!-- form-group// -->                                   
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <button type="submit" name="btnCadastrarComentarista" class="btn btn-success btn-block"> Cadastrar  </button>
                                  </div> <!-- form-group// -->
                              </div>                                           
                          </div> <!-- .row// -->                                                                  
                      </form>
            </article>
          </div> <!-- card.// -->

        </aside> <!-- col.// -->
        
      </div> <!-- row.// -->
   </div> 
<!--container end.//-->   


</body>
</html>
