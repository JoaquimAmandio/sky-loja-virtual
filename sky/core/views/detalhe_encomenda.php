<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="text-center">Detalhe da Encomenda</h3>
            <!--detalhes da encomenda-->
            <div class="row">
                <div class="col">
                    <div class="p-2 my-3">
                        <span><strong>Data da encomenda</strong></span><br>
                        <?= $dados_encomenda->data_encomenda ?>
                    </div>
                    <div class="p-2 my-3">
                    <span><strong>Morada</strong></span><br>
                        <?= $dados_encomenda->morada ?>
                    </div>
                    <div class="p-2 my-3">
                    <span><strong>Cidade</strong></span><br>
                        <?= $dados_encomenda->cidade ?>
                    </div>



                </div>
                <div class="col">
                    <div class="p-2 my-3">
                    <span><strong>Telefone</strong></span><br>
                        <?= $dados_encomenda->telefone ?>
                    </div>
                    <div class="p-2 my-3">
                    <span><strong>Email</strong></span><br>
                        <?= $dados_encomenda->email ?>
                    </div>
                    <div class="p-2 my-3">
                    <span><strong>Codigo da Encomenda</strong></span><br>
                        <?= $dados_encomenda->codigo_encomenda ?>
                    </div>
                </div>
                <div class="col align-self-center">
                    <div class="">
                    <span><strong>Estado</strong></span><br>
                        <?= $dados_encomenda->estado ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                   <table class="table table-striped">
                      <thead>
                          <tr>
                              <th>Produto</th>
                              <th>Quantidade</th>
                              <th>Preço</th>
                              
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach($produtos_encomenda as $produto):?>
                          <tr>
                              <td><?=$produto->designacao_produto ?></td>
                              <td><?=$produto->quantidade ?></td>
                              <td><?=number_format($produto->preco,2,',','.').'kzs' ?></td>
                          </tr>
                          <?php endforeach;?>
                          <tr>
                              <td></td>
                              <td class="text-end">Total</td>
                              <td><strong> <?= number_format($total_encomenda,2,'.',',').'kzs' ?></strong></td>
                          </tr>
                      </tbody>
                   </table>
                </div>
            </div>
            <div class="row">
                <div class="col my-2">
                    <a href="?a=historico_encomendas" class="btn btn-primary">Voltar</a>
                </div>
            </div>



            <!--lista de produtos-->
            
        </div>
    </div>
</div>