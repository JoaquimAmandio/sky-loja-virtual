<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="my-3">A sua encomenda - Resumo</h3>
            <hr>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col"></div>

        <table class="table">
            <thead>
                <tr>

                    <th>Produto Ou Serviço</th>
                    <th class="text-center">Quantidade</th>
                    <th>Valor Total</th>

                </tr>
            </thead>
            <?php $index = 0;
            $total_rows = count($carrinho);
            ?>
            <?php foreach ($carrinho as $produto) : ?>
                <?php if ($index < $total_rows - 1) : ?>
                    <!--lista de produtos-->
                    <tr>

                        <td class="align-middle">
                            <?= $produto['titulo'] ?>
                        </td>
                        <td class="text-center align-middle">
                            <?= $produto['quantidade'] ?>
                        </td>
                        <td class="align-middle">
                            <!-- <h4><?= str_replace('.', ',',  $produto['preco'] . 'kzs') ?></h4> -->
                            <?= number_format($produto['preco'], 2, ',', '.') . 'kzs' ?>
                        </td>

                    </tr>
                <?php else : ?>
                    <!--total -->
                    <tr>


                        <td></td>
                        <td class="text-end">
                            <h4>Total: </h4>
                        </td>
                        <td>
                            <h4><?= number_format($produto, 2, ',', '.') . 'kzs' ?></h4>
                        </td>

                    </tr>

                <?php endif; ?>
                <?php $index++; ?>
            <?php endforeach; ?>
            <tbody>

            </tbody>
        </table>


        <!--dados do cliente -->
        <h5 class="bg-dark text-white p-2">Dados do Cliente</h5>
        <div class="row ">
            <hr>
            <div class="col">
                <p>Nome:<strong><?= $cliente->nome_completo ?> </strong></p>
                <p>Morada:<strong><?= $cliente->morada ?> </strong></p>
                <p>Cidade:<strong><?= $cliente->cidade ?> </strong></p>
            </div>
            <div class="col">
                <p>Telefone:<strong><?= $cliente->email ?> </strong></p>
                <p>Telefone:<strong><?= $cliente->telefone ?> </strong></p>
            </div>
        </div>


        <!--Dados de pagamento-->
        <h5 class="bg-dark text-white p-2">Dados do Pagamento</h5>
        <div class="row">
            <div class="col">
                <p>Iban:<strong class="text-dark"><?=iBAN_CONTA?></strong></p>
                <p>Codigo da encomenda: <?=$_SESSION['codigo_encomenda'] ?></p>
                <p>Total: <?= number_format($produto, 2, ',', '.') . 'kzs' ?></p>
            </div>
        </div>


                    <!--Morada Alternativa-->
                    <h5 class="bg-dark text-white p-2">Morada Alternativa de entrega</h5>
        <div class="form-check">
            <input type="checkbox" onchange="usar_morada_alternativa()" name="check_morada_alternativa" id="check_morada_alternativa" class="form-check-input">
            <label class="form-check-label" for="check_morada_alternativa">Definir uma Morada Alternativa</label>
        </div>
        <!--morada alternativa -->
        <div id="morada_alternativa" style="display: none;">
            <!--morada  -->
            <div class="mb-3">
                <label for="" class="form-label">Morada</label>
                <input type="text" id="text_morada_alternativa" class="form-control">
            </div>
            <!--cidade -->
            <div class="mb-3">
                <label for="" class="form-label">Cidade</label>
                <input type="text" id="text_cidade_alternativa" class="form-control">
            </div>
            <!--email -->
            <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input type="email" id="text_email_alternativo" class="form-control">
            </div>
            <!--Telefone -->
            <div class="mb-3">
                <label for="" class="form-label">Telefone</label>
                <input type="text" id="text_telefone_alternativo" class="form-control">
            </div>

        </div>




        <div class="row my-3 my-5">
            <div class="col">
                <a href="?a=carrinho" class="btn btn-sm btn-primary">Cancelar</a>

            </div>
            <div class="col text-end">
                <a href="?a=confirmar_encomenda" onclick="morada_alternativa()" class="btn btn-sm btn-primary">Confirmar Encomenda</a>

            </div>
        </div>


    </div>
</div>






<!-- Start Brands -->
<section class="bg-light py-5">
    <div class="container my-4">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Our Brands</h1>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    Lorem ipsum dolor sit amet.
                </p>
            </div>
            <div class="col-lg-9 m-auto tempaltemo-carousel">
                <div class="row d-flex flex-row">
                    <!--Controls-->
                    <div class="col-1 align-self-center">
                        <a class="h1" href="#multi-item-example" role="button" data-bs-slide="prev">
                            <i class="text-light fas fa-chevron-left"></i>
                        </a>
                    </div>
                    <!--End Controls-->

                    <!--Carousel Wrapper-->
                    <div class="col">
                        <div class="carousel slide carousel-multi-item pt-2 pt-md-0" id="multi-item-example" data-bs-ride="carousel">
                            <!--Slides-->
                            <div class="carousel-inner product-links-wap" role="listbox">

                                <!--First slide-->
                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png" alt="Brand Logo"></a>
                                        </div>
                                    </div>
                                </div>
                                <!--End First slide-->

                                <!--Second slide-->
                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png" alt="Brand Logo"></a>
                                        </div>
                                    </div>
                                </div>
                                <!--End Second slide-->

                                <!--Third slide-->
                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png" alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png" alt="Brand Logo"></a>
                                        </div>
                                    </div>
                                </div>
                                <!--End Third slide-->

                            </div>
                            <!--End Slides-->
                        </div>
                    </div>
                    <!--End Carousel Wrapper-->

                    <!--Controls-->
                    <div class="col-1 align-self-center">
                        <a class="h1" href="#multi-item-example" role="button" data-bs-slide="next">
                            <i class="text-light fas fa-chevron-right"></i>
                        </a>
                    </div>
                    <!--End Controls-->
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Brands-->