// =============================================================================

import { deslogar } from '../../scripts/auth/deslogar.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { criarPergunta } from '../../scripts/perguntas/criarPergunta.js';
import { deletarPergunta } from '../../scripts/perguntas/deletarPergunta.js';
import { listarSugestoes } from '../../scripts/sugestoes/listarSugestoes.js';
import { responderSugestao } from '../../scripts/sugestoes/responderSugestao.js';
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
const sugestoesTable = sugestaoContainer.querySelector('.sugestoes-table');

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

  const sugestaoId = document.querySelector('#sugestao-id');
  const perguntaSugestao = document.querySelector('#pergunta-sugestao');
  const perguntaSugestaoClasse = document.querySelectorAll('.pergunta-sugestao-classe');

  const user = await getLoggedUseInfo();
  fillHeaderUserData(user);

  const handleResponderSugestao = (id, pergunta) => {
    sugestaoId.value = id;
    perguntaSugestao.value = pergunta;

    perguntaSugestaoClasse.forEach((p) => p.classList.add('mostrar'));

    botaoSugestao.classList.remove('aberto');
    dadosSugestoes.classList.remove('aberto');
    botaoPerguntas.classList.remove('aberto');
    form.classList.remove('aberto');
    botaoPerguntas.classList.add('aberto');
    form.classList.add('aberto');
  };

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
      if (sugestaoId.value && perguntaSugestao.value) {
        try {
          const perguntaSugeridaRespondida = await responderSugestao(sugestaoId.value);

          if (perguntaSugeridaRespondida) {
            toast('Sugestão respondida com sucesso');
          }

          setTimeout(() => {
            window.location = `${serverUrl}/sistema/perguntas`;
          }, 3000);
        } catch (error) {
          toast('Houve um problema ao atualizar a sugestão', true);
          console.log(error);

          try {
            deletarPergunta(perguntaCriada.id);
          } catch (error) {
            console.log(error.message);
          }

          return;
        }
      }

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

  const sugestoes = await listarSugestoes();

  sugestoesTable.innerHTML = `
  <thead>
      <tr>
        <th>
          <span>Nome <i class="fas fa-sort-down"></i></span>
        </th>
        <th>
          <span>Email <i class="fas fa-sort-down"></i></span>
        </th>
        <th>
          <span>Telefone<i class="fas fa-sort-down"></i></span>
        </th>
        <th id="pergunta">
          <span>Sugestão <i class="fas fa-sort-down"></i></span>
        </th>
        <th>
          <span>Ações</span>
        </th>
      </tr>
    </thead>`;

  sugestoesTable.innerHTML += sugestoes
    .map(
      (sugestao) => `
    <tbody>
      <td>
        <span>${sugestao.nome}</span>
      </td>
      <td>
        <span>${sugestao.email}</span>
      </td>
      <td>
        <span>${sugestao.telefone}</span>
      </td>
      <td>
        <span>${sugestao.pergunta}</span>
      </td>
      <td>
        <div id="acao">
          <button class="botao-responder-sugestao" title="Responder a sugestão" data-id="${sugestao.id}" data-pergunta="${sugestao.pergunta}">
            <i class="fas fa-comment"></i>
          </button>
        </div>
      </td>
    </tbody>
  `,
    )
    .join('');

  const botoesResponderSugestao = document.querySelectorAll('.botao-responder-sugestao');

  botoesResponderSugestao.forEach((botao) => {
    botao.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      const pergunta = this.getAttribute('data-pergunta');
      handleResponderSugestao(id, pergunta);
    });
  });
};

loggedIn && (await execute());
