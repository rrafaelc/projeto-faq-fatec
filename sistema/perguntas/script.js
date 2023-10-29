// =============================================================================

import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { deslogar } from '../../scripts/deslogar.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';

// Header
const usuario = document.querySelector('.usuario');
const botaoUsuario = usuario.querySelector('.botao');
const dropdown = usuario.querySelector('.dropdown');

botaoUsuario.addEventListener('click', function () {
  botaoUsuario.classList.toggle('ativo');
  dropdown.classList.toggle('ativo');
});
//==============================================================================
// Impedir que o tab pule para o proximo elemento
const textarea = document.querySelector('textarea');

textarea.addEventListener('keydown', function (event) {
  if (event.key === 'Tab') {
    event.preventDefault();

    // Adiciona uma tabulação manual ao conteúdo do textarea
    var start = this.selectionStart;
    var end = this.selectionEnd;
    this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);
    this.selectionStart = this.selectionEnd = start + 1;
  }
});
//==============================================================================

const perguntas = document.querySelector('.adicionar-pergunta');
const tituloPerguntas = perguntas.querySelector('.titulo');
const botaoPerguntas = perguntas.querySelector('.botao');
const form = perguntas.querySelector('form');

const titulo = form.querySelector('#titulo');
const resposta = form.querySelector('#resposta');
const botaoPrioridade = form.querySelector('#prioridade');

tituloPerguntas.addEventListener('click', function () {
  botaoPerguntas.classList.toggle('aberto');
  form.classList.toggle('aberto');
});

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

form.addEventListener('submit', function (event) {
  event.preventDefault();

  console.log({
    titulo: titulo.value,
    resposta: resposta.value,
    prioridade: botaoPrioridade.value,
  });
});

const spinner = document.querySelector('.spinnerFull');
const deslogarBotao = document.querySelector('#deslogar');
spinner.classList.remove('hideElement');

const loggedIn = await isLoggedIn();
if (!loggedIn) window.location.href = `${serverUrl}/login`;

const execute = () => {
  document.body.classList.remove('no-scroll');
  spinner.classList.add('hideElement');

  deslogarBotao.addEventListener('click', () => deslogar());
};

loggedIn && execute();
