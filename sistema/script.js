// =============================================================================

import { serverUrl } from '../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../scripts/middlewares/isLoggedIn.js';

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
spinner.classList.remove('hideElement');

const loggedIn = await isLoggedIn();
if (!loggedIn) window.location.href = `${serverUrl}/login`;

const execute = () => {
  document.body.classList.remove('no-scroll');
  spinner.classList.add('hideElement');
};

loggedIn && execute();
