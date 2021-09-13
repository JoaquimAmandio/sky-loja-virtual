<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class AdminModel
{
    //---------------------------------------------------------------
    public function login_admin($usuario_admin, $senha)
    {
        //verificar se  login é válido
        $parametros = [
            ':usuario_admin' => $usuario_admin,
        ];

        $db = new Database();
        $resultado = $db->select('SELECT  *FROM admins WHERE usuario=:usuario_admin  AND deleted_at IS  NULL', $parametros);
        if (count($resultado) != 1) {

            //não existe usuario
            return false;
        } else {
            //temos o usuario, vamos ver a password
            $usuario_admin = $resultado[0];
            //verificar a senha
            if (!password_verify($senha, $usuario_admin->senha)) {
                //senha inválida
                return false;
            } else {
                //login válido
                return $usuario_admin;
            }
        }
    }
    //---------------------------------------------------------------
    public function total_encomendas_pendentes()
    {
        //vai buscar a quantidade de encomendas pendentes
        $db = new Database();
        $resultados = $db->select('SELECT COUNT(*) total
        FROM encomendas WHERE estado="PENDENTE"');
        return $resultados[0]->total;
    }
    //---------------------------------------------------------------
    public function total_encomendas_em_processamento()
    {

        //vai buscar a quantidade de encomendas EM PROCESSAMENTO
        $db = new Database();
        $resultados = $db->select('SELECT COUNT(*) total
         FROM encomendas WHERE estado="EM PROCESSAMENTO"');
        return $resultados[0]->total;
    }

    //---------------------------------------------------------------
    public function lista_encomendas($filtro,$id_cliente)
    {
        //buscar lista de encomendas com filtro
        $db = new Database();
        $sql = 'SELECT encomendas.*, clientes.nome_completo FROM encomendas, clientes WHERE 1';
        if ($filtro != '') {
            $sql .= " AND encomendas.estado= '$filtro'";
        }
        if(!empty($id_cliente)){
            $sql .= " AND encomendas.id_cliente= $id_cliente";

        }
        $sql .= ' AND clientes.id_cliente = encomendas.id_cliente ORDER BY encomendas.id_encomenda DESC ';

        return $db->select($sql);
    }
    //---------------------------------------------------------------
    public function lista_cliente()
    {
        $bd = new Database();
        $resultado = $bd->select('SELECT
        clientes.id_cliente,
        clientes.email,
        clientes.nome_completo,
        clientes.telefone,
        clientes.activo,
        clientes.deleted_at,
        COUNT(encomendas.id_encomenda) total_encomendas
        FROM clientes LEFT JOIN encomendas
        ON clientes.id_cliente= encomendas.id_cliente
        GROUP BY clientes.id_cliente');
        return $resultado;
    }


    //---------------------------------------------------------------
    public function buscar_cliente($id_cliente)
    {
        $bd = new Database();
        $parametros = [':id' => $id_cliente];
        $resultado = $bd->select('SELECT 
         *FROM clientes WHERE id_cliente=:id', $parametros);
        return $resultado[0];
    }
    //---------------------------------------------------------------
    public function buscar_encomendas_cliente($id_cliente)
    {
        // buscar todas as encomendas do cliente indicado
        $bd = new Database();
        $parametros = [':id' => $id_cliente];
        return $bd->select('SELECT *FROM encomendas
        WHERE id_cliente=:id', $parametros);
    }

    //---------------------------------------------------------------
    public function total_encomendas_cliente($id_cliente)
    {
        $parametros = [
            ':id_cliente' => $id_cliente
        ];
        $bd = new Database();
        return $bd->select('SELECT COUNT(*) total
        FROM encomendas WHERE id_cliente=:id_cliente', $parametros)[0]->total;
    }

    //---------------------------------------------------------------
    public function buscar_detalhes_encomenda($id_encomenda)
    {
        //vai buscar os detalhes de uma encomenda
        $bd = new Database();
        //buscar os dados da encomenda

        $parametros = [
            ':id_encomenda' => $id_encomenda
        ];
        $dados_encomenda = $bd->select('SELECT 
        clientes.nome_completo, encomendas.
        *FROM clientes,encomendas
        WHERE encomendas.id_encomenda=:id_encomenda
        AND clientes.id_cliente=encomendas.id_cliente', $parametros);
        //lista de produtos da encomenda
        $lista_produtos = $bd->select('SELECT *FROM encomenda_produto
        WHERE id_encomenda=:id_encomenda', $parametros);


        return [
            'encomenda' => $dados_encomenda[0],
            'lista_produtos' => $lista_produtos
        ];
    }

    //---------------------------------------------------------------
    public function actualizar_estados_encomenda($id_encomenda,$estado)
    {
         //actualizar o estado da encomenda
         $bd = new Database();
         //buscar os dados da encomenda
 
         $parametros = [
             ':id_encomenda' => $id_encomenda,
             ':estado'=>$estado
         ];
         $bd->update('UPDATE encomendas
         SET estado=:estado, updated_at=NOW()
         WHERE id_encomenda=:id_encomenda',$parametros);

    }
}
