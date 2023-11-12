// =============================================================================

import { deslogar } from '../../scripts/auth/deslogar.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { criarPergunta } from '../../scripts/perguntas/criarPergunta.js';
import { getLoggedUseInfo } from '../../scripts/user/getLoggedUserInfo.js';
import { fillHeaderUserData } from '../../scripts/utils/fillHeaderUserData.js';
import { toast } from '../../scripts/utils/toast.js';

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
const tituloPerguntas = perguntas.querySelector('.titulo-pergunta');
const botaoPerguntas = perguntas.querySelector('.botao');
const form = perguntas.querySelector('form');

const titulo = form.querySelector('#titulo');
const resposta = form.querySelector('#resposta');
const botaoPrioridade = form.querySelector('#prioridade');
const botaoEnviar = form.querySelector('.enviar');

const sugestaoContainer = document.querySelector('.sugestao-container');
const tituloSugestao = sugestaoContainer.querySelector('.titulo-sugestao');
const botaoSugestao = sugestaoContainer.querySelector('.botao');
const dadosSugestoes = sugestaoContainer.querySelector('.dados-sugestoes');

tituloPerguntas.addEventListener('click', function () {
  botaoPerguntas.classList.toggle('aberto');
  form.classList.toggle('aberto');
});

tituloSugestao.addEventListener('click', function () {
  botaoSugestao.classList.toggle('aberto');
  dadosSugestoes.classList.toggle('aberto');
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

  form.addEventListener('submit', async function (event) {
    event.preventDefault();

    botaoEnviar.disabled = true;
    botaoEnviar.textContent = 'Carregando';

    const perguntaCriada = await criarPergunta({
      pergunta: titulo.value,
      resposta: resposta.value,
      prioridade: botaoPrioridade.value,
    });

    if (perguntaCriada) {
      botaoPerguntas.classList.toggle('aberto');
      form.classList.toggle('aberto');
      titulo.value = '';
      resposta.value = '';
      botaoPrioridade.value = 'Normal';
      botaoPrioridade.classList.remove('alta');
      botaoPrioridade.classList.remove('normal');
      botaoPrioridade.classList.add('normal');
      botaoEnviar.disabled = false;
      botaoPrioridade.value = 'Normal';
      botaoEnviar.textContent = 'Adicionar';

      window.scrollTo({
        top: 0,
        behavior: 'smooth',
      });

      toast('Pergunta criada com sucesso');
    } else {
      botaoEnviar.disabled = false;
      botaoEnviar.textContent = 'Adicionar';
      toast('Erro ao criar a pergunta', true);
    }
  });
};

loggedIn && (await execute());
