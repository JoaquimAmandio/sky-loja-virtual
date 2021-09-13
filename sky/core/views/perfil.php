<div class="container-fluid">
    <div class="row my-5">
        <div class="col ">
            <table class="table table-striped">
                <?php foreach($dados_cliente as $key=>$value):?>
                <tr>
                    <td class="text-end" width="20%"><?=$key?>:</td>
                    <td style="text:black" width="70%"><strong><?= $value ?></strong></td>
                </tr>
                <?php endforeach?>
               
            </table>

        </div>
    </div>
</div>