// =============================================================================

import { deslogar } from '../../../scripts/auth/deslogar.js';
import { serverUrl } from '../../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../../scripts/middlewares/isLoggedIn.js';
import { getLoggedUseInfo } from '../../../scripts/user/getLoggedUserInfo.js';
import { fillHeaderUserData } from '../../../scripts/utils/fillHeaderUserData.js';

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
    window.location.href = '../../../sistema/perguntas/';
  }, 2000);
});

const spinner = document.querySelector('.spinnerFull');
const deslogarBotao = document.querySelector('#deslogar');
spinner.classList.remove('hideElement');

const loggedIn = await isLoggedIn();
if (!loggedIn) window.location.href = `${serverUrl}/login`;

const execute = async () => {
  document.body.classList.remove('no-scroll');
  spinner.classList.add('hideElement');
  deslogarBotao.addEventListener('click', async () => await deslogar());

  const user = await getLoggedUseInfo();
  fillHeaderUserData(user);
};

loggedIn && (await execute());
