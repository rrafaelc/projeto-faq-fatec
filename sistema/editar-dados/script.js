// =============================================================================
// Header
const usuario = document.querySelector('.usuario');
const botaoUsuario = usuario.querySelector('.botao');
const dropdown = usuario.querySelector('.dropdown');

botaoUsuario.addEventListener('click', function () {
  botaoUsuario.classList.toggle('ativo');
  dropdown.classList.toggle('ativo');
});
//==============================================================================
const form = document.querySelector('form');

form.addEventListener('submit', function (event) {
  event.preventDefault();
  const button = form.querySelector('button');

  const senhaAtual = form.querySelector('#senha-atual');

  if (senhaAtual.value === '') {
    senhaAtual.focus();
    return;
  }

  button.innerText = 'Atualizando aguarde...';
  button.disabled = true;
  button.classList.add('disabled');

  setTimeout(function () {
    window.location.href = '/sistema/';
  }, 2000);
});
