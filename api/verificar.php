<?php

require '../config/database.php';

$db = (new Database())->conectar();

$defeito = $_POST['defeito'];
$componente = $_POST['componente'];

$sql = $db->prepare("
SELECT *
FROM solucoes
WHERE defeito_id = ?
AND componente = ?
");

$sql->execute([
    $defeito,
    $componente
]);

$resposta = $sql->fetch(PDO::FETCH_ASSOC);

if (!$resposta) {

    echo json_encode([
        "resultado" => "erro",
        "mensagem" => "Componente não cadastrado"
    ]);
    exit;
}

echo json_encode([
    "resultado" => $resposta['correto']
        ? "correto"
        : "erro",
    "mensagem" => $resposta['mensagem']
]);