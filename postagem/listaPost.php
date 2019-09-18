<?php
  session_start();
  date_default_timezone_set("Brazil/East"); // HORA E DATA

	include_once("../conexao.php");
	include_once("../estrutura/cabecalho.php");
	include_once("../estrutura/corpo.php");

  if (isset($_SESSION['id_usuario'])) {
   
      $usuario = $_SESSION['id_usuario'];
      $queryUsuario = "SELECT * FROM usuario WHERE id_usuario = $usuario";
      $exeUsuario = mysqli_query($conexao, $queryUsuario);
      $dado = mysqli_fetch_assoc($exeUsuario);
      if ($dado['perfil'] == 'a') {
        $query = "SELECT * FROM noticia, usuario WHERE noticia.id_usuario = usuario.id_usuario order by id_noticia desc ";
      } else {
        $query = "SELECT * FROM noticia, usuario WHERE noticia.id_usuario = usuario.id_usuario and noticia.id_usuario = $usuario order by id_noticia desc ";
      }
      	
    	$exe = mysqli_query($conexao, $query);
    	//var_dump($exe, $query);
?>
      <h2>Noticias Publicadas</h2>
      <br>      
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
      	<a href="post.php">
      		<button type='submit' name="cadastrar" class='btn btn btn-primary'>Postar</button><br><br>
      	</a>	
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>              
              <th>Publicado</th>
              <!--<th>Atualizado</th>-->
              <th>Titulo</th>              
              <th>Subtitulo</th>
              <th>Noticia</th>
              <th>Publicado por</th>
              <th>Acoes</th>
            </tr>
          </thead>
          <tbody>
            <tr>
          <?php

				while($result = mysqli_fetch_assoc($exe)){
          //var_dump($result);exit;
          $publicado = date('d/m/Y H:i', strtotime($result['publicado']));
          $atualizado = date('d/m/Y H:i', strtotime($result['atualizado']));
         ?> 
					<tr>
    				<td><?php echo $publicado?></td>
           <!-- <td><?php echo $atualizado?></td>-->
    				<td><?php echo $result['titulo']?></td>
    				<td><?php echo $result['subtitulo']?></td>
            <td width="160px"><?php echo strip_tags(substr($result['noticia'], 0,60))?></td> 
            <td><?php echo $result['nome']?></td>        
					   <td>
                <a href='editarPost.php?idnoticia=<?php echo $result['id_noticia'];?>&editar=1'>	
                   <input type='submit' name="btnEditar" class='btn btn-primary' value='Editar'>
                </a>
                <a href='validaPost.php?idnoticia=<?php echo $result['id_noticia'];?>&excluir=1'>  
						       <input type='submit' class='btn btn-danger' value='Excluir'>
                </a>
						  </td>						
					</tr>	
			<?php  } 

          } else {
              header("Location: ../adm/login.php"); 
          }
      ?>
			            
          </tbody>
        </table>
      </div>
