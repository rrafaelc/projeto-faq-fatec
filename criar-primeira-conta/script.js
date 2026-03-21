import { serverUrl } from '../scripts/constants/serverUrl.js';
import { criarPrimeiraConta } from '../scripts/user/criarPrimeiraConta.js';
import { temUsuarios } from '../scripts/user/temUsuarios.js';
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
const confirmarSenhaInput = document.querySelector('#confirmarSenha');
const eyeContainers = document.querySelectorAll('.eye-container');
const eyes = document.querySelectorAll('.eye');

if (await temUsuarios()) {
  window.location.href = `${serverUrl}/login`;
} else if (turnstileMisconfigured) {
  erro.classList.add('erro');
  erro.textContent =
    'Defina TURNSTILE_SITE_KEY (chave pública) no servidor. A API exige verificação Turnstile.';
  inputs.forEach((input) => {
    input.disabled = true;
  });
  button.disabled = true;
  button.classList.remove('hideElement');
  spinner.classList.add('hideElement');
} else {
  button.classList.toggle('hideElement');
  spinner.classList.toggle('hideElement');
}

eyeContainers.forEach((eyeContainer) =>
  eyeContainer.addEventListener('click', () => {
    eyes.forEach((eye) => {
      if (eye.classList.contains('bi-eye-slash')) {
        eye.classList.remove('bi-eye-slash');
        eye.classList.add('bi-eye');
        senhaInput.type = 'text';
        confirmarSenhaInput.type = 'text';
      } else {
        eye.classList.add('bi-eye-slash');
        eye.classList.remove('bi-eye');
        senhaInput.type = 'password';
        confirmarSenhaInput.type = 'password';
      }
    });
  }),
);

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  if (isTurnstileMisconfigured()) {
    erro.classList.add('erro');
    erro.textContent = 'Defina TURNSTILE_SITE_KEY no servidor para criar a conta.';
    return;
  }

  erro.classList.remove('erro');
  inputs.forEach((input) => input.classList.remove('erro'));

  button.classList.toggle('hideElement');
  spinner.classList.toggle('hideElement');

  const data = new FormData(form);
  const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;

  const nome = data.get('nome');
  const email = data.get('email');
  const senha = data.get('senha');
  const confirmarSenha = data.get('confirmarSenha');

  if (!nome.trim() || !email.trim() || !senha.trim() || !confirmarSenha.trim()) {
    erro.classList.add('erro');
    erro.textContent = 'Preencha todos os campos';
    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');

    return;
  }

  if (nome.length < 3) {
    erro.classList.add('erro');
    erro.textContent = 'Nome no mínimo 3 caracteres';
    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');

    return;
  }

  if (!emailRegex.test(email)) {
    erro.classList.add('erro');
    erro.textContent = 'E-mail inválido';
    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');

    return;
  }

  if (senha.length < 8) {
    erro.classList.add('erro');
    erro.textContent = 'Senha no mínimo 8 caracteres';
    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');

    return;
  }

  if (senha !== confirmarSenha) {
    erro.classList.add('erro');
    erro.textContent = 'Senhas não coincidem';
    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');

    return;
  }

  if (turnstileApi.isEnforced && !turnstileApi.getToken()) {
    erro.classList.add('erro');
    erro.textContent = 'Complete a verificação de segurança';
    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');
    return;
  }

  try {
    await criarPrimeiraConta({
      nome_completo: nome,
      email,
      senha,
      captchaToken: turnstileApi.getToken(),
    });

    window.location.href = `${serverUrl}/login`;
  } catch (error) {
    turnstileApi.reset();
    erro.classList.add('erro');
    erro.textContent = error instanceof Error ? error.message : 'Erro ao criar conta';
    inputs.forEach((input) => {
      input.value = '';
      input.classList.add('erro');
    });

    button.classList.toggle('hideElement');
    spinner.classList.toggle('hideElement');
  }
});
