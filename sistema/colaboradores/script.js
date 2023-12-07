// =============================================================================

import { deslogar } from '../../scripts/auth/deslogar.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { alterarCargoUsuario } from '../../scripts/user/alterarCargoUsuario.js';
import { criarContaUsuario } from '../../scripts/user/criarContaUsuario.js';
import { deletarContaUsuario } from '../../scripts/user/deletarContaUsuario.js';
import { getLoggedUseInfo } from '../../scripts/user/getLoggedUserInfo.js';
import { listarUsuarios } from '../../scripts/user/listarUsuarios.js';
import { resetarSenhaUsuario } from '../../scripts/user/resetarSenhaUsuario.js';
import { suspenderContaUsuario } from '../../scripts/user/suspenderContaUsuario.js';
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

const criarConta = document.querySelector('.criar-conta');
const tituloCriarConta = criarConta.querySelector('.titulo');
const botaoAngleDown = criarConta.querySelector('.botao');
const formCriarConta = criarConta.querySelector('form');

const eyeContainers = document.querySelectorAll('.eye-container');
const eyes = document.querySelectorAll('.eye');
const senha = formCriarConta.querySelector('#conta-senha');
const confirmarSenha = formCriarConta.querySelector('#conta-confirmar-senha');

eyeContainers.forEach((eyeContainer) =>
  eyeContainer.addEventListener('click', () => {
    eyes.forEach((eye) => {
      if (eye.classList.contains('bi-eye-slash')) {
        eye.classList.remove('bi-eye-slash');
        eye.classList.add('bi-eye');
        senha.type = 'text';
        confirmarSenha.type = 'text';
      } else {
        eye.classList.add('bi-eye-slash');
        eye.classList.remove('bi-eye');
        senha.type = 'password';
        confirmarSenha.type = 'password';
      }
    });
  }),
);

tituloCriarConta.addEventListener('click', function () {
  botaoAngleDown.classList.toggle('aberto');
  formCriarConta.classList.toggle('aberto');
});

