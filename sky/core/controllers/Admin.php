<?php

namespace core\controllers;

use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Encomendas;
use core\models\Produtos;
use core\models\AdminModel;

class Admin
{
    //------------------------------------------------------------
    // admin: admin@gmail.com
    //senha: 12345678
    //------------------------------------------------------------
    public function index()
    {


        //verifica se já existe sessão aberta (admin)
        if (!Store::adminlogado()) {
            Store::redirect('admin_login', true);
            return;
        }
        //verificar se existe encomendas em estado pendentes
        $ADMIN = new AdminModel();
        $total_encomendas_pendentes = $ADMIN->Total_encomendas_pendentes();
        $total_encomendas_em_processamento = $ADMIN->total_encomendas_em_processamento();
        $data = [
            'total_encomendas_pendentes' => $total_encomendas_pendentes,
            'total_encomendas_em_processamento' => $total_encomendas_em_processamento,
        ];
        //já existe um admin logado
        Store::layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/home',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $data);
    }
    //------------------------------------------------------------
    public function admin_login()
    {
        //
        if (Store::adminlogado()) {
            Store::redirect('inicio', true);
            return;
        }
        //apresenta o quadro de login
        Store::layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/login_admin',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ]);
    }

    //------------------------------------------------------------
    public function admin_logout()
    {
        unset($_SESSION['admin_usuario']);
        unset($_SESSION['admin']);
        Store::redirect('inicio', true);
        return;
    }
    //------------------------------------------------------------
    public function lista_encomendas()
    {
        if (!Store::adminlogado()) {
            Store::redirect('inicio', true);
            return;
        }
        //verifca se existe um filtro na query string
        $filtros = [
            'pendente' => 'PENDENTE',
            'em_processamento' => 'EM PROCESSAMENTO',
            'cancelada' => 'CANCELADA',
            'enviada' => 'ENVIADA',
            'concluida' => 'CONCLUIDA'
        ];
        $filtro = '';
        if (isset($_GET['f'])) {
            //verifica se a variavel é uma key dos filtros
            if (key_exists($_GET['f'], $filtros)) {
                $filtro = $filtros[$_GET['f']];
            }
        }
        $id_cliente=null;
        //vai buscar o id_cliente se existir na query string
        if(isset($_GET['c'])){
            $id_cliente=Store::aesDesencriptar($_GET['c']);
        }
        //apresenta a lista de encomendas(usuando o filtro se for o caso)
        $admin_model = new AdminModel();
        $lista_encomendas = $admin_model->lista_encomendas($filtro,$id_cliente);
        // Store::printData($lista_encomendas);

        $data = [
            'listas_encomendas' => $lista_encomendas,
            'filtro' => $filtro,

        ];
        //apresenta a a pagina das encomendas 
        Store::layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/lista_encomendas',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $data);
    }

    //------------------------------------------------------------
    public function lista_cliente()
    {
        //verifica se o admin esta logado
        if (!Store::adminlogado()) {
            Store::redirect('inicio', true);
            return;
        }

        //vai buscar a lista de clientes
        $admin = new AdminModel();
        $clientes = $admin->lista_cliente();


        $data = [
            'clientes' => $clientes
        ];
        //apresenta a a pagina das da lista de clientes
        Store::layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/lista_cliente',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $data);
    }
    //------------------------------------------------------------
    public function detalhe_cliente()
    {
        //verifica se o admin esta logado
        if (!Store::adminlogado()) {
            Store::redirect('inicio', true);
            return;
        }
        //verifica se existe um id cliente na query string
        if (!isset($_GET['c'])) {
            Store::redirect('inicio', true);
            return;
        }
        $id_cliente = Store::aesDesencriptar($_GET['c']);
        //verifica se o id_cliente é válido
        if (empty($id_cliente)) {
            Store::redirect('inicio', true);
            return;
        }
        //
        $admin = new AdminModel();
        $dados_cliente = $admin->buscar_cliente($id_cliente);
        $data = [
            'dados_cliente' => $dados_cliente,
            'total_encomendas' => $admin->total_encomendas_cliente($id_cliente),

        ];
        Store::layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/detalhe_cliente',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $data);
    }
    //------------------------------------------------------------
    public function login_admin_submit()
    {

        //verifica se o admin esta logado
        if (Store::adminlogado()) {
            Store::redirect('inicio', true);
            return;
        }


        //verifica se houve uma submissão do formulário do admin
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('inicio', true);
            return;
        }


