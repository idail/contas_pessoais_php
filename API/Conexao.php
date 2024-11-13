<?php
class Conexao{
    public static $conexao;

    public static function Obtem()
    {
        if(self::$conexao === null)
        {
            try{
                self::$conexao = new PDO("mysql:dbname=contas_pessoais;host=localhost","root","");
                return self::$conexao;
            }catch(PDOException $exception)
            {
                return $exception->getMessage();
            }catch(Exception $excecao)
            {
                return $excecao->getMessage();
            }
        }else{
            return self::$conexao;
        }
    }
}
?>