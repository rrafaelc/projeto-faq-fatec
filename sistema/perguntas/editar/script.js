// =============================================================================
// Header
const usuario = document.querySelector('.usuario');
const botaoUsuario = usuario.querySelector('.botao');
const dropdown = usuario.querySelector('.dropdown');

botaoUsuario.addEventListener('click', function () {
  botaoUsuario.classList.toggle('ativo');
  dropdown.classList.toggle('ativo');
});
//==============================================================================
const botaoPrioridade = document.querySelector('#prioridade');

botaoPrioridade.addEventListener('click', function () {
  const value = botaoPrioridade.value;

  if (value === 'Normal') {
    botaoPrioridade.classList.remove('normal');
    botaoPrioridade.classList.add('alta');
    botaoPrioridade.value = 'Alta';
  } else if (value === 'Alta') {
    botaoPrioridade.classList.remove('alta');
    botaoPrioridade.classList.add('normal');
    botaoPrioridade.value = 'Normal';
  } else {
    console.log('Erro ao mudar prioridade');
  }
});

const form = document.querySelector('form');

form.addEventListener('submit', function (event) {
  event.preventDefault();
  const button = form.querySelector('button[type="submit"]');
  const botaoVoltar = form.querySelector('button#voltar');

  const titulo = form.querySelector('#titulo');
  const resposta = form.querySelector('#resposta');

  if (titulo.value === '') {
    titulo.focus();
    return;
  } else if (resposta.value === '') {
    resposta.focus();
    return;
  }

  button.innerText = 'Aguarde';

  button.disabled = true;
  button.classList.add('disabled');
  botaoVoltar.disabled = true;
  botaoVoltar.classList.add('disabled');

  setTimeout(function () {
    window.location.href = '/sistema/perguntas/';
  }, 2000);
});
