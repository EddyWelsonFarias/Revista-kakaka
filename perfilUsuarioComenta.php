<?php

	include_once("conexao.php");
	session_start();
	include_once("estrutura/site/cabecalho.php");
	
	//var_dump($_SESSION);
	if (isset($_SESSION['id_usuarioComentario'])) {		
?>

   <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
		<!--<form method="POST" action="" enctype="">
			<div class="form-group">
				<label>Alterar Foto: </label><br>
				<input type="file" name="imagemComenta">
			</div>
			<div class="form-group">
				<label>Sexo: </label><br>
				<select>
					<option>Masculino</option>
					<option>Feminino</option>
				</select>
			</div>
			<div class="form-group">
				<label>Celular: </label><br>
				<input type="text" name="celular">
			</div>
			<div class="form-group">
				<label>E-mail: </label><br>
				<input type="text" name="email">
			</div>
		</form>-->
		<aside class="col-sm-9">      
          <div class="card">
          	<div class="row">
          		<div class="col-sm-8">          			
          			<article class="card-body">               
	                  <h4 class="card-title mb-4 mt-1">Perfil</h4>	                  
	                  <?php         

	                      if (isset($_SESSION['msgCadastrar']) ) {
	                               if ($_SESSION['corCadastrar'] == 'azul') {
	                                 echo "<div class='alert alert-primary' role='alert'>
	                                      ".$_SESSION['msgCadastrar']."
	                                  </div>";
	                               }else if ($_SESSION['corCadastrar'] == 'vermelha') {
	                                  echo "<div class='alert alert-danger' role='alert'>
	                                      ".$_SESSION['msgCadastrar']."
	                                  </div>";
	                              } 
	                            
	                           unset($_SESSION['corCadastrar']);
	                           unset($_SESSION['msgCadastrar']);              
	                          }

	                      $usuario = $_SESSION['id_usuarioComentario'];
	                      $query = "SELECT * FROM usuario where id_usuario = $usuario";
	                      $exeQuery = mysqli_query($conexao, $query);
	                      $dadosQuery = mysqli_fetch_assoc($exeQuery);
		                      if ($dadosQuery['sexo'] == 'm'){
		                      		$principal = 'Masculino';
		                           	$sexo2 = 'f';
		                           	$mens = 'Feminino';
		                       }else if($dadosQuery['sexo'] == 'f'){
		                       		$principal = 'Feminino';
		                           	$sexo2 = 'm';
		                           	$mens = 'Masculino';
		                       	}	                                           	
	                    ?> 
	                      <form method="POST" action="comentarios/validaComentarios.php" enctype="multipart/form-data">
		                      	<div class="form-group">
		                      		<input type="hidden" name="idusuario" value="<?php echo $dadosQuery['id_usuario'];?>">
		                      		<img src="cadastroUsuario/imagemperfil/<?php echo $dadosQuery['foto'];?>" alt="" title=""><br>
									<label>Alterar Foto: </label><br>
									<input type="file" name="novaFoto">
						  		</div><br>
		                        <div class="form-group">
		                           <input type="text" name="nomeUsuario" class="form-control" value="<?php echo $dadosQuery['nome'];?>" required="" >
		                        </div> <!-- form-group// -->
		                        <div class="form-group">
		                           <input name="sexo" type="radio" value="<?php echo $dadosQuery['sexo'];?>" checked> <?php echo $principal;?>  
		                            <input name="sexo" type="radio" value="<$php echo $sexo2;?>"> <?php echo $mens;?>
		                        </div> <!-- form-group// -->
		                        <div class="form-group">
		                           <input name="celular" class="form-control" type="text" value="<?php echo $dadosQuery['celular'];?>" required="">
		                        </div> <!-- form-group// -->
		                        <div class="form-group">
		                           <input name="email" class="form-control" placeholder="ocara@ocara.com.br" type="email" value="<?php echo $dadosQuery['email'];?>" required="">
		                        </div> <!-- form-group// -->	                            
		                          <div class="row">
		                              <div class="col-md-6">
		                                  <div class="form-group">
		                                      <button type="submit" name="btnAlterarCadastroComentario" class="btn btn-success btn-block"> Alterar  </button>
		                                  </div> <!-- form-group// -->
		                              </div>                                           
		                          </div> <!-- .row// -->                                         
	                      </form>
           			</article>
          		</div>          		
          		<div class="col-sm-4" >
          					<br>
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
													<form method="POST" action="comentarios/validaComentarios.php">
														<input type="hidden" name="idusuario" value="<?php echo $dadosQuery['id_usuario']?>">
														<input type="password" name="novaSenha" placeholder="Digite a nova senha"><br><br>
														<input type="password" name="confirmarSenha" placeholder="Confirmar nova senha"><br><br>
														
													      <div class="modal-footer">
													        <input type="submit" name="btnSenha" class="btn btn-primary" value="Alterar">		        
														  </div>
													</form>
												</div>
									      </div>
									    </div>
								  </div>
							</div>
							<?php
								if($dadosQuery['perfil'] == 'c'){

							?>
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
							  Deletar Conta
							</button>

							<!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">Excluir conta</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							       <p>Deseja realmente excluir sua conta? </p>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
							        <a href="comentarios/validaComentarios.php?excluirConta=Sim&id=<?php echo $usuario; ?>">
							        	<button type="button" class="btn btn-danger">Sim</button>
							    	</a>
							      </div>
							    </div>
							  </div>
							</div>
							<?php

								}
							?>
				</div>
          		
          	</div>
            
          </div> <!-- card.// -->
        </aside> <!-- col.// -->
	</div>
  </div>
</div>


<?php


	} else {
		$_SESSION['msgLogar'] = "Login e senha incorreto!";
		$_SESSION['corLogar'] = "vermelha";
		header("Location: index.php");
	}

?>