
<?php
	session_start();
	include_once ("../conexao.php");
	include_once("../estrutura/cabecalho.php");
	include_once("../estrutura/corpo.php");

	if (isset($_SESSION['id_usuario'])) {
		
?>

	<h2>Publicar Noticias</h2>
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

<form method="POST" action="validaPost.php" enctype="multipart/form-data" class="col-md-12">
	<div class="form-group">
		Titulo:<br> <input type="text" name="titulo-noticia" size="50" maxlength="50" placeholder="Titulo" autofocus="" />
	</div>
	<div class="form-group">
		Sub-titulo:<br> <input type="text" name="subtitulo-noticia" size="50" maxlength="50" placeholder="Sub-Título"> 
	</div>	
	<div class="form-group">
		Noticia:<br> <textarea name="postagem" id="postagem"  cols="620" rows="30" maxlength="4000" size="4000" placeholder="Digite o conteúdo de sua postagem"></textarea>
	</div>
	<div class="form-group">
		<label for="exampleFormControlFile1">Imagem:</label>	
		 <input type="file" name="imagem" class="form-control-file" id="exampleFormControlFile1" />
	</div>
	<div class="form-group">	
		<?php
			$query = "SELECT id_categoria, categoria FROM categoria";
			$exeQuery = mysqli_query($conexao, $query);

			while ($listaUsuario = mysqli_fetch_array($exeQuery)) {
		?>
			<input type="checkbox" name="categoria[]" value="<?php echo $listaUsuario['id_categoria'];?>"><?php echo $listaUsuario['categoria'];?>
		<?php
			}
		 ?>
	</div>	
	<div class="form-group">	
		<input type="submit" name="btnPostar" value="Postar">
	</div>
</form>

<?php		
	} else {
		header("Location: ../adm/login.php");
	}
?>
</div>
