<?php
require("Conexao.php");

//O valor diz aos navegadores para permitir que o código de solicitação de qualquer origem acesse o recurso
header('Access-Control-Allow-Origin: *');
//Especifica um ou mais métodos permitidos ao acessar um recurso em resposta a uma solicitação de comprovação
header("Access-Control-Allow-Methods: POST , GET , DELETE");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $valores = json_decode(file_get_contents("php://input"), true);

    $nomeCategoriaRenda = $valores["nome_categoria_renda"];

    $sqlCadastrarCategoriaRenda = "insert into categoria_renda(nome_categoria)values(:recebe_nome_categoria_renda)";
    $comandoCadastrarCategoriaRenda = Conexao::Obtem()->prepare($sqlCadastrarCategoriaRenda);
    $comandoCadastrarCategoriaRenda->bindValue(":recebe_nome_categoria_renda",$nomeCategoriaRenda);
    $comandoCadastrarCategoriaRenda->execute();
    $registroUltimoCodigoCadastroCategoriaRenda = Conexao::Obtem()->lastInsertId();

    echo json_encode($registroUltimoCodigoCadastroCategoriaRenda);
}
?>