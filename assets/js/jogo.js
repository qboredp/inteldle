
async function responder(componente) {

  const defeito =
    document.body.dataset.defeito;

  const dados = new FormData();

  dados.append("defeito", defeito);
  dados.append("componente", componente);

  const resposta = await fetch(
    "../api/verificar.php",
    {
      method: "POST",
      body: dados
    }
  );

  const json = await resposta.json();

  mostrarStatus(
      json.resultado,
      json.mensagem
    );


  if(json.resultado === 'correto'){
    const dados_pontos = new FormData();
    dados_pontos.append('pontos', pontos)

    await fetch(
    "../api/salvar_pontos.php",
    {
      method: "POST",
      body: dados_pontos
    } 
  );

  } else {
    pontos -= 200;
  }
}
let pontos = 10000;
let ligado = true;

function mostrarAviso(mensagem) {
  document.getElementById('avisoTexto').innerText = mensagem;
  document.getElementById('modalAviso').style.display = 'flex';
}

function fecharAviso() {
  document.getElementById('modalAviso').style.display = 'none';

}

function acaoHardware(nomePeca) {
  if (ligado) {
    mostrarAviso("PERIGO: O computador deve ser DESLIGADO antes de manipular o hardware!");
    return;
  }
  responder(nomePeca);
  
}

function acaoSoftware(nomeSoft) {
  if (!ligado) {
    mostrarAviso("ERRO: O computador precisa estar LIGADO para acessar o software!");
    return;
  }
  responder(nomeSoft);
}

function toggleBandeja(id) {
  const bandeja = document.getElementById(id);
  bandeja.classList.toggle('aberta');
}

function mostrarStatus(tipo, mensagem) {
  const modal = document.getElementById('modalStatus');
  const content = document.getElementById('statusContent');
  const titulo = document.getElementById('statusTitulo');
  const texto = document.getElementById('statusMensagem');

  const ehCorreto = tipo === 'correto';

  content.classList.remove('status-ok', 'status-erro');
  content.classList.add(ehCorreto ? 'status-ok' : 'status-erro');
  titulo.innerText = ehCorreto ? 'CORRETO' : 'INCORRETO';
  texto.innerText = mensagem || '';
  modal.style.display = 'flex';
}

function fecharStatus() {
  document.getElementById('modalStatus').style.display = 'none';
}

function verificarTagStatus(elemento) {
  if (!elemento) return;

  const status = (elemento.getAttribute('data-status') || '').toLowerCase();
  const mensagem = elemento.getAttribute('data-mensagem') || '';
  const estaNoHardware = !!elemento.closest('#bandejaHW');
  const estaNoSoftware = !!elemento.closest('#bandejaSW');

  if (estaNoHardware && ligado) {
    fecharStatus();
    mostrarAviso('PERIGO: O computador deve ser DESLIGADO antes de manipular o hardware!');
    return;
  }

  if (estaNoSoftware && !ligado) {
    fecharStatus();
    mostrarAviso('ERRO: O computador precisa estar LIGADO para acessar o software!');
    return;
  }

  if (status === 'correto') {
    mostrarStatus('correto', mensagem);
  } else if (status === 'incorreto') {
    mostrarStatus('incorreto', mensagem);
  }
}

document.addEventListener('click', function (event) {
  const botao = event.target.closest('.btn-vermelho');
  const componenteComStatus = event.target.closest('[data-status]');

  if (botao && componenteComStatus) {

    const estaNoHardware = !!botao.closest('#bandejaHW');
    const estaNoSoftware = !!botao.closest('#bandejaSW');

    if (estaNoHardware && ligado) {
      mostrarAviso('PERIGO: O computador deve ser DESLIGADO antes de manipular o hardware!');
      return;
    }

    if (estaNoSoftware && !ligado) {
      mostrarAviso('ERRO: O computador precisa estar LIGADO para acessar o software!');
      return;
    }

    botao.classList.add('usado');
    verificarTagStatus(componenteComStatus);
  }

  if (event.target && event.target.id === 'modalStatus') {
    fecharStatus();
  }
});

function alternarEnergia() {
  const btnPower = document.getElementById('btnPower');
  const imgOn = document.getElementById('imgOn');
  const imgOff = document.getElementById('imgOff');

  ligado = !ligado;

  if (ligado) {
    imgOn.style.opacity = '1';
    imgOff.style.opacity = '0';

    btnPower.classList.remove('apagando');
    btnPower.classList.add('aceso');
    console.log("Sistema Energizado");
  } else {
    imgOn.style.opacity = '0';
    imgOff.style.opacity = '1';

    btnPower.classList.remove('aceso');
    btnPower.classList.add('apagando');
    console.log("Sistema Desativado");
  }
}