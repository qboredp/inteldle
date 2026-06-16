<?php
session_start();
require '../config/database.php';
$db = (new Database())->conectar();
$stmt = $db->prepare('INSERT INTO ranking_diario(usuario_id,pontuacao,data_jogo) VALUES(?,?,CURDATE())');
$stmt->execute([$_SESSION['id'], $_POST['pontos']]);
echo json_encode(['sucesso' => true]);
