<?php
	session_start();  
  date_default_timezone_set('America/Sao_Paulo');
	include_once("../conexao.php");
	include_once("../estrutura/cabecalho.php");
	include_once("../estrutura/corpo.php");
  
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
        

        $queryAprovados = "SELECT comentario.id_comentario, comentario.dia, comentario.comentario, usuario.nome, noticia.titulo 
            FROM comentario, usuario, noticia 
            WHERE (comentario.flag = 1 and comentario.id_usuario = usuario.id_usuario and noticia.id_noticia = comentario.id_noticia) ORDER BY comentario.id_comentario desc
          
         ";

        } else {
          //echo "não é administrador"; exit;
          $query = "SELECT comentario.id_comentario, comentario.dia, comentario.comentario, usuario.nome, noticia.titulo 
            FROM comentario, usuario, noticia 
            WHERE (comentario.flag = 0 and comentario.id_usuario = usuario.id_usuario and noticia.id_noticia = comentario.id_noticia and noticia.id_usuario = $usuario )      
         ";  

        $queryAprovados = "SELECT comentario.id_comentario, comentario.dia, comentario.comentario, usuario.nome, noticia.titulo 
            FROM comentario, usuario, noticia 
            WHERE (comentario.flag = 1 and comentario.id_usuario = usuario.id_usuario and noticia.id_noticia = comentario.id_noticia and noticia.id_usuario = $usuario)
         ";
        }
        

      	$exe = mysqli_query($conexao, $query);
        $exeAprovados = mysqli_query($conexao, $queryAprovados);
      	//var_dump($exeAprovados, $queryAprovados); exit;
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
	    					<a href="validaComentarios.php?id_comentario=<?php echo $result['id_comentario']?>&aprovar=1">	                   
			                   <input type="submit" name="btnAprovar" class="btn btn-success" value="Aprovar">
			                </a>
			                <a href="validaComentarios.php?id_comentario='<?php echo $result['id_comentario']?>'&excluir=1">  
								<input type='submit' class='btn btn-danger' value='Excluir'>
			                </a>			                
						  </td>
					</tr>	
<?php  } ?>
		            
          </tbody>
        </table>

        <h2>Comentarios Aprovados</h2>
      <br><br> 
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

        while($resultAprovados = mysqli_fetch_assoc($exeAprovados)){
            
          //var_dump($resultAprovados); exit;
          $publicado = date('d/m/Y H:i', strtotime($resultAprovados['dia']));

?> 

          <tr>  
              <td><?php echo $publicado?></td>
              <td><?php echo $resultAprovados['comentario']?></td>
              <td><?php echo $resultAprovados['nome']?></td>
              <td><?php echo $resultAprovados['titulo']?></td> 
              <?php if($dadosUsuario['perfil'] == 'a') {?>
              <td>
                      <a href="validaComentarios.php?id_comentario='<?php echo $resultAprovados['id_comentario']?>'&excluir=1">  
                <input type='submit' class='btn btn-danger' value='Excluir'>
                      </a> 
                                
              </td>
              <?php }?>   
          </tr> 
<?php  } 
    
  } else {
    header("Location: ../adm/login.php");
  }
?>
                
          </tbody>
        </table>
      </div>

