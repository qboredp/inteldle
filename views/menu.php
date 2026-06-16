<?php
session_start();
require_once "../config/database.php";

$db = (new Database())->conectar();

$rankingDiario = $db->query("
SELECT u.nome, r.pontuacao
FROM ranking_diario r
INNER JOIN usuarios u ON u.id = r.usuario_id
ORDER BY r.pontuacao DESC
LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);

$rankingInfinito = $db->query("
SELECT u.nome, r.pontuacao
FROM ranking_infinito r
INNER JOIN usuarios u ON u.id = r.usuario_id
ORDER BY r.pontuacao DESC
LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inteldle</title>

  <link rel="stylesheet" href="../assets/css/menu.css">
</head>

<body>

  <header>
    <div class="logo">Inteldle</div>

    <?php if (isset($_SESSION['id'])): ?>
      <div class="usuario-logado">
        Olá, <?= htmlspecialchars($_SESSION['nome']) ?>
        <a href="../api/logout.php" class="botao">Sair</a>
      </div>
    <?php else: ?>
      <button class="botao"
        onclick="abrirModal()">
        Login / Cadastro
      </button>
    <?php endif; ?>
  </header>

  <h1>Simulador de Erros</h1>

  <div class="container">

    <div class="painel-tecnicos">

      <p class="titulo-painel">
        Técnicos Diários
      </p>

      <ul class="lista-scores">

        <?php foreach ($rankingDiario as $player): ?>

          <li class="item-score">
            <span><?= htmlspecialchars($player['nome']) ?></span>
            <span class="score">
              <?= $player['pontuacao'] ?>
            </span>
          </li>

        <?php endforeach; ?>

      </ul>

    </div>

    <div class="menu-central">

      <a href="diario.php" class="botao">
        Defeito Diário
      </a>

      <a href="infinito.php" class="botao">
        Defeitos Infinitos
      </a>

      <a href="opcoes.php" class="botao">
        Opções
      </a>

      <a href="creditos.php" class="botao">
        Créditos
      </a>

      <a href="tutorial.php" class="botao">
        Como Jogar
      </a>

    </div>

    <div class="painel-tecnicos">

      <p class="titulo-painel">
        Técnicos Infinitos
      </p>

      <ul class="lista-scores">

        <?php foreach ($rankingInfinito as $player): ?>

          <li class="item-score">
            <span><?= htmlspecialchars($player['nome']) ?></span>
            <span class="score">
              <?= $player['pontuacao'] ?>
            </span>
          </li>

        <?php endforeach; ?>

      </ul>

    </div>

  </div>

  <div class="modal-overlay" id="modalLogin">

    <div class="modal-content">

      <span class="fechar-modal"
        onclick="fecharModal()">
        &times;
      </span>

      <h2 id="modalTitulo">Login</h2>

      <input type="text"
        id="nome"
        placeholder="Nome"
        style="display:none;">

      <input type="email"
        id="email"
        placeholder="Email">

      <input type="password"
        id="senha"
        placeholder="Senha">

      <button class="botao"
        onclick="enviarFormulario()">
        Entrar
      </button>

      <p id="toggleTexto"
        onclick="toggleModo()">
        Ainda não tem conta? Cadastre-se
      </p>

    </div>

  </div>

  <script src="../assets/js/menu.js"></script>

</body>

</html>