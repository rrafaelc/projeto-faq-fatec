import { criarSugestao } from '../scripts/sugestoes/criarSugestao.js';
import { toast } from '../scripts/utils/toast.js';
const form = document.querySelector('form');
const spinner = document.querySelector('.spinner');
const botao = document.querySelector('.botao');

const nome = form.querySelector('#nome');
const email = form.querySelector('#email');
const telefone = form.querySelector('#phone');
const pergunta = form.querySelector('#mensagem');

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  spinner.classList.toggle('mostrar');
  botao.classList.toggle('mostrar');

  if (nome.value.length < 3) {
    toast('Nome precisa de no mínimo 3 caracteres', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    return;
  } else if (nome.value.length > 100) {
    toast('Nome máximo permitido 100 caracteres', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    return;
  }

  if (pergunta.value.length < 10) {
    toast('Dúvida precisa de no mínimo 10 caracteres', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    return;
  } else if (pergunta.value.length > 2000) {
    toast('Dúvida máximo permitido 2000 caracteres', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    return;
  }

  try {
    const sugestaoCriada = await criarSugestao({
      nome: nome.value,
      email: email.value,
      telefone: telefone.value,
      pergunta: pergunta.value,
    });

    if (sugestaoCriada) {
      toast('Sugestão enviada com sucesso');
      nome.value = '';
      email.value = '';
      telefone.value = '';
      pergunta.value = '';
    } else {
      toast('Houve um erro ao criar a sugestão', true);
    }
  } catch (err) {
    toast('Houve um erro ao criar a sugestão', true);
    console.error(err);
  } finally {
    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
  }
});
