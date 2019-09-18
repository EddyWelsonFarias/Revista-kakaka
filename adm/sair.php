<?php
	session_start();
	

	if ($_GET['sair'] == "OKADM") {
		//print_r($_SESSION);exit;
		$_SESSION['msg'] = "Deslogado com Sucesso!";
		$_SESSION['cor'] = "vermelha";
		//$temp = $_SESSION['id_usuarioComentario'];
		//var_dump($temp);exit;
		//session_destroy();
		unset($_SESSION['id_usuario']);
		//$_SESSION['id_usuarioComentario'] = $temp;
		header("Location:login.php");
	} 

	if ($_GET['sair'] == "OKCOMENTARIO") {
		$_SESSION['msg'] = "Deslogado com Sucesso!";
		$_SESSION['cor'] = "vermelha";
		//$temp = $_SESSION['id_usuario'];
		//var_dump($temp);exit;
		//session_destroy();
		unset($_SESSION['id_usuarioComentario']);
		//$_SESSION['id_usuario'] = $temp;
		//volta para a pagina anterior
		header("Location: ".$_SERVER['HTTP_REFERER']."");
		//var_dump($_SESSION); exit;
	}
	
	// EXCLUSAO DE CONTA
	if($_GET['sair'] == "OKEXCLUSAO"){
		$_SESSION['msg'] = "Conta excluida com sucesso";
		$_SESSION['cor'] = "vermelha";
		unset($_SESSION['id_usuarioComentario']);
		header("Location:../index.php");
	}
?>