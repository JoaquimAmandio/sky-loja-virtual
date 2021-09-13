<div class="container-fluid">
    <div class="row ">
        <div class="col">
    <?php require_once(__DIR__ .'/layouts/admin_menu.php')?>
        </div>

        <div class="col-sm">
           <h3>Lista de Encomendas do Cliente </h3>
           <hr>
           <div class="row">
               <div class="col">Nome: <?=$cliente->nome_completo ?></div>
               <div class="col">Telefone: <?=$cliente->telefone ?></div>
               <div class="col">Email: <?=$cliente->email ?></div>
           </div>
       
           <hr>
           
           
           <?php if(count($lista_encomendas)==0):?>
            <hr>
            <p>Não existem encomendas Registradas</p>
            <hr>
           <?php else:?>
            
            <table class="table table-striped responsive " id="tabela-encomendas">
                <thead class="table-dark">
                    <tr>
                        <th>Data</th>
                        <th>Morada</th>
                        <th>Cidade </th>
                    
                        <th>Codigo</th>
                        <th>Estado</th>
                        <th>Mensagem</th>
                        <th>Actualizada em:</th>
                    </tr>

                </thead>
                <tbody>
                    <?php foreach($lista_encomendas as $encomenda):?>
                        <tr>
                            <td><?=$encomenda->data_encomenda ?></td>
                            <td><?=$encomenda->morada ?></td>
                            <td><?=$encomenda->cidade ?></td>
                          
                            <td><?=$encomenda->codigo_encomenda?></td>
                            <td><?=$encomenda->estado ?></td>
                            <td><?=$encomenda->mensagem ?></td>
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