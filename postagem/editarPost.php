<?php
	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	include_once("../conexao.php");
	include_once("../estrutura/cabecalho.php");
	include_once("../estrutura/corpo.php");

	if (isset($_SESSION['id_usuario'])) {
	

		// recebendo o valor do botao de editar e verificando se e igual a 1
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
		          
		if (isset($_GET['editar']) and $_GET['editar'] == 1) {
			$id = $_GET['idnoticia'];
			//var_dump($id);exit;
			$query = "SELECT * FROM noticia WHERE id_noticia = $id ";
			$exe = mysqli_query($conexao, $query);
			//var_dump($exe, $query);
			while ($resultado = mysqli_fetch_assoc($exe)) {
				//$_SESSION['id_usuario'] = $id;
			
?>
	<h4>Editar Noticia</h4>
	<form method="POST" action="validaPost.php" enctype="multipart/form-data" class="col-md-12">
		<div class="form-group">
			<input type="hidden" name="id" value="<?php echo $resultado['id_noticia'] ?>" readonly="true"/>
		</div>
		<div class="form-group">
			Titulo:<br> <input type="text" name="titulo-noticia" size="50" maxlength="50" value="<?php echo $resultado['titulo'] ?>" autofocus=""/>
		</div>
		<div class="form-group">
			Sub-titulo:<br> <input type="text" name="subtitulo-noticia" size="50" maxlength="50" value="<?php echo $resultado['subtitulo'] ?>"> 
		</div>	
		
		<div class="form-group">
			Noticia:<br> <textarea name="postagem" id="postagem" cols="620" rows="30" ><?php echo $resultado['noticia'] ?></textarea>
		</div>
		<div class="form-group">
			<img src="upload/<?php echo $resultado['imagem'] ?>" alt="<?php echo $resultado['titulo'] ?>" width="180px" height="180px">	<br>
			Imagem<br> <input type="file" name="imagem" />
		</div>

		<div class="form-group">
		<label>Categorias</label><br>	
		<?php
			$query = "SELECT id_categoria, categoria FROM categoria";
			$exeQuery = mysqli_query($conexao, $query);

			while ($listaUsuario = mysqli_fetch_array($exeQuery)) {
				//var_dump($listaUsuario);
				$queryChecado = "SELECT * from categoria_noticia WHERE id_categoria = ".$listaUsuario['id_categoria'] ." and id_noticia = $id";
				$exeQueryChecado = mysqli_query($conexao, $queryChecado);
				//	var_dump($exeQueryChecado, $queryChecado);
				
		?>
		<!-- Pega o valor da categoria e retorna a categoria cadastrada do filme -->
			<input type="checkbox" name="categoria[]" value="<?php echo $listaUsuario['id_categoria'];?>"
				<?php
				if($exeQueryChecado->num_rows >= 1){
					echo 'checked'; 
				}

				?>

			><?php echo $listaUsuario['categoria'];?>
			
		<?php
		
			}
		 ?>
	</div>


	<div class="input-group mb-3">
  	<div class="input-group-prepend">
	    <div class="input-group-text">
	      <!--<input type="checkbox" aria-label="Chebox para permitir input text">-->
	      <input type="checkbox" name="categoria[]" value="<?php echo $listaUsuario['id_categoria'];?>">
	    </div>
	  </div>
	  <?php echo $listaUsuario['categoria'];?>
	</div>	


		<div class="form-group">
				<br>				
				<input type="submit" name="btnEditar" class="btn btn-primary" value="Atualizar" title="Atualizar">
			</a>		
		</div>			
	</form>	

</div>



<?php

			} 

		// Em caso o usuario altere o valor de editar
		}else if ($_GET['editar'] != 1) {
			$_SESSION['msg'] = "Erro ao excluir a noticia";
			$_SESSION['cor'] = "vermelha";
			header("Location: listaPost.php");
		// Caso nao seja pressionado o botao de editar
		}else {
			$_SESSION['msg'] = "Pagina nao encontrada";
			$_SESSION['cor'] = "vermelha";
			header("Location: listaPost.php");
		}

	
	} else {
		header("Location:../adm/login.php");
	}



?>