<?php
//O valor diz aos navegadores para permitir que o código de solicitação de qualquer origem acesse o recurso
header('Access-Control-Allow-Origin: *');
//Especifica um ou mais métodos permitidos ao acessar um recurso em resposta a uma solicitação de comprovação
header("Access-Control-Allow-Methods: POST , GET , DELETE");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    $valores = json_decode(file_get_contents("php://input"), true);

    $nomeUsuario = $valores["nome_usuario"];
    $nomeImagemUsuario = $valores["nome_imagem"];

    $dados = $nomeUsuario."-".$nomeImagemUsuario;

    echo json_encode($dados);
}
?>