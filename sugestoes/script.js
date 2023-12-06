import { criarSugestao } from '../scripts/sugestoes/criarSugestao.js';
import { toast } from '../scripts/utils/toast.js';
const form = document.querySelector('form');
const spinner = document.querySelector('.spinner');
const botao = document.querySelector('.botao');

const nome = form.querySelector('#nome');
const email = form.querySelector('#email');
const celular = form.querySelector('#phone');
const pergunta = form.querySelector('#mensagem');

VMasker(celular).maskPattern('(99) 9-9999-9999');

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  VMasker(celular).unMask();

  spinner.classList.toggle('mostrar');
  botao.classList.toggle('mostrar');

  if (nome.value.length < 3) {
    toast('Nome precisa de no mínimo 3 caracteres', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    VMasker(celular).maskPattern('(99) 9-9999-9999');
    return;
  } else if (nome.value.length > 100) {
    toast('Nome máximo permitido 100 caracteres', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    VMasker(celular).maskPattern('(99) 9-9999-9999');
    return;
  }

  if (!validator.isEmail(email.value.trim())) {
    toast('Digite um e-mail válido', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    VMasker(celular).maskPattern('(99) 9-9999-9999');
    return;
  }

  if (!celular.value.trim()) {
    toast('Celular obrigatório', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    VMasker(celular).maskPattern('(99) 9-9999-9999');
    return;
  } else if (celular.value.length !== 11) {
    toast('Celular deve ter 11 dígitos', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    VMasker(celular).maskPattern('(99) 9-9999-9999');
    return;
  }

  if (pergunta.value.length < 10) {
    toast('Dúvida precisa de no mínimo 10 caracteres', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    VMasker(celular).maskPattern('(99) 9-9999-9999');
    return;
  } else if (pergunta.value.length > 2000) {
    toast('Dúvida máximo permitido 2000 caracteres', true);

    spinner.classList.toggle('mostrar');
    botao.classList.toggle('mostrar');
    VMasker(celular).maskPattern('(99) 9-9999-9999');
    return;
  }

  nome.disabled = true;
  email.disabled = true;
  celular.disabled = true;
  pergunta.disabled = true;

  setTimeout(async () => {
    try {
      const sugestaoCriada = await criarSugestao({
        nome: nome.value,
        email: email.value,
        telefone: celular.value,
        pergunta: pergunta.value,
      });

      if (sugestaoCriada) {
        toast('Sugestão enviada com sucesso');
        nome.value = '';
        email.value = '';
        celular.value = '';
        pergunta.value = '';
      } else {
        toast('Houve um erro ao criar a sugestão', true);
      }
    } catch (err) {
      err.message.split(',').forEach((erro) => {
        toast(erro, true);
      });
    } finally {
      VMasker(celular).maskPattern('(99) 9-9999-9999');
      spinner.classList.toggle('mostrar');
      botao.classList.toggle('mostrar');
      nome.disabled = false;
      email.disabled = false;
      celular.disabled = false;
      pergunta.disabled = false;
    }
  }, 1000);
});
