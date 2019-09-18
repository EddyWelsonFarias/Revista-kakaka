 <?php
    include_once("conexao.php");

    $query = "SELECT noticia.id_noticia,noticia.titulo, count(comentario.id_noticia) as 'qtdeComentarios' 
              FROM comentario, noticia 
              WHERE noticia.id_noticia = comentario.id_noticia              
              GROUP BY comentario.id_noticia
              ORDER BY qtdeComentarios desc
              LIMIT 5";
    $exe = mysqli_query($conexao, $query);
    //var_dump($exe, $query);exit;
    
    
 ?>

 <footer class="pt-4 my-md-4 pt-md-4 border-top">
    <div class="row">
      <div class="col-12 col-md">        
        <small class="d-block mb-3 text-muted">&copy; KaKaKa - 2019</small>
      </div>
      <div class="col-6 col-md">
        <h5>Filmes e Series mais comentadas </h5>
        <ul class="list-unstyled text-small">
          
                <?php 
                    while ($dados = mysqli_fetch_assoc($exe)) {                      
                ?>
                      
                        <li>
                           <a class="text-muted" href="visualizarPost.php?id_noticia=<?php echo $dados['id_noticia']; ?>">
                               <?php echo $dados['titulo']; ?>
                          </a>
                        </li>
                <?php          
                        }
                ?>
            
        </ul>
      </div>

      <div class="col-6 col-md">
        <h5>Desenvolvido por</h5>
        <ul class="list-unstyled text-small">
          <li class="text-muted">Andressa</a></li>
          <li class="text-muted">Eddy</li>
          <li class="text-muted">Ester</li>
          <li class="text-muted">Francisco</li>
          <li class="text-muted">Robson</li>
        </ul>
      </div>
    </div>
  </footer>