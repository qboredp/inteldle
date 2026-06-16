<?php

require '../config/database.php';

$db = (new Database())->conectar();

$sql = $db->query("
SELECT *
FROM defeitos
ORDER BY RAND()
LIMIT 1
");

echo json_encode(
  $sql->fetch(PDO::FETCH_ASSOC)
);
