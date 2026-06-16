<?php

session_start();

require '../config/database.php';

$db = (new Database())->conectar();

$defeito = $_POST['defeito'];
$componente = $_POST['componente'];

$sql = $db->prepare("
SELECT *
FROM solucoes
WHERE defeito_id=?
AND componente=?
");

$sql->execute([
  $defeito,
  $componente
]);

$resposta = $sql->fetch(PDO::FETCH_ASSOC);

if ($resposta) {

  if ($resposta['correto']) {

    $pontos = 100;

    echo json_encode([
      "resultado" => "correto",
      "mensagem" => $resposta['mensagem'],
      "pontos" => $pontos
    ]);
  } else {

    echo json_encode([
      "resultado" => "erro",
      "mensagem" => $resposta['mensagem']
    ]);
  }
}
