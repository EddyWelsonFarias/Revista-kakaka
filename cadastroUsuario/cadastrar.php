<?php 
	session_start();
	include_once("../conexao.php");
	include_once ("../estrutura/cabecalho.php");
	include_once("../estrutura/corpo.php");

	if (isset($_SESSION['id_usuario'])) {
		
?>	
		<h2>Cadastrar Usuario</h2>
	
		<?php					

			if (isset($_SESSION['msg']) ) {
           		 if ($_SESSION['cor'] == 'azul') {
	               echo "<div class='alert alert-primary' role='alert'>
	                    ".$_SESSION['msg']."
	                </div>";
           		 }else if ($_SESSION['cor'] == 'vermelha') {
	                echo "<div class='alert alert-danger' role='alert'>
	                    ".$_SESSION['msg']."
	                </div>";
            	} 
            
           unset($_SESSION['cor']);
           unset($_SESSION['msg']);              
          }
		?>
		<br>
	<form method="POST" action="validaCadastro.php" enctype="multipart/form-data" class="col-md-6">
		<div class="form-group">
			<label for="exampleInputEmail1">Nome:</label>
				<input type="text" name="nomeUsuario" class="form-control" placeholder="Ex: O cara" autofocus="" required="">
		</div>
		<div class="form-group" >
			Sexo: 
				<input type="radio" name="sexo" value="m" checked > Masculino
				<input type="radio" name="sexo" value="f"> Feminino
		</div>
		<div class="form-group">		
			Celular: <input type="cel" name="celular" class="form-control" placeholder="Ex: (xx) xxxxx-xxxx" required="" >
		</div>
		<div class="form-group">	
			
			Email: <input type="email" name="email" class="form-control" placeholder="Ex: ocara@etec.sp.gov.br" required="">
		</div>
		<div class="form-group">		
			Senha: <input type="password" name="senha" class="form-control" required="">
		</div>
		<div class="form-group">
			<label for="exampleFormControlFile1"> Foto: </label> 			
			<input type="file" name="img" class="form-control-file" id="exampleFormControlFile1" />
		</div>
		<div class="form-group">		
			Perfil: <select name="perfil" class="form-control" required="">
						<option value="">-</option>
						<option value="a">Administrador</option>
						<option value="j">Jornalista</option>
						<option value="c">Comentarista</option>
					</select>
		</div>	
		<div class="form-group">				
			<input type="submit" name="btnCadastrar" class="btn btn-primary" value="Cadastrar" >
		</div>	
		
	</form>
	<?php 

	} else {
		header("Location: ../adm/login.php");
	}
	?>
</body>
</html>
