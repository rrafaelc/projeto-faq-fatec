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

const perguntas = document.querySelector('.adicionar-pergunta');
const botaoPerguntas = perguntas.querySelector('.botao');
const form = perguntas.querySelector('form');

const titulo = form.querySelector('#titulo');
const resposta = form.querySelector('#resposta');
const botaoPrioridade = form.querySelector('#prioridade');

botaoPerguntas.addEventListener('click', function () {
  botaoPerguntas.classList.toggle('aberto');
  form.classList.toggle('aberto');
});

botaoPrioridade.addEventListener('click', function () {
  const value = botaoPrioridade.value;

  if (value === 'Normal') {
    botaoPrioridade.classList.remove('normal');
    botaoPrioridade.classList.add('alta');
    botaoPrioridade.value = 'Alta';
  } else if (value === 'Alta') {
    botaoPrioridade.classList.remove('alta');
    botaoPrioridade.classList.add('normal');
    botaoPrioridade.value = 'Normal';
  } else {
    console.log('Erro ao mudar prioridade');
  }
});

form.addEventListener('submit', function (event) {
  event.preventDefault();

  console.log({
    titulo: titulo.value,
    resposta: resposta.value,
    prioridade: botaoPrioridade.value,
  });
});
