<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Produtos
{
    //------------------------------------------------------------
    public function lista_produtos_disponiveis($categoria)
    {
        // $this->lista_categorias();
        //buscar todas informações dos serviços na base de dados
        $bd = new Database();
        //buscar a lista de categorias da loja
        $categorias = $this->lista_categorias();


        $sql = "SELECT *FROM produtos WHERE visivel = 1";


        if (in_array($categoria, $categorias)) {
            $sql = "SELECT *FROM produtos WHERE visivel=1 AND categoria='$categoria'";
        }

        //  die($sql);
        $produtos = $bd->select($sql);
        //  Store::printData($produtos);
        return $produtos;
    }
    //------------------------------------------------------------
    public function lista_categorias()
    {
        //devolve a lista de categoria existente na base de dados
        $bd = new Database();
        $resultados = $bd->select('SELECT DISTINCT categoria FROM produtos');
        $categorias = [];
        foreach ($resultados as $resultado) {
            array_push($categorias, $resultado->categoria);
        }
        //   Store::printData($categorias);
        return $categorias;
    }
    //------------------------------------------------------------
    public function verificar_stock_produto($id_produto)
    {
        $bd = new Database();
        $parametros = [
            ':id_produto' => $id_produto,
        ];
        $result = $bd->select('SELECT *FROM produtos WHERE id_produto=:id_produto
                             AND visivel=1 AND stock>0', $parametros);
        return count($result)!=0 ? true: false;
    }
    //------------------------------------------------------------
    public function buscar_produto_por_ids($ids){
        $bd=new Database();
        // $parametros=[
        //     ':ids'=>$ids,
        // ];
        
        return $bd->select("SELECT *FROM produtos WHERE id_produto IN($ids)");
        


    }
}
