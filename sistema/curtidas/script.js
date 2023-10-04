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
const opcoes = document.querySelectorAll('input[type="radio"][name="opcao"]');
const dados = document.querySelector('.dados');
const naoMostrar = dados.querySelectorAll('.nao-mostrar');

opcoes.forEach(radio => {
  radio.addEventListener('change', function () {
    if (this.checked) {
      const opcaoEscolhida = this.value;

      if (opcaoEscolhida === 'suas-perguntas') {
        naoMostrar.forEach(elemento => {
          elemento.classList.add('nao-mostrar');
        });
      } else if (opcaoEscolhida === 'outros') {
        naoMostrar.forEach(elemento => {
          elemento.classList.remove('nao-mostrar');
        });
      } else {
        console.log('Erro: opção inválida');
      }
    }
  });
});
