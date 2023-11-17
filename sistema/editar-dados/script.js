import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { atualizarContaUsuario } from '../../scripts/user/atualizarContaUsuario.js';
import { toast } from '../../scripts/utils/toast.js';

const form = document.querySelector('form');
const eyeContainers = document.querySelectorAll('.eye-container');
const eyes = document.querySelectorAll('.eye');
const senha = form.querySelector('#nova-senha');
const confirmarSenha = form.querySelector('#nova-confirmar-senha');

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

form.addEventListener('submit', async function (event) {
  event.preventDefault();
  const button = form.querySelector('button');

  const senhaAtual = form.querySelector('#senha-atual');
  const nome = form.querySelector('#nome').value.trim();
  const email = form.querySelector('#email').value.trim();
  const senha = form.querySelector('#nova-senha').value.trim();
  const confirmarSenha = form.querySelector('#nova-confirmar-senha').value.trim();
  const foto = form.querySelector('#foto').value.trim();

  if (nome && nome.length < 3) {
    toast('Nome mínimo 3 letras', true);
    return;
  }

  if (senha && senha.length < 8) {
    toast('Nova senha mínimo 8 caracteres', true);
    return;
  }

  if (senha && confirmarSenha !== senha) {
    toast('Nova senha e confirmar senha não são iguais', true);
    return;
  }

  if (!senhaAtual.value.trim()) {
    toast('Preencha a senha atual', true);
    senhaAtual.focus();
    return;
  }

  button.innerText = 'Atualizando aguarde...';
  button.disabled = true;
  button.classList.add('disabled');

  try {
    await atualizarContaUsuario({
      nome_completo: nome,
      email,
      senha,
      foto_uri: foto,
      senha_atual: senhaAtual.value,
    });

    toast('Dados alterados com sucesso!');
  } catch (error) {
    toast(error.message, true);
  } finally {
    button.innerText = 'Atualizar dados';
    button.disabled = false;
    button.classList.remove('disabled');
  }

  if (email) {
    Swal.fire({
      title: 'Você alterou o email, por favor faça o login novamente',
      confirmButtonText: 'Certo!',
      icon: 'info',
    }).then(() => {
      localStorage.clear();
      window.location.href = `${serverUrl}/login`;
      return;
    });
  }

  if (senha) {
    Swal.fire({
      title: 'Você alterou a senha, por favor faça o login novamente',
      confirmButtonText: 'Certo!',
      icon: 'info',
    }).then(() => {
      localStorage.clear();
      window.location.href = `${serverUrl}/login`;
      return;
    });
  }
});

const spinner = document.querySelector('.spinnerFull');
spinner.classList.remove('hideElement');

const loggedIn = await isLoggedIn();
if (!loggedIn) window.location.href = `${serverUrl}/login`;

const execute = () => {
  document.body.classList.remove('no-scroll');
  spinner.classList.add('hideElement');
};

loggedIn && execute();
