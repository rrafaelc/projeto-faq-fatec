const usuario = document.querySelector('.usuario');
const botao = usuario.querySelector('.botao');
const dropdown = usuario.querySelector('.dropdown');

botao.addEventListener('click', function () {
  botao.classList.toggle('ativo');
  dropdown.classList.toggle('ativo');
});
