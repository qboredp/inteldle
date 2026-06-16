<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['id']))
  die('Faça login');
$id_usuario = $_SESSION['id'];
$db = (new Database())->conectar();
$defeito = $db->query("SELECT * FROM defeitos ORDER BY RAND() LIMIT 1;")->fetch(PDO::FETCH_ASSOC);
$stmt_check = $db->prepare("
    SELECT COUNT(*) AS total 
    FROM ranking_diario 
    WHERE usuario_id = :id_do_usuario 
      AND data_jogo = CURDATE()
");
$stmt_check->execute([':id_do_usuario' => $id_usuario]);
$check_resultado = $stmt_check->fetch(PDO::FETCH_ASSOC);

$ja_jogou = $check_resultado['total'] > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simulador - Área de Trabalho</title>
  <link rel="stylesheet" href="../assets/css/jogo.css">
</head>

<body data-defeito="<?= htmlspecialchars($defeito['id']) ?>" data-ja-jogou="<?= htmlspecialchars($ja_jogou) ?>">

  <a href="./menu.php" class="botao-voltar">← Voltar ao Menu</a>

  <div id="modalAviso" class="aviso-overlay">
    <div class="aviso-content">
      <h2 id="avisoTitulo" style="color: #ff4444;">ALERTA DE SEGURANÇA</h2>
      <p id="avisoTexto" style="color: #fff;"></p>
      <button class="btn-ok" onclick="fecharAviso()">ENTENDIDO</button>
    </div>
  </div>

  <div id="modalStatus" class="status-overlay">
    <div id="statusContent" class="status-content status-ok">
      <h2 id="statusTitulo" class="status-titulo">CORRETO</h2>
      <p id="statusMensagem" class="status-mensagem"></p>
      <button class="btn-ok" onclick="fecharStatus()">ENTENDIDO</button>
    </div>
  </div>

  <div class="topo-container">
    <div class="area-computador">
      <img src="pc_foto_exemplo.png" alt="[Imagem do Computador]">
    </div>

    <div class="caixa-descricao">
      <h3 style="margin-top: 0;">
        <?= htmlspecialchars($defeito['titulo']) ?>
      </h3>
      <p id="textoStatusSistema">
        <?= htmlspecialchars($defeito['descricao'] ?? '') ?>
      </p>
    </div>
  </div>

  <div class="controles-area">
    <div class="secao-botoes-bandejas">

      <div class="grupo-interativo">
        <button class="btn-azul" onclick="toggleBandeja('bandejaHW')">HARDWARE</button>
        <div id="bandejaHW" class="linha-pecas">
          <button class="btn-vermelho" data-nome="Processador" data-status="incorreto" onclick="acaoHardware('Fonte')">
            <img src="../assets/imagens/cpu.png" alt="CPU">
          </button>
          <button class="btn-vermelho" data-nome="Memória RAM" onclick="acaoHardware('RAM')">
            <img src="../assets/imagens/ram.png" alt="RAM">
          </button>
          <button class="btn-vermelho" data-nome="Placa de Vídeo" onclick="acaoHardware('Placa de Vídeo')">
            <img src="../assets/imagens/placadevideo.png" alt="GPU">
          </button>
          <button class="btn-vermelho" data-nome="Disco Rígido" onclick="acaoHardware('Disco Rígido')">
            <img src="../assets/imagens/hd.webp" alt="HD">
          </button>
          <button class="btn-vermelho" data-nome="SSD" onclick="acaoHardware('SSD')">
            <img src="../assets/imagens/ssd.png" alt="SSD">
          </button>
          <button class="btn-vermelho" data-nome="Monitor" onclick="acaoHardware('Monitor')">
            <img src="../assets/imagens/monitor.png" alt="Monitor">
          </button>
          <button class="btn-vermelho" data-nome="Limpeza" onclick="acaoHardware('Limpeza')">
            <img src="../assets/imagens/broom.png" alt="CLN">
          </button>
          <button class="btn-vermelho" data-nome="Placa-mãe" onclick="acaoHardware('Placa-mãe')">
            <img src="../assets/imagens/placamae.png" alt="MOB">
          </button>
          <button class="btn-vermelho" data-nome="Cooler" onclick="acaoHardware('Cooler')">
            <img src="../assets/imagens/cooler.png" alt="COL">
          </button>
          <button class="btn-vermelho" data-nome="Fonte" onclick="acaoHardware('Fonte')">
            <img src="../assets/imagens/fonte.png" alt="Fonte">
          </button>
        </div>
      </div>

      <div class="grupo-interativo">
        <button class="btn-azul" onclick="toggleBandeja('bandejaSW')">SOFTWARE</button>
        <div id="bandejaSW" class="linha-pecas">
          <button class="btn-vermelho" data-nome="BIOS" onclick="acaoSoftware('BIOS')">
            <img src="../assets/imagens/bios.png" alt="BIOS">
          </button>
          <button class="btn-vermelho" data-nome="Atualização" onclick="acaoSoftware('Atualização')">
            <img src="../assets/imagens/update.png" alt="CMD">
          </button>
          <button class="btn-vermelho" data-nome="Reinstalar SO" onclick="acaoSoftware('Reinstalar SO')">
            <img src="../assets/imagens/reinstall.png" alt="DRV">
          </button>
          <button class="btn-vermelho" data-nome="Procurar Vírus" onclick="acaoSoftware('Procurar Vírus')">
            <img src="../assets/imagens/Virabot_shell.webp" alt="SEC">
          </button>
        </div>
      </div>

    </div>

    <div class="area-power">
      <button id="btnPower" class="aceso" onclick="alternarEnergia()" aria-label="Alternar energia">
        <img id="imgOn" src="../assets/imagens/BtnOn.png" alt="Power ligado">
        <img id="imgOff" src="../assets/imagens/BtnOff.png" alt="Power desligado">
      </button>
    </div>
  </div>

  <script src="../assets/js/jogo.js"></script>

</body>

</html>