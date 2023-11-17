// =============================================================================

import { deslogar } from '../../../scripts/auth/deslogar.js';
import { serverUrl } from '../../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../../scripts/middlewares/isLoggedIn.js';
import { buscarPergunta } from '../../../scripts/perguntas/buscarPergunta.js';
import { editarPergunta } from '../../../scripts/perguntas/editarPergunta.js';
import { getLoggedUseInfo } from '../../../scripts/user/getLoggedUserInfo.js';
import { fillHeaderUserData } from '../../../scripts/utils/fillHeaderUserData.js';
import { toast } from '../../../scripts/utils/toast.js';

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
    toast('Erro ao mudar prioridade', true);
  }
});

const form = document.querySelector('form');
const url = new URL(window.location.href);

const id = url.searchParams.get('id');

if (!id) {
  window.location.href = `${serverUrl}/sistema`;
}

form.addEventListener('submit', async function (event) {
  event.preventDefault();
  const button = form.querySelector('button[type="submit"]');
  const botaoVoltar = form.querySelector('button#voltar');

  const titulo = form.querySelector('#titulo').value.trim();
  const resposta = form.querySelector('#resposta').value.trim();
  const prioridade = botaoPrioridade.value;

  if (prioridade !== 'Alta' && prioridade !== 'Normal') {
    toast('Prioridade deve ser Alta ou Normal', true);
    return;
  }

  if (!titulo) {
    toast('Título não pode estar vazio', true);
    return;
  } else if (!resposta) {
    toast('Resposta não pode estar vazio', true);
    return;
  }

  button.innerText = 'Aguarde';

  button.disabled = true;
  button.classList.add('disabled');
  botaoVoltar.disabled = true;
  botaoVoltar.classList.add('disabled');

  try {
    await editarPergunta({
      id,
      pergunta: titulo,
      resposta,
      prioridade,
    });

    window.location.href = `${serverUrl}/sistema`;
  } catch (error) {
    toast(error.message, true);
  } finally {
    button.innerText = 'Editar';

    button.disabled = false;
    button.classList.remove('disabled');
    botaoVoltar.disabled = false;
    botaoVoltar.classList.remove('disabled');
  }
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

  try {
    const titulo = document.querySelector('#titulo');
    const resposta = document.querySelector('#resposta');
    const prioridade = document.querySelector('#prioridade');

    const pergunta = await buscarPergunta({ id });

    titulo.value = pergunta.pergunta;
    resposta.value = pergunta.resposta;
    prioridade.value = pergunta.prioridade;
    prioridade.className = pergunta.prioridade.toLowerCase();
  } catch {
    window.location.href = `${serverUrl}/sistema`;
  }
};

loggedIn && (await execute());
