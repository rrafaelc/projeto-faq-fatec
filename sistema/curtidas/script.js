// =============================================================================

import { deslogar } from '../../scripts/auth/deslogar.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
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

// Gambiarras temporárias, depois sera feito com o backend
const opcoes = document.querySelectorAll('input[type="radio"][name="opcao"]');
const dados = document.querySelector('.dados');
const naoMostrar = dados.querySelectorAll('.nao-mostrar');

opcoes.forEach((radio) => {
  radio.addEventListener('change', function () {
    if (this.checked) {
      const opcaoEscolhida = this.value;

      if (opcaoEscolhida === 'suas-perguntas') {
        naoMostrar.forEach((elemento) => {
          elemento.classList.add('nao-mostrar');
        });
      } else if (opcaoEscolhida === 'outros') {
        naoMostrar.forEach((elemento) => {
          elemento.classList.remove('nao-mostrar');
        });
      } else {
        console.log('Erro: opção inválida');
      }
    }
  });
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
};

loggedIn && (await execute());
