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

// Gambiarras temporárias, depois sera feito com o backend
const pesquisar = document.querySelector('.pesquisar-por');
const form = pesquisar.querySelector('form');

const opcoes = form.querySelectorAll('input[type="radio"][name="opcao"]');
const inputs = form.querySelector('.inputs');

const dados = document.querySelector('.dados');
const tbodys = dados.querySelectorAll('tbody.nao-mostrar');
const paginacao = dados.querySelector('.paginacao');

const id = inputs.querySelector('#id');
const titulo = inputs.querySelector('#titulo');
const colaborador = inputs.querySelector('#colaborador');

const valorID = id.querySelector('#id');
const valorTitulo = titulo.querySelector('#titulo');

const colaboradores = form.querySelectorAll('input[type="radio"][name="usuario"]');

let opcaoEscolhida = 'id';
let usuarioEscolhido = '';
let resposta = '';

opcoes.forEach(radio => {
  radio.addEventListener('change', function () {
    if (this.checked) {
      opcaoEscolhida = this.value;

      if (opcaoEscolhida === 'id') {
        id.classList.add('ativo');
        titulo.classList.remove('ativo');
        colaborador.classList.remove('ativo');

        tbodys.forEach(tbody => {
          tbody.classList.add('nao-mostrar');
        });
        paginacao.classList.add('nao-mostrar');
      } else if (opcaoEscolhida === 'titulo') {
        titulo.classList.add('ativo');
        id.classList.remove('ativo');
        colaborador.classList.remove('ativo');

        tbodys.forEach(tbody => {
          tbody.classList.remove('nao-mostrar');
        });
        paginacao.classList.remove('nao-mostrar');
      } else if (opcaoEscolhida === 'colaborador') {
        colaborador.classList.add('ativo');
        id.classList.remove('ativo');
        titulo.classList.remove('ativo');

        tbodys.forEach(tbody => {
          tbody.classList.remove('nao-mostrar');
        });
        paginacao.classList.remove('nao-mostrar');
      }
    }
  });
});

colaboradores.forEach(radio => {
  radio.addEventListener('change', function () {
    if (this.checked) {
      usuarioEscolhido = this.value;
    }
  });
});

form.addEventListener('submit', function (event) {
  if (opcaoEscolhida === 'id') {
    resposta = valorID.value;
  } else if (opcaoEscolhida === 'titulo') {
    resposta = valorTitulo.value;
  } else if (opcaoEscolhida === 'colaborador') {
    resposta = usuarioEscolhido;
  }

  event.preventDefault();

  console.log({
    opcaoEscolhida,
    resposta,
  });
});
