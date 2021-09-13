    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-3">
            <div class="col-12 ">
                <h3 class="text-center">Alterar Senha</h3>

            </div>
            <form class="col-md-9 m-auto my-2" method="post" role="form" action="?a=alterar_senha_submit">
                <div class="row">
                    <div class="mb-3">
                        <label for="inputsubject">Senha Actual</label>
                        <input type="password" maxlength="30" class="form-control mt-1" id="email" name="text_senha_actual"  required >
                    </div>
                    <div class="mb-3">
                        <label for="inputsubject">Nova Senha</label>
                        <input type="password" maxlength="30" class="form-control mt-1" id="name" name="text_nova_senha"  required >
                    </div>


                    <div class=" mb-3">
                        <label for="inputemail">Repetir Nova Senha</label>
                        <input type="password" maxlength="30" class="form-control mt-1" name="text_repetir_nova_senha"  required >
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
