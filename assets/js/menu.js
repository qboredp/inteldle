let cadastro = false;

const modal = document.getElementById("modalLogin");

function abrirModal() {
  modal.style.display = "flex";
}

function fecharModal() {
  modal.style.display = "none";
}

window.onclick = function (e) {
  if (e.target === modal) {
    fecharModal();
  }
}

function toggleModo() {

  cadastro = !cadastro;

  document.getElementById("nome").style.display =
    cadastro ? "block" : "none";

  document.getElementById("modalTitulo").innerText =
    cadastro ? "Cadastro" : "Login";

  document.getElementById("toggleTexto").innerText =
    cadastro
      ? "Já possui conta? Faça Login"
      : "Ainda não tem conta? Cadastre-se";
}

async function enviarFormulario() {

  const url = cadastro
    ? "../api/cadastro.php"
    : "../api/login.php";

  const dados = new FormData();

  if (cadastro) {
    dados.append(
      "nome",
      document.getElementById("nome").value
    );
  }

  dados.append(
    "email",
    document.getElementById("email").value
  );

  dados.append(
    "senha",
    document.getElementById("senha").value
  );

  const resposta = await fetch(url, {
    method: "POST",
    body: dados
  });

  const json = await resposta.json();

  if (json.sucesso) {
    location.reload();
  } else {
    alert("Erro ao autenticar.");
  }
}