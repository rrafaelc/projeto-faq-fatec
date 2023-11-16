// =============================================================================

import { deslogar } from '../../scripts/auth/deslogar.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { deletarPergunta } from '../../scripts/perguntas/deletarPergunta.js';
import { listarPerguntas } from '../../scripts/perguntas/listarPerguntas.js';
import { getLoggedUseInfo } from '../../scripts/user/getLoggedUserInfo.js';
import { fillHeaderUserData } from '../../scripts/utils/fillHeaderUserData.js';

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
  const curtidasTable = document.querySelector('#curtidas');
  const curtidasIcon = curtidasTable.querySelector('span');

  let perguntas = [];

  try {
    perguntas = await listarPerguntas();
    perguntas.sort((a, b) => b.curtidas - a.curtidas);
  } catch (error) {
    console.log(error);
  }

  //ordena as perguntas pra trazer as mais curtidas primeiro
  curtidasIcon.addEventListener('click', () => {
    const isClicked = curtidasIcon.getAttribute('isclicked') === 'true';

    if (isClicked) {
      perguntas.sort((a, b) => b.curtidas - a.curtidas);
    } else {
      perguntas.sort((a, b) => a.curtidas - b.curtidas);
    }

    tbody.innerHTML = '';

    tbody.innerHTML += perguntas.map(
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
                <img src="../../img/userFallback.jpg" />
              </div>
              <div class="nome">
                <span>Nome do criador</span>
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
              <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
              <button class='click' data-id=${pergunta.id} href="#"><i class="fas fa-trash-can"></i></button>
            </div>
          </td>
      </tr>
      `,
    );

    curtidasIcon.setAttribute('isclicked', isClicked ? 'false' : 'true');
  });

  tbody.innerHTML += perguntas.map(
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
            <img src="../../img/userFallback.jpg" />
            </div>
            <div class="nome">
            <span>Nome do criador</span>
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
            <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
            <button class='click' data-id=${pergunta.id} href="#"><i class="fas fa-trash-can"></i></button>
          </div>
        </td>
    </tr>
    `,
  );

  //logica para deletar a pergunta
  const botaoDeletar = document.querySelectorAll('.click');

  botaoDeletar.forEach((botao) => {
    botao.addEventListener('click', () => {
      const id = botao.dataset.id;

      Swal.fire({
        title: 'Tem certezar que quer deletar a pergunta?',
        showCancelButton: true,
        confirmButtonText: 'Sim, confirmar!',
        cancelButtonText: 'Não',
        icon: 'question',
      }).then((result) => {
        if (result.isConfirmed) {
          deletarPergunta(id);
          window.location.reload();
        }
      });
    });
  });
};

loggedIn && (await execute());
