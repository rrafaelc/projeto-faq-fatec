// =============================================================================

import { deslogar } from '../scripts/auth/deslogar.js';
import { serverUrl } from '../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../scripts/middlewares/isLoggedIn.js';
import { deletarPergunta } from '../scripts/perguntas/deletarPergunta.js';
import { getTotaisPerguntas } from '../scripts/perguntas/getTotaisPerguntas.js';
import { listarPerguntas } from '../scripts/perguntas/listarPerguntas.js';
import { getLoggedUseInfo } from '../scripts/user/getLoggedUserInfo.js';
import { fillHeaderUserData } from '../scripts/utils/fillHeaderUserData.js';
import { toast } from '../scripts/utils/toast.js';

// Header
const usuario = document.querySelector('.usuario');
const botaoUsuario = usuario.querySelector('.botao');
const dropdown = usuario.querySelector('.dropdown');

botaoUsuario.addEventListener('click', function () {
  botaoUsuario.classList.toggle('ativo');
  dropdown.classList.toggle('ativo');
});
//==============================================================================
const spinner = document.querySelector('.spinnerFull');
const deslogarBotao = document.querySelector('#deslogar');
spinner.classList.remove('hideElement');

const loggedIn = await isLoggedIn();
if (!loggedIn) window.location.href = `${serverUrl}/login`;

