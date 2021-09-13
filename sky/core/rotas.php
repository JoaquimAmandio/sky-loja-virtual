<?php
//coleção de rotas
$rotas = [
    'inicio' => 'main@index',
    'produtos' => 'main@',
    'loja'=>'main@loja',

    //cliente
    'novo_cliente' => 'main@novo_cliente',
    'novo_cliente_submit' => 'main@novo_cliente_submit',
    'confirmar_email' => 'main@confirmar_email',
    //login
    'login' => 'main@login',
    'login_submit' => 'main@login_submit',
    'logout' => 'main@logout',

    //perfil
    'perfil'=>'main@perfil',
    'alterar_dados_pessoais'=>'main@alterar_dados_pessoais',
    'alterar_dados_pessoais_submit'=>'main@alterar_dados_pessoais_submit',
    'alterar_senha'=>'main@alterar_senha',
    'alterar_senha_submit'=>'main@alterar_senha_submit',
    //histórico encomendas
    'historico_encomendas'=>'main@historico_encomendas',
    'detalhe_encomenda'=>'main@detalhe_encomenda',


    //carrinho
    'adicionar_carrinho' => 'carrinho@adicionar_carrinho',
    'limpar_carrinho' => 'carrinho@limpar_carrinho',
    'remover_produto_carrinho'=>'carrinho@remover_produto_carrinho',
    'carrinho' => 'carrinho@carrinho',
    'finalizar_encomenda'=>'carrinho@finalizar_encomenda',
    'finalizar_encomenda_resumo'=>'carrinho@finalizar_encomenda_resumo',
    'finalizar_servico_resumo'=>'carrinho@finalizar_servico_resumo',
    'morada_alternativa'=>'carrinho@morada_alternativa',

    //pagamento
    'confirmar_encomenda'=>'carrinho@confirmar_encomenda',
    'pagamento'=>'main@pagamento'

  

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
