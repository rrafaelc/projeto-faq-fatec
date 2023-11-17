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

  const perguntas = await listarPerguntas();

  perguntasTbody.innerHTML += perguntas
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
};

loggedIn && (await execute());
