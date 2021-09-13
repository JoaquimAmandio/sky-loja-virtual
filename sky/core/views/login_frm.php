    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-5">
            <div class="col-12 ">
                <h3 class="text-center">Login</h3>

            </div>
            <form class="col-md-9 m-auto my-2" method="post" role="form" action="?a=login_submit">
                <div class="row">
                    <div class="mb-3">
                        <label for="inputsubject">Usuario</label>
                        <input type="email" class="form-control mt-1" id="email" name="text_usuario" placeholder="Usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputsubject">Senha</label>
                        <input type="password" class="form-control mt-1"  name="text_senha" placeholder="Senha" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-primary btn-lg px-3">Entrar</button>
                    </div>
                </div>
                <?php if (isset($_SESSION['erro'])) : ?>
                    <div class="alert alert-danger text-center mt-2">
                      <?= $_SESSION['erro']?>
                      <?php  unset($_SESSION['erro'])?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <!-- End Contact -->