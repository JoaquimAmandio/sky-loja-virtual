<?php
//coleção de rotas
$rotas = [
    'inicio' => 'admin@index',
    //admin
    'admin_login'=>'admin@admin_login',
    'admin_logout'=>'admin@admin_logout',
    'login_admin_submit'=>'admin@login_admin_submit',
    //clientes
    'lista_cliente'=>'admin@lista_cliente',
    'cliente_historico_encomenda'=>'admin@cliente_historico_encomenda',
    //cliente detalhe
    'detalhe_cliente'=>'admin@detalhe_cliente',
    //encomendas
    'lista_encomendas'=>'admin@lista_encomendas',
    'detalhe_encomenda'=>'admin@detalhe_encomenda',
    'encomenda_alterar_estado'=>'admin@encomenda_alterar_estado',
    

  

];
//definir ação por defeito
$acao = 'inicio';
//verifica se a ação existe na query string
if (isset($_GET['a'])) {
    //verifca se a ação existe nas rotas
    if (!key_exists($_GET['a'], $rotas)) {
        $acao = 'inicio';
    } else {
        $acao = $_GET['a'];
    }
}
//tratar a definção da rota
$partes = explode('@', $rotas[$acao]);
$controlador = "core\\controllers\\" . ucfirst($partes[0]);
$metodo = $partes['1'];
$ctr = new $controlador();
$ctr->$metodo();
