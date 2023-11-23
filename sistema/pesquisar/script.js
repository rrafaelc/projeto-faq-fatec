import { deslogar } from '../../scripts/auth/deslogar.js';
import '../../scripts/autocomplete/autoComplete.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { deletarPergunta } from '../../scripts/perguntas/deletarPergunta.js';
import { listarPerguntas } from '../../scripts/perguntas/listarPerguntas.js';
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

  const perguntasTbody = document.querySelector('.perguntas-tbody');
  const spinnerContainer = document.querySelector('.spinnerContainer');
  const pgInicioSistemaPesquisar = document.querySelector('.pg-inicio-pesquisar');
  const pgAnteriorSistemaPesquisar = document.querySelector('.pg-anterior-pesquisar');
  const pgProximoSistemaPesquisar = document.querySelector('.pg-proximo-pesquisar');
  const pgUltimoSistemaPesquisar = document.querySelector('.pg-ultimo-pesquisar');
  const pgNumerosSistemaPesquisar = document.querySelector('.pg-numeros-pesquisar');

  pgNumerosSistemaPesquisar.innerHTML = `
  <div class="numero">1</div>
  <div class="numero">2</div>
  <div class="numero active">3</div>
  <div class="numero">4</div>
  <div class="numero">5</div>
  `;

  let prioridadeAlta = false;
  let paginas = 1;
  let qtdPgs = 0;
  let loading = false;
  const renderPerguntas = async ({
    maisAlta = false,
    pagina = 1,
    qtdPorPg = 20,
    order = 'asc',
    titulo = '',
  } = {}) => {
    try {
      loading = true;
      spinnerContainer.classList.add('mostrar');
      perguntasTbody.innerHTML = '';
      pgNumerosSistemaPesquisar.innerHTML = '';

      const perguntas = await listarPerguntas({
        maisAlta,
        pagina,
        qtdPorPg,
        order,
        titulo,
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
        pgNumerosSistemaPesquisar.innerHTML += `<div class="numero ${
          i === paginas ? 'active' : ''
        }">${i}</div>`;
      }

      perguntasTbody.innerHTML += perguntas.resultado
        .map((pergunta) => {
          const dataEditado = new Date(pergunta.atualizado_em);

          return `
        <tr>
          <td>
            <div id="colaborador">
              <div class="avatar">
                <img
                title="${pergunta.nome_usuario ?? 'Sistema'}"
                src="${pergunta.foto_usuario ?? '../../img/userFallback.jpg'}"
                onerror="this.onerror=null;this.src='../../img/userFallback.jpg';"
                 />
              </div>
              <div class="nome">${pergunta.nome_usuario ?? 'Sistema'}</div>
            </div>
          </td>
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
      loading = false;
      spinnerContainer.classList.remove('mostrar');
    }

    if (paginas === 1) {
      pgInicioSistemaPesquisar.classList.add('disabled');
      pgAnteriorSistemaPesquisar.classList.add('disabled');
    } else {
      pgInicioSistemaPesquisar.classList.remove('disabled');
      pgAnteriorSistemaPesquisar.classList.remove('disabled');
    }

    if (paginas === qtdPgs) {
      pgProximoSistemaPesquisar.classList.add('disabled');
      pgUltimoSistemaPesquisar.classList.add('disabled');
    } else {
      pgProximoSistemaPesquisar.classList.remove('disabled');
      pgUltimoSistemaPesquisar.classList.remove('disabled');
    }

    const numerosPesquisar = pgNumerosSistemaPesquisar.querySelectorAll('.numero');

    numerosPesquisar.forEach((numero) => {
      numero.addEventListener('click', async function () {
        await renderPerguntas({
          pagina: numero.textContent,
          maisAlta: prioridadeAlta,
        });
      });
    });
  };

  await renderPerguntas();

  pgInicioSistemaPesquisar.addEventListener('click', async function () {
    if (pgInicioSistemaPesquisar.classList.contains('disabled')) return;

    await renderPerguntas({
      pagina: 1,
      maisAlta: prioridadeAlta,
    });
  });

  pgAnteriorSistemaPesquisar.addEventListener('click', async function () {
    if (pgAnteriorSistemaPesquisar.classList.contains('disabled')) return;

    const pgAnt = paginas - 1 >= 1 ? paginas - 1 : 1;
    await renderPerguntas({
      pagina: pgAnt,
      maisAlta: prioridadeAlta,
    });
  });

  pgProximoSistemaPesquisar.addEventListener('click', async function () {
    if (pgProximoSistemaPesquisar.classList.contains('disabled')) return;

    const pgDep = paginas + 1 > qtdPgs ? qtdPgs : paginas + 1;
    await renderPerguntas({
      pagina: pgDep,
      maisAlta: prioridadeAlta,
    });
  });

  pgUltimoSistemaPesquisar.addEventListener('click', async function () {
    if (pgUltimoSistemaPesquisar.classList.contains('disabled')) return;

    await renderPerguntas({
      pagina: qtdPgs,
      maisAlta: prioridadeAlta,
    });
  });

  const autoCompleteJS = new autoComplete({
    data: {
      src: async () => {
        try {
          document.getElementById('autoComplete').disabled = true;
          document.getElementById('autoComplete').setAttribute('placeholder', 'Carregando...');

          const data = await listarPerguntas({ qtdPorPg: 2000 });

          document
            .getElementById('autoComplete')
            .setAttribute('placeholder', autoCompleteJS.placeHolder);

          const { resultado } = data;

          const perguntasArray = resultado.map((item) => item.pergunta);

          return perguntasArray;
        } catch (error) {
          return error;
        } finally {
          document.getElementById('autoComplete').disabled = false;
        }
      },
      cache: true,
    },
    placeHolder: 'Quando abre o vestibular?',
    resultsList: {
      element: (list, data) => {
        const info = document.createElement('p');
        if (data.results.length > 0) {
          info.innerHTML = `Mostrando <strong>${data.results.length}</strong> de <strong>${data.matches.length}</strong> resultados`;
        } else {
          info.innerHTML = `Encontrado <strong>${data.matches.length}</strong> resultados que combinam com <strong>"${data.query}"</strong>`;
        }
        list.prepend(info);
      },
      noResults: true,
      tabSelect: true,
    },
    resultItem: {
      element: (item, data) => {
        item.style = 'display: flex; justify-content: space-between;';
        item.innerHTML = `
        <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
          ${data.match}
        </span>
        `;
      },
      highlight: true,
    },
    events: {
      input: {
        focus: () => {
          if (autoCompleteJS.input.value.length) autoCompleteJS.start();
        },
      },
    },
  });

  autoCompleteJS.input.addEventListener('input', async function (event) {
    if (loading) return;
    if (!event.target.value) {
      await renderPerguntas();
    }
  });

  autoCompleteJS.input.addEventListener('blur', async function (event) {
    if (loading) return;
    if (!event.target.value) {
      await renderPerguntas();
    }
  });

  autoCompleteJS.input.addEventListener('results', async function (event) {
    if (loading) return;
    await renderPerguntas({
      titulo: event.detail.query,
    });
  });

  autoCompleteJS.input.addEventListener('selection', async function (event) {
    if (loading) return;
    const feedback = event.detail;
    autoCompleteJS.input.blur();

    document.querySelector('#autoComplete');
    autoCompleteJS.input.value = feedback.selection.value;
    await renderPerguntas({
      titulo: feedback.selection.value,
    });
  });
};

loggedIn && (await execute());
