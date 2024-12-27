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
        $codigoUsuarioRenda = $valores["codigo_usuario_renda"];

        $sqlCadastrarCategoriaRenda = "insert into categoria(nome_categoria,codigo_usuario,tipo_categoria)values(:recebe_nome_categoria_renda,:recebe_codigo_usuario_renda,:recebe_tipo_categoria)";
        $comandoCadastrarCategoriaRenda = Conexao::Obtem()->prepare($sqlCadastrarCategoriaRenda);
        $comandoCadastrarCategoriaRenda->bindValue(":recebe_nome_categoria_renda",$nomeCategoriaRenda);
        $comandoCadastrarCategoriaRenda->bindValue(":recebe_codigo_usuario_renda",$codigoUsuarioRenda);
        $comandoCadastrarCategoriaRenda->bindValue(":recebe_tipo_categoria","renda");
        $comandoCadastrarCategoriaRenda->execute();
        $registroUltimoCodigoCadastroCategoriaRenda = Conexao::Obtem()->lastInsertId();

        echo json_encode($registroUltimoCodigoCadastroCategoriaRenda);
    }else if($processo_categoria === "cadastrar_categoria_despesa")
    {
        $nomeCategoriaDespesa = $valores["nome_categoria_despesa"];
        $codigoUsuarioDespesa = $valores["codigo_usuario_despesa"];

        $sqlCadastrarCategoriaDespesa = "insert into categoria(nome_categoria,codigo_usuario,tipo_categoria)values(:recebe_nome_categoria_despesa,:recebe_codigo_usuario_despesa,:recebe_tipo_categoria)";
        $comandoCadastrarCategoriaDespesa = Conexao::Obtem()->prepare($sqlCadastrarCategoriaDespesa);
        $comandoCadastrarCategoriaDespesa->bindValue(":recebe_nome_categoria_despesa",$nomeCategoriaDespesa);
        $comandoCadastrarCategoriaDespesa->bindValue(":recebe_codigo_usuario_despesa",$codigoUsuarioDespesa);
        $comandoCadastrarCategoriaDespesa->bindValue(":recebe_tipo_categoria","despesa");
        $comandoCadastrarCategoriaDespesa->execute();
        $registroUltimoCodigoCadastroCategoriaDespesa = Conexao::Obtem()->lastInsertId();

        echo json_encode($registroUltimoCodigoCadastroCategoriaDespesa);
    }
}if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $processo_categoria = $_GET["execucao"];

    if($processo_categoria === "busca_categorias_renda")
    {
        $codigoUsuario = $_GET["codigo_usuario"];
        $sqlBuscaCategoriasRenda = "select * from categoria where codigo_usuario = :recebe_codigo_usuario and tipo_categoria = :recebe_tipo_categoria";
        $comandoBuscaCategoriasRenda = Conexao::Obtem()->prepare($sqlBuscaCategoriasRenda);
        $comandoBuscaCategoriasRenda->bindValue(":recebe_codigo_usuario",$codigoUsuario);
        $comandoBuscaCategoriasRenda->bindValue(":recebe_tipo_categoria","renda");
        $comandoBuscaCategoriasRenda->execute();
        $resultadoBuscaCategoriasRenda = $comandoBuscaCategoriasRenda->fetchAll(PDO::FETCH_ASSOC);

        if(empty($resultadoBuscaCategoriasRenda))
            echo json_encode("nada");
        else
            echo json_encode($resultadoBuscaCategoriasRenda);
    }else if($processo_categoria === "busca_categorias_despesa")
    {
        $codigoUsuario = $_GET["codigo_usuario"];
        $sqlBuscaCategoriasRenda = "select * from categoria where codigo_usuario = :recebe_codigo_usuario and tipo_categoria = :recebe_tipo_categoria";
        $comandoBuscaCategoriasDespesa = Conexao::Obtem()->prepare($sqlBuscaCategoriasRenda);
        $comandoBuscaCategoriasDespesa->bindValue(":recebe_codigo_usuario",$codigoUsuario);
        $comandoBuscaCategoriasDespesa->bindValue(":recebe_tipo_categoria","despesa");
        $comandoBuscaCategoriasDespesa->execute();
        $resultadoBuscaCategoriasDespesa = $comandoBuscaCategoriasDespesa->fetchAll(PDO::FETCH_ASSOC);

        if(empty($resultadoBuscaCategoriasDespesa))
            echo json_encode("nada");
        else
            echo json_encode($resultadoBuscaCategoriasDespesa);   
    }
}
?>