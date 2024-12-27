<?php
require("Conexao.php");

header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: POST , GET , DELETE");

header("Content-Type: application/json; charset=UTF-8");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $valores = json_decode(file_get_contents("php://input"), true);

    $processo_despesa = $valores["execucao"];

    if($processo_despesa === "cadastrar_despesa")
    {
        $nomeDespesa = $valores["nome_despesa"];
        $categoriaDespesa = $valores["categoria_despesa"];
        $valorDespesa = $valores["valor_despesa"];
        $pagoDespesa = $valores["pago_despesa"];

        $sqlCadastrarDespesa = "insert into despesa(nome_despesa,categoria_despesa,valor_despesa,pago_despesa)values
        (:recebe_nome_despesa,:recebe_categoria_despesa,:recebe_valor_despesa,:recebe_pago_despesa)";
        $comandoCadastrarDespesa = Conexao::Obtem()->prepare($sqlCadastrarDespesa);
        $comandoCadastrarDespesa->bindValue(":recebe_nome_despesa",$nomeDespesa);
        $comandoCadastrarDespesa->bindValue(":recebe_categoria_despesa",$categoriaDespesa);
        $comandoCadastrarDespesa->bindValue(":recebe_valor_despesa",$valorDespesa);
        $comandoCadastrarDespesa->bindValue(":recebe_pago_despesa",$pagoDespesa);
        $comandoCadastrarDespesa->execute();
        $registroUltimoCodigoCadastroDespesa = Conexao::Obtem()->lastInsertId();

        echo json_encode($registroUltimoCodigoCadastroDespesa);
    }else if($processo_renda === "alterar_despesa")
    {
        $nomeDespesa = $valores["nome_despesa"];
        $categoriaDespesa = $valores["categoria_despesa"];
        $valorDespesa = $valores["valor_despesa"];
        $pagoDespesa = $valores["pago_despesa"];
        $codigoDespesa = $valores["codigo_despesa"];

        $sqlAlterarDespesa = "update despesa set nome_despesa = :recebe_nome_despesa, categoria_despesa = :recebe_categoria_despesa, valor_despesa = :recebe_valor_despesa, pago_despesa = :recebe_pago_despesa where codigo_despesa = :recebe_codigo_despesa";
        $comandoAlterarDespesa = Conexao::Obtem()->prepare($sqlAlterarDespesa);
        $comandoAlterarDespesa->bindValue(":recebe_nome_despesa",$nomeDespesa);
        $comandoAlterarDespesa->bindValue(":recebe_categoria_despesa",$categoriaDespesa);
        $comandoAlterarDespesa->bindValue(":recebe_valor_despesa",$valorDespesa);
        $comandoAlterarDespesa->bindValue(":recebe_pago_despesa",$pagoDespesa);
        $comandoAlterarDespesa->bindValue(":recebe_codigo_despesa",$codigoDespesa);
        $resultadoAlterarDespesa = $comandoAlterarDespesa->execute();
        
        if($resultadoAlterarDespesa)
            echo json_encode("despesa alterada");
        else
            echo json_encode("despesa nao alterada");
    }
}else if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $processo_despesa = $_GET["execucao"];
    $opcao = $_GET["opcao"];
    $filtroInformado = $_GET["filtro"];

    if($processo_despesa === "busca_despesas")
    {
        if($opcao === "todos")
        {
            $sqlBuscaDespesas = "select * from despesa";
            $comandoBuscaDespesas = Conexao::Obtem()->prepare($sqlBuscaDespesas);
            $comandoBuscaDespesas->execute();
            $resultadoBuscaDespesas = $comandoBuscaDespesas->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $sqlBuscaDespesas = "select * from despesa where nome_despesa like :recebe_nome_despesa";
            $comandoBuscaDespesas = Conexao::Obtem()->prepare($sqlBuscaDespesas);
            $comandoBuscaDespesas->bindValue(":recebe_nome_despesa","%$filtroInformado%");
            $comandoBuscaDespesas->execute();
            $resultadoBuscaDespesas = $comandoBuscaDespesas->fetchAll(PDO::FETCH_ASSOC);
        }

        echo json_encode($resultadoBuscaDespesas);
    }
}else if($_SERVER["REQUEST_METHOD"] === "DELETE")
{
    // Recebe os dados do corpo da requisição
    $valores = json_decode(file_get_contents("php://input"), true);

    // Verifica se as variáveis 'execucao' e 'codigo_renda' foram enviadas
    $processo_despesa = $valores["execucao"] ?? null;
    $codigo_despesa = $valores["codigo_despesa"] ?? null;

    if($processo_despesa === "excluir_despesa")
    {
        $sqlExcluirDespesa = "delete from despesa where codigo_despesa = :recebe_codigo_despesa";
        $comandoExcluirDespesa = Conexao::Obtem()->prepare($sqlExcluirDespesa);
        $comandoExcluirDespesa->bindValue(":recebe_codigo_despesa",$codigo_despesa);
        $resultadoExcluirDespesa = $comandoExcluirDespesa->execute();

        if($resultadoExcluirDespesa)
            echo json_encode("despesa excluida");
        else
            echo json_encode("despesa nao excluida");
    }
}
?>