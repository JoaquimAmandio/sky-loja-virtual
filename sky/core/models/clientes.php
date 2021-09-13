<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Clientes
{

    //------------------------------------------------------------
    public function verificar_email_existe($email)
    {
        //verificar se já existe um email com o mesmo nome registado
        $bd = new Database();
        $parametros = [
            ':email' => strtolower(trim($email))
        ];
        $resultado = $bd->select('SELECT email FROM clientes WHERE email=:email', $parametros);
        //se o cliente já existe
        if (count($resultado) != 0) {
            return true;
        } else {
            return false;
        }
    }

    //------------------------------------------------------------
    public function registar_cliente()
    {
        //cliente pronto para ser inserido na bd
        $bd = new Database();
        //criação do purl
        $purl = Store::criarHash();
        //define os parametros
        $parametros = [
            ':email' => strtolower(trim($_POST['text_email'])),
            ':senha' => password_hash(trim($_POST['text_senha1']), PASSWORD_DEFAULT),
            ':nome_completo' => trim($_POST['text_nome_completo']),
            ':morada' => trim($_POST['text_morada']),
            ':cidade' => trim($_POST['text_cidade']),
            ':telefone' => trim($_POST['text_telefone']),
            ':purl' => $purl,
            ':activo' => 0,
        ];
        $bd->insert(
            'INSERT INTO clientes 
        VALUES(0, :email, 
                  :senha,
                  :nome_completo,
                  :morada,
                  :cidade,
                  :telefone,
                  :purl,
                  :activo,
                   NOW(),
                   NOW(),
                   NULL
                   )',
            $parametros
        );
        //retorna o purl criado
        return $purl;
    }
    //------------------------------------------------------------
    public function validar_email($purl)
    {
        //validar o email do novo cliente
        $bd = new Database();
        //preparar os dados
        $parametros = [':purl' => $purl];
        $resultados = $bd->select('SELECT *FROM  clientes WHERE purl=:purl ', $parametros);
        if (count($resultados) != 1) {
            return false;
        }
        // foi encontrado o cliente
        $id_cliente = $resultados[0]->id_cliente;
        // Actualizar os dados do cliente
        $parametros = [
            ':id' => $id_cliente
        ];
        $bd->update('UPDATE clientes
                     SET purl=NULL, activo=1, updated_at=NOW() WHERE id_cliente=:id', $parametros);
        return true;

        /*
        2. pesquisar a existencia de um cliente com o purl indicado
            //não existe -erro
            //existe - remover o purl do cliente
            alterar o activo de o para 1 
            apresentar mensagem de registo concluido com sucesso
        */
    }
    //------------------------------------------------------------
    public function validar_login($usuario, $senha)
    {
        //verificar se  login é válido
        $parametros = [
            ':usuario' => $usuario,
        ];
        $db = new Database();
        $resultado = $db->select('SELECT  *FROM clientes WHERE email=:usuario AND activo=1 AND deleted_at IS  NULL', $parametros);
        if (count($resultado) != 1) {

            //não existe usuario
            return false;
        } else {
            //temos o usuario, vamos ver a password
            $usuario = $resultado[0];
            //verificar a senha
            if (!password_verify($senha, $usuario->senha)) {
                //senha inválida
                return false;
            } else {
                //login válido
                return $usuario;
            }
        }
    }
    //------------------------------------------------------------
    public function buscar_dados_cliente($id_cliente)
    {
        $bd = new Database();
        $parametros = [':id' => $id_cliente];
        $resultado = $bd->select('SELECT 
        email, nome_completo, morada, cidade, telefone FROM clientes WHERE id_cliente=:id', $parametros);
        return $resultado[0];
    }
    //------------------------------------------------------------
    public function verificar_email_existe_noutra_conta($id_cliente, $email)
    {
        //verificar se existe a conta de email noutra conta de cliente
        $bd = new Database();
        $parametros = [
            ':email' => $email,
            ':id_cliente' => $id_cliente,

        ];
        $resultados = $bd->select("SELECT id_cliente FROM clientes 
        WHERE id_cliente <>:id_cliente AND email=:email ", $parametros);
        //verificar se vem resultado
        if (count($resultados) != 0) {
            return true;
        } else {
            return false;
        }
    }

    //------------------------------------------------------------
    public function actualizar_dados_cliente($email, $nome_completo, $morada, $cidade, $telefone)
    {
        //actualizar os dados do cliente na base de dados
        $bd = new Database();
        $parametros = [
            ':id_cliente' => $_SESSION['usuario'],
            ':email' => $email,
            ':nome_completo' => $nome_completo,
            ':morada' => $morada,
            ':cidade' => $cidade,
            ':telefone' => $telefone,

        ];
        $bd->update("UPDATE clientes 
        SET 
        email=:email,
        nome_completo=:nome_completo,
        morada=:morada,
        cidade=:cidade,
        telefone=:telefone,
        updated_at=NOW()
        WHERE id_cliente=:id_cliente", $parametros);
    }
    //------------------------------------------------------------
    public function ver_se_senha_esta_correcta($id_cliente, $senha_actual)
    {
        //verifica se senha  actual esta correcta (de acordo com o que está na base de dados)
        $parametros = [
            'id_cliente' => $id_cliente,
        ];
        $bd = new Database();
        $senha_na_bd = $bd->select('SELECT senha FROM clientes 
        WHERE id_cliente=:id_cliente', $parametros)[0]->senha;

        //verificar se a senha corresponde a senha actual na bd
        return password_verify($senha_actual, $senha_na_bd);
    }
    //------------------------------------------------------------
    public function actualizar_a_nova_senha($id_cliente, $nova_senha)
    {
        $bd=new Database();
        //actualização da senha do cliente
        $parametros=[
            ':id_cliente'=>$id_cliente,
            ':nova_senha'=>password_hash($nova_senha, PASSWORD_DEFAULT)
        ];
        $bd->update('UPDATE clientes SET
        senha=:nova_senha, updated_at=NOW() WHERE id_cliente=:id_cliente',$parametros);
    }
}
