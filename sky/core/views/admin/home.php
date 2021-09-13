<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-3">
            <?php require_once(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>

        <div class="col-md-9">
            <!--Apresenta informações sobre o total de encomendas pensentes-->

            <h4>Encomendas Pendentes</h4>
            <?php if ($total_encomendas_pendentes == 0) : ?>

                <p class="text-a1a1a1">Não existem Encomendas Pendentes</p>
            <?php else : ?>
                <div class="alert alert-info p-2 ">
                    <span class="me-3"> Existem Encomendas Pendentes: <strong><?= $total_encomendas_pendentes ?></strong></span>
                    <a href="?a=lista_encomendas&f=pendente"><i class="far fa-eye me-2"></i> </a>

                </div>

            <?php endif; ?>
            <hr>
            <!--Apresenta informações sobre o total de encomendas em PROCESSAMENTO-->

            <h4>Encomendas em processamento</h4>
            <?php if ($total_encomendas_em_processamento == 0) : ?>

                <p class="text-a1a1a1">Não existem Encomendas em processamento</p>
            <?php else : ?>
                <div class="alert alert-warning p-2 ">
                    <span class="me-3"> Existem Encomendas em processamento: <strong><?= $total_encomendas_em_processamento ?></strong></span>
                    <a href="?a=lista_encomendas&f=em_processamento"><i class="far fa-eye me-2"></i> </a>

                </div>

            <?php endif; ?>
        </div>
    </div>
</div>