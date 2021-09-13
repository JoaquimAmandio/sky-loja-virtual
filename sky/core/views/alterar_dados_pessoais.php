    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-3">
            <div class="col-12 ">
                <h3 class="text-center">Alterar Dados Pessoais</h3>

            </div>
            <form class="col-md-9 m-auto my-2" method="post" role="form" action="?a=alterar_dados_pessoais_submit">
                <div class="row">
                    <div class="mb-3">
                        <label for="inputsubject">Email</label>
                        <input type="email" maxlength="50" class="form-control mt-1" id="email" name="text_email"  required value="<?=$dados_pessoais->email?>">
                    </div>
                    <div class="mb-3">
                        <label for="inputsubject">Nome Completo</label>
                        <input type="text" maxlength="50" class="form-control mt-1" id="name" name="text_nome_completo"  required value="<?=$dados_pessoais->nome_completo?>">
                    </div>


                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Morada</label>
                        <input type="text" maxlength="100" class="form-control mt-1" name="text_morada"  required value="<?=$dados_pessoais->morada?>">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Cidade</label>
                        <input type="text" maxlength="50" class="form-control mt-1" name="text_cidade"  required value="<?=$dados_pessoais->cidade?>">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Telefone</label>
                        <input type="text" maxlength="20" class="form-control mt-1" name="text_telefone" required value="<?=$dados_pessoais->telefone?>">
                    </div>
                </div>

                <div class="row">
                <div class="col text-start mt-2">
                       <a href="?a=perfil" class="btn btn-primary btn-lg px-3 btn-100">Cancelar</a> 
                    </div>
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-primary btn-lg px-3 btn-100">Alterar</button>
                    </div>
                </div>
                <?php if (isset($_SESSION['erro'])) : ?>
                    <div class="alert alert-danger text-center mt-2">
                        <?= $_SESSION['erro'] ?>
                        <?php unset($_SESSION['erro']) ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <!-- End Contact -->