// =============================================================================

import { deslogar } from '../../scripts/auth/deslogar.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { criarContaUsuario } from '../../scripts/user/criarContaUsuario.js';
import { getLoggedUseInfo } from '../../scripts/user/getLoggedUserInfo.js';
import { listarUsuarios } from '../../scripts/user/listarUsuarios.js';
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

const dados = document.querySelector('.dados');
const paginacao = dados.querySelector('.paginacao');
const tabela = dados.querySelector('.usuarios-tabela');

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
    }, 1000);
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

  const usuarios = await listarUsuarios();

  tabela.innerHTML = `
  <thead>
    <tr>
      <th>
        <span>Colaborador <i class="fas fa-sort-down"></i></span>
      </th>
      <th id="cargo">
        <span>Cargo <i class="fas fa-sort-down"></i></span>
      </th>
      <th id="suspenso">
        <span>Suspenso <i class="fas fa-sort-down"></i></span>
      </th>
      <th></th>
    </tr>
  </thead>`;

  tabela.innerHTML += usuarios
    .map(
      (usuario) => `
      <tbody>
      <tr>
        <td class="colaborador">
          <div id="colaborador">
            <div class="avatar">
              <img src="${usuario.foto_uri ?? `${serverUrl}/img/userFallback.jpg`}" />
            </div>
            <div class="nome">
              ${usuario.nome_completo}
            </div>
          </div>
        </td>
        <td class="cargo ${usuario.cargo.toLowerCase()}">
          <button>${usuario.cargo}</button>
        </td>
        <td class="suspenso ${usuario.esta_suspenso ? 'sim' : 'nao'}">
          <button>${usuario.esta_suspenso ? 'Sim' : 'Não'}</button>
        </td>
        <td class="acao">
          <div>
            <button>Resetar senha</button>
            <button>Deletar conta</button>
          </div>
        </td>
      </tr>
    </tbody>
  `,
    )
    .join('');

  const cargos = dados.querySelectorAll('.cargo');
  const suspensos = dados.querySelectorAll('.suspenso');

  cargos.forEach((cargo) => {
    cargo.addEventListener('click', function () {
      const cargoBotao = cargo.querySelector('button');

      switch (cargoBotao.textContent) {
        case 'Administrador':
          cargoBotao.textContent = 'Moderador';

          cargo.classList.add('moderador');
          cargo.classList.remove('administrador');
          cargo.classList.remove('colaborador');
          break;
        case 'Moderador':
          cargoBotao.textContent = 'Colaborador';

          cargo.classList.add('colaborador');
          cargo.classList.remove('administrador');
          cargo.classList.remove('moderador');
          break;
        case 'Colaborador':
          cargoBotao.textContent = 'Administrador';

          cargo.classList.add('administrador');
          cargo.classList.remove('moderador');
          cargo.classList.remove('colaborador');
          break;
      }
    });
  });

  suspensos.forEach((suspenso) => {
    suspenso.addEventListener('click', function () {
      const suspensoBotao = suspenso.querySelector('button');

      switch (suspensoBotao.textContent) {
        case 'Sim':
          suspensoBotao.textContent = 'Não';

          suspenso.classList.add('nao');
          suspenso.classList.remove('sim');
          break;
        case 'Não':
          suspensoBotao.textContent = 'Sim';

          suspenso.classList.add('sim');
          suspenso.classList.remove('nao');
          break;
      }
    });
  });
};

loggedIn && (await execute());
