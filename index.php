
<style type="text/css">
  .titulo{
    text-align: center;
    margin-top: 10px;
  }

  .subtitulo{
    text-align: center;
    //border: 1px solid #000;

  }

  .noticia-abreviada{
    text-align: justify;
    margin-top: 15px;
  }

  .conteudo{
    display: flex;
    //padding: 10px;
    //border: 1px solid #000;
  }

  .box{
    display: flex 1;
    padding: 10px;

  }

  .botao{
    position: relative;
   // border: 1px solid #000;
    height: 40px;
  }

  .rodape{
    //border: 1px solid #000;
    position: absolute;
    width: 100%;
  }

</style>

<?php
            session_start();
            //var_dump($_SESSION);
            include_once("conexao.php");
            include_once("estrutura/site/cabecalho.php");

                if (isset($_SESSION['msg']) ) {
                  if ($_SESSION['cor'] == 'azul') {
                     echo "<div class='alert alert-primary' role='alert'>
                          ".$_SESSION['msg']."
                      </div>";
                  }else if ($_SESSION['cor'] == 'vermelha') {
                      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                          ".$_SESSION['msg']."
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                               <span aria-hidden='true'>&times;</span>
                          </button>
                      </div>";

                  } 
                  
                 unset($_SESSION['cor']);
                 unset($_SESSION['msg']);              
                }
?>
<main role="main">
  <section class="jumbotron text-center " style="background-image: url('img/capa.jpg') ;">
    <div class="container">
      <br><br><br><br><br><br><br><br>
     <!-- <h1 class="jumbotron-heading">Album example</h1>
      <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
      <p>
        <a href="#" class="btn btn-primary my-2">Main call to action</a>
        <a href="#" class="btn btn-secondary my-2">Secondary action</a>
      </p>-->
    </div>
  </section>

 <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
  <?php
      //passando por get
      $paginacao = (!isset($_GET['pagina'])) ? 1 : $_GET['pagina'];
      //$query = "SELECT * FROM noticia order by id_noticia desc LIMIT 9 ";
      $query = "SELECT * FROM noticia order by id_noticia ";
      $exe = mysqli_query($conexao, $query);
      //quantidade de registros 
      $total = mysqli_num_rows($exe);
      
      // arredonda para cima
      $numpaginas = ceil($total / 6);

    // var_dump($total, $numpaginas);exit;
      $exibir = 6;

      $inicioExibir = ($exibir * $paginacao) - $exibir;

       $query2 = "SELECT * FROM noticia order by id_noticia desc limit $inicioExibir, $exibir";
       $exe2 = mysqli_query($conexao, $query2);

       
      while ($resultado = mysqli_fetch_assoc($exe2)) {
        //var_dump($resultado); exit;   
                

  ?>      
        <div class="conteudo col-md-4">
          <div class="box card mb-4 shadow-sm ">
            <img src="<?php echo "postagem/upload/".$resultado['imagem'];?>" title="<?php echo $resultado['titulo']?>" width ="250px" height="250px" style="margin: 3px auto;">                               
            <div>
               <h5 class="titulo">
                <?php 
                echo $resultado['titulo']."<br>";
                //echo $resultado['subtitulo'];
                ?>                
              </h5>
              <div class="subtitulo">
                <?php echo $resultado['subtitulo']."<br>"; ?>
               </div>
               <p class="noticia-abreviada">
                <?php echo strip_tags(substr($resultado['noticia'],0,148))."...";?>
               </p>
               <div class="botao">
                   <div class="rodape d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="visualizarPost?id_noticia=<?php echo $resultado['id_noticia']?>">
                      <button type="button" class="btn btn-sm btn-outline-secondary">Visualizar</button>
                    </a>                
                  </div>
                  <!--<small class="text-muted">9 mins</small>-->
                 </div>

               </div>
              
            </div>
          </div>
        </div>

                
<?php }
           
    echo "<div style='width: 100%; text-align: center;'>";
      if ($total > 0) {
          for ($i=1; $i <= $numpaginas ; $i++) { 
            if ($i == $paginacao) {
             echo " <button type='button' class='btn btn-primary' disabled>".$i."</button> ";
            } else {
              echo " <a href='?pagina=".$i."' title='Pagina ".$i."' style='text-decoration: none;'>
                        <button type='button' class='btn btn-light'>".$i."</button>
                      </a> ";              
            }
          }
      }
    echo "</div>";  
?>
   
</main>

<?php include_once("estrutura/site/footer.php");?>
</div>
</body>
</html>
