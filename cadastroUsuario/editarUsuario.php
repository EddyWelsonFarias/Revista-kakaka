
<?php
	session_start();
	include_once("../conexao.php");
	include_once("../estrutura/cabecalho.php");
	include_once("../estrutura/corpo.php");

	
	if (isset($_SESSION['id_usuario'])) {
		$usuario = $_SESSION['id_usuario'];

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
	          }/* FIM DO IF ISSET $SESSION MSG */


	     // pega o id do usuario pelo GET	          
	     $editar = $_GET['id_usuario'];
	     $query = "SELECT * FROM usuario WHERE id_usuario = $editar";
		 $exe = mysqli_query($conexao, $query);
		
		 //var_dump($exe,$dadosQuery);exit;

		if ($exe->num_rows == 1) {
			
			// pegar perfis de usuario
			//$queryPerfil = "SELECT DISTINCT perfil FROM usuario";
			//$exePerfil = mysqli_query($conexao, $queryPerfil);
			//$tamanho = $exePerfil->num_rows;
			//var_dump($tamanho);exit;

			//$dados = mysqli_fetch_assoc($exe);
			
			//echo "<select>";
			//while ($perfil = mysqli_fetch_assoc($exePerfil)) {
				//echo "<option>".$perfil['perfil']."</option>"
			//	echo "<option value=".$perfil['perfil'].">".$perfil['perfil']."</option>";
				
			//}
			 //echo "<select>";

			while ($dados = mysqli_fetch_assoc($exe)) {
			
?>

<div class="row" >
	<div class="col-sm-8">
		<form action="validaCadastro.php" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<img src="imagemPerfil/<?php echo $dados['foto']?>" width="180" height="180"><br>
				<label>Alterar foto</label><br>		
				<input type="file" name="fotoNova" value="imagemPerfil/<?php echo $dados['foto']?>?>">
			</div>	
			<div class="form-group ">
				
				<input type="hidden" name="idusuario" class="form-control" readonly value="<?php echo $dados['id_usuario'];?>" >
			</div>		
			<div class="form-group">
				<label>Nome</label>		
				<input type="text" name="nomeUsuario" class="form-control"  value="<?php echo $dados['nome'];?>" required onfocus>				
			</div>
			<div class="form-group">
				<label>Sexo</label>			
			
				<!--<input type="text" name="sexo" class="form-control" value="<?php  $dados[sexo];?>" required>-->
				<select name="sexo" class="form-control" required>
					<option value="<?php echo $dados['sexo'];?>">
						<?php
							if ($dados['sexo'] == 'f') {
								echo "Feminino";
							} else {
								echo "Masculino";
							}							
						?>
					</option>
					<?php
						if ($dados['sexo'] == 'f') {
								echo "Masculino";
								$sexo = 'm';
							} else {
								echo "Feminino";
								$sexo = 'f';
							}
					?>
					<option value="<?php echo $sexo; ?>">
						<?php
							if ($sexo == 'f') {
								echo "Feminino";
								
							} else {
								echo "Masculino";
								
							}							
						?>
					</option>
				</select>
			</div>
			<div class="form-group">
				<label>Celular</label>
				<input type="text" name="celular" class="form-control" value="<?php echo $dados['celular'];?>" required>
			</div>
			<div class="form-group">
				<label>email</label>
				<input type="text" name="email" class="form-control" value="<?php echo $dados['email'];?>" required>
			</div>

			<div class="form-group">
				<label>Perfil</label>
								
					<select name="perfilUsuario" class="form-control" required>
						<option value="<?php echo $dados['perfil']; ?>">
							<?php
							if($dados['perfil'] == 'a'){
								echo "Administrador";
							}
							elseif ($dados['perfil'] == 'j') {
								echo "Jornalista";
							}else{
								echo "Comentarista";
							}
						?>

						</option>
						<option value="a">
							Administrador
						</option>
						<option value="j">
							Jornalista
						</option>
						<option value="c">
							Comentarista
						</option>
					</select>
			</div>			

			<br>
			<div class="form-group botoes">				
					<input type="submit" name="btnEditar" class="btn btn-primary" value="Atualizar">				
			</div>

		</form>

		<?php if(($dados['perfil'] == 'a') or ($dados['perfil'] == 'c') or (($dados['perfil'] == 'j') and $dados['id_usuario'] == $editar)){
		?>

	</div>
	<div class="col-sm-4" >
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#senha">
		  Alterar Senha
		</button>

		<!-- Modal -->
		<div class="modal fade" id="senha" tabindex="-1" role="dialog" aria-labelledby="senhaModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Alterar Senha</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        Digite sua nova senha duas vezes<br><br>

		        	<div class="form-group editarSenha">
						<form method="POST" action="validaCadastro.php">
							<input type="hidden" name="idusuario" value="<?php echo $dados['id_usuario'];?>">
							<input type="password" name="novaSenha" placeholder="Digite a nova senha"><br><br>
							<input type="password" name="confirmarSenha" placeholder="Confirmar nova senha"><br><br>
							
						      <div class="modal-footer">
						        <button type="submit" name="btnEditarSenha" class="btn btn-primary">Alterar</button>		        
							  </div>
						</form>
					</div>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
		<?php 	} ?>




	<?php		
			
		}
			
		}

}else {
		header("Location: ../adm/login.php");
	}

?>	
</div>