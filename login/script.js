import { login } from '../scripts/auth/login.js';
import { serverUrl } from '../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../scripts/middlewares/isLoggedIn.js';
import { temUsuarios } from '../scripts/user/temUsuarios.js';
import { toast } from '../scripts/utils/toast.js';

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

if (await isLoggedIn()) {
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

  erro.classList.remove('erro');
  inputs.forEach((input) => input.classList.remove('erro'));

  button.classList.toggle('hideElement');
  spinner.classList.toggle('hideElement');

  const data = new FormData(form);

  const email = data.get('email');
  const senha = data.get('senha');

  try {
    await login({ email, senha });

    window.location.href = `${serverUrl}/sistema`;
  } catch (error) {
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
