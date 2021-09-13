<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Encomendas;
use core\models\Produtos;

class Main
{
    //------------------------------------------------------------
    public function index()
    {
        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'inicio',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }
    //------------------------------------------------------------
    public function produtos()
    {
        //apresenta a página dos serviços
        //buscar a lista de serviços disponiveis
        $produtos = new Produtos();
        //analisa que categoria é para mostrar
        $c = 'todos';
        if (isset($_GET['c'])) {
            $c = $_GET['c'];
        }
        //buscar informção a bd de dados
        $lista_produtos = $produtos->lista_produtos_disponiveis($c);
        $lista_categorias = $produtos->lista_categorias();
        $dados = [
            'produtos' => $lista_produtos,
            'categorias' => $lista_categorias,

        ];


        Store::layout([
            'layouts/html_header',
            'layouts/header',
            //'servicos',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }
    //------------------------------------------------------------
    public function novo_cliente()
    {
        //verifica se já existe sessão aberta
        if (Store::usuariologado()) {
            $this->index();
            return;
        }

        //apresenta layout para criar novo utilizador

        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'novo_cliente',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }
    //------------------------------------------------------------
    public function novo_cliente_submit()
    {

        //verifica se já existe sessão
        if (Store::usuariologado()) {
            $this->index();
            return;
        }
        //verifica se houve submisão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }
        //verifica se senha 1 é igual a senha2
        if ($_POST['text_senha1'] != $_POST['text_senha2']) {
            //as senhas são diferentes
            $_SESSION['erro'] = 'as senhas não estão iguais';
            $this->novo_cliente();
            return;
        }
        //verificar se já existe um email com o mesmo nome registado
        $cliente = new Clientes();
        if ($cliente->verificar_email_existe($_POST['text_email'])) {
            $_SESSION['erro'] = 'já existe um cliente com o mesmo email';
            $this->novo_cliente();
            return;
        }


        //inserir novo cliente na base de dados e devolver o purl
        $email_cliente = strtolower(trim($_POST['text_email']));
        $purl = $cliente->registar_cliente();
        //envio do email para o cliente
        $email = new EnviarEmail();

        $resultado = $email->enviar_email_de_confirmacao($email_cliente, $purl);
        if ($resultado) {
            //apresenta um layout para informar envio de email 
            Store::layout([
                'layouts/html_header',
                'layouts/header',
                'novo_cliente_submit_sucesso',
                'layouts/footer',
                'layouts/html_footer'
            ]);


            return;
        } else {
        }
    }
    //------------------------------------------------------------
    public function confirmar_email()
    {
        //verifica se já existe sessão aberta
        if (Store::usuariologado()) {
            $this->index();
            return;
        }

        //verificar se existe na query string um purl
        if (!isset($_GET['purl'])) {
            $this->index();
            return;
        }
        $purl = $_GET['purl'];
        //verifica se o purl é válido
        if (strlen($purl) != 12) {
            $this->index();
            return;
        }
        //conectar a base de dados
        $cliente = new Clientes();
        $resultado = $cliente->validar_email($purl);
        if ($resultado) {
            //apresenta um layout para informar que a conta foi informada com sucesso
            Store::layout([
                'layouts/html_header',
                'layouts/header',
                'conta_confirmada_sucesso',
                'layouts/footer',
                'layouts/html_footer'
            ]);
        } else {
            //redirecionar para a página inicial
            Store::redirect();
        }
    }
    //------------------------------------------------------------
    public function login()
    {
        //apresenta a página do formulario para login 
        //verifica se já existe um utilizador logado
        if (Store::usuariologado()) {
            Store::redirect();
            return;
        }
        //apresenta a página do formulario para login 


        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'login_frm',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }
    //------------------------------------------------------------
    public function login_submit()
    {
        //verifica se já existe um utilizador logado
        if (Store::usuariologado()) {
            Store::redirect();
            return;
        }
        //verifica se foi efetuado o post do login
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }
        //validar se os campos vieram corretamente prenchidos
        if (
            !isset($_POST['text_usuario']) ||
            !isset($_POST['text_senha'])   ||
            !filter_var(trim($_POST['text_usuario']), FILTER_VALIDATE_EMAIL)
        ) {
            // erro de prenchimento do formulário
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login');
            return;
        }
        //pedir informações a bse de dados
        $cliente = new Clientes();
        //prepara os dados para o model
        $usuario = trim(strtolower($_POST['text_usuario']));
        $senha = trim($_POST['text_senha']);
        //carrega o model e verifica se o login é válido
        $resultado = $cliente->validar_login($usuario, $senha);
        //analisa o resultado
        if (is_bool($resultado)) {
            //login inválido
            $_SESSION['erro'] = 'Login Invalido';
            Store::redirect('login');
            return;
        } else {
            //login valido. coloca os dados na sessão
            $_SESSION['usuario'] = $resultado->id_cliente;
            $_SESSION['usuario_email'] = $resultado->email;
            $_SESSION['usuario_nome_completo'] = $resultado->nome_completo;

            //redirecionar para o local correcto
            if (isset($_SESSION['tmp_carrinho'])) {
                //remove a variavel temporária da sessão
                unset($_SESSION['tmp_carrinho']);
                //redirecionar para o resumo da encomenda
                Store::redirect('finalizar_encomenda_resumo');
            } else {
                //redirecionamento para a loja
                Store::redirect();
            }
        }
    }
    //------------------------------------------------------------
    public function logout()
    {
        //remove as variaveis da funcão
        unset($_SESSION['usuario']);
        unset($_SESSION['usuario_email']);
        unset($_SESSION['usuario_nome_completo']);
        //redireciona para o incio da aplicação
        Store::redirect();
    }

    //------------------------------------------------------------
    public function loja()
    {
        //apresenta a pagina da loja
        //buscar a lista de produtos disponiveis
        $produtos = new Produtos();
        //analisar que categoria mostrar
        $c = 'todos';
        if (isset($_GET['c'])) {
            $c = $_GET['c'];
        }
        //buscar informação á base de dados 
        $lista_produtos = $produtos->lista_produtos_disponiveis($c);
        $lista_categorias = $produtos->lista_categorias();
        $dados = [
            'produtos' => $lista_produtos,
            'categorias' => $lista_categorias,

        ];
        // Store::printData($lista_produtos);
        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'loja',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }
    //------------------------------------------------------------
    //perfil do usuario

    //--------------------------------------------------------------
    public function perfil()
    {
        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }

        //buscar informação a base de dados do cliente
        $cliente = new Clientes();

        $dtemp = $cliente->buscar_dados_cliente($_SESSION['usuario']);
        $dados_cliente = [
            'Email' => $dtemp->email,
            'Nome Completo' => $dtemp->nome_completo,
            'Morada' => $dtemp->morada,
            'Cidade' => $dtemp->cidade,
            'Telefone' => $dtemp->telefone

        ];
        $dados = [
            'dados_cliente' => $dados_cliente,
        ];


        //apresenta a página da pagina de perfil 
        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'perfil_navegacao',
            'perfil',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }
    //--------------------------------------------------------------
    public function alterar_dados_pessoais()
    {
        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }

        //vai buscar os dados pessoais
        $cliente = new Clientes();
        $dados = [
            'dados_pessoais' => $cliente->buscar_dados_cliente($_SESSION['usuario']),
        ];

        //apresenta a página do formulario para edição dos dados 


        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'perfil_navegacao',
            'alterar_dados_pessoais',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }
    //--------------------------------------------------------------
    public function alterar_dados_pessoais_submit()
    {
        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }
        //verifica se houve submição de formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('inicio');
            return;
        }
        //validar dados
        $email = trim(strtolower($_POST['text_email']));
        $nome_completo = trim($_POST['text_nome_completo']);
        $morada = trim($_POST['text_morada']);
        $cidade = trim($_POST['text_cidade']);
        $telefone = trim($_POST['text_telefone']);
        //validar se é email valido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = 'Endereço de Email Inválido!';
            $this->alterar_dados_pessoais();
            return;
        }
        // validar rapidamente os restantes campos
        if (empty($nome_completo) || empty($morada) || empty($cidade) || empty($telefone)) {
            $_SESSION['erro'] = 'Preencha correctamente o formulário!!';
            $this->alterar_dados_pessoais();
            return;
        }
        //validar se este email já existe noutra conta de cliente
        $cliente = new Clientes();
        $existe_noutra_conta = $cliente->verificar_email_existe_noutra_conta($_SESSION['usuario'], $email);
        if ($existe_noutra_conta) {
            $_SESSION['erro'] = 'O email ja pertence a outro cliente!!';
            $this->alterar_dados_pessoais();
            return;
        }
        // actualizar os dados do cliente na base de dados
        $cliente->actualizar_dados_cliente($email, $nome_completo, $morada, $cidade, $telefone);
        //actualizar os dados do cliente na sessão
        $_SESSION['usuario_email'] = $email;
        $_SESSION['usuario_nome_completo'] = $nome_completo;
        //redirecionar para página do perfil

        Store::redirect('perfil');
    }
    //--------------------------------------------------------------
    public function alterar_senha()
    {
        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }



        //apresentação da página de alteração da senha  


        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'perfil_navegacao',
            'alterar_senha',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }
    //--------------------------------------------------------------
    public function alterar_senha_submit()
    {
        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }
        //verifica se houve submição de formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('inicio');
            return;
        }
        //validar dados
        $senha_actual = trim($_POST['text_senha_actual']);
        $nova_senha = trim($_POST['text_nova_senha']);
        $repetir_nova_senha = trim($_POST['text_repetir_nova_senha']);



        //verificar se a nova senha vem com dados
        if (strlen($nova_senha) < 6) {
            $_SESSION['erro'] = "indique a nova senha e arepetição da nova senha!!";
            $this->alterar_senha();
            return;
        }


        //verificar se a nova senha e a sua repetição coincidem
        if ($nova_senha != $repetir_nova_senha) {
            $_SESSION['erro'] = 'A nova senha e a sua repetição não são iguais!';
            $this->alterar_senha();
            return;
        }
        if ($senha_actual == $nova_senha) {
            $_SESSION['erro'] = 'A nova senha é igual a senha actual!';
            $this->alterar_senha();
            return;
        }
        //verificar se a a senha actual esta correcta
        $cliente = new clientes();
        if (!$cliente->ver_se_senha_esta_correcta($_SESSION['usuario'], $senha_actual)) {
            $_SESSION['erro'] = 'A senha actual está errada!';
            $this->alterar_senha();
            return;
        }
        //actualizar a nova senha
        $cliente->actualizar_a_nova_senha($_SESSION['usuario'], $nova_senha);
        Store::redirect('perfil');
        return;
    }
    //--------------------------------------------------------------
    public function historico_encomendas()
    {
        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }

        //carrega o histórico das encomendas
        $encomendas = new Encomendas();
        $historico_encomenda = $encomendas->buscar_historico_encomenda($_SESSION['usuario']);


        $data = [
            'historico_encomenda' => $historico_encomenda,
        ];
        //apresenta a página com o histórico de encomendas
        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'perfil_navegacao',
            'historico_encomendas',
            'layouts/footer',
            'layouts/html_footer'
        ], $data);
    }
    //--------------------------------------------------------------
    public function detalhe_encomenda()
    {
        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }

        //verificar se veio um id_encomenda (encriptado)
        if (!isset($_GET['id'])) {
            Store::redirect('inicio');
            return;
        }
        $id = $_GET['id'];
        $id_encomenda = null;
        //verifica se o id_encomenda é uma string com 32 caracteres
        if (strlen($id) != 32) {
            Store::redirect('inicio');
            return;
        } else {
            $id_encomenda = Store::aesDesencriptar($id);
            if (empty($id_encomenda)) {
                Store::redirect('inicio');
                return;
            }
        }

        //verifica se o id_encomenda pertence a este cliente
        $encomendas = new Encomendas();
        $resultado = $encomendas->verificar_encomenda_cliente($_SESSION['usuario'], $id_encomenda);

        if (!$resultado) {
            Store::redirect('inicio');
            return;
        }

        //vamos buscar os dados de detalhe da encomenda
        $detalhe_encomenda = $encomendas->detalhes_de_encomenda($_SESSION['usuario'], $id_encomenda);
        //calcular o valor total da encomenda
        $total = 0;
        foreach ($detalhe_encomenda['produtos_encomenda'] as $produto) {
            $total += ($produto->quantidade * $produto->preco);
        }

        $data = [
            'dados_encomenda' => $detalhe_encomenda['dados_encomenda'],
            'produtos_encomenda' => $detalhe_encomenda['produtos_encomenda'],
            'total_encomenda' => $total
        ];
        //vamos apresentar a nova vews com os detalhes
        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'perfil_navegacao',
            'detalhe_encomenda',
            'layouts/footer',
            'layouts/html_footer'
        ], $data);
    }
    //--------------------------------------------------------------
    public function pagamento()
    {
        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }
        //verificar se o codigo da encomenda veio indicado
        $codigo_encomenda = '';
        if (!isset($_GET['cod'])) {
            Store::redirect('inicio');
            return;
        } else {
            $codigo_encomenda = $_GET['cod'];
        }
        //verifica se o id_encomenda é uma string com 32 caracteres
        if (strlen($_GET['cod']) != 8) {
            Store::redirect('inicio');
            return;
        
        }

        //verificar se existe condigo ativo (pendente)
        $encomenda = new Encomendas();
        $resultado = $encomenda->efectuar_pagamento($codigo_encomenda);
        echo (int)$resultado;
        //simulação do webhook do gateway de pagamento

    }
}
