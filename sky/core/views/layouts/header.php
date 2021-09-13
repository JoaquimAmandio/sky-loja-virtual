 <?php

    use core\classes\Store;
    //  $_SESSION['usuario']=1;
    //  unset($_SESSION['usuario']);
    //calcula o número de produtos no carrinho
    $total_produtos=0;
    if(isset($_SESSION['carrinho'])){
        foreach($_SESSION['carrinho'] as $quantidade){
            $total_produtos +=$quantidade;
        }
    }

    ?>
 <!-- Start Top Nav -->
 <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
     <div class="container text-light">
         <div class="w-100 d-flex justify-content-between">
             <div>
                 <i class="fa fa-envelope mx-2"></i>
                 <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:info@company.com">info@company.com</a>
                 <i class="fa fa-phone mx-2"></i>
                 <a class="navbar-sm-brand text-light text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
             </div>
             <div>
                 <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                 <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                 <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                 <a class="text-light" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
             </div>
         </div>
     </div>
 </nav>
 <!-- Close Top Nav -->


 <!-- Header -->
 <nav class="navbar navbar-expand-lg navbar-light shadow">
     <div class="container d-flex justify-content-between align-items-center">

         <a class="navbar-brand text-primary logo h1 align-self-center" href="?a=inicio">
             Sky
         </a>

         <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>

         <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
             <div class="flex-fill">
                 <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                     <li class="nav-item">
                         <a class="nav-link" href="?a=inicio">Inicio</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="?a=loja">Loja</a>
                     </li>
                     <!--verifica se existe cliente na sessão-->
                     <?php if (Store::usuariologado()) : ?>
                         <li class="nav-item">
                             <a class="nav-link" href="?a=perfil">
                                 <i class="fas fa-user "> <?= $_SESSION['usuario_email'] ?></i></a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="?a=logout">
                                 <i class="fas fa-sign-out-alt"></i>
                             </a>
                         </li>

                     <?php else : ?>
                         <li class="nav-item">
                             <a class="nav-link" href="?a=login">Login</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="?a=novo_cliente">Criar Conta</a>
                         </li>
                     <?php endif; ?>

                     <!-- <li class="nav-item">
                         <a class="nav-link" href="contact.html">Contactos</a>
                     </li> -->
                 </ul>
             </div>
             <div class="navbar align-self-center d-flex">
                 <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                     <div class="input-group">
                         <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ...">
                         <div class="input-group-text">
                             <i class="fa fa-fw fa-search"></i>
                         </div>
                     </div>
                 </div>
                 <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                     <i class="fa fa-fw fa-search text-dark mr-2"></i>
                 </a>
                 <a class="nav-icon position-relative text-decoration-none" href="?a=carrinho">
                     <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                     <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark" id="carrinho"><?=$total_produtos==0? '': $total_produtos?></span>
                 </a>
                 <!-- <a class="nav-icon position-relative text-decoration-none" href="#">
                     <i class="fa fa-fw fa-user text-dark mr-3"></i>
                     <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">+99</span>
                 </a> -->
             </div>
         </div>

     </div>
 </nav>
 <!-- Close Header -->