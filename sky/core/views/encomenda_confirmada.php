    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1 ">Encomenda Confirmada</h1>
            <p>
                Muito obrigado pela sua encomenda
            <div class="my-5">
                <h4>Dados de pagamento</h4>
                <p>Iban:<?=iBAN_CONTA?> </p>
                <p>Codigo da Encomenda:<strong><?= $codigo_encomenda ?></strong></p>
                <p>Codigo da Encomenda:<strong><?= number_format($total_encomenda, 2, ',', '.') . 'kzs' ?></strong></p>

            </div>
            </p>
            <p>
                vai receber um email com a confirmação da encomenda e os dados de pagamento
                <br>
                A sua encomenda só sera processada após confirmação do pagamento.
            </p>
            <p><small>Por favor verifique se o email aparece na sua conta ou se foi parar na pasta do SPAM</small> </p>
            <div class="my-2"><a href="?a=inicio" class="btn btn-primary btn-lg px-3">Voltar</a></div>
        </div>
    </div>