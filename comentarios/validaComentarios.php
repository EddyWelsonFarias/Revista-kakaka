<?php
	include_once("../conexao.php");
	date_default_timezone_set('America/Sao_Paulo');
	session_start();

	// Aprovação - Area do Administrador
	if (isset($_SESSION['id_usuario'])) {

		if(isset($_GET['id_comentario']) and $_GET['aprovar'] == 1){
			$id = $_GET['id_comentario'];

			$query = "UPDATE comentario
					  SET flag = 1
					  WHERE id_comentario = $id
			";
			$exe = mysqli_query($conexao,$query);
			//var_dump($query, $exe)
				if ($exe) {
					$_SESSION['msg'] = "Comentário aprovado com sucesso!";
					$_SESSION['cor'] = "azul";
					header("Location:listaComentarios.php");
				} else {
					$_SESSION['msg'] = "Erro ao aprovar o comentário!";
					$_SESSION['cor'] = "vermelha";
					header("Location:listaComentarios.php");
				}
		
		}
	}
	/*else{
			$_SESSION['msg'] = "Digite o login e a senha!";
			$_SESSION['cor'] = "vermelha";
			header("Location: adm/login.php");
	}*/


	// cadastrando usuario para comentar
		if (isset($_POST['btnCadastrarComentarista'])) {
			$nome = $_POST['nome'];
			$sexo = $_POST['sexo'];
			$celular = $_POST['celular'];
			$email = $_POST['email'];
			$senha = $_POST['senha'];
			//var_dump($nome, $sexo, $celular, $email, $senha);exit;
			$erro = false;

			// verificando se o email ja esta cadastrado 
				$query = "SELECT * FROM usuario WHERE email = '$email' ";
				$resultadoQuery = mysqli_query($conexao,$query);
				 //var_dump($resultadoQuery);

			if (!isset($nome) and !isset($sexo) and !isset($celular) and !isset($email) and !isset($senha)) {			
				$erro = true;
				$mensagem = "Preencha os campos obrigatorios!";				
					// verificando se a senha tem mais de 6 caracteres 
			}else if (strlen($senha) < 6) {
				$erro = true;
				$mensagem = "A Senha deve ter no minimo 6 caracteres";
			} else if(strlen($celular) > 16){
				$erro = true;
				$mensagem = "Insira um celular válido";
			}else if ($resultadoQuery->num_rows != 0){
					$erro = true;
					$mensagem = "Email ja cadastrado, Favor usar outro! ";
			}			
			
			//var_dump($mensagem, $erro);exit;		
			if(!$erro){			

				//decodificando a senha digitada pelo usuario
				$senhacodificada = sha1($senha);
				//var_dump($senhacodificada);

				$query = "INSERT INTO usuario (nome, sexo, celular, email, senha, foto, perfil) VALUES(
										'$nome',
										'$sexo',
										'$celular',
										'$email',
										'$senhacodificada',	
										'perfil_comentario.png',
										'c')";
							
				$exe = mysqli_query($conexao,$query);
				//var_dump($exe, $query);	exit;	
				$_SESSION['msgCadastrar'] = "Usuario Cadastrado com sucesso!";
				$_SESSION['corCadastrar'] = "azul";
				header("Location: ../loginComentario.php");	

			}else{
				$_SESSION['msgCadastrar'] = $mensagem;
				$_SESSION['corCadastrar'] = "vermelha";
				header("Location: ../loginComentario.php");
			}

		}

	//Logar para comentar
		if (isset($_POST['btnLogarComentario'])) {
			$login = $_POST['login'];
			$senha = $_POST['senha'];
			//decodificando a senha digitada pelo usuario
			$senhacodificada = sha1($senha);
			//var_dump($login, $senha);exit;
			if (isset($login) and isset($senha)) {						
				$senhacodificada = sha1($senha);
						$query = "SELECT * FROM usuario WHERE email = '$login' and senha = '$senhacodificada'";
						$exe = mysqli_query($conexao, $query);	
						//var_dump($exe); exit;				
						if($exe->num_rows == 1){

							while ($dadoUsuario = mysqli_fetch_assoc($exe)) {
								//var_dump($dadoUsuario['id_usuario']);exit;
								$_SESSION['id_usuarioComentario'] = $dadoUsuario['id_usuario'];	
								//var_dump($_SESSION);exit;
								header("Location:../index.php");
							}
								
						}else{
							//echo "entrou errado"; exit;
							$_SESSION['msgLogar'] = "Login e senha incorreto!";
							$_SESSION['corLogar'] = "vermelha";
							header("Location: ../loginComentario.php");
						}	
								
			
			}		

		}



	if(isset($_SESSION['id_usuarioComentario'])){
		
		//inserindo comentario
		if (isset($_POST['btnComentario'])) {
			$idNoticia = $_POST['idNoticia'];
			$usuarioComentario = $_POST['nomeUsuarioComentario'];
			$emailUsuarioComentario = $_POST['emailUsuarioComentario'];
			$ComentarioUsuario = $_POST['comentarioUsuario'];
			$usuario = $_SESSION['id_usuarioComentario'];
			$diaHora = date('Y-m-d H:i:s');
			//var_dump($usuarioComentario, $emailUsuarioComentario); exit;

			if (!empty($ComentarioUsuario) and isset($_SESSION['id_usuarioComentario'])) {
					
					$query = "INSERT INTO comentario (comentario, flag, dia, id_usuario, id_noticia)
							VALUES ('$ComentarioUsuario', 0, '$diaHora',$usuario,$idNoticia) ";
					$exe = mysqli_query($conexao, $query);					
					//var_dump($query, $exe);	exit;

					if ($exe) {
						$_SESSION['mensagemComentario'] = "Comentario enviado com sucesso! <br><br> Aguarde seu comentário ser aprovado pelo administrador do site";
						$_SESSION['corComentario'] = "azul";			
						header("Location:../visualizarPost.php?id_noticia=$idNoticia");
					} else {
						$_SESSION['mensagemComentario'] = "Erro ao inserir o comentário no banco!";
						$_SESSION['corComentario'] = "vermelha";			
						header("Location:../visualizarPost.php?id_noticia=$idNoticia");
					}
					

					
				
			} else {
				$_SESSION['mensagemComentario'] = "Preencha todos os dados!";
				$_SESSION['corComentario'] = "vermelha";			
				header("Location:../visualizarPost.php?id_noticia=$idNoticia");
			}
			
			//var_dump($usuarioComentario, $emailUsuarioComentario, $ComentarioUsuario);	
		
		
		} 
		// alterando perfil conta cliente
		if(isset($_POST['btnAlterarCadastroComentario'])){
			$id = $_POST['idusuario'];
			$nome = $_POST['nomeUsuario'];
			$sexo = $_POST['sexo'];
			$celular = $_POST['celular'];
			$email = $_POST['email'];		
			$foto = $_FILES['novaFoto'];
			//var_dump($foto);exit;
			$consulta = "SELECT * FROM usuario WHERE $id = id_usuario ";	
			$exe =	mysqli_query($conexao, $consulta);
			//var_dump($consulta, $exe);
			$dados = mysqli_fetch_array($exe);			
					
		
				if ($foto["error"] == 4) {
					$query = "UPDATE usuario 
						  SET nome = '$nome',
						  	  sexo = '$sexo',
						  	  celular = '$celular',
						  	  email = '$email'
						  WHERE id_usuario = $id ";

				} else if ($foto["error"] == 0) {

					
					// Largura máxima em pixels
					$largura = 180;
					// Altura máxima em pixels
					$altura = 180;
					// Tamanho máximo do arquivo em bytes
					$tamanho = 1000000; // coloquei 1 megabyte
			    	// Verifica se o arquivo é uma imagem através de uma função nativa do PHP preg_match, através de expressões regulares
					// Pega as dimensões da imagem, criando um novo vetor através da função nativa getimagesize
					$dimensoes = getimagesize($foto['tmp_name']);
					//var_dump($dimensoes);exit;
			    	//var_dump(preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto['name'], $ext)); exit;

				    	if(!preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto['name'], $ext)){
				    		$_SESSION['msgCadastrar'] = "Ops! Isso não é uma imagem.";
				    		$_SESSION['corCadastrar'] = "vermelha";			
							header("Location:../perfilUsuarioComenta.php"); 
							// Verifica se a largura da imagem é maior que a largura permitida          	
				   	 	}else if($dimensoes[0] > $largura) {
								$_SESSION['msgCadastrar'] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
								$_SESSION['corCadastrar'] = "vermelha";						
								header("Location: ../perfilUsuarioComenta.php");  
						} else if($dimensoes[1] > $altura) {
								$_SESSION['msgCadastrar'] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
								$_SESSION['corCadastrar'] = "vermelha";
								header("Location: ../perfilUsuarioComenta.php");
						} else if($foto['size'] > $tamanho) {
					   		 	$_SESSION['msgCadastrar'] = "A imagem deve ter no máximo ".$tamanho." bytes";
					   		 	$_SESSION['corCadastrar'] = "vermelha";
					   		 	header("Location: ../perfilUsuarioComenta.php");
						}else {
							
								// Pega extensão da imagem
								preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

								//var_dump($ext);exit;
					        	// Gera um nome único para a imagem, esse nome será criptografado em md5 (assim como poderia ser em sha1, preferi md5 porque não requer tanta segurança e o número de caracteres é menor que sha1), juntamente com o milesegundos que estou upando a imagem
					        	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

					        	// Caminho de onde ficará a imagem
					        	$caminho = "../cadastroUsuario/imagemPerfil/" . $nome_imagem;

					        	
								if ($dados['foto']) {
									// excluindo imagem 
									unlink ("../cadastroUsuario/imagemPerfil/". $dados['foto']);
								} 				
									
								// Faz o upload da imagem para seu respectivo caminho
								$certo = move_uploaded_file($foto['tmp_name'], $caminho);

								//var_dump($caminho, $certo); exit;

						   	 }
						   	 //var_dump($dimensoes);exit;
					
						   	 
					if ($certo) {
						$query = "UPDATE usuario 
						  SET nome = '$nome',
						  	  sexo = '$sexo',
						  	  celular = '$celular',
						  	  email = '$email',
						  	  foto = '$nome_imagem'
						  WHERE id_usuario = $id ";
						   	 
					}	   	 
					

				}

				if($dimensoes[0] > $largura) {
								$_SESSION['msgCadastrar'] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
								$_SESSION['corCadastrar'] = "vermelha";						
								header("Location: ../perfilUsuarioComenta.php");  
						} else if($dimensoes[1] > $altura) {
								$_SESSION['msgCadastrar'] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
								$_SESSION['corCadastrar'] = "vermelha";
								header("Location: ../perfilUsuarioComenta.php");
						} else if($foto['size'] > $tamanho) {
					   		 	$_SESSION['msgCadastrar'] = "A imagem deve ter no máximo ".$tamanho." bytes";
					   		 	$_SESSION['corCadastrar'] = "vermelha";
					   		 	header("Location: ../perfilUsuarioComenta.php");
						}

				//var_dump($query);
				//var_dump($dimensoes);exit;
					$exe =	mysqli_query($conexao, $query);
					//var_dump($exe, $query);	exit;
					if ($exe) {
					 	$_SESSION['msgCadastrar'] = "Usuario Editado com sucesso";
					 	$_SESSION['corCadastrar'] = "azul";		
						header("Location: ../perfilUsuarioComenta.php");
					}else{
						$_SESSION['msgCadastrar'] = "Erro ao Editar o usuario";
						$_SESSION['corCadastrar'] = "vermelha";		
						header("Location: ../perfilUsuarioComenta.php");
					}

		}


		// alterar senha do perfil site
		if(isset($_POST['btnSenha'])){
		 	
			$usuario = $_POST['idusuario'];
			$novaSenha = $_POST['novaSenha'];
			$confirmarNovaSenha = $_POST['confirmarSenha'];
			//var_dump($usuario, $novaSenha, $confirmarNovaSenha);exit;

			if (!empty($novaSenha) and !empty($confirmarNovaSenha)) {
				// verificando se as senhas digitadas são iguais
				if ($novaSenha != $confirmarNovaSenha) {
					$_SESSION['msgCadastrar'] = "As senhas não se coincidem";
					$_SESSION['corCadastrar'] = "vermelha";		
					header("Location: ../perfilUsuarioComenta.php");

				// verificando se as senhas digitadas tem mais de 6 caracteres
				} elseif (strlen($novaSenha) < 6 or strlen($confirmarNovaSenha) <6) {
					$_SESSION['msgCadastrar'] = "As senhas precisam ter mais de 6 caracteres";
					$_SESSION['corCadastrar'] = "vermelha";		
					header("Location: ../perfilUsuarioComenta.php");
				// se tudo estiver certo
				} else{
					$senhaCriptografada = sha1($novaSenha);
					$query = "SELECT * FROM usuario WHERE id_usuario = $usuario";
					$exeUsuario = mysqli_query($conexao, $query);
					//var_dump($query, $exeUsuario, $novaSenha, $senhaCriptografada);exit;
					while ($dadosUsuario = mysqli_fetch_assoc($exeUsuario)) {
						
						// atualizando a senha
						$queryAtualizacao = "UPDATE usuario SET senha = '$senhaCriptografada' WHERE id_usuario = $usuario";
						$exeAtualizacao = mysqli_query($conexao, $queryAtualizacao);
						//var_dump($queryAtualizacao, $exeAtualizacao);exit;
						// exibindo mensagem
						if ($exeAtualizacao) {
							$_SESSION['msgCadastrar'] = "Senha Alterada com sucesso! Não esquecer de logar no próximo acesso com esta nova senha";
							$_SESSION['corCadastrar'] = "azul";		
							header("Location: ../perfilUsuarioComenta.php");
						}else{
							$_SESSION['msgCadastrar'] = "Erro ao atualizar a senha";
							$_SESSION['corCadastrar'] = "vermelha";		
							header("Location: ../perfilUsuarioComenta.php");
						}					
					}				
				}

			}

		}

		// excluir conta
		if(isset($_GET['excluirConta']) == "sim"){
			$usuario = $_GET['id'];
			$queryConta = "SELECT * FROM usuario where id_usuario = $usuario";
			$exeQueryConta = mysqli_query($conexao, $queryConta);

			if($exeQueryConta){
				$exclusao = "DELETE FROM usuario WHERE id_usuario = $usuario";
				$exeExclusao = mysqli_query($conexao, $exclusao);
				if($exeExclusao){
					header("Location: ../adm/sair.php?sair=OKEXCLUSAO");
				}else{
					$_SESSION['msgLogar'] = "Erro ao excluir a conta!";
					$_SESSION['corLogar'] = "vermelha";
					header("Location: ../perfilUsuarioComenta.php");
				}
			}


		}

	}
	/*else{
			$_SESSION['msgLogar'] = "Digite o login e a senha!";
			$_SESSION['corLogar'] = "vermelha";
			header("Location: ../loginComentario.php");
	}*/

	
	

	
	
	

?>