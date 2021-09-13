<?php

namespace core\classes;

use Exception;

class Store
{
    //------------------------------------------------------------
    public static function layout($estruturas, $dados = null)
    {
        //verifica se a estruturas é um array
        if (!is_array($estruturas)) {
            throw new Exception('colecção de estruturas inválida');
        }
        //variaveis
        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }
        //apresentar as views da aplicação
        foreach ($estruturas as $estrutura) {
            include("../core/views/$estrutura.php");
        }
    }
    //------------------------------------------------------------
    public static function layout_admin($estruturas, $dados = null)
    {
        //verifica se a estruturas é um array
        if (!is_array($estruturas)) {
            throw new Exception('colecção de estruturas inválida');
        }
        //variaveis
        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }
        //apresentar as views da aplicação
        foreach ($estruturas as $estrutura) {
            include("../../core/views/$estrutura.php");
        }
    }

    //------------------------------------------------------------
    public  static function usuariologado()
    {
        //verifica se existe um cliente com sessão
        return isset($_SESSION['usuario']);
    }
    //------------------------------------------------------------
    public static function adminlogado()
    {
           //verifica se existe um admin com sessão
           return isset($_SESSION['admin']);
    }

    //------------------------------------------------------------
    public static function criarHash($num_caracter = 12)
    {
        //criar hashes
        $chars = '0123456789abcdefghijklmnopqrstwuvxzabcdefghijklmnopqrstwuvxzABCDEFGHIJKLMNOPQRSTWUVXZABCDEFGHIJKLMNOPQRSTWUVXZ';
        return substr(str_shuffle($chars), 0, $num_caracter);
    }
    //------------------------------------------------------------
    public static function redirect($rota = '', $admin=false)
    {
        
             //faz o redirecionamento para a rota desejada
             if(!$admin){
                header('location:' . BASE_URL . "?a=$rota");
             }else{
                header('location:' . BASE_URL . "/admin?a=$rota");
             }
      
        
       
    }

    //------------------------------------------------------------
    public static function gerar_codigo_encomenda()
    {
        //gerar um código de encomenda 
        $codigo = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codigo .= substr(str_shuffle($chars), 0, 2);
        $codigo .= rand(100000, 999999);
        return $codigo;
    }
    //------------------------------------------------------------
    public  static function printData($data,$die=true)
    {
        if (is_array($data) || is_object($data)) {
            echo '<pre>';
            print_r($data);
        } else {
            echo '<pre>';
            echo $data;
        }
        if($die){
            die('terminado');
        }
        
    }

    //------------------------------------------------------------
    //funcções de encriptação
    //------------------------------------------------------------
    public static function aesencriptar($valor)
    {
        return bin2hex(openssl_encrypt($valor, 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV));
    }
    //------------------------------------------------------------
    public static function aesDesencriptar($valor)
    {
        return
            openssl_decrypt(hex2bin($valor), 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV);
    }
}
