<?php
	date_default_timezone_set('America/Sao_Paulo'); 
	session_start();
	include_once("../conexao.php");


	
	//recebendo o valor do botao
	//$btnPostagem = $_POST['btnPostar'];
	//$excluir = isset($_GET['excluir']);

	if (isset($_SESSION['id_usuario'])) {
		
		//verificando se o botao de postar foi clicado
		if (isset($_POST['btnPostar'])) {
			// variavel para verificacao de erros dentro do formulario	

			$usuario = $_SESSION['id_usuario'];
			$erro = false;
			$publicado = date('Y-m-d H:i:s');			
			$titulo = $_POST['titulo-noticia'];
			$subtitulo = $_POST['subtitulo-noticia'];
			$not = $_POST['postagem'];
			$img = $_FILES["imagem"];
			$categoria = $_POST['categoria'];
			var_dump($categoria);
			 if($categoria == null){
				echo "entrou aqui"; 
				$erro = true;
				$mensagem = "Uma categoria deverá ser selecionada";		
				  

			}else if(empty($titulo) or empty($subtitulo) or empty($not)){
				$erro = true;
				$mensagem = "Preencha todos os campos!";

			} else if ($img['error'] == 4){
				//echo "entrou aqui"; exit;
				$erro = true;
				$mensagem =  "Selecione uma imagem";	
				header("Location:post.php");
			} else if ($img["error"] == 1){
					$erro = true;
					$mensagem = "O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini";//Ai teremos que alterar lá no php.ini meus camaradas, pesquisem e deem seus pulos			
					header("location:post.php");
					// Verifica se o arquivo é uma imagem através de uma função nativa do PHP preg_match, através de expressões regulares
			} else if(!preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $img['name'], $ext)){
		    		
		    		//echo "entrou aqui"; exit;

		    		$erro = true;
		    		$mensagem = "Ops! Isso não é uma imagem.";		    				
					header("Location:post.php");            	
		   	} else{	
		   		//echo "entrou aqui"; exit;
				// Largura máxima em pixels
				$largura = 2000;
				// Altura máxima em pixels
				$altura = 3000;
				// Tamanho máximo do arquivo em bytes
				$tamanho = 1000000; // coloquei 1 megabyte
		    	
		   	 	// Pega as dimensões da imagem, criando um novo vetor através da função nativa getimagesize
				$dimensoes = getimagesize($img['tmp_name']);
				//print_r($dimensoes);exit;
				//echo $dimensoes[0];exit;
				// Verifica se a largura da imagem é maior que a largura permitida
				if($dimensoes[0] > $largura) {
					$erro = true;
					$mensagem = "A largura da imagem não deve ultrapassar ".$largura." pixels";
					header("Location:post.php");  
				} else if($dimensoes[1] > $altura) {
					$erro = true;
					$mensagem = "Altura da imagem não deve ultrapassar ".$altura." pixels";					
					header("Location:post.php");
				} else if($img['size'] > $tamanho) {
					$erro = true;
		   		 	$mensagem = "A imagem deve ter no máximo ".$tamanho." bytes";
		   		 	header("Location:post.php");
				}else {
				
					// Pega extensão da imagem
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $img["name"], $ext);

		        	// Gera um nome único para a imagem, esse nome será criptografado em md5 (assim como poderia ser em sha1, preferi md5 porque não requer tanta segurança e o número de caracteres é menor que sha1), juntamente com o milesegundos que estou upando a imagem
		        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

		        	// Caminho de onde ficará a imagem
		        	$caminho = "upload/" . $nome_imagem;

					// Faz o upload da imagem para seu respectivo caminho
					$certo = move_uploaded_file($img['tmp_name'], $caminho);

					//var_dump($certo); exit;
					if ($certo) {
						$erro = false;
					}				
					
			   	 }
			}

			// se nao possui nenhum erro no preenchimento do formulario
	 		if (!$erro) {
				
				$query = "INSERT INTO noticia (titulo, subtitulo, noticia, publicado, atualizado, imagem, id_usuario)
							 VALUES ('$titulo', '$subtitulo', '$not', '$publicado', '$publicado', '$nome_imagem', $usuario)";
				$exe = mysqli_query($conexao, $query);
					//var_dump($exe, $query);exit;		

				if ($exe) {						
					//var_dump($exe, $query);
					// pegando o ultimo ID inserido
					//if ($conexao->query($query)) {
						 //$Ultimo_id = $conexao->insert_id;
						 $Ultimo_id = mysqli_insert_id($conexao);
    					 //echo "Ultimo ID: " . $Ultimo_id; exit;
    					 foreach ($categoria as $cat) {
							//echo $cat;
							//$queryCategoria = "INSERT INTO categoria_noticia VALUES (null,id_categoria = '$cat' , id_noticia = '$Ultimo_id')";
							$queryCategoria = "INSERT INTO `categoria_noticia` (`id_categoriaNoticia`, `id_categoria`, `id_noticia`) VALUES (NULL, '$cat', '$Ultimo_id');";
							$exeQueryCategoria = mysqli_query($conexao, $queryCategoria);								
						}
					
						//var_dump($exeQueryCategoria);exit;
					if ($exeQueryCategoria) {
							//var_dump($exeQueryCategoria, $queryCategoria);exit;
							$_SESSION['msg'] = "Postagem realizada com sucesso!";
							$_SESSION['cor'] = "azul";
							header("Location:listaPost.php");
						} else {
							$_SESSION['msg'] = "Erro na insercao a categoria no Banco";	
							$_SESSION['cor'] = "vermelha";	
							header("Location:post.php");
						}
						 	
				}else{
					$_SESSION['msg'] = "Erro na insercao ao Banco";	
					$_SESSION['cor'] = "vermelha";	
					header("Location:post.php");
				}			 

				
			// caso possua erro retornar a mensagem ao usuario do erro correspondente
			}else{				
				$_SESSION['msg'] = $mensagem;	
				$_SESSION['cor'] = "vermelha";	
				header("Location:post.php");
			}
		
		} 

		// Editar noticia
		if (isset($_POST['btnEditar'])) {
			$usuario = $_SESSION['id_usuario'];
			$id_not = $_POST['id'];
			$titulo = $_POST['titulo-noticia'];
			$subtitulo = $_POST['subtitulo-noticia'];
			$postagem = $_POST['postagem'];
			$img = $_FILES["imagem"];
			$atualizado = date('Y-m-d H:i:s');
			$categoria = $_POST['categoria']; 
			//var_dump($categoria);exit;
			//var_dump($img);
			/*foreach ($categoria as $cat) {
					echo $cat;
				}exit;*/

			if($categoria == null){
				$_SESSION['msg'] = "Pelo menos uma categoria deverá ser selecionada";
			    $_SESSION['cor'] = "vermelha";			
				header("Location:editarPost.php?idnoticia=".$id_not."&editar=1");   
			}

			if ($img["error"] == 4) {
				$query = "UPDATE noticia 
					  SET titulo = '$titulo',
					  	  subtitulo = '$subtitulo',
					  	  noticia = '$postagem',
					  	  atualizado = '$atualizado',
					  	  id_usuario = $usuario
					  WHERE id_noticia = $id_not";
					  //var_dump($query); exit;

			} else if ($img["error"] == 0) {

				$consulta = "SELECT * FROM noticia WHERE $id_not = id_noticia ";	
				$exe =	mysqli_query($conexao, $consulta);
				 while ($dados = mysqli_fetch_array($exe)){
				 	//var_dump($dados);exit;	
				// Largura máxima em pixels
				$largura = 1800;
				// Altura máxima em pixels
				$altura = 1800;
				// Tamanho máximo do arquivo em bytes
				$tamanho = 1000000; // coloquei 1 megabyte
		    	// Verifica se o arquivo é uma imagem através de uma função nativa do PHP preg_match, através de expressões regulares

		    	//var_dump(preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto['name'], $ext)); exit;

			    	if(!preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $img['name'], $ext)){
			    		$_SESSION['msg'] = "Ops! Isso não é uma imagem.";
			    		$_SESSION['cor'] = "vermelha";			
						header("Location:editarPost.php?idnoticia=".$dados['id_noticia']."&editar=1");           	
			   	 	}
			   	 	// Pega as dimensões da imagem, criando um novo vetor através da função nativa getimagesize
					$dimensoes = getimagesize($img['tmp_name']);
						//print_r($dimensoes);exit;
						//echo $dimensoes[0];exit;
						// Verifica se a largura da imagem é maior que a largura permitida
						if($dimensoes[0] > $largura) {
							$_SESSION['msg'] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
							$_SESSION['cor'] = "vermelha";						
							header("Location:editarPost.php?idnoticia=".$dados['id_noticia']."&editar=1"); 
						} else if($dimensoes[1] > $altura) {
							$_SESSION['msg'] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
							$_SESSION['cor'] = "vermelha";
							header("Location:editarPost.php?idnoticia=".$dados['id_noticia']."&editar=1"); 
						} else if($img['size'] > $tamanho) {
				   		 	$_SESSION['msg'] = "A imagem deve ter no máximo ".$tamanho." bytes";
				   		 	$_SESSION['cor'] = "vermelha";
				   		 	header("Location:editarPost.php?idnoticia=".$dados['id_noticia']."&editar=1"); 
						}else {
						
							// Pega extensão da imagem
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $img["name"], $ext);

							//var_dump($ext);exit;
				        	// Gera um nome único para a imagem, esse nome será criptografado em md5 (assim como poderia ser em sha1, preferi md5 porque não requer tanta segurança e o número de caracteres é menor que sha1), juntamente com o milesegundos que estou upando a imagem
				        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

				        	// Caminho de onde ficará a imagem
				        	$caminho = "upload/" . $nome_imagem;
				        	//var_dump($caminho);exit	;
				        	
							if ($dados['imagem']) {
								// excluindo imagem 
								echo ("upload/".$dados['imagem']); 
							} 				
								
							// Faz o upload da imagem para seu respectivo caminho
							$certo = move_uploaded_file($img['tmp_name'], $caminho);

							//var_dump($caminho, $certo, $img); exit;

					   	 }
					   	 
				$query = "UPDATE noticia 
					  SET titulo = '$titulo',
					  	  subtitulo = '$subtitulo',
					  	  noticia = '$postagem',
					  	  atualizado = '$atualizado',
					  	  imagem = '$nome_imagem',
					  	  id_usuario = $usuario
					  WHERE id_noticia = $id_not";

				 }				
			

			}
			
			$exe = mysqli_query($conexao, $query);
			//var_dump($exe);exit;
			// selecionando as categorias pertencentes a noticia
			$querySelecao = "SELECT * FROM categoria_noticia WHERE id_noticia = $id_not order by id_categoria";
			$exeQuerySelecao = mysqli_query($conexao,$querySelecao);
			//var_dump($exeQuerySelecao, $querySelecao);exit;
			if($exeQuerySelecao){
				$queryExcluirCategoria = "DELETE FROM categoria_noticia WHERE id_noticia = $id_not";
				$exeExcluirCategoria = mysqli_query($conexao, $queryExcluirCategoria);
				//var_dump($queryExcluirCategoria, $exeExcluirCategoria);exit;
				foreach ($categoria as $cat) {
					$queryInsercao = "INSERT INTO categoria_noticia VALUES (NULL, '$cat', '$id_not')";
					$exeInsercaoCategoria = mysqli_query($conexao, $queryInsercao);
				}
				if ($exeInsercaoCategoria) {
										
					
					$_SESSION['msg'] = "Noticia Atualizada com sucesso!";
					$_SESSION['cor'] = "azul";		
					header("Location: listaPost.php");
				}else{
					$_SESSION['msg'] = "Erro ao atualizar a noticia!";
					$_SESSION['cor'] = "vermelha";		
					header("Location: listaPost.php");
				}				
			}
			
			
		
		}
		// Excluir noticia	
		if (isset($_GET['excluir'])) {
			$id = $_GET['idnoticia'];
			//var_dump($id);exit;

			$query = "DELETE FROM noticia WHERE id_noticia = $id";
			$exe = mysqli_query($conexao, $query);
			//var_dump($query, $exe); exit;

			if ($exe) {
				$querySelecao = "DELETE FROM categoria_noticia WHERE id_noticia = $id";
				$exeQuerySelecao = mysqli_query($conexao,$querySelecao);
				if($exeQuerySelecao){
					$queryComentario = "DELETE FROM comentario WHERE id_noticia = $id";
					$exeQueryComentario = mysqli_query($conexao,$queryComentario);	
					if ($exeQueryComentario) {						
							$_SESSION['msg'] = "Noticia Excluida com sucesso!";
							$_SESSION['cor'] = "vermelha";		
							header("Location: listaPost.php");					
						}else{
							$_SESSION['msg'] = "Erro ao excluir a categoria!";
							$_SESSION['cor'] = "vermelha";		
							header("Location: listaPost.php");
						}
					}
				}
				

				
			}

		// caso o usuario queira entrar na pagina de validaPost 
	}

	
	
?>