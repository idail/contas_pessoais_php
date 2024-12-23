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

    $processo_renda = $valores["execucao"];

    if($processo_renda === "cadastrar_renda")
    {
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
    }else if($processo_renda === "alterar_renda")
    {
        $nomeRenda = $valores["nome_renda"];
        $categoriaRenda = $valores["categoria_renda"];
        $valorRenda = $valores["valor_renda"];
        $pagoRenda = $valores["pago_renda"];
        $codigoRenda = $valores["codigo_renda"];

        $sqlCadastrarRenda = "update renda set nome_renda = :recebe_nome_renda, categoria_renda = :recebe_categoria_renda, valor_renda = :recebe_valor_renda, pago_renda = :recebe_pago_renda where codigo_renda = :recebe_codigo_renda";
        $comandoCadastrarRenda = Conexao::Obtem()->prepare($sqlCadastrarRenda);
        $comandoCadastrarRenda->bindValue(":recebe_nome_renda",$nomeRenda);
        $comandoCadastrarRenda->bindValue(":recebe_categoria_renda",$categoriaRenda);
        $comandoCadastrarRenda->bindValue(":recebe_valor_renda",$valorRenda);
        $comandoCadastrarRenda->bindValue(":recebe_pago_renda",$pagoRenda);
        $comandoCadastrarRenda->bindValue(":recebe_codigo_renda",$codigoRenda);
        $resultadoAlterarRenda = $comandoCadastrarRenda->execute();
        
        if($resultadoAlterarRenda)
            echo json_encode("renda alterada");
        else
            echo json_encode("renda nao alterada");
    }
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
}else if($_SERVER["REQUEST_METHOD"] === "DELETE")
{
    // Recebe os dados do corpo da requisição
    $valores = json_decode(file_get_contents("php://input"), true);

    // Verifica se as variáveis 'execucao' e 'codigo_renda' foram enviadas
    $processo_renda = $valores["execucao"] ?? null;
    $codigo_renda = $valores["codigo_renda"] ?? null;

    if($processo_renda === "excluir_renda")
    {
        $sqlExcluirRenda = "delete from renda where codigo_renda = :recebe_codigo_renda";
        $comandoExcluirRenda = Conexao::Obtem()->prepare($sqlExcluirRenda);
        $comandoExcluirRenda->bindValue(":recebe_codigo_renda",$codigo_renda);
        $resultadoExcluirRenda = $comandoExcluirRenda->execute();

        if($resultadoExcluirRenda)
            echo json_encode("renda excluida");
        else
            echo json_encode("renda nao excluida");
    }
}