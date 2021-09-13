<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Encomendas
{
    //-----------------------------------------------------------------
    public function guardar_encomendas($dados_encomenda, $dados_produtos)
    {

        $bd = new Database();
        // guardar os dados da encomenda
        $parametros = [
            ':id_cliente' => $_SESSION['usuario'],
            ':morada' => $dados_encomenda['morada'],
            ':cidade' => $dados_encomenda['cidade'],
            ':email' => $dados_encomenda['email'],
            ':telefone' => $dados_encomenda['telefone'],
            ':codigo_encomenda' => $dados_encomenda['codigo_encomenda'],
            ':estado' => $dados_encomenda['estado'],
            ':mensagem' => $dados_encomenda['mensagem'],

        ];
        $bd->insert('INSERT INTO encomendas VALUES(
            0,
            :id_cliente,
            NOW(),
            :morada,
            :cidade,
            :email,
            :telefone,
            :codigo_encomenda,
            :estado,
            :mensagem,
            NOW(),
            NOW()
        )', $parametros);


        //buscar o id_encomenda
        $id_encomenda = $bd->select("SELECT MAX(id_encomenda) AS id_incomenda
         FROM encomendas")[0]->id_incomenda;




        //guardar os dados dos produtos

        foreach ($dados_produtos as $produto) {
            $parametros = [

                ':id_encomenda' => $id_encomenda,
                ':designacao_produto' => $produto['designacao_produto'],
                ':preco' => $produto['preco'],
                ':quantidade' => $produto['quantidade']

            ];
            $bd->insert('INSERT INTO encomenda_produto 
            VALUES(
                0,
                :id_encomenda,
                :designacao_produto,
                :preco,
                :quantidade,
                NOW()
    
    
            )', $parametros);
        }
    }
    //-----------------------------------------------------------------
    public function buscar_historico_encomenda($id_cliente)
    {
        //buscar histórico de encomenda do cliente com o id- cliente
        $parametros = [
            'id_cliente' => $id_cliente
        ];
        $db = new database();
        $resultados = $db->select('SELECT 
        id_encomenda, data_encomenda, codigo_encomenda, estado
        FROM encomendas
        WHERE id_cliente=:id_cliente
        ORDER BY data_encomenda DESC  
        ', $parametros);

        return $resultados;
    }
    //-----------------------------------------------------------------
    public function verificar_encomenda_cliente($id_cliente, $id_encomenda)
    {
        //verificar se a a encomenda pertence ao usuario identificado

        $parametros = [
            ':id_cliente' => $id_cliente,
            ':id_encomenda' => $id_encomenda
        ];
        $bd = new Database();
        $resultado = $bd->select('SELECT id_encomenda FROM encomendas
        WHERE id_cliente=:id_cliente
        AND id_encomenda=:id_encomenda', $parametros);
        return count($resultado) == 0 ? false : true;
    }

    //-----------------------------------------------------------------
    public function detalhes_de_encomenda($id_cliente, $id_encomenda)
    {
        //vai buscar os dados da encmenda e a lista dos produtos da encomenda
        $parametros = [
            ':id_cliente' => $id_cliente,
            ':id_encomenda' => $id_encomenda
        ];
        //dados da encomenda
        $bd = new Database();
        $dados_encomenda = $bd->select('SELECT *FROM encomendas
        WHERE id_cliente=:id_cliente
        AND id_encomenda=:id_encomenda', $parametros)[0];
        //dados da lista de produtos da encomenda
        $parametros = [
            ':id_encomenda' => $id_encomenda
        ];
        $produtos_encomenda = $bd->select('SELECT 
        *FROM encomenda_produto
        WHERE id_encomenda=:id_encomenda', $parametros);

        //devolver ao controlador os dados do detalhe da encomenda
        return [
            'dados_encomenda' => $dados_encomenda,
            'produtos_encomenda' => $produtos_encomenda
        ];
    }

    //-----------------------------------------------------------------
    public function efectuar_pagamento($codigo_encomenda)
    {
        //
        $parametros=[
            ':codigo_encomenda'=>$codigo_encomenda
        ];
        $bd= new Database();
        $resultado=$bd->select('SELECT *FROM encomendas
        WHERE codigo_encomenda=:codigo_encomenda
        AND estado="PENDENTE"',$parametros);
        if(count($resultado)==0){
            return false;
        }
        //efectuar a alteração do estado da encomenda indicada
        $bd->update('UPDATE encomendas
        SET estado="EM PROCESSAMENTO",
        updated_at=NOW()
        WHERE codigo_encomenda=:codigo_encomenda',$parametros);
         return true;
         
    }
}
