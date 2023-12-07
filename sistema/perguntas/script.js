// =============================================================================

import { deslogar } from '../../scripts/auth/deslogar.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { criarPergunta } from '../../scripts/perguntas/criarPergunta.js';
import { deletarPergunta } from '../../scripts/perguntas/deletarPergunta.js';
import { listarPerguntasPorUsuario } from '../../scripts/perguntas/listarPerguntasPorUsuario.js';
import { deletarSugestao } from '../../scripts/sugestoes/deletarSugestao.js';
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
const sugestoesTbody = sugestaoContainer.querySelector('.sugestoes-tbody');

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

  const handleDeletarSugestao = async (id) => {
    const result = await deletarSugestao(id);

    perguntaSugestaoClasse.forEach((p) => p.classList.remove('mostrar'));
    botaoSugestao.classList.remove('aberto');
    dadosSugestoes.classList.remove('aberto');
    botaoPerguntas.classList.remove('aberto');
    form.classList.remove('aberto');

    if (!result) {
      toast('Houve um erro ao deletar a sugestão', true);
      return;
    }

    toast('Sugestão deletada com sucesso');

    setTimeout(() => {
      window.location = `${serverUrl}/sistema/perguntas`;
    }, 500);
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
            window.location.reload();
          }, 500);
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

      setTimeout(() => {
        window.location.reload();
      }, 500);
    } else {
      botaoEnviar.disabled = false;
      botaoEnviar.textContent = 'Adicionar';
      toast('Erro ao criar a pergunta', true);
    }
  });

  const spinnerContainer = document.querySelector('.spinnerContainer');
  const pgInicioSugestoes = document.querySelector('.pg-inicio-sugestoes');
  const pgAnteriorSugestoes = document.querySelector('.pg-anterior-sugestoes');
  const pgProximoSugestoes = document.querySelector('.pg-proximo-sugestoes');
  const pgUltimoSugestoes = document.querySelector('.pg-ultimo-sugestoes');
  const pgNumerosSugestoes = document.querySelector('.pg-numeros-sugestoes');

  pgNumerosSugestoes.innerHTML = `
  <div class="numero">1</div>
  <div class="numero">2</div>
  <div class="numero active">3</div>
  <div class="numero">4</div>
  <div class="numero">5</div>
  `;

  let paginaSugestoes = 1;
  let qtdPgSugestoes = 0;
  const renderSugestoes = async ({ pagina = 1, qtdPorPg = 5, order = 'asc' } = {}) => {
    try {
      spinnerContainer.classList.add('mostrar');
      sugestoesTbody.innerHTML = '';
      pgNumerosSugestoes.innerHTML = '';

      const sugestoes = await listarSugestoes({
        pagina,
        qtdPorPg,
        order,
      });

      paginaSugestoes = sugestoes.pagina;
      qtdPgSugestoes = sugestoes.qtd_pg;

      const maxLinks = 2;
      const numBotoesLado = maxLinks * 2 + 1; // Número total de botões à esquerda e à direita

      let startPage = Math.max(1, paginaSugestoes - maxLinks);
      let endPage = Math.min(qtdPgSugestoes, startPage + numBotoesLado - 1);

      // Ajuste para garantir que o número total de botões seja consistente
      if (endPage - startPage + 1 < numBotoesLado) {
        startPage = Math.max(1, endPage - numBotoesLado + 1);
      }

      for (let i = startPage; i <= endPage; i++) {
        pgNumerosSugestoes.innerHTML += `<div class="numero ${
          i === paginaSugestoes ? 'active' : ''
        }">${i}</div>`;
      }

      sugestoesTbody.innerHTML += sugestoes.resultado
        .map(
          (sugestao) => `
        <tr>
          <td class="sugestao-nome">
            <span>${sugestao.nome}</span>
          </td>
          <td class="sugestao-email">
            <span>${sugestao.email}</span>
          </td>
          <td class="sugestao-telefone">
            <span>${sugestao.telefone}</span>
          </td>
          <td class="sugestao-pergunta">
            <span>${sugestao.pergunta}</span>
          </td>
          <td>
            <div id="acao" class="td-acao-sugestao">
              <button class="botao-responder-sugestao" title="Responder a sugestão" data-id="${sugestao.id}" data-pergunta="${sugestao.pergunta}">
                <i class="fas fa-comment"></i>
              </button>
              <button class="botao-deletar-sugestao" title="Deletar a sugestão" data-id="${sugestao.id}">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
      `,
        )
        .join('');

      const botoesResponderSugestao = document.querySelectorAll('.botao-responder-sugestao');
      const botoesDeletarSugestao = document.querySelectorAll('.botao-deletar-sugestao');

      botoesResponderSugestao.forEach((botao) => {
        botao.addEventListener('click', function () {
          const id = this.getAttribute('data-id');
          const pergunta = this.getAttribute('data-pergunta');
          handleResponderSugestao(id, pergunta);
        });
      });

      botoesDeletarSugestao.forEach((botao) => {
        botao.addEventListener('click', function () {
          const id = this.getAttribute('data-id');

          Swal.fire({
            title: 'Tem certeza que quer excluir a sugestão?',
            showCancelButton: true,
            confirmButtonText: 'Sim, confirmar!',
            cancelButtonText: 'Não',
            icon: 'question',
          }).then((result) => {
            if (result.isConfirmed) {
              handleDeletarSugestao(id);
            }
          });
        });
      });

      if (paginaSugestoes === 1) {
        pgInicioSugestoes.classList.add('disabled');
        pgAnteriorSugestoes.classList.add('disabled');
      } else {
        pgInicioSugestoes.classList.remove('disabled');
        pgAnteriorSugestoes.classList.remove('disabled');
      }

      if (paginaSugestoes === qtdPgSugestoes) {
        pgProximoSugestoes.classList.add('disabled');
        pgUltimoSugestoes.classList.add('disabled');
      } else {
        pgProximoSugestoes.classList.remove('disabled');
        pgUltimoSugestoes.classList.remove('disabled');
      }
    } catch (error) {
      toast(error.message, true);
    } finally {
      spinnerContainer.classList.remove('mostrar');
    }

    const numerosSugestoes = pgNumerosSugestoes.querySelectorAll('.numero');

    numerosSugestoes.forEach((numero) => {
      numero.addEventListener('click', async function () {
        await renderSugestoes({
          pagina: numero.textContent,
        });
      });
    });
  };

  await renderSugestoes();

  pgInicioSugestoes.addEventListener('click', async function () {
    if (pgInicioSugestoes.classList.contains('disabled')) return;

    await renderSugestoes({
      pagina: 1,
    });
  });

  pgAnteriorSugestoes.addEventListener('click', async function () {
    if (pgAnteriorSugestoes.classList.contains('disabled')) return;

    const pgAnt = paginaSugestoes - 1 >= 1 ? paginaSugestoes - 1 : 1;
    await renderSugestoes({
      pagina: pgAnt,
    });
  });

  pgProximoSugestoes.addEventListener('click', async function () {
    if (pgProximoSugestoes.classList.contains('disabled')) return;

    const pgDep = paginaSugestoes + 1 > qtdPgSugestoes ? qtdPgSugestoes : paginaSugestoes + 1;
    await renderSugestoes({
      pagina: pgDep,
    });
  });

  pgUltimoSugestoes.addEventListener('click', async function () {
    if (pgUltimoSugestoes.classList.contains('disabled')) return;

    await renderSugestoes({
      pagina: qtdPgSugestoes,
    });
  });

  const suasPerguntasTbody = document.querySelector('.suas-perguntas-tbody');
  const spinnerContainerSuasPerguntas = document.querySelector('.spinnerContainerSuasPerguntas');
  const pgInicioSuasPerguntas = document.querySelector('.pg-inicio-suas-perguntas');
  const pgAnteriorSuasPerguntas = document.querySelector('.pg-anterior-suas-perguntas');
  const pgProximoSuasPerguntas = document.querySelector('.pg-proximo-suas-perguntas');
  const pgUltimoSuasPerguntas = document.querySelector('.pg-ultimo-suas-perguntas');
  const pgNumerosSuasPerguntas = document.querySelector('.pg-numeros-suas-perguntas');

  pgNumerosSuasPerguntas.innerHTML = `
  <div class="numero">1</div>
  <div class="numero">2</div>
  <div class="numero active">3</div>
  <div class="numero">4</div>
  <div class="numero">5</div>
  `;

  let paginas = 1;
  let qtdPgs = 0;
  const renderSuasPerguntas = async ({ pagina = 1, qtdPorPg = 20, order = 'asc' } = {}) => {
    try {
      spinnerContainerSuasPerguntas.classList.add('mostrar');
      suasPerguntasTbody.innerHTML = '';
      pgNumerosSuasPerguntas.innerHTML = '';

      const perguntas = await listarPerguntasPorUsuario({
        pagina,
        qtdPorPg,
        order,
      });

      paginas = perguntas.pagina;
      qtdPgs = perguntas.qtd_pg;

      const maxLinks = 2;
      const numBotoesLado = maxLinks * 2 + 1;

      let startPage = Math.max(1, paginas - maxLinks);
      let endPage = Math.min(qtdPgs, startPage + numBotoesLado - 1);

      if (endPage - startPage + 1 < numBotoesLado) {
        startPage = Math.max(1, endPage - numBotoesLado + 1);
      }

      for (let i = startPage; i <= endPage; i++) {
        pgNumerosSuasPerguntas.innerHTML += `<div class="numero ${
          i === paginas ? 'active' : ''
        }">${i}</div>`;
      }

      suasPerguntasTbody.innerHTML += perguntas.resultado
        .map((pergunta) => {
          const dataEditado = new Date(pergunta.atualizado_em);

          return `
      <tr>
        <td>
          <div id="pergunta">${pergunta.pergunta}</div>
        </td>
        <td>
          <div id="editado" class="avatar">
            <img
            title="${pergunta.nome_usuario_editado ?? 'Sistema'}"
            src="${pergunta.foto_usuario_editado ?? '../../img/userFallback.jpg'}"
            onerror="this.onerror=null;this.src='../../img/userFallback.jpg';"
          />
          </div>
        </td>
        <td>
          <div id="prioridade" class="${pergunta.prioridade.toLowerCase()}">
            <span>${pergunta.prioridade}</span>
          </div>
        </td>
        <td>
          <div id="edicao"><span>${dataEditado.toLocaleDateString()}</span></div>
        </td>
        <td>
          <div id="acao">
            <a class="editar-pergunta" data-id=${pergunta.id}><i class="fas fa-pencil"></i></a>
            <a class="deletar-pergunta" data-id=${pergunta.id}><i class="fas fa-trash-can"></i></a>
          </div>
        </td>
      </tr>`;
        })
        .join('');

      const botaoDeletar = document.querySelectorAll('.deletar-pergunta');
      const botaoEditar = document.querySelectorAll('.editar-pergunta');

      botaoDeletar.forEach((botao) => {
        botao.addEventListener('click', () => {
          const id = botao.dataset.id;

          Swal.fire({
            title: 'Tem certezar que quer deletar a pergunta?',
            showCancelButton: true,
            confirmButtonText: 'Sim, confirmar!',
            cancelButtonText: 'Não',
            icon: 'question',
          }).then(async (result) => {
            if (result.isConfirmed) {
              try {
                await deletarPergunta(id);
                window.location.reload();
              } catch (error) {
                toast(error.message, true);
              }
            }
          });
        });
      });

      botaoEditar.forEach((botao) => {
        botao.addEventListener('click', () => {
          const id = botao.dataset.id;

          window.location.href = `${serverUrl}/sistema/perguntas/editar?id=${id}`;
        });
      });
    } catch (error) {
    } finally {
      spinnerContainerSuasPerguntas.classList.remove('mostrar');
    }

    if (paginas === 1) {
      pgInicioSuasPerguntas.classList.add('disabled');
      pgAnteriorSuasPerguntas.classList.add('disabled');
    } else {
      pgInicioSuasPerguntas.classList.remove('disabled');
      pgAnteriorSuasPerguntas.classList.remove('disabled');
    }

    if (paginas === qtdPgs) {
      pgProximoSuasPerguntas.classList.add('disabled');
      pgUltimoSuasPerguntas.classList.add('disabled');
    } else {
      pgProximoSuasPerguntas.classList.remove('disabled');
      pgUltimoSuasPerguntas.classList.remove('disabled');
    }

    const numerosSuasPerguntas = pgNumerosSuasPerguntas.querySelectorAll('.numero');

    numerosSuasPerguntas.forEach((numero) => {
      numero.addEventListener('click', async function () {
        await renderSuasPerguntas({
          pagina: numero.textContent,
        });
      });
    });
  };

  await renderSuasPerguntas();

  pgInicioSuasPerguntas.addEventListener('click', async function () {
    if (pgInicioSuasPerguntas.classList.contains('disabled')) return;

    await renderSuasPerguntas({
      pagina: 1,
    });
  });

  pgAnteriorSuasPerguntas.addEventListener('click', async function () {
    if (pgAnteriorSuasPerguntas.classList.contains('disabled')) return;

    const pgAnt = paginas - 1 >= 1 ? paginas - 1 : 1;
    await renderSuasPerguntas({
      pagina: pgAnt,
    });
  });

  pgProximoSuasPerguntas.addEventListener('click', async function () {
    if (pgProximoSuasPerguntas.classList.contains('disabled')) return;

    const pgDep = paginas + 1 > qtdPgs ? qtdPgs : paginas + 1;
    await renderSuasPerguntas({
      pagina: pgDep,
    });
  });

  pgUltimoSuasPerguntas.addEventListener('click', async function () {
    if (pgUltimoSuasPerguntas.classList.contains('disabled')) return;

    await renderSuasPerguntas({
      pagina: qtdPgs,
    });
  });
};

loggedIn && (await execute());