formCriarConta.addEventListener('submit', async function (event) {
  event.preventDefault();

  const nome = formCriarConta.querySelector('#conta-nome').value;
  const email = formCriarConta.querySelector('#conta-email').value.trim();
  const senha = formCriarConta.querySelector('#conta-senha').value.trim();
  const confirmarSenha = formCriarConta.querySelector('#conta-confirmar-senha').value.trim();

  if (!nome || !email || !senha || !confirmarSenha) {
    toast('Preencha todos os campos', true);
    return;
  }

  if (senha.length < 8) {
    toast('Senha precisa de no mínimo 8 caracteres', true);
    return;
  }

  if (senha !== confirmarSenha) {
    toast('Senha e confirmar senha não são iguais', true);
    return;
  }

  try {
    await criarContaUsuario({
      nome_completo: nome,
      email,
      senha,
      cargo: 'Moderador',
    });

    toast('Conta criada com sucesso');

    setTimeout(() => {
      window.location.reload();
    }, 500);
  } catch (error) {
    toast(error.message, true);
    console.error(error);
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

  const colaboradoresTbody = document.querySelector('.colaboradores-tbody');
  const spinnerContainer = document.querySelector('.spinnerContainer');
  const pgInicioSistemaUsuarios = document.querySelector('.pg-inicio-sistema-usuarios');
  const pgAnteriorSistemaUsuarios = document.querySelector('.pg-anterior-sistema-usuarios');
  const pgProximoSistemaUsuarios = document.querySelector('.pg-proximo-sistema-usuarios');
  const pgUltimoSistemaUsuarios = document.querySelector('.pg-ultimo-sistema-usuarios');
  const pgNumerosSistemaUsuarios = document.querySelector('.pg-numeros-sistema-usuarios');

  pgNumerosSistemaUsuarios.innerHTML = `
  <div class="numero">1</div>
  <div class="numero">2</div>
  <div class="numero active">3</div>
  <div class="numero">4</div>
  <div class="numero">5</div>
  `;

  let paginas = 1;
  let qtdPgs = 0;
  const renderUsuarios = async ({ pagina = 1, qtdPorPg = 20, order = 'asc' } = {}) => {
    try {
      spinnerContainer.classList.add('mostrar');
      colaboradoresTbody.innerHTML = '';
      pgNumerosSistemaUsuarios.innerHTML = '';

      const usuarios = await listarUsuarios({
        pagina,
        qtdPorPg,
        order,
      });

      paginas = usuarios.pagina;
      qtdPgs = usuarios.qtd_pg;

      const maxLinks = 2;
      const numBotoesLado = maxLinks * 2 + 1;

      let startPage = Math.max(1, paginas - maxLinks);
      let endPage = Math.min(qtdPgs, startPage + numBotoesLado - 1);

      if (endPage - startPage + 1 < numBotoesLado) {
        startPage = Math.max(1, endPage - numBotoesLado + 1);
      }

      for (let i = startPage; i <= endPage; i++) {
        pgNumerosSistemaUsuarios.innerHTML += `<div class="numero ${
          i === paginas ? 'active' : ''
        }">${i}</div>`;
      }

      colaboradoresTbody.innerHTML += usuarios.resultado
        .map(
          (usuario) => `
      <tr>
        <td class="colaborador">
          <div id="colaborador">
            <div class="avatar">
              <img
              src="${usuario.foto_uri ?? `${serverUrl}/img/userFallback.jpg`}"
              title="${usuario.nome_completo}"
              onerror="this.onerror=null;this.src='../../img/userFallback.jpg';"
            />
            </div>
            <div class="nome">
              ${usuario.nome_completo}
            </div>
          </div>
        </td>
        <td data-id="${usuario.id}" class="cargo ${usuario.cargo.toLowerCase()}">
          <button>${usuario.cargo}</button>
        </td>
        <td data-id="${usuario.id}" class="suspenso ${usuario.esta_suspenso ? 'sim' : 'nao'}">
          <button>${usuario.esta_suspenso ? 'Sim' : 'Não'}</button>
        </td>
        <td class="acao">
          <div>
            <button data-id="${usuario.id}" class="resetar-senha">Resetar senha</button>
            <button data-id="${usuario.id}" class="deletar-usuario">Deletar conta</button>
          </div>
        </td>
      </tr>
      `,
        )
        .join('');

      const cargos = document.querySelectorAll('.cargo');
      const suspensos = document.querySelectorAll('.suspenso');
      const deletarButtons = document.querySelectorAll('.deletar-usuario');
      const resetarButtons = document.querySelectorAll('.resetar-senha');

      cargos.forEach((cargo) => {
        cargo.addEventListener('click', async function () {
          const cargoBotao = cargo.querySelector('button');
          const id = this.getAttribute('data-id');

          Swal.fire({
            title: 'Tem certeza que quer mudar o cargo dessa conta?',
            showCancelButton: true,
            confirmButtonText: 'Sim, confirmar!',
            cancelButtonText: 'Não',
            icon: 'question',
          }).then(async (result) => {
            if (result.isConfirmed) {
              switch (cargoBotao.textContent) {
                case 'Administrador':
                  try {
                    await alterarCargoUsuario({
                      id,
                      cargo: 'Moderador',
                    });
                    cargoBotao.textContent = 'Moderador';

                    cargo.classList.add('moderador');
                    cargo.classList.remove('administrador');

                    toast('Cargo alterado com sucesso');
                  } catch (error) {
                    toast(error.message, true);
                  }
                  break;
                case 'Moderador':
                  try {
                    await alterarCargoUsuario({
                      id,
                      cargo: 'Administrador',
                    });
                    cargoBotao.textContent = 'Administrador';

                    cargo.classList.add('administrador');
                    cargo.classList.remove('moderador');

                    toast('Cargo alterado com sucesso');
                  } catch (error) {
                    toast(error.message, true);
                  }
                  break;
              }
            }
          });
        });
      });

      suspensos.forEach((suspenso) => {
        suspenso.addEventListener('click', async function () {
          const suspensoBotao = suspenso.querySelector('button');
          const id = this.getAttribute('data-id');

          Swal.fire({
            title: 'Tem certeza que quer mudar a suspensão dessa conta?',
            showCancelButton: true,
            confirmButtonText: 'Sim, confirmar!',
            cancelButtonText: 'Não',
            icon: 'question',
          }).then(async (result) => {
            if (result.isConfirmed) {
              switch (suspensoBotao.textContent) {
                case 'Sim':
                  try {
                    await suspenderContaUsuario({
                      id,
                      esta_suspenso: false,
                    });
                    suspensoBotao.textContent = 'Não';

                    suspenso.classList.add('nao');
                    suspenso.classList.remove('sim');

                    toast('Suspensão alterada com sucesso');
                  } catch (error) {
                    toast(error.message, true);
                  }
                  break;
                case 'Não':
                  try {
                    await suspenderContaUsuario({
                      id,
                      esta_suspenso: true,
                    });

                    suspensoBotao.textContent = 'Sim';

                    suspenso.classList.add('sim');
                    suspenso.classList.remove('nao');

                    toast('Suspensão alterada com sucesso');
                  } catch (error) {
                    toast(error.message, true);
                  }
                  break;
              }
            }
          });
        });
      });

      deletarButtons.forEach((botao) => {
        botao.addEventListener('click', async function () {
          const id = this.getAttribute('data-id');

          Swal.fire({
            title: 'Tem certeza que quer deletar essa conta?',
            showCancelButton: true,
            confirmButtonText: 'Sim, confirmar!',
            cancelButtonText: 'Não',
            icon: 'question',
          }).then(async (result) => {
            if (result.isConfirmed) {
              try {
                await deletarContaUsuario({ id });

                toast('Conta deletada com sucesso');

                setTimeout(() => {
                  window.location.reload();
                }, 500);
              } catch (error) {
                toast(error.message, true);
              }
            }
          });
        });
      });

      resetarButtons.forEach((botao) => {
        botao.addEventListener('click', async function () {
          const id = this.getAttribute('data-id');

          Swal.fire({
            title: 'Tem certeza que quer resetar a senha dessa conta?',
            showCancelButton: true,
            confirmButtonText: 'Sim, confirmar!',
            cancelButtonText: 'Não',
            allowEnterKey: false,
            icon: 'question',
          }).then(async (result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title:
                  'Importante: Após redefinir a senha do usuário, informe-a imediatamente e faça login. Altere a senha após o login para segurança. Se esquecer, a recuperação só é possível ao redefinir a senha. Mantenha a senha segura. Se esta for sua conta, copie-a e faça login novamente.',
                showCancelButton: true,
                confirmButtonText: 'Sim, irei anotar!',
                cancelButtonText: 'Não',
                allowEnterKey: false,
                icon: 'info',
              }).then(async (result) => {
                if (result.isConfirmed) {
                  try {
                    const novaSenha = await resetarSenhaUsuario({ id });

                    Swal.fire({
                      title: `Por favor, copie cuidadosamente a nova senha e forneça-a ao usuário correspondente.\n\nNova senha: ${novaSenha}\n\n\n\n`,
                      showCancelButton: false,
                      allowOutsideClick: false,
                      allowEscapeKey: false,
                      allowEnterKey: false,
                      stopKeydownPropagation: true,
                      confirmButtonText: 'Certo, copiei a nova senha!',
                      icon: 'info',
                    });
                  } catch (error) {
                    toast(error.message, true);
                  }
                }
              });
            }
          });
        });
      });
    } catch (error) {
      toast(error.message, true);
    } finally {
      spinnerContainer.classList.remove('mostrar');
    }

    if (paginas === 1) {
      pgInicioSistemaUsuarios.classList.add('disabled');
      pgAnteriorSistemaUsuarios.classList.add('disabled');
    } else {
      pgInicioSistemaUsuarios.classList.remove('disabled');
      pgAnteriorSistemaUsuarios.classList.remove('disabled');
    }

    if (paginas === qtdPgs) {
      pgProximoSistemaUsuarios.classList.add('disabled');
      pgUltimoSistemaUsuarios.classList.add('disabled');
    } else {
      pgProximoSistemaUsuarios.classList.remove('disabled');
      pgUltimoSistemaUsuarios.classList.remove('disabled');
    }

    const numerosUsuarios = pgNumerosSistemaUsuarios.querySelectorAll('.numero');

    numerosUsuarios.forEach((numero) => {
      numero.addEventListener('click', async function () {
        await renderUsuarios({
          pagina: numero.textContent,
        });
      });
    });
  };

  await renderUsuarios();

  pgInicioSistemaUsuarios.addEventListener('click', async function () {
    if (pgInicioSistemaUsuarios.classList.contains('disabled')) return;

    await renderUsuarios({
      pagina: 1,
    });
  });

  pgAnteriorSistemaUsuarios.addEventListener('click', async function () {
    if (pgAnteriorSistemaUsuarios.classList.contains('disabled')) return;

    const pgAnt = paginas - 1 >= 1 ? paginas - 1 : 1;
    await renderUsuarios({
      pagina: pgAnt,
    });
  });

  pgProximoSistemaUsuarios.addEventListener('click', async function () {
    if (pgProximoSistemaUsuarios.classList.contains('disabled')) return;

    const pgDep = paginas + 1 > qtdPgs ? qtdPgs : paginas + 1;
    await renderUsuarios({
      pagina: pgDep,
    });
  });

  pgUltimoSistemaUsuarios.addEventListener('click', async function () {
    if (pgUltimoSistemaUsuarios.classList.contains('disabled')) return;

    await renderUsuarios({
      pagina: qtdPgs,
    });
  });
};

loggedIn && (await execute());
