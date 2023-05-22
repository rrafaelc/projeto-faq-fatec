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
const criarConta = document.querySelector('.criar-conta');
const botaoAngle = criarConta.querySelector('.botao');
const formCriarConta = criarConta.querySelector('form');

botaoAngle.addEventListener('click', function () {
  botaoAngle.classList.toggle('aberto');
  formCriarConta.classList.toggle('aberto');
});

const pesquisar = document.querySelector('.pesquisar-por');
const form = pesquisar.querySelector('form');

const opcoes = form.querySelectorAll('input[type="radio"][name="opcao"]');
const inputs = form.querySelector('.inputs');

const dados = document.querySelector('.dados');
const paginacao = dados.querySelector('.paginacao');

const todos = inputs.querySelector('#input-todos');
const id = inputs.querySelector('#input-id');
const nome = inputs.querySelector('#input-nome');

const tabela1 = dados.querySelector('#tabela-1');
const tabela2 = dados.querySelector('#tabela-2');

const valorID = id.querySelector('#id');
const valorNome = nome.querySelector('#nome');

const button = pesquisar.querySelector('button[type="submit"]');

opcoes.forEach(radio => {
  radio.addEventListener('change', function () {
    if (this.checked) {
      opcaoEscolhida = this.value;

      if (opcaoEscolhida === 'id') {
        id.classList.add('ativo');
        nome.classList.remove('ativo');

        button.classList.remove('nao-mostrar');
        paginacao.classList.add('nao-mostrar');

        tabela1.classList.remove('mostrar');
        tabela2.classList.add('mostrar');
      } else if (opcaoEscolhida === 'nome') {
        nome.classList.add('ativo');
        id.classList.remove('ativo');

        button.classList.remove('nao-mostrar');
        paginacao.classList.add('nao-mostrar');

        tabela1.classList.remove('mostrar');
        tabela2.classList.add('mostrar');
      } else if (opcaoEscolhida === 'todos') {
        id.classList.remove('ativo');
        nome.classList.remove('ativo');

        button.classList.add('nao-mostrar');
        paginacao.classList.remove('nao-mostrar');

        tabela1.classList.add('mostrar');
        tabela2.classList.remove('mostrar');
      }
    }
  });
});

const cargos = dados.querySelectorAll('.cargo');
const suspensos = dados.querySelectorAll('.suspenso');

cargos.forEach(cargo => {
  cargo.addEventListener('click', function () {
    const cargoBotao = cargo.querySelector('button');

    switch (cargoBotao.textContent) {
      case 'Administrador':
        cargoBotao.textContent = 'Moderador';

        cargo.classList.add('moderador');
        cargo.classList.remove('administrador');
        cargo.classList.remove('colaborador');
        break;
      case 'Moderador':
        cargoBotao.textContent = 'Colaborador';

        cargo.classList.add('colaborador');
        cargo.classList.remove('administrador');
        cargo.classList.remove('moderador');
        break;
      case 'Colaborador':
        cargoBotao.textContent = 'Administrador';

        cargo.classList.add('administrador');
        cargo.classList.remove('moderador');
        cargo.classList.remove('colaborador');
        break;
    }
  });
});

suspensos.forEach(suspenso => {
  suspenso.addEventListener('click', function () {
    const suspensoBotao = suspenso.querySelector('button');

    switch (suspensoBotao.textContent) {
      case 'Sim':
        suspensoBotao.textContent = 'Não';

        suspenso.classList.add('nao');
        suspenso.classList.remove('sim');
        break;
      case 'Não':
        suspensoBotao.textContent = 'Sim';

        suspenso.classList.add('sim');
        suspenso.classList.remove('nao');
        break;
    }
  });
});

form.addEventListener('submit', function (event) {
  event.preventDefault();
});

formCriarConta.addEventListener('submit', function (event) {
  event.preventDefault();
});
