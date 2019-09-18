<?php
  session_start();
  date_default_timezone_set('America/Sao_Paulo');
	include_once("conexao.php");
  include_once("estrutura/site/cabecalho.php");
  
	$noticia = $_GET['id_noticia'];
	//var_dump($noticia); 
	$query ="SELECT * FROM noticia, usuario where noticia.id_noticia = $noticia and noticia.id_usuario = usuario.id_usuario";
	$exe = mysqli_query($conexao, $query);
	//var_dump($query, $exe);exit;


  if ($exe->num_rows == 1) {
  
  
	
?>


 <br>
<main role="main" >
    <div class="container col-md-11" >
        <?php
          //var_dump($dados);

          if (isset($noticia) and $exe) {
                while ($dados = mysqli_fetch_array($exe)){
                  //var_dump($dados);exit;
          ?>

              <h2><?php echo strtoupper($dados['titulo']);?></h2>              
              <h4><?php echo $dados['subtitulo'];?></h4><br>
              <p>Escrito por: <?php echo $dados['nome'];?><br>
                 Postado em: <?php echo date('d/m/Y H:i', strtotime($dados['publicado']));?> - 
                 Atualizado em: <?php echo date('d/m/Y H:i', strtotime($dados['atualizado']));?>
              </p>
              <hr size="6">



              <div style="width: 100%;">
                <img src="postagem/upload/<?php echo $dados['imagem'];?>" alt="" title="<?php echo $dados['titulo'];?>" alt="<?php echo $dados['titulo'];?>" width="600px" class="col-md-9" style="display: block; margin-left: auto; margin-right: auto;">                
              </div>
              <p><?php echo $dados['noticia'];?></p><br><br>
          <?php  
                  
                 // echo "Noticia ". $dados['noticia']."<br>";  
                }
             
                } else {
                  $_SESSION['msg'] = "vermelha";    
                  $_SESSION['cor'] = "vermelha";  
                  header("Location: index.php");

                }    
                $queryComentarios = "SELECT comentario.id_comentario,
                          comentario.comentario, comentario.dia, usuario.nome, usuario.foto 
                      FROM comentario, usuario 
                      WHERE comentario.flag = 1 and comentario.id_noticia = $noticia and usuario.id_usuario = comentario.id_usuario ORDER BY comentario.id_comentario DESC"; 
            $exeComentarios = mysqli_query($conexao, $queryComentarios);
            $totalComentarios = mysqli_num_rows($exeComentarios);
            //var_dump($queryComentarios, $totalComentarios);
            
                                
          ?>  
          <h4><?php 
                  if ($totalComentarios == 0) {
                    echo " Nenhum Comentário";
                  } else if ($totalComentarios == 1) {
                    echo $totalComentarios." Comentário";
                  } else{
                    echo $totalComentarios." Comentários";
                  }
              ?>                    
          </h4>
          <hr size="6">
          <?php
              if (isset($_SESSION['mensagemComentario']) ) {                
                  if ($_SESSION['corComentario'] == 'azul') {
                     echo "<div class='alert alert-primary' role='alert'>
                          ".$_SESSION['mensagemComentario']."
                      </div>";
                  }else if ($_SESSION['corComentario'] == 'vermelha') {
                      echo "<div class='alert alert-danger' role='alert'>
                          ".$_SESSION['mensagemComentario']."
                      </div>";
                  } 
            
               unset($_SESSION['corComentario']);
               unset($_SESSION['mensagemComentario']);              
              }

          ?>


          <?php
            if (isset($_SESSION['id_usuarioComentario'])) { 

            $usuario =  $_SESSION['id_usuarioComentario']; 

            $queryUsuario = "SELECT * FROM usuario where id_usuario = $usuario";
            $exeUsuario = mysqli_query($conexao, $queryUsuario);
              while ($dadosUsuario = mysqli_fetch_assoc($exeUsuario)) {
                  if($dadosUsuario['perfil'] == 'c'){                
            
          ?>
          <br>
          <label>Olá <b><?php echo $dadosUsuario['nome'];?></b> deixe o seu comentário abaixo:</label><br><br>          <form method="POST" action="comentarios/validaComentarios.php">            
              <div class="form-group">                
                <input type="hidden" name="idNoticia" value="<?php echo $noticia; ?>" />
                <input type="hidden" name="nomeUsuarioComentario" value="<?php echo $usuario; ?>" />
                <input type="hidden" name="emailUsuarioComentario" value="<?php echo $dadosUsuario['email']; ?>"/>
                <textarea name="comentarioUsuario" id="comentarioUsuario" cols="70" rows="3" placeholder="Digite seu comentário aqui!" required></textarea>
              </div> 
              <div class="form-group">
                  <input type="submit" name="btnComentario" value="Enviar" class="btn btn btn-primary">
              </div> 
          </form>
          <br><br>
          <?php 
                  }
                }
                
            }else{ ?>

          <a href="loginComentario.php">Clique aqui</a> para fazer login e comentar<br><br><br>
          <?php 
          
            } 
          ?>
          <?php 

            while ($dadosComentarios = mysqli_fetch_assoc($exeComentarios)) {
              // echo($dadosComentarios['comentario']."<br><br>");
             // var_dump($dadosComentarios);
            
          ?>

  <table border="0" style="margin: 6px; width: 50%;">
      <tr>
        <td rowspan="3" style="padding: 10px;" >
           <img src="cadastroUsuario/imagemPerfil/<?php echo $dadosComentarios['foto'];?>" alt="<?php echo $dadosComentarios['nome'];?>" title="<?php echo $dadosComentarios['nome'];?> "/>
        </td>
        <td>
          <h6>
          <?php echo $dadosComentarios['nome'];?>        
        </h6>
        </td>
      </tr>      
      <tr>
        <td>
          <p><?php echo $dadosComentarios['comentario'];?></p>
        </td>
      </tr>
      <tr>
        <td>
           <p style="font-size: 12px;">
              <?php echo date('d M Y H:i', strtotime($dadosComentarios['dia']));?>                
            </p>
        </td>
      </tr>
  </table>      
      
  <hr size="6"> 
          <?php
              }
          ?>
</div>	
</main>
<?php include_once("estrutura/site/footer.php");

  
  } else {
   $_SESSION['msg'] = "Página não encontrada";
   $_SESSION['cor'] = "vermelha"; 
   header("Location: index.php");
  }?>