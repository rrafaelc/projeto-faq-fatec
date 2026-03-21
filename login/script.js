import { login } from '../scripts/auth/login.js';
import { serverUrl } from '../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../scripts/middlewares/isLoggedIn.js';
import { temUsuarios } from '../scripts/user/temUsuarios.js';
import { toast } from '../scripts/utils/toast.js';
import { initTurnstile, isTurnstileMisconfigured } from '../scripts/utils/turnstile.js';

const siteKey = window.turnstileSiteKey || '';
const turnstileApi = await initTurnstile(siteKey, '#turnstile-container');
const turnstileMisconfigured = isTurnstileMisconfigured();

const form = document.querySelector('form');
const inputs = form.querySelectorAll('input');
const button = document.querySelector('button');
const spinner = document.querySelector('.spinner');
const erro = document.querySelector('#erro');
const senhaInput = document.querySelector('#senha');
const eyeContainer = document.querySelector('.eye-container');
const eye = document.querySelector('.eye');

if (!(await temUsuarios())) {
  window.location.href = `${serverUrl}/criar-primeira-conta`;
}

if (turnstileMisconfigured) {
  erro.classList.add('erro');
  erro.textContent =
    'Defina TURNSTILE_SITE_KEY (chave pública) no servidor. A API exige verificação Turnstile.';
  inputs.forEach((input) => {
    input.disabled = true;
  });
  button.disabled = true;
  button.classList.remove('hideElement');
  spinner.classList.add('hideElement');
} else if (await isLoggedIn()) {
  window.location.href = `${serverUrl}/sistema`;
} else {
  button.classList.toggle('hideElement');
  spinner.classList.toggle('hideElement');
}

eyeContainer.addEventListener('click', () => {
  if (eye.classList.contains('bi-eye-slash')) {
    eye.classList.remove('bi-eye-slash');
    eye.classList.add('bi-eye');
    senhaInput.type = 'text';
  } else {
    eye.classList.add('bi-eye-slash');
    eye.classList.remove('bi-eye');
    senhaInput.type = 'password';
  }
});

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  if (isTurnstileMisconfigured()) {
    toast('Defina TURNSTILE_SITE_KEY no servidor para fazer login.', true);
    return;
  }

  erro.classList.remove('erro');
  inputs.forEach((input) => input.classList.remove('erro'));

  button.classList.toggle('hideElement');
  spinner.classList.toggle('hideElement');

  const data = new FormData(form);

  const email = data.get('email');
  const senha = data.get('senha');

  if (turnstileApi.isEnforced && !turnstileApi.getToken()) {
    toast('Complete a verificação de segurança', true);
    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');
    return;
  }

  try {
    await login({ email, senha, captchaToken: turnstileApi.getToken() });

    window.location.href = `${serverUrl}/sistema`;
  } catch (error) {
    turnstileApi.reset();
    erro.classList.add('erro');
    inputs.forEach((input) => {
      input.value = '';
      input.classList.add('erro');
    });

    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');

    toast(error.message, true);
  }
});
