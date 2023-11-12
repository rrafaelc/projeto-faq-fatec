// =============================================================================

import { deslogar } from '../scripts/auth/deslogar.js';
import { serverUrl } from '../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../scripts/middlewares/isLoggedIn.js';
import { getLoggedUseInfo } from '../scripts/user/getLoggedUserInfo.js';
import { fillHeaderUserData } from '../scripts/utils/fillHeaderUserData.js';

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
};

loggedIn && (await execute());
