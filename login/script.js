import { login } from '../scripts/auth/login.js';
import { serverUrl } from '../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../scripts/middlewares/isLoggedIn.js';

const form = document.querySelector('form');
const loading = document.querySelector('.loading');
const inputs = form.querySelectorAll('input');
const button = document.querySelector('button');
const spinner = document.querySelector('.spinner');
const erro = document.querySelector('#erro');

if (await isLoggedIn()) {
  window.location.href = `${serverUrl}/sistema`;
} else {
  button.classList.toggle('hideElement');
  spinner.classList.toggle('hideElement');
}

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

    window.location.href = '../sistema';
  } catch (error) {
    erro.classList.add('erro');
    inputs.forEach((input) => {
      input.value = '';
      input.classList.add('erro');
    });

    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');
  }
});
