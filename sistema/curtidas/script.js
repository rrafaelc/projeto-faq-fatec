// =============================================================================

import { deslogar } from '../../scripts/auth/deslogar.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { deletarPergunta } from '../../scripts/perguntas/deletarPergunta.js';
import { listarPerguntas } from '../../scripts/perguntas/listarPerguntas.js';
import { listarPerguntasMaisBuscadas } from '../../scripts/perguntas/listarPerguntasMaisBuscadas.js';
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

  const tablePerguntas = document.querySelector('.perguntas-table');
  const tbody = tablePerguntas.querySelector('tbody');
  const spinnerContainer = document.querySelector('.spinnerContainer');
  const curtidasTable = document.querySelector('#curtidas');
  const curtidasIcon = curtidasTable.querySelector('span');
  const pgInicioSistemaCurtidas = document.querySelector('.pg-inicio-sistema-curtidas');
  const pgAnteriorSistemaCurtidas = document.querySelector('.pg-anterior-sistema-curtidas');
  const pgProximoSistemaCurtidas = document.querySelector('.pg-proximo-sistema-curtidas');
  const pgUltimoSistemaCurtidas = document.querySelector('.pg-ultimo-sistema-curtidas');
  const pgNumerosSistemaCurtidas = document.querySelector('.pg-numeros-sistema-curtidas');

  pgNumerosSistemaCurtidas.innerHTML = `
  <div class="numero">1</div>
  <div class="numero">2</div>
  <div class="numero active">3</div>
  <div class="numero">4</div>
  <div class="numero">5</div>
  `;

  let topCurtidas = false;
  let paginas = 1;
  let qtdPgs = 0;
  const renderCurtidas = async ({
    topCurtidas = true,
    maisAlta = false,
    pagina = 1,
    qtdPorPg = 20,
    order = 'asc',
  } = {}) => {
    try {
      spinnerContainer.classList.add('mostrar');
      tbody.innerHTML = '';
      pgNumerosSistemaCurtidas.innerHTML = '';

      let perguntas = [];

      if (!topCurtidas) {
        perguntas = await listarPerguntas({
          maisAlta,
          pagina,
          qtdPorPg,
          order,
        });
      } else {
        perguntas = await listarPerguntasMaisBuscadas({
          pagina,
          qtdPorPg,
          order,
        });
      }

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
        pgNumerosSistemaCurtidas.innerHTML += `<div class="numero ${
          i === paginas ? 'active' : ''
        }">${i}</div>`;
      }

      tbody.innerHTML += perguntas.resultado
        .map(
          (pergunta) =>
            `<tr>
      <td>
        <div id="id">
          <span>${pergunta.id}</span>
        </div>
      </td>
      <td>
        <div id="colaborador">
          <div class="avatar">
          <img
          title="${pergunta.nome_usuario ?? 'Sistema'}"
          src="${pergunta.foto_usuario ?? '../../img/userFallback.jpg'}"
          onerror="this.onerror=null;this.src='../../img/userFallback.jpg';"
          />
          </div>
          <div class="nome">
          <span>${pergunta.nome_usuario ?? 'Sistema'}</span>
          </div>
        </div>
      </td>
      <td>
        <div id="pergunta">
          ${pergunta.pergunta}
        </div>
      </td>
      <td>
        <div id="curtidas"><span>${pergunta.curtidas}</span></div>
      </td>
      <td>
        <div id="acao">
          <a class="editar-pergunta" data-id=${pergunta.id}><i class="fas fa-pencil"></i></a>
          <button class='click' data-id=${
            pergunta.id
          } href="#"><i class="fas fa-trash-can"></i></button>
        </div>
      </td>
  </tr>
  `,
        )
        .join('');

      const botaoDeletar = document.querySelectorAll('.click');
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
      pgInicioSistemaCurtidas.classList.add('disabled');
      pgAnteriorSistemaCurtidas.classList.add('disabled');
    } else {
      pgInicioSistemaCurtidas.classList.remove('disabled');
      pgAnteriorSistemaCurtidas.classList.remove('disabled');
    }

    if (paginas === qtdPgs) {
      pgProximoSistemaCurtidas.classList.add('disabled');
      pgUltimoSistemaCurtidas.classList.add('disabled');
    } else {
      pgProximoSistemaCurtidas.classList.remove('disabled');
      pgUltimoSistemaCurtidas.classList.remove('disabled');
    }

    const numerosCurtidas = pgNumerosSistemaCurtidas.querySelectorAll('.numero');

    numerosCurtidas.forEach((numero) => {
      numero.addEventListener('click', async function () {
        await renderCurtidas({
          pagina: numero.textContent,
          topCurtidas,
        });
      });
    });
  };

  await renderCurtidas();

  const curtidasBotao = document.querySelector('.curtidas-botao');

  curtidasBotao.addEventListener('click', async function () {
    const icone = curtidasBotao.querySelector('i');

    if (icone.classList.contains('fa-sort-down')) {
      icone.classList.remove('fa-sort-down');
      icone.classList.add('fa-sort-up');

      topCurtidas = true;
      await renderCurtidas({
        topCurtidas,
      });
    } else {
      icone.classList.remove('fa-sort-up');
      icone.classList.add('fa-sort-down');

      topCurtidas = false;
      await renderCurtidas({
        topCurtidas,
      });
    }
  });

  pgInicioSistemaCurtidas.addEventListener('click', async function () {
    if (pgInicioSistemaCurtidas.classList.contains('disabled')) return;

    await renderCurtidas({
      pagina: 1,
      topCurtidas,
    });
  });

  pgAnteriorSistemaCurtidas.addEventListener('click', async function () {
    if (pgAnteriorSistemaCurtidas.classList.contains('disabled')) return;

    const pgAnt = paginas - 1 >= 1 ? paginas - 1 : 1;
    await renderCurtidas({
      pagina: pgAnt,
      topCurtidas,
    });
  });

  pgProximoSistemaCurtidas.addEventListener('click', async function () {
    if (pgProximoSistemaCurtidas.classList.contains('disabled')) return;

    const pgDep = paginas + 1 > qtdPgs ? qtdPgs : paginas + 1;
    await renderCurtidas({
      pagina: pgDep,
      topCurtidas,
    });
  });

  pgUltimoSistemaCurtidas.addEventListener('click', async function () {
    if (pgUltimoSistemaCurtidas.classList.contains('disabled')) return;

    await renderCurtidas({
      pagina: qtdPgs,
      topCurtidas,
    });
  });
};

loggedIn && (await execute());
