    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-5">
            <div class="col-12 ">
                <h3 class="text-center">Registo de Novo Cliente</h3>

            </div>
            <form class="col-md-9 m-auto my-2" method="post" role="form" action="?a=novo_cliente_submit">
                <div class="row">
                    <div class="mb-3">
                        <label for="inputsubject">Email</label>
                        <input type="email" class="form-control mt-1" id="email" name="text_email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputsubject">Nome Completo</label>
                        <input type="text" class="form-control mt-1" id="name" name="text_nome_completo" placeholder="Nome Completo" required>
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Senha</label>
                        <input type="password" class="form-control mt-1" name="text_senha1" placeholder="Senha" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Repetir Senha</label>
                        <input type="password" class="form-control mt-1" name="text_senha2" placeholder="Repetir Senha" required>
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Morada</label>
                        <input type="text" class="form-control mt-1" name="text_morada" placeholder="Morada" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Cidade</label>
                        <input type="text" class="form-control mt-1" name="text_cidade" placeholder="Cidade" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Telefone</label>
                        <input type="text" class="form-control mt-1" name="text_telefone" placeholder="Telefone" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-primary btn-lg px-3">Criar Conta</button>
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