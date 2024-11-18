<?php
//O valor diz aos navegadores para permitir que o código de solicitação de qualquer origem acesse o recurso
header('Access-Control-Allow-Origin: *');
//Especifica um ou mais métodos permitidos ao acessar um recurso em resposta a uma solicitação de comprovação
header("Access-Control-Allow-Methods: POST , GET , DELETE");
header("Content-Type: application/json; charset=UTF-8");
require("Conexao.php");
if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $valores = json_decode(file_get_contents("php://input"), true);

    $nomeUsuario = $valores["nome_usuario"];
    $loginUsuario = $valores["login_usuario"];
    $emailUsuario = $valores["email_usuario"];
    $senhaUsuario = $valores["senha_usuario"];
    $nomeImagemUsuario = $valores["nome_imagem"];

    $senhaCriptografada = md5($senhaUsuario);
    
    //$dados = $nomeUsuario."\n".$loginUsuario."\n".$emailUsuario."\n".$senhaUsuario."\n".$nomeImagemUsuario;

    $sqlCadastrarUsuario = "insert into usuario(nome_usuario,login_usuario,email_usuario,senha_usuario,imagem_usuario)values
    (:recebe_nome_usuario,:recebe_login_usuario,:recebe_email_usuario,:recebe_senha_usuario,:recebe_imagem_usuario)";
    $comandoCadastrarUsuaruio = Conexao::Obtem()->prepare($sqlCadastrarUsuario);
    $comandoCadastrarUsuaruio->bindValue(":recebe_nome_usuario",$nomeUsuario);
    $comandoCadastrarUsuaruio->bindValue(":recebe_login_usuario",$loginUsuario);
    $comandoCadastrarUsuaruio->bindValue(":recebe_email_usuario",$emailUsuario);
    $comandoCadastrarUsuaruio->bindValue(":recebe_senha_usuario",$senhaCriptografada);
    $comandoCadastrarUsuaruio->bindValue(":recebe_imagem_usuario",$nomeImagemUsuario);
    $comandoCadastrarUsuaruio->execute();
    $registroUltimoCodigoCadastroUsuario = Conexao::Obtem()->lastInsertId();

    echo json_encode($registroUltimoCodigoCadastroUsuario);
}else if($_SERVER["REQUEST_METHOD"] === "GET"){
    $loginUsuario = $_GET["recebe_login_usuario"];
    $senhaUsuario = $_GET["recebe_senha_usuario"];

    $senhaCriptografada = md5($senhaUsuario);

    $sqlBuscaUsuario = "select * from usuario where login_usuario = :recebe_login_usuario and senha_usuario = :recebe_senha_usuario";
    $comandoBuscaUsuario = Conexao::Obtem()->prepare($sqlBuscaUsuario);
    $comandoBuscaUsuario->bindValue(":recebe_login_usuario",$loginUsuario);
    $comandoBuscaUsuario->bindValue(":recebe_senha_usuario",$senhaCriptografada);
    $comandoBuscaUsuario->execute();
    $resultadoBuscaUsuario = $comandoBuscaUsuario->fetch(PDO::FETCH_ASSOC);

    if(empty($resultadoBuscaUsuario))
        echo json_encode("nenhum usuario localizado");
    else
        echo json_encode($resultadoBuscaUsuario);
}
?>