const execute = async () => {
  deslogarBotao.addEventListener('click', async () => await deslogar());
  document.body.classList.remove('no-scroll');
  spinner.classList.add('hideElement');

  const user = await getLoggedUseInfo();
  fillHeaderUserData(user);

  const totaisPergunta = document.querySelector('#totais-pergunta');
  const totaisAlta = document.querySelector('#totais-alta');
  const totaisCurtida = document.querySelector('#totais-curtidas');

  try {
    const { total_perguntas, total_prioridade_alta, total_curtidas } = await getTotaisPerguntas();
    totaisPergunta.textContent = total_perguntas;
    totaisAlta.textContent = total_prioridade_alta;
    totaisCurtida.textContent = total_curtidas;
  } catch (error) {
    toast('Houve um erro ao carregar os totais', true);
  }

  const perguntasTbody = document.querySelector('.perguntas-tbody');
  const spinnerContainer = document.querySelector('.spinnerContainer');
  const pgInicioSistemaPerguntas = document.querySelector('.pg-inicio-sistema-perguntas ');
  const pgAnteriorSistemaPerguntas = document.querySelector('.pg-anterior-sistema-perguntas ');
  const pgProximoSistemaPerguntas = document.querySelector('.pg-proximo-sistema-perguntas ');
  const pgUltimoSistemaPerguntas = document.querySelector('.pg-ultimo-sistema-perguntas ');
  const pgNumerosSistemaPerguntas = document.querySelector('.pg-numeros-sistema-perguntas ');

  pgNumerosSistemaPerguntas.innerHTML = `
  <div class="numero">1</div>
  <div class="numero">2</div>
  <div class="numero active">3</div>
  <div class="numero">4</div>
  <div class="numero">5</div>
  `;

  let prioridadeAlta = false;
  let paginas = 1;
  let qtdPgs = 0;
  const renderPerguntas = async ({
    maisAlta = false,
    pagina = 1,
    qtdPorPg = 20,
    order = 'asc',
  } = {}) => {
    try {
      spinnerContainer.classList.add('mostrar');
      perguntasTbody.innerHTML = '';
      pgNumerosSistemaPerguntas.innerHTML = '';

      const perguntas = await listarPerguntas({
        maisAlta,
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
        pgNumerosSistemaPerguntas.innerHTML += `<div class="numero ${
          i === paginas ? 'active' : ''
        }">${i}</div>`;
      }

      perguntasTbody.innerHTML += perguntas.resultado
        .map((pergunta) => {
          const dataEditado = new Date(pergunta.atualizado_em);

          return `
        <tr>
          <td>
            <div id="id">
              <span>${pergunta.id}</span>
            </div>
          </td>
          <td>
            <div id="colaborador">
              <div class="avatar">
                <img
                title="${pergunta.nome_usuario ?? 'N/A'}"
                src="${pergunta.foto_usuario ?? '../img/userFallback.jpg'}"
                onerror="this.onerror=null;this.src='../img/userFallback.jpg';"
                 />
              </div>
              <div class="nome">${pergunta.nome_usuario ?? 'N/A'}</div>
            </div>
          </td>
          <td>
            <div id="pergunta">${pergunta.pergunta}</div>
          </td>
          <td>
            <div id="editado" class="avatar">
              <img
              title="${pergunta.nome_usuario_editado ?? 'N/A'}"
              src="${pergunta.foto_usuario_editado ?? '../img/userFallback.jpg'}"
              onerror="this.onerror=null;this.src='../img/userFallback.jpg';"
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
              <a class="deletar-pergunta" data-id=${
                pergunta.id
              }><i class="fas fa-trash-can"></i></a>
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
      toast(error.message, true);
    } finally {
      spinnerContainer.classList.remove('mostrar');
    }

    if (paginas === 1) {
      pgInicioSistemaPerguntas.classList.add('disabled');
      pgAnteriorSistemaPerguntas.classList.add('disabled');
    } else {
      pgInicioSistemaPerguntas.classList.remove('disabled');
      pgAnteriorSistemaPerguntas.classList.remove('disabled');
    }

    if (paginas === qtdPgs) {
      pgProximoSistemaPerguntas.classList.add('disabled');
      pgUltimoSistemaPerguntas.classList.add('disabled');
    } else {
      pgProximoSistemaPerguntas.classList.remove('disabled');
      pgUltimoSistemaPerguntas.classList.remove('disabled');
    }

    const numerosPerguntas = pgNumerosSistemaPerguntas.querySelectorAll('.numero');

    numerosPerguntas.forEach((numero) => {
      numero.addEventListener('click', async function () {
        await renderPerguntas({
          pagina: numero.textContent,
          maisAlta: prioridadeAlta,
        });
      });
    });
  };

  await renderPerguntas();

  const prioridadeBotao = document.querySelector('.prioridade-botao');

  prioridadeBotao.addEventListener('click', async function () {
    const icone = prioridadeBotao.querySelector('i');

    if (icone.classList.contains('fa-sort-down')) {
      icone.classList.remove('fa-sort-down');
      icone.classList.add('fa-sort-up');

      prioridadeAlta = true;
      await renderPerguntas({
        maisAlta: prioridadeAlta,
      });
    } else {
      icone.classList.remove('fa-sort-up');
      icone.classList.add('fa-sort-down');

      prioridadeAlta = false;
      await renderPerguntas({
        maisAlta: prioridadeAlta,
      });
    }
  });

  pgInicioSistemaPerguntas.addEventListener('click', async function () {
    if (pgInicioSistemaPerguntas.classList.contains('disabled')) return;

    await renderPerguntas({
      pagina: 1,
      maisAlta: prioridadeAlta,
    });
  });

  pgAnteriorSistemaPerguntas.addEventListener('click', async function () {
    if (pgAnteriorSistemaPerguntas.classList.contains('disabled')) return;

    const pgAnt = paginas - 1 >= 1 ? paginas - 1 : 1;
    await renderPerguntas({
      pagina: pgAnt,
      maisAlta: prioridadeAlta,
    });
  });

  pgProximoSistemaPerguntas.addEventListener('click', async function () {
    if (pgProximoSistemaPerguntas.classList.contains('disabled')) return;

    const pgDep = paginas + 1 > qtdPgs ? qtdPgs : paginas + 1;
    await renderPerguntas({
      pagina: pgDep,
      maisAlta: prioridadeAlta,
    });
  });

  pgUltimoSistemaPerguntas.addEventListener('click', async function () {
    if (pgUltimoSistemaPerguntas.classList.contains('disabled')) return;

    await renderPerguntas({
      pagina: qtdPgs,
      maisAlta: prioridadeAlta,
    });
  });
};

loggedIn && (await execute());
