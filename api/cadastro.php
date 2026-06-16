<?php

require '../config/database.php';

$db = (new Database())->conectar();

$nome = $_POST['nome'];
$email = $_POST['email'];

$senha = password_hash(
  $_POST['senha'],
  PASSWORD_DEFAULT
);

$sql = $db->prepare("
INSERT INTO usuarios
(nome,email,senha)
VALUES(?,?,?)
");

$sql->execute([
  $nome,
  $email,
  $senha
]);

echo json_encode([
  "sucesso" => true
]);
