<?php
	session_start();
  date_default_timezone_set('America/Sao_Paulo');
  //print_r($_SESSION);
	include_once("../estrutura/cabecalho.php");
	include_once("../estrutura/corpo.php");	
  // exit;
	
?>

<?php
      if (isset($_SESSION['id_usuario'])) {
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
      }else {
          header("Location: login.php");
      }              
            ?>

  <?php 

    if (isset($_SESSION['id_usuario'])) {
      $usuario = $_SESSION['id_usuario'];
        $queryUsuario = "SELECT * FROM usuario where id_usuario = $usuario";
        $exeUsuario = mysqli_query($conexao, $queryUsuario);
        $dadosUsuario = mysqli_fetch_assoc($exeUsuario);

        if ($dadosUsuario['perfil'] == 'a') {
            $query = "SELECT comentario.id_comentario, comentario.dia, comentario.comentario, usuario.nome, noticia.titulo 
            FROM comentario, usuario, noticia 
            WHERE (comentario.flag = 0 and comentario.id_usuario = usuario.id_usuario and noticia.id_noticia = comentario.id_noticia)
         ";  

        } else {
          //echo "não é administrador"; exit;
          $query = "SELECT comentario.id_comentario, comentario.dia, comentario.comentario, usuario.nome, noticia.titulo 
            FROM comentario, usuario, noticia 
            WHERE (comentario.flag = 0 and comentario.id_usuario = usuario.id_usuario and noticia.id_noticia = comentario.id_noticia and noticia.id_usuario = $usuario )      
         ";  
        
        }        

        $exe = mysqli_query($conexao, $query);
       
?>
      <h2>Comentarios Pendentes</h2>
      <br><br> 
      <?php
          if (isset($_SESSION['msg']) ) {
            if ($_SESSION['cor'] == 'azul') {
               echo "<div class='alert alert-primary' role='alert'>
                    ".$_SESSION['msg']."
                </div>";
            }elseif ($_SESSION['cor'] == 'vermelha') {
                echo "<div class='alert alert-danger' role='alert'>
                    ".$_SESSION['msg']."
                </div>";
            } 
            
           unset($_SESSION['cor']);
           unset($_SESSION['msg']);              
          }
      ?>    

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>                           
              <th>Data e Hora</th>
              <th>Comentario</th>              
              <th>Usuario</th>
              <th>Noticia</th>
            </tr>
          </thead>
          <tbody>
            <tr>
<?php

        while($result = mysqli_fetch_assoc($exe)){

          //var_dump($result); exit;
          $publicado = date('d/m/Y H:i', strtotime($result['dia']));

?> 

          <tr>
              <td><?php echo $publicado;?></td>
              <td><?php echo $result['comentario']?></td>
              <td><?php echo $result['nome']?></td>
              <td><?php echo $result['titulo']?></td> 
              <td>
                <a href="../comentarios/validaComentarios.php?id_comentario=<?php echo $result['id_comentario']?>&aprovar=1">                     
                         <input type="submit" name="btnAprovar" class="btn btn-success" value="Aprovar">
                      </a>
                      <a href="../comentarios/validaComentarios.php?id_comentario='<?php echo $result['id_comentario']?>'&excluir=1">  
                <input type='submit' class='btn btn-danger' value='Excluir'>
                      </a>                      
              </td>
          </tr> 
<?php  } ?>
                
          </tbody>
        </table>

        
    <?php  }  ?>


</main>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="/docs/4.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script></body>
</html>
