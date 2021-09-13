<?php
use core\classes\Store;
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="tetx-center">Histórico das Encomendas</h3>

            <?php if (count($historico_encomenda) == 0) : ?>
                <p class="text-center">Não existem Encomendas Registadas!</p>
            <?php else : ?>
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Data da Encomenda</th>
                            <th>Codigo da Encomenda</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historico_encomenda as $encomendas) : ?>
                            <tr>
                                <td><?= $encomendas->data_encomenda ?> </td>
                                <td><?= $encomendas->codigo_encomenda ?> </td>
                                <td><?= $encomendas->estado ?> </td>
                                <td>
                                    <a href="?a=detalhe_encomenda&id=<?= Store::aesencriptar($encomendas->id_encomenda) ?>">Detalhes</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
                <p>Total: <strong> <?= count($historico_encomenda) ?></strong></p>
            <?php endif; ?>

        </div>
    </div>
</div>