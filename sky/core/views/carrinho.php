 <div class="container">
     <div class="row">
         <div class="col">
             <h3 class="my-3">A sua encomenda</h3>
             <hr>

         </div>
     </div>
 </div>

 <div class="container">
     <div class="row">
         <div class="col"></div>
         <?php if ($carrinho == null) : ?>
             <p class="text-center">Não existem serviços ou produtos no carrinho</p>
             <div class="my-4 text-center">
                 <a href="?a=loja">ir para loja</a>

             </div>

         <?php else : ?>
             <table class="table">
                 <thead>
                     <tr>
                         <th></th>
                         <th>Produto Ou Serviço</th>
                         <th class="text-center">Quantidade</th>
                         <th>Valor Total</th>
                         <th></th>
                     </tr>
                 </thead>
                 <?php $index = 0;
                    $total_rows = count($carrinho);
                    ?>
                 <?php foreach ($carrinho as $produto) : ?>
                     <?php if ($index < $total_rows - 1) : ?>
                         <!--lista de produtos-->
                         <tr>
                             <td><img src="assets/img/<?= $produto['imagem'] ?>" class="img-fluid" width="50px"> </td>
                             <td class="align-middle">
                                 <h5><?= $produto['titulo'] ?></h5>
                             </td>
                             <td class="text-center align-middle">
                                 <h5><?= $produto['quantidade'] ?></h5>
                             </td>
                             <td class="align-middle">
                                 <!-- <h4><?= str_replace('.', ',',  $produto['preco'] . 'kzs') ?></h4> -->
                                 <h4><?= number_format(  $produto['preco'],2,',','.' ). 'kzs' ?></h4>
                             </td>
                             <td><a href="?a=remover_produto_carrinho&id_produto=<?=$produto['id_produto'] ?>" class="align-middle btn btn-danger btn-sm"><i class="fas fa-times"></i></a></td>
                         </tr>
                     <?php else : ?>
                         <!--total -->
                         <tr>

                             <td></td>
                             <td></td>
                             <td class="text-end">
                                 <h3>Total: </h3>
                             </td>
                             <td>
                                 <h3><?= number_format($produto,2,',','.') . 'kzs' ?></h3>
                             </td>
                             <td> </td>
                         </tr>

                     <?php endif; ?>
                     <?php $index++; ?>
                 <?php endforeach; ?>
                 <tbody>

                 </tbody>
             </table>
             <div class="row my-3">
                 <div class="col">
                     <!-- <a href="?a=limpar_carrinho" class="btn btn-primary">apagar compras</a> -->
                     <button onclick="limpar_carrinho()" class="btn btn-sm btn-primary">apagar compras</button>
                     <span class="ms-3" id="confirmar_limpar_carrinho" style="display: none;"> certeza?
                        <button class="btn btn-sm btn-primary" onclick="limpar_carrinho_off()" >Não</button>
                        <a href="?a=limpar_carrinho" class="btn btn-sm btn-primary">Sim</a>
                     </span>
                 </div>
                 <div class="col text-end">
                     <a href="?a=inicio" class="btn btn-sm btn-primary">Voltar a loja</a>
                     <a href="?a=finalizar_encomenda" class="btn  btn-sm btn-primary ">Finalizar </a>
                 </div>
             </div>

         <?php endif; ?>
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