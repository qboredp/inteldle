<?php

require '../config/database.php';

$db = (new Database())->conectar();

$sql = $db->query("
SELECT
u.nome,
r.pontuacao

FROM ranking_infinito r

INNER JOIN usuarios u
ON u.id=r.usuario_id

ORDER BY pontuacao DESC

LIMIT 10
");

echo json_encode(
  $sql->fetchAll(PDO::FETCH_ASSOC)
);
