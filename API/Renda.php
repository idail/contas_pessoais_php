<?php
require("Conexao.php");

//O valor diz aos navegadores para permitir que o código de solicitação de qualquer origem acesse o recurso
header('Access-Control-Allow-Origin: *');
//Especifica um ou mais métodos permitidos ao acessar um recurso em resposta a uma solicitação de comprovação
header("Access-Control-Allow-Methods: POST , GET , DELETE");

header("Content-Type: application/json; charset=UTF-8");

if($_SERVER["REQUEST_METHOD"] === "POST")
{

}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $processo_renda = $_GET["execucao"];

    if($processo_renda === "busca_rendas")
    {
        $sqlBuscaRendas = "select * from renda";
        $comandoBuscaRendas = Conexao::Obtem()->prepare($sqlBuscaRendas);
        $comandoBuscaRendas->execute();
        $resultadoBuscaRendas = $comandoBuscaRendas->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resultadoBuscaRendas);
    }
}