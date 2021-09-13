<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-3">
    <?php

use core\classes\Store;

require_once(__DIR__ .'/layouts/admin_menu.php')?>
        </div>

        <div class="col-md-9">
            <h4>Detalhe do Cliente</h4>
            <hr>
            <div class="row mt-4 ">
                <div class="col-3 text-end fw-bold"> Nome : </div>
                <div class="col-8"> <?=$dados_cliente->nome_completo ?>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-end fw-bold"> Morada: </div>
                <div class="col-8"> <?=$dados_cliente->morada ?>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-end fw-bold"> Cidade: </div>
                <div class="col-8"> <?=$dados_cliente->cidade ?>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-end fw-bold"> Telefone: </div>
                <div class="col-8"> <?=$dados_cliente->telefone ?>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-end fw-bold"> Email: </div>
                <div class="col-8"><a href="mailto:<?=$dados_cliente->email ?>"> <?=$dados_cliente->email ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-end fw-bold">Estado: </div>
                <div class="col-8"> <?=$dados_cliente->activo==0?  '<span class="text-danger">inativo</span>':'<span class="text-primary">activo</span>' ?>
                </div>
            </div>
            <div class="row">
                <div class="col-3 text-end fw-bold"> Cliente Desde: </div>
                <div class="col-8"> <?=$dados_cliente->created_at ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                <?php if($total_encomendas==0):?>
            <div class="col text-center">
                <p class="text-muted">Não existem encomendas deste cleinte</p>
            </div>
            <?php else:?>
               <a href="?a=cliente_historico_encomenda&c=<?=Store::aesencriptar($dados_cliente->id_cliente) ?>" class="btn btn-primary">Ver Histórico de Encomendas</a>
            </div>
            <?php endif; ?>
            </div>

        </div>
            

        </div>


        
    </div>
</div>