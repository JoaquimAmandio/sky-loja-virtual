<?php
namespace core\classes;

use PDO;
use PDOException;
use Exception;

class Database
{
    private $ligacao;
    //------------------------------------------------------------
    private function ligar()
    {

        //liga a a base de dados
        $this->ligacao = new PDO(
            'mysql:host=' . MYSQL_SERVER .
                ';dbname=' . MYSQL_DATABASE .
                ';charset=' . MYSQL_CHARSERT,
            MYSQ_USER,
            MYSQL_SENHA,
            array(PDO::ATTR_PERSISTENT => true)
        );

        // Mecanismo de debug (erro)
        $this->ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    //------------------------------------------------------------
    public function desligar()
    {
        //desliga a coneção com a bse de dados
        $this->ligacao = null;
    }

    //------------------------------------------------------------
    //CRUD
    //------------------------------------------------------------
    public function select($sql, $parametros = null)
    {
        $sql=trim($sql);
        //verifica se é uma instrução select
        if (!preg_match("/^SELECT/i", $sql)) {
            throw new Exception('Base de dados não é uma instrução select.');
        }

        //ligar a bd 
        $this->ligar();
        $resultados = null;
        try {
            //comunicação com a bd
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            }
        } catch (PDOException $E) {
            //caso exista erro
            return false;
        }

        //desligar da bd
        $this->desligar();
        //devolver os resultados obtidos
        return $resultados;
    }

    //------------------------------------------------------------
    public function insert($sql, $parametros = null)
    {
        $sql=trim($sql);
        //verifica se é uma instrução insert
        if (!preg_match("/^INSERT/i", $sql)) {
            throw new Exception('Base de dados não é uma instrução insert.');
        }

        //ligar a bd 
        $this->ligar();

        try {
            //comunicação com a bd
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $E) {
            //caso exista erro
            return false;
        }

        //desligar da bd
        $this->desligar();
    }

    //------------------------------------------------------------
    public function update($sql, $parametros = null)
    {
        $sql=trim($sql);
        //verifica se é uma instrução update
        if (!preg_match("/^UPDATE/i", $sql)) {
            throw new Exception('Base de dados não é uma instrução update.');
        }

        //ligar a bd 
        $this->ligar();

        try {
            //comunicação com a bd
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $E) {
            //caso exista erro
            return false;
        }

        //desligar da bd
        $this->desligar();
    }

    //------------------------------------------------------------
    public function delete($sql, $parametros = null)
    {
        $sql=trim($sql);
        //verifica se é uma instrução delete
        if (!preg_match("/^DELETE/i", $sql)) {
            throw new Exception('Base de dados não é uma instrução delete.');
        }

        //ligar a bd 
        $this->ligar();

        try {
            //comunicação com a bd
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $E) {
            //caso exista erro
            return false;
        }

        //desligar da bd
        $this->desligar();
    }
    //------------------------------------------------------------
    //GENERICA
    //------------------------------------------------------------
    public function statement($sql, $parametros = null)
    {
        $sql=trim($sql);
        //verifica se é uma instrução diferente das anteriores
        if (preg_match("/^(SELECT|INSERT|UPDATE|DELETE)/i", $sql)) {
            throw new Exception('Base de dados INSTRUÇÃO INVÁLIDA.');
        }

        //ligar a bd 
        $this->ligar();

        try {
            //comunicação com a bd
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $E) {
            //caso exista erro
            return false;
        }

        //desligar da bd
        $this->desligar();
    }
}
