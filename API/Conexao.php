<?php
class Conexao{
    public static $conexao;

    public static function Obtem()
    {
        if(self::$conexao === null)
        {
            try{
                self::$conexao = new PDO("mysql:dbname=idailneto05;host=mysql.idailneto.com.br","idailneto05","BatmanI19910615");
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