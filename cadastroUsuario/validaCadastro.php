<?php
	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	include_once("../conexao.php");

// Cadastro
	if(isset($_POST['btnCadastrar'])){
		
		$nome = $_POST['nomeUsuario'];
		$sexo = $_POST['sexo'];
		$celular = $_POST['celular'];
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		$img = $_FILES['img'];		
		$perfil = $_POST['perfil'];

		//var_dump($img,$perfil);exit;
		// variavel de controle de erros
		$erro = false;

		// Necessario preencher todos os campos
		if(empty($nome) or empty($sexo) or empty($celular) or empty($email) or empty($senha) or empty($perfil) or $img['error'] == 4){
				$erro = true;
				$mensagem = "Preencha os campos obrigatorios!";
				//var_dump($nome, $sexo, $celular, $email, $senha, $perfil);exit;
				// verificando se a senha tem mais de 6 caracteres 
			}else if (strlen($senha) < 6) {
				$erro = true;
				$mensagem = "A Senha deve ter no minimo 6 caracteres";
			} else{
				// verificando se o email ja esta cadastrado 
				$query = "SELECT * FROM usuario WHERE email = '$email' ";
				$resultadoQuery = mysqli_query($conexao,$query);
				
				//print_r($resultadoQuery); exit;

				if ($resultadoQuery->num_rows != 0){
					$erro = true;
					$mensagem = "Email ja cadastrado, Favor usar outro! ";
				}
			} 



			if ($img['name']) {	
			// Largura máxima em pixels
			$largura = 180;
			// Altura máxima em pixels
			$altura = 180;
			// Tamanho máximo do arquivo em bytes
			$tamanho = 1000000; // coloquei 1 megabyte
	    	// Verifica se o arquivo é uma imagem através de uma função nativa do PHP preg_match, através de expressões regulares
		    	if(!preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $img['name'], $ext)){
		    		$_SESSION['msg'] = "Ops! Isso não é uma imagem.";		
					header("Location:cadastrar.php");            	
		   	 	}
		   	 	// Pega as dimensões da imagem, criando um novo vetor através da função nativa getimagesize
				$dimensoes = getimagesize($img['tmp_name']);
					//print_r($dimensoes);exit;
					//echo $dimensoes[0];exit;
					// Verifica se a largura da imagem é maior que a largura permitida
					if($dimensoes[0] > $largura) {
						$_SESSION['msg'] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
						$_SESSION['cor'] = "vermelha";
						header("Location:cadastrar.php");  
					} else if($dimensoes[1] > $altura) {
						$_SESSION['msg'] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
						$_SESSION['cor'] = "vermelha";
						header("Location:cadastrar.php");
					} else if($img['size'] > $tamanho) {
			   		 	$_SESSION['msg'] = "A imagem deve ter no máximo ".$tamanho." bytes";
			   		 	$_SESSION['cor'] = "vermelha";
			   		 	header("Location:cadastrar.php");
					}else {
					
						// Pega extensão da imagem
						preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $img["name"], $ext);

			        	// Gera um nome único para a imagem, esse nome será criptografado em md5 (assim como poderia ser em sha1, preferi md5 porque não requer tanta segurança e o número de caracteres é menor que sha1), juntamente com o milesegundos que estou upando a imagem
			        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

			        	// Caminho de onde ficará a imagem
			        	$caminho = "imagemPerfil/" . $nome_imagem;

						// Faz o upload da imagem para seu respectivo caminho
						$certo = move_uploaded_file($img['tmp_name'], $caminho);

						//var_dump($caminho, $certo, $img); exit;

				   	 }
			}




			

		if (!empty($nome) or !empty($sexo) or !empty($celular) or !empty($email) or !empty($senha) or !empty($perfil) or $certo) {
			$erro = false;
			$mensagem = "Postagem realizada com sucesso!";
		}

			//var_dump($erro, $mensagem);  exit;
		if(!$erro){			

			//decodificando a senha digitada pelo usuario
			$senhacodificada = sha1($senha);
			//ar_dump($senhacodificada);exit;

			$query = "INSERT INTO usuario (nome, sexo, celular, email, senha, foto, perfil) VALUES(
									'$nome',
									'$sexo',
									'$celular',
									'$email',
									'$senhacodificada',
									'$nome_imagem',
									'$perfil')";
						
			$exe = mysqli_query($conexao,$query);
			//var_dump($exe, $query);	exit;	
			$_SESSION['msg'] = "Usuario Cadastrado com sucesso!";
			$_SESSION['cor'] = "azul";
			header("Location: listarUsuarios.php");	

		}else{
			$_SESSION['msg'] = $mensagem;
			$_SESSION['cor'] = "vermelha";
			header("Location: cadastrar.php");
		}

	// Edicao do cadastro 	
	}else if(isset($_POST['btnEditar'])){
		// Caso nenhuma das opcoes nao exista
		$id = $_POST['idusuario'];
		$nome = $_POST['nomeUsuario'];
		$sexo = $_POST['sexo'];
		$celular = $_POST['celular'];
		$email = $_POST['email'];		
		$foto = $_FILES['fotoNova'];
		$perfil = $_POST['perfilUsuario'];
		


		

		//var_dump($sexo);exit;

		$consulta = "SELECT * FROM usuario WHERE $id = id_usuario ";	
		$exe =	mysqli_query($conexao, $consulta);
		var_dump($consulta, $exe);
		while ($dados = mysqli_fetch_array($exe)) {			
			if (!isset($perfil)) {
				$perfil = $dados['perfil']; 
			} 
		}

			

		

				
		
		if ($foto["error"] == 4) {
			$query = "UPDATE usuario 
				  SET nome = '$nome',
				  	  sexo = '$sexo',
				  	  celular = '$celular',
				  	  email = '$email',
				  	  perfil = '$perfil'
				  WHERE id_usuario = $id ";

		} else if ($foto["error"] == 0) {

			
			// Largura máxima em pixels
			$largura = 180;
			// Altura máxima em pixels
			$altura = 180;
			// Tamanho máximo do arquivo em bytes
			$tamanho = 1000000; // coloquei 1 megabyte
	    	// Verifica se o arquivo é uma imagem através de uma função nativa do PHP preg_match, através de expressões regulares

	    	//var_dump(preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto['name'], $ext)); exit;

		    	if(!preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto['name'], $ext)){
		    		$_SESSION['msg'] = "Ops! Isso não é uma imagem.";
		    		$_SESSION['cor'] = "vermelha";			
					header("Location:editarUsuario.php?id_usuario=".$dados['id_usuario']."&editar=1");           	
		   	 	}
		   	 	// Pega as dimensões da imagem, criando um novo vetor através da função nativa getimagesize
				$dimensoes = getimagesize($foto['tmp_name']);
					//print_r($dimensoes);exit;
					//echo $dimensoes[0];exit;
					// Verifica se a largura da imagem é maior que a largura permitida
					if($dimensoes[0] > $largura) {
						$_SESSION['msg'] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
						$_SESSION['cor'] = "vermelha";						
						header("Location:editarUsuario.php?id_usuario=".$dados['id_usuario']."&editar=1");  
					} else if($dimensoes[1] > $altura) {
						$_SESSION['msg'] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
						$_SESSION['cor'] = "vermelha";
						header("Location:editarUsuario.php?id_usuario=".$dados['id_usuario']."&editar=1");
					} else if($foto['size'] > $tamanho) {
			   		 	$_SESSION['msg'] = "A imagem deve ter no máximo ".$tamanho." bytes";
			   		 	$_SESSION['cor'] = "vermelha";
			   		 	header("Location:editarUsuario.php?id_usuario=".$dados['id_usuario']."&editar=1");
					}else {
					
						// Pega extensão da imagem
						preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

						//var_dump($ext);exit;
			        	// Gera um nome único para a imagem, esse nome será criptografado em md5 (assim como poderia ser em sha1, preferi md5 porque não requer tanta segurança e o número de caracteres é menor que sha1), juntamente com o milesegundos que estou upando a imagem
			        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

			        	// Caminho de onde ficará a imagem
			        	$caminho = "imagemPerfil/" . $nome_imagem;

			        	
						if ($dados['foto']) {
							// excluindo imagem 
							unlink ("imagemPerfil/". $dados['foto']);
						} 				
							
						// Faz o upload da imagem para seu respectivo caminho
						$certo = move_uploaded_file($foto['tmp_name'], $caminho);

						//var_dump($caminho, $certo, $img); exit;

				   	 }
			
				   	 
				   	 
			$query = "UPDATE usuario 
				  SET nome = '$nome',
				  	  sexo = '$sexo',
				  	  celular = '$celular',
				  	  email = '$email',
				  	  foto = '$nome_imagem',
				  	  perfil = '$perfil'
				  WHERE id_usuario = $id ";

		}
		
		
		$exe =	mysqli_query($conexao, $query);
		//var_dump($exe, $query);	exit;
		if ($exe) {
		 	$_SESSION['msg'] = "Usuario Editado com sucesso";
		 	$_SESSION['cor'] = "azul";		
			header("Location: listarUsuarios.php");
		}else{
			$_SESSION['msg'] = "Erro ao Editar o usuario";
			$_SESSION['cor'] = "vermelha";		
			header("Location: listarUsuarios.php");
		}
	// alterar senha
	}else if(isset($_POST['btnEditarSenha'])){
		$usuario = $_POST['idusuario'];
		$novaSenha = $_POST['novaSenha'];
		$confirmarNovaSenha = $_POST['confirmarSenha'];
		//var_dump($usuario, $novaSenha, $confirmarNovaSenha);exit;

		if (!empty($novaSenha) and !empty($confirmarNovaSenha)) {
			// verificando se as senhas digitadas são iguais
			if ($novaSenha != $confirmarNovaSenha) {
				$_SESSION['msg'] = "As senhas não se coincidem";
				$_SESSION['cor'] = "vermelha";		
				header("Location: editarUsuario.php");

			// verificando se as senhas digitadas tem mais de 6 caracteres
			} elseif (strlen($novaSenha) < 6 or strlen($confirmarNovaSenha) <6) {
				$_SESSION['msg'] = "As senhas precisam ter mais de 6 caracteres";
				$_SESSION['cor'] = "vermelha";		
				header("Location: editarUsuario.php");
			// se tudo estiver certo
			} else{
				$query = "SELECT * FROM usuario WHERE id_usuario = $usuario";
				$exeUsuario = mysqli_query($conexao, $query);
				while ($dadosUsuario = mysqli_fetch_assoc($exeUsuario)) {
					$senhaCriptografada = sha1($novaSenha);
					// atualizando a senha
					$queryAtualizacao = "UPDATE usuario SET senha = '$senhaCriptografada' WHERE id_usuario = $usuario";
					$exeAtualizacao = mysqli_query($conexao, $queryAtualizacao);
					//var_dump($queryAtualizacao, $exeAtualizacao);exit;
					// exibindo mensagem
					if ($exeAtualizacao) {
						$_SESSION['msg'] = "Senha Alterada com sucesso! Não esquecer de logar no próximo acesso com esta nova senha";
						$_SESSION['cor'] = "azul";		
						header("Location: editarUsuario.php?id_usuario=$usuario");
					}else{
						$_SESSION['msg'] = "Erro ao atualizar a senha";
						$_SESSION['cor'] = "vermelha";		
						header("Location: editarUsuario.php?id_usuario=$usuario");
					}					
				}				
			}
		// caso a senha não seja digitada duas vezes		
		}else {	
			$_SESSION['msg'] = "Digite duas vezes a nova senha";
			$_SESSION['cor'] = "vermelha";		
			header("Location: editarUsuario.php?id_usuario=$usuario");
		}

	// Excluir Cadastro	
	}else if ($_GET['deletar'] == 1) {
		$id = $_GET['id_usuario'];


		$query = "DELETE FROM usuario WHERE id_usuario = $id";
		$exe = mysqli_query($conexao, $query);

		if ($exe) {
			$_SESSION['msg'] = "Usuario Excluido com sucesso";
			$_SESSION['cor'] = "azul";		
			header("Location: listarUsuarios.php");
		}else{
			$_SESSION['msg'] = "Erro ao excluir este usuario";
			$_SESSION['cor'] = "vermelha";		
			header("Location: listarUsuarios.php");
		}

	// caso seja modificado o valor de deletar	
	}else if ($_GET['deletar'] != 1){
		$_SESSION['msg'] = "Erro ao excluir este usuario";
		$_SESSION['cor'] = "vermelha";		
		header("Location: listarUsuarios.php");
	// Caso acessem a pagina sem pressionar alguma funcao (CRUD)
	}else{
		$_SESSION['msg'] = "Pagina nao encontrada!";
		$_SESSION['cor'] = "vermelha";
		unset($_SESSION['msg']);
		header("Location: login.php");
	}
?>