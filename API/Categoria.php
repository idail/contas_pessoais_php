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

    $processo_categoria = $valores["execucao"];

    if($processo_categoria === "cadastrar_categoria_renda")
    {
        $nomeCategoriaRenda = $valores["nome_categoria_renda"];

        $sqlCadastrarCategoriaRenda = "insert into categoria_renda(nome_categoria)values(:recebe_nome_categoria_renda)";
        $comandoCadastrarCategoriaRenda = Conexao::Obtem()->prepare($sqlCadastrarCategoriaRenda);
        $comandoCadastrarCategoriaRenda->bindValue(":recebe_nome_categoria_renda",$nomeCategoriaRenda);
        $comandoCadastrarCategoriaRenda->execute();
        $registroUltimoCodigoCadastroCategoriaRenda = Conexao::Obtem()->lastInsertId();

        echo json_encode($registroUltimoCodigoCadastroCategoriaRenda);
    }else if($processo_categoria === "cadastrar_renda"){
        $nomeRenda = $valores["nome_renda"];
        $categoriaRenda = $valores["categoria_renda"];
        $valorRenda = $valores["valor_renda"];
        $pagoRenda = $valores["pago_renda"];

        $sqlCadastrarRenda = "insert into renda(nome_renda,categoria_renda,valor_renda,pago_renda)values(:recebe_nome_renda,:categoria_renda,:valor_renda,:pago_renda)";
        $comandoCadastrarRenda = Conexao::Obtem()->prepare($sqlCadastrarRenda);
        $comandoCadastrarRenda->bindValue(":recebe_nome_renda",$nomeRenda);
        $comandoCadastrarRenda->bindValue(":categoria_renda",$categoriaRenda);
        $comandoCadastrarRenda->bindValue(":valor_renda",$valorRenda);
        $comandoCadastrarRenda->bindValue(":pago_renda",$pagoRenda);
        $comandoCadastrarRenda->execute();
        $registroUltimoCodigoCadastroRenda = Conexao::Obtem()->lastInsertId();

        echo json_encode($registroUltimoCodigoCadastroRenda);
    }
}if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $processo_categoria = $_GET["execucao"];

    if($processo_categoria === "busca_categorias")
    {
        $sqlBuscaCategoriasRenda = "select * from categoria_renda";
        $comandoBuscaCategoriasRenda = Conexao::Obtem()->prepare($sqlBuscaCategoriasRenda);
        $comandoBuscaCategoriasRenda->execute();
        $resultadoBuscaCategoriasRenda = $comandoBuscaCategoriasRenda->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resultadoBuscaCategoriasRenda);    
    }
}
?>