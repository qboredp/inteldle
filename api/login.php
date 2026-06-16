<?php

session_start();

require '../config/database.php';

$db = (new Database())->conectar();

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = $db->prepare("
SELECT *
FROM usuarios
WHERE email=?
");

$sql->execute([$email]);

$user = $sql->fetch(PDO::FETCH_ASSOC);

if (
  $user &&
  password_verify($senha, $user['senha'])
) {

  $_SESSION['id'] = $user['id'];
  $_SESSION['nome'] = $user['nome'];

  echo json_encode([
    "sucesso" => true
  ]);
} else {

  echo json_encode([
    "sucesso" => false
  ]);
}