        //validar se os campos vieram corectamente preenchido
        if (
            !isset($_POST['text_administrador'])
            || !isset($_POST['text_senha'])
            || !filter_var($_POST['text_administrador'], FILTER_VALIDATE_EMAIL)
        ) {
            //erro de preenchimento de formulário
            $_SESSION['erro'] = 'Login Inválido';
            Store::redirect('admin_login', true);
            return;
        }



        //preparar os dados para o model
        $admin = trim(strtolower($_POST['text_administrador']));
        $senha = trim($_POST['text_senha']);


        //carregar model e verificar se login é válido
        $admin_model = new AdminModel();
        $resultado = $admin_model->login_admin($admin, $senha);

        //analisa o resultado
        if (is_bool($resultado)) {
            //login inválido
            $_SESSION['erro'] = 'senha inválida';
            Store::redirect('admin_login', true);
            return;
        } else {
            //login valido coloca os dados do admin na sessão
            $_SESSION['admin'] = $resultado->id_admin;
            $_SESSION['admin_usuario'] = $resultado->usuario;
            //redirecionar para a pagina inicial do backoffice


            Store::redirect('inicio', true);
        }

        //apresenta o quadro de login
        Store::layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/login_admin_submit',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ]);
    }
    //------------------------------------------------------------
    public function cliente_historico_encomenda()
    {
        if (!Store::adminlogado()) {
            Store::redirect('inicio', true);
            return;
        }
        if (!isset($_GET['c'])) {
            Store::redirect('inicio', true);
        }
        //definir o id_cliente que veio encriptado
        $id_cliente = Store::aesDesencriptar($_GET['c']);
        $ADMIN = new AdminModel();

        $data = [
            'cliente' => $ADMIN->buscar_cliente($id_cliente),
            'lista_encomendas' => $encomendas = $ADMIN->buscar_encomendas_cliente($id_cliente),
        ];

        //apresenta o quadro de login
        Store::layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/cliente_historico_encomenda',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $data);
    }

    //------------------------------------------------------------
    public function detalhe_encomenda()
    {
        if (!Store::adminlogado()) {
            Store::redirect('inicio', true);
            return;
        }
        $id_encomenda = null;
        if (isset($_GET['e'])) {
            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }
        if (gettype($id_encomenda) != 'string') {
            Store::redirect('inicio', true);
            return;
        }

        $ADMIN = new AdminModel();
        $encomenda = $ADMIN->buscar_detalhes_encomenda($id_encomenda);
        $data = $encomenda;
        Store::layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/encomenda_detalhe',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ], $data);
    }

    //------------------------------------------------------------
    public function encomenda_alterar_estado()
    {
        if (!Store::adminlogado()) {
            Store::redirect('inicio', true);
            return;
        }
        //buscar o id da encomenda
        $id_encomenda = null;
        if (isset($_GET['e'])) {
            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }
        if (gettype($id_encomenda) != 'string') {
            Store::redirect('inicio', true);
            return;
        }
        //buscar o novo estado
        $estado = null;
        if (isset($_GET['s'])) {
            $estado = $_GET['s'];
        }
        if (!in_array($estado, ESTADOS)) {
            Store::redirect('inicio', true);
            return;
        }
        //regras de negocios para gerir as encomendas(novo estado)
        //actualizar o estado da encomenda na base de dados
        $admin_model = new AdminModel();
        $admin_model->actualizar_estados_encomenda($id_encomenda, $estado);
        //executar operações baseadas no novo estado
        switch ($estado) {
            case 'PENDENTE':
                # não existem acções
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                break;
            case 'EM PROCESSAMENTO':
                # não existem acções
                break;
            case 'ENVIADA':
                # enviar um email com a notificação ao cliente sobre o envio da encomenda
                $this->operacao_enviar_email_encomenda_enviada($id_encomenda);
                break;
            case 'CANCELADA':
                # code...
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                break;
            case 'CONCLUIDA':
                # code...
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                break;
        }
        //redireciona para a pagina da propria encomenda
        Store::redirect('detalhe_encomenda&e='.$_GET['e'],true);
        return;
    }

    //------------------------------------------------------------
    //operações após mudanças de estado
    //------------------------------------------------------------
    private function operacao_enviar_email_encomenda_enviada($id_encomenda)
    {
        //executar as operações para enviar o email ao cliente
    }
    //------------------------------------------------------------
    private function operacao_notificar_cliente_mudanca_estado()
    {
        //vai enviar um email para o cliente indicando que a encomenda sofreu alterações
    }
}
