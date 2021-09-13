<?php

namespace core\controllers;

use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Encomendas;
use core\models\Produtos;

class Carrinho
{
    //------------------------------------------------------------
    public function limpar_carrinho()
    {
        //esvazia o carrinho
        unset($_SESSION['carrinho']);

        //refrescar a pagina do carrinho
        $this->carrinho();
    }
    //------------------------------------------------------------
    public function adicionar_carrinho()
    {
        //vai buscar id produto a query string
        if (!isset($_GET['id_produto'])) {

            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        //define o id do produto
        $id_produto = $_GET['id_produto'];
        $produtos = new Produtos();
        $resultados = $produtos->verificar_stock_produto($id_produto);
        if (!$resultados) {
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }
        //adiciona/gestão da variavel da sessão no carrinho 
        $carrinho = [];
        if (isset($_SESSION['carrinho'])) {
            $carrinho = $_SESSION['carrinho'];
        }
        //adicionar o produto ao carrinho
        if (key_exists($id_produto, $carrinho)) {
            //já existe o produto. acrescenta mais uma unidade
            $carrinho[$id_produto]++;
        } else {
            //adicionar novo produto ao carrinho
            $carrinho[$id_produto] = 1;
        }
        //actualiza os dados do carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;
        //devolve a resposta(numero de produtos no carrinho)
        $total_produtos = 0;
        foreach ($carrinho as $produto_quantidade) {
            $total_produtos += $produto_quantidade;
        }
        echo $total_produtos;




























        // //vai buscar o id_produto a query string
        // if (!isset($_GET['id_produto'])) {
        //     echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
        //     return;
        // }

        // //adiciona/gestão da variavel de sessão á query string
        // //define o id do servico
        // $id_produto = $_GET['id_produto'];
        // //procurar na base de dados se esse id_produto existe
        // $serv = new Produtos();
        // $resultados = $serv->verificar_stock_produto($id_produto);
        // if (!$resultados) {
        //     echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
        //     return;
        // }
        // //faz a gestão da variavel da sessão no carrinho
        // $_SESSION['carrinho'] = $id_produto;
        // //resposta
        // echo 'carro nº ' . $id_produto . ' alugado';
    }
    //------------------------------------------------------------
    public function morada_alternativa()
    {
        //receber os dados via ajax(axios)
        $post = json_decode(file_get_contents('php://input'), true);
        $_SESSION['dados_alternativos'] = [
            'morada' => $post['text_morada'],
            'cidade' => $post['text_cidade'],
            'email' => $post['text_email'],
            'telefone' => $post['text_telefone']
        ];
    }
    //------------------------------------------------------------
    public function remover_produto_carrinho()
    {
        //vai buscar id produto a query string
        $id_produto = $_GET['id_produto'];
        //busca o carrinho a sessão
        $carrinho = $_SESSION['carrinho'];
        //remove o produto do carrinho
        unset($carrinho[$id_produto]);
        //actualiza o carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;
        //apresenta novamente a pagina do carrinho
        $this->carrinho();
    }
    //------------------------------------------------------------
    public function carrinho()
    {

        //verificar se existe carrinho
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            $dados = [
                'carrinho' => null
            ];
        } else {
            $ids = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                array_push($ids, $id_produto);
            }
            $ids = implode(",", $ids);
            $produtos = new Produtos();
            $resultados = $produtos->buscar_produto_por_ids($ids);
            $dados_tmp = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {
                //buscar a imagem do produto
                foreach ($resultados as $produtos) {
                    if ($produtos->id_produto == $id_produto) {
                        $id_produto = $produtos->id_produto;
                        $imagem = $produtos->imagem;
                        $titulo = $produtos->nome_produto;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produtos->preco * $quantidade;

                        //colocar o produto na coleção
                        array_push($dados_tmp, [
                            'id_produto' => $id_produto,
                            'imagem' => $imagem,
                            'titulo' => $titulo,
                            'quantidade' => $quantidade,
                            'preco' => $preco
                        ]);
                        break;
                    }
                }
            }
            //calcular o total
            $total_encomenda = 0;
            foreach ($dados_tmp as $item) {
                $total_encomenda += $item['preco'];
            }
            array_push(
                $dados_tmp,
                $total_encomenda,
            );
            $dados = ['carrinho' => $dados_tmp];
        }

        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'carrinho',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }
    //------------------------------------------------------------
    public function finalizar_encomenda()
    {
        //verifica se existe usuario logado
        if (!Store::usuariologado()) {
            //coloca na sessão um referrer temporário
            $_SESSION['tmp_carrinho'] = true;
            //redirecionar para o quadro de login
            Store::redirect('login');
        } else {
            Store::redirect('finalizar_encomenda_resumo');
        }
    }
    //------------------------------------------------------------
    public function finalizar_encomenda_resumo()
    {
        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }
        //verifica de pode avançar com a gravação da encomenda
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            Store::redirect('inicio');
            return;
        }

        //informações do carrinho
        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $resultados = $produtos->buscar_produto_por_ids($ids);
        $dados_tmp = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {
            //buscar a imagem do produto
            foreach ($resultados as $produtos) {
                if ($produtos->id_produto == $id_produto) {
                    $id_produto = $produtos->id_produto;
                    $imagem = $produtos->imagem;
                    $titulo = $produtos->nome_produto;
                    $quantidade = $quantidade_carrinho;
                    $preco = $produtos->preco * $quantidade;

                    //colocar o produto na coleção
                    array_push($dados_tmp, [
                        'id_produto' => $id_produto,
                        'imagem' => $imagem,
                        'titulo' => $titulo,
                        'quantidade' => $quantidade,
                        'preco' => $preco
                    ]);
                    break;
                }
            }
        }
        //calcular o total
        $total_encomenda = 0;
        foreach ($dados_tmp as $item) {
            $total_encomenda += $item['preco'];
        }
        array_push(
            $dados_tmp,
            $total_encomenda,
        );

        //colocar o prço total na sessão
        $_SESSION['total_encomenda'] = $total_encomenda;

        //preparar os dados da view
        $dados = [];

        $dados['carrinho'] = $dados_tmp;

        //buscar informações do cliente
        $cliente = new Clientes();
        $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['usuario']);
        $dados['cliente'] = $dados_cliente;

        //gerar o código da encomenda
        if (!isset($_SESSION['codigo_encomenda'])) {
            $codigo_encomenda = Store::gerar_codigo_encomenda();
            $_SESSION['codigo_encomenda'] = $codigo_encomenda;
        }


        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'encomenda_resumo',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }

    //------------------------------------------------------------

    public function confirmar_encomenda()
    {

        //verifica se existe utilizador logado
        if (!Store::usuariologado()) {
            Store::redirect('inicio');
            return;
        }
        //verifica de pode avançar com a gravação da encomenda
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            Store::redirect('inicio');
            return;
        }

        //enviar um email para o cliente com os dados da encomenda e pagamento
        $dados_encomenda = [];
        //buscar os dados do produto
        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $produtos_da_encomenda = $produtos->buscar_produto_por_ids($ids);
        //estrutura dos dados dos produtos
        $string_produtos = [];
        foreach ($produtos_da_encomenda as $resultado) {
            //quantidade
            $quantidade = $_SESSION['carrinho'][$resultado->id_produto];
            //string do produto
            $string_produtos[] = "$quantidade x $resultado->nome_produto - " . number_format($resultado->preco, 2, ",", ".") . 'kzs.';
        }
        //definir a lista de produtos para email
        $dados_encomenda['lista_produtos'] = $string_produtos;

        //preço total da encomenda para email
        $dados_encomenda['total'] = number_format($_SESSION['total_encomenda'], 2, ',', '.') . 'kzs';

        //dados do pagamento
        $dados_encomenda['dados_pagamento'] = [
            'iban' => iBAN_CONTA,
            'codigo_encomenda' => $_SESSION['codigo_encomenda'],
            'total' => number_format($_SESSION['total_encomenda'], 2, ',', '.') . 'kzs',

        ];

        //Store::printData($_SESSION);





        //enviar email para o cliente com os dados da encomenda
        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_encomenda($_SESSION['usuario_email'], $dados_encomenda);


        //guardar na base de dados a encomenda

        $dados_encomenda = [];
        $dados_encomenda['id_cliente'] = $_SESSION['usuario'];
        //morada
        if (isset($_SESSION['dados_alternativos']['morada']) && !empty($_SESSION['dados_alternativos']['morada'])) {
            //considerar a morada alternativa
            $dados_encomenda['morada'] = $_SESSION['dados_alternativos']['morada'];
            $dados_encomenda['cidade'] = $_SESSION['dados_alternativos']['cidade'];
            $dados_encomenda['email'] = $_SESSION['dados_alternativos']['email'];
            $dados_encomenda['telefone'] = $_SESSION['dados_alternativos']['telefone'];
        } else {
            //considerar a morada do cliente da base de dados
            $CLIENTE = new Clientes();
            $dados_cliente = $CLIENTE->buscar_dados_cliente($_SESSION['usuario']);
            $dados_encomenda['morada'] = $dados_cliente->morada;
            $dados_encomenda['cidade'] = $dados_cliente->cidade;
            $dados_encomenda['email'] = $dados_cliente->email;
            $dados_encomenda['telefone'] = $dados_cliente->telefone;
        }

        //codigo da encomenda
        $dados_encomenda['codigo_encomenda'] = $_SESSION['codigo_encomenda'];
        $dados_encomenda['estado'] = 'PENDENTE';
        $dados_encomenda['mensagem'] = '';
        //---------------------------------
        //dados dos produtos da encomenda
        //$produtos_da_encomenda
        $dados_produtos = [];
        foreach ($produtos_da_encomenda as $produto) {
            $dados_produtos[] = [
                'designacao_produto' => $produto->nome_produto,
                'preco' => $produto->preco,
                'quantidade' => $_SESSION['carrinho'][$produto->id_produto],

            ];
        }

        $encomenda = new Encomendas();
        $encomenda->guardar_encomendas($dados_encomenda, $dados_produtos);


        //preparar dados para apresentar na pagina de agradecimentos
        $codigo_encomenda = $_SESSION['codigo_encomenda'];
        $total_encomenda = $_SESSION['total_encomenda'];

        //limpar todos os dados da encomenda que estão no carrinho
        unset($_SESSION['codigo_encomenda']);
        unset($_SESSION['carrinho']);
        unset($_SESSION['total_encomenda']);
        unset($_SESSION['dados_alternativos']);



        //apresentar a agradecer a encomenda
        $dados = [
            'codigo_encomenda' => $codigo_encomenda,
            'total_encomenda' => $total_encomenda,

        ];
        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'encomenda_confirmada',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }
}
