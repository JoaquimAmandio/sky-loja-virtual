<?php
use core\classes\Store;
?>
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-3">
            <?php require_once(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>

        <div class="col-md-9">

            <div class="row">
                <div class="col">
                <h4>Detalhe da encomenda -</h4> <small><?= $encomenda->codigo_encomenda ?></small>
                </div>
                <div class="col text-end">
                   <div class="text-center p-3 badge bg-primary btn" onclick="apresentarModal()"><?=$encomenda->estado?></div>
                </div>
                <?php if($encomenda->estado=='EM PROCESSAMENTO'):?>
                    <div class="text-end">
                        <a href="" class="btn btn-primary btn-sm">pdf</a>
                    </div>
                 <?php endif;?>
            </div>

         
            <hr>
            <div class="row">
                <div class="col">
                    <p class="text-bold">Nome Cliente: <br><?=$encomenda->nome_completo?> </p>
                    <p>Email: <br><?= $encomenda->email ?> </p>
                    <p>Telefone: <br><?= $encomenda->telefone ?> </p>
                </div>

                <div class="col">
                    <p>Data Encomenda: <br><?= $encomenda->data_encomenda ?> </p>
                    <p>Morada: <br><?= $encomenda->morada ?> </p>
                    <p>Cidade: <br><?= $encomenda->cidade ?> </p>

                </div>
            </div>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produto/Serviço</th>
                        <th>Preço</th>
                        <th>Quantidade</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_produtos as $produto):?>
                    <tr>
                        <td><?= $produto->designacao_produto?></td>
                        <td><?=number_format($produto->preco,2,'.','.').'kzs' ?></td>
                        <td><?= $produto->quantidade?></td>
                    </tr>
                    <?php endforeach;?>

                </tbody>
            </table>


        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEstado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alterar Estado Da Encomenda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
               <?php foreach(ESTADOS as $estad):?>
                <?php if($encomenda->estado==$estad):?>
                    <p><?= $estad?></p>
                <?php else:?>
                    <p><a href="?a=encomenda_alterar_estado&e=<?=Store::aesencriptar($encomenda->id_encomenda)?>&s=<?=$estad?>"><?= $estad?></p></a>
                <?php endif;?>

               <?php endforeach;?>
      </div>
      <div class="modal-footer">
          
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        
      </div>
    </div>
  </div>
</div>
<script>
    function apresentarModal(){
        console.log('Modal');
         var modalEstado = new bootstrap.Modal(document.getElementById('modalEstado'));
         modalEstado.show();
    }
</script>