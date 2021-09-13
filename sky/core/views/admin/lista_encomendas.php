<div class="container-fluid">
    <div class="row ">
        <div class="col">
    <?php

use core\classes\Store;

require_once(__DIR__ .'/layouts/admin_menu.php')?>
        </div>

        <div class="col-sm">
           <h3>Lista de Encomendas <?= $filtro!='' ? strtolower($filtro) : '' ?></h3>
           <hr>

            <div class="row">
                <div class="col text-end">
                <a href="?a=lista_encomendas" class="btn btn-primary btn-sm me-2">Ver todas as encomendas</a>
                </div>
                <div class="col">
                <?php
               $f='';
               if(isset($_GET['f'])){
                $f=$_GET['f'];
               }
               ?>
              <div class="d-inline-flex mb-5">
                  <span class="text -align me-2 p-1">Estado</span> 
                  <select name="" id="combo-estado" class="form-select" onchange="definir_filtro()">
                  <option value <?= $f==''? 'selected': ''?>></option>
                      <option value="pendente" <?= $f=='pendente'? 'selected': ''?>>Pendentes</option>
                      <option value="em_processamento" <?= $f=='em_processamento'? 'selected': ''?>>Em Processamentos</option>
                      <option value="enviada" <?= $f=='enviada'? 'selected': ''?>>Envidas</option>
                      <option value="cancelada" <?= $f=='cancelada'? 'selected': ''?>>Canceladas</option>
                      <option value="concluida" <?= $f=='concluida'? 'selected': ''?>>Concluidas</option>
                  </select>
              </div>
                </div>
            </div>



          
           
           <?php if(count($listas_encomendas)==0):?>
            <hr>
            <p>Não existem encomendas Registradas</p>
            <hr>
           <?php else:?>
            
            <table class="table table-striped responsive " id="tabela-encomendas">
                <thead class="table-dark">
                    <tr>
                        <th>Data</th>
                        <th>codigo</th>
                        <th>Estado</th>
                        <th>Email</th>
                        <th>Telefone</th>
                 
                        <th>Actualizado Em</th>
                    </tr>

                </thead>
                <tbody>
                    <?php foreach($listas_encomendas as $encomenda):?>
                        <tr>
                            <td><?=$encomenda->data_encomenda ?></td>
                            <td><?=$encomenda->codigo_encomenda ?></td>
                            <td>
                                <a href="?a=detalhe_encomenda&e=<?=Store::aesencriptar($encomenda->id_encomenda)?>"><?=$encomenda->estado ?></a>
                            </td>
                            <td><?=$encomenda->email ?></td>
                            <td><?=$encomenda->telefone ?></td>
                           
                            <td><?=$encomenda->updated_at ?></td>
                        </tr>

                    <?php endforeach;?>

                </tbody>
            </table>
            </small>

            <?php endif;?>
          

        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#tabela-encomendas').DataTable(
          
        );
    })
    function definir_filtro(){
        var filtro=document.getElementById('combo-estado').value;
        //reload da pagina com o determinado filtro
        window.location.href=window.location.pathname+"?"
        +$.param({'a':'lista_encomendas', 'f':filtro});
    }
</script>