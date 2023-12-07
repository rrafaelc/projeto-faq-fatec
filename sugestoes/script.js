import { criarSugestao } from '../scripts/sugestoes/criarSugestao.js';
import { toast } from '../scripts/utils/toast.js';
const form = document.querySelector('form');
const spinner = document.querySelector('.spinner');
const botao = document.querySelector('.botao');

const nome = form.querySelector('#nome');
const email = form.querySelector('#email');
const telefone = form.querySelector('#phone');
const pergunta = form.querySelector('#mensagem');

telefone.addEventListener('input', function (e) {
  if (e.target.value.replace(/\D/g, '').length < 11) {
    VMasker(telefone).maskPattern('(99) 9999-9999');
  } else {
    VMasker(telefone).maskPattern('(99) 9-9999-9999');
  }
});

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

  if (!validator.isEmail(email.value.trim())) {
    toast('Digite um e-mail válido', true);
    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');

    return;
  }

  if (!telefone.value.trim()) {
    toast('telefone obrigatório', true);
    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');

    return;
  } else if (
    telefone.value.replace(/\D/g, '').length < 10 ||
    telefone.value.replace(/\D/g, '').length > 11
  ) {
    toast('telefone deve ter 10 ou 11 dígitos', true);
    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    return;
  }

  if (pergunta.value.length < 10) {
    toast('Dúvida precisa de no mínimo 10 caracteres', true);
    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');

    return;
  } else if (pergunta.value.length > 650) {
    toast('Dúvida máximo permitido 650 caracteres', true);
    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');

    return;
  }

  nome.disabled = true;
  email.disabled = true;
  telefone.disabled = true;
  pergunta.disabled = true;

  setTimeout(async () => {
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
      err.message.split(',').forEach((erro) => {
        toast(erro, true);
      });
    } finally {
      spinner.classList.toggle('mostrar');
      botao.classList.toggle('mostrar');
      nome.disabled = false;
      email.disabled = false;
      telefone.disabled = false;
      pergunta.disabled = false;
    }
  }, 1000);
});
