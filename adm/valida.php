<?php
session_start();
include_once("../conexao.php");

$btnlogin = $_POST['btnLogin'];
$login = $_POST['login'];
$senha = $_POST['senha'];

//var_dump($login, $senha); exit;
	
	if ($btnlogin) {
			if (isset($login) and isset($senha)) {			
					$senhacodificada = sha1($senha);
					$query = "SELECT * FROM usuario WHERE perfil != 'c' and email = '$login' and senha = '$senhacodificada'";
					$exe = mysqli_query($conexao, $query);					
					if($exe->num_rows == 1){

						while ($dadoUsuario = mysqli_fetch_assoc($exe)) {
							//var_dump($acesso['id_usuario']);exit;
							$_SESSION['id_usuario'] = $dadoUsuario['id_usuario'];	
							//var_dump($_SESSION);exit;
							header("Location:administrativo.php");
						}
							
					}else{
						//echo "entrou errado"; exit;
						$_SESSION['msg'] = "Login e senha incorreto!";
						$_SESSION['cor'] = "vermelha";
						header("Location: login.php");
					}		
			}	
		}else{
			$_SESSION['msg'] = "Pagina nao encontrada!";
			$_SESSION['cor'] = "vermelha";
			header("Location: login.php");
		}
	
?>