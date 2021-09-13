<div class="container-fluid">
    <div class="row ">
        <div class="col-md">
    <?php

use core\classes\Store;

require_once(__DIR__ .'/layouts/admin_menu.php')?>
        </div>

        <div class="col">
        <h3>Lista de Clientes </h3>
           <hr>
           <?php if(count($clientes)==0): ?>
            <p class="text-center text-muted">Não existem Clientes Registrados</p>
           <?php else: ?>
            <table class="table table-sm responsive" id='tabela-cliente'>
                <thead  class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                     
                        <th >Telefone</th>
                        <th class="text-center">Encomendas</th>
                        <th class="text-center">Activo</th>
               
                        <th class="text-center"><i class="fas fa-deleted"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($clientes as $cliente): ?>
                    <tr>
                        <td>
                            <a href="?a=detalhe_cliente&c=<?=Store::aesencriptar($cliente->id_cliente)?>">
                            <?= $cliente->nome_completo?>
                            </a>
                        </td>
                        <td><?= $cliente->email?></td>
                        
                        <td><?= $cliente->telefone?></td>
                        <td class="text-center">
                            <?php if($cliente->total_encomendas==0):?>
                                -
                            <?php else:?>
                            <a href="?a=lista_encomendas&c=<?=Store::aesencriptar($cliente->id_cliente)?>"><?= $cliente->total_encomendas?> </a>
                            <?php endif;?>
                        </td>
                        <td class="text-center">
                            <?php if($cliente->activo==1):?>
                            <span class="text-primary"><i class="fas fa-check-circle"></i></span>
                            <?php else:?>
                             <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                            <?php endif;?>
                        </td>
               
                        <td class="text-center">
                        <?php if($cliente->deleted_at==null):?>
                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                            <?php else:?>
                             <span class="text-primary"><i class="fas fa-check-circle"></i></span>
                            <?php endif;?>
                        </td>

                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
           <?php endif;  ?>

        </div>
    </div>
</div>
<script>
       $(document).ready(function(){
        $('#tabela-cliente').DataTable(
          
        );
    })
</script>