<?php
  include_once("../conexao.php");
  session_start();
  date_default_timezone_set("Brazil/East");

	include_once("../estrutura/cabecalho.php");
	include_once("../estrutura/corpo.php");

  if (isset($_SESSION['id_usuario'])) {
    
      $query_cliente = "SELECT * FROM usuario WHERE perfil = 'c' order by nome";
      $cliente = mysqli_query($conexao, $query_cliente);
      $query_administrador = "SELECT * FROM usuario WHERE perfil = 'a' order by nome";
      $administrador = mysqli_query($conexao, $query_administrador);
      $query_jornalista = "SELECT * FROM usuario WHERE perfil = 'j' order by nome";
      $jornalista = mysqli_query($conexao, $query_jornalista);
     
?>
      <div class="row">
          <div class="col-sm-6"><h2>Usuários</h2></div>
          <div class="col-sm-6">
            <a href="cadastrar.php">
               <button type='submit' name="cadastrar" class='btn btn btn-primary'>Cadastrar</button><br><br>
            </a>
          </div>
      </div>
      
      
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
      	
        <h4>Administradores</h4>	
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>              
             
              <th>Nome</th>              
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <tr>
          <?php

				while($result_administrador = mysqli_fetch_assoc($administrador)){
          ?>
					 <tr>					   
					   <td><?php echo $result_administrador['nome'];?></td>
					   <td><?php echo $result_administrador['email'];?></td>
					   <td>	
             					
						    <a href='editarUsuario.php?id_usuario=<?php echo $result_administrador['id_usuario'];?>'>
                    <input type='submit' name='btnEditar' value="Editar" class='btn btn-success'>
                </a>

                <a href='validaCadastro.php?id_usuario=<?php echo $result_administrador['id_usuario'];?>&deletar=1'>
                    <input type='submit' name='btnDeletar' value="Deletar" class='btn btn-danger'>
                </a>
						  </td>					
					 </tr>	
				<?php } ?>
			            
          </tbody>
        </table>
        <br/>
        <h4>Jornalistas</h4>
        <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr> 
              <th>Nome</th>              
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <tr>
          <?php

        while($result_juridico = mysqli_fetch_assoc($jornalista)){
          ?>
           <tr>             
             <td><?php echo $result_juridico['nome'];?></td>
             <td><?php echo $result_juridico['email'];?></td>
             <td>           
                <a href='editarUsuario.php?id_usuario=<?php echo $result_juridico['id_usuario'];?>'>
                    <input type='submit' name='btnEditar' value="Editar" class='btn btn-success'>
                </a>

                <a href='validaCadastro.php?id_usuario=<?php echo $result_juridico['id_usuario'];?>&deletar=1'>
                    <input type='submit' name='btnDeletar' value="Deletar" class='btn btn-danger'>
                </a>
              </td>         
           </tr>  
        <?php } ?>
                  
          </tbody>
        </table>
        <br/>
        <h4>Comentaristas</h4>
        <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Nome</th>              
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <tr>
          <?php

        while($result_cliente = mysqli_fetch_assoc($cliente)){
          ?>
           <tr>
             <td><?php echo $result_cliente['nome'];?></td>
             <td><?php echo $result_cliente['email'];?></td>
             <td>           
                <a href='editarUsuario.php?id_usuario=<?php echo $result_cliente['id_usuario'];?>'>
                    <input type='submit' name='btnEditar' value="Editar" class='btn btn-success'>
                </a>

                <a href='validaCadastro.php?id_usuario=<?php echo $result_cliente['id_usuario'];?>&deletar=1'>
                    <input type='submit' name='btnDeletar' value="Deletar" class='btn btn-danger'>
                </a>
              </td>         
           </tr>  
        <?php } 


          } else {
                  header("Location: ../adm/login.php");
                }       
        ?>
                  
          </tbody>
        </table>
      </div>
