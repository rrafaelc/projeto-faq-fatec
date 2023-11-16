import { decrementarCurtidas } from './scripts/perguntas/decrementarCurtidas.js';
import { incrementarCurtidas } from './scripts/perguntas/incrementarCurtidas.js';
import { listarPerguntas } from './scripts/perguntas/listarPerguntas.js';
import {
  addLinksToContent,
  replaceLineBreaks,
} from './scripts/utils/addLinksAndReplaceLineBreaks.js';
import { toast } from './scripts/utils/toast.js';

const spinnerContainer = document.querySelector('.spinnerContainer');
const questionsContainer = document.querySelector('.container');

let perguntas = [];

try {
  perguntas = await listarPerguntas();
} catch (error) {
  toast('Houve um erro ao carregar as perguntas', true);
  console.log(error);
} finally {
  spinnerContainer.classList.remove('mostrar');
}

questionsContainer.innerHTML += perguntas
  .map(
    (question) =>
      `
      <div class="faq-container">
        <div class="question">
          <h2 class="question-title">
            ${question.pergunta}
            <i class="fa-solid fa-chevron-down drop"> </i>
          </h2>
        </div>
        <div class="content">
          <p>
            ${replaceLineBreaks(addLinksToContent(question.resposta))}
          </p>
          <p>
            Essa resposta foi útil?
            <i data-id="${question.id}" class="fa-regular fa-thumbs-up heart"></i>
          </p>
        </div>
      </div>`,
  )
  .join('');
const form = document.querySelector('form');

// pega todas as divs containers que tem a tag faq-container para filtrar
const containers = document.querySelectorAll('.faq-container');
form.addEventListener('keyup', (event) => {
  event.preventDefault();
  const searchValue = form.querySelector('input').value.toLowerCase();
  containers.forEach((container) => {
    const questionTitleText = container.querySelector('.question-title').textContent.toLowerCase();
    const content = container.querySelector('.content').textContent.toLowerCase();

    if (questionTitleText.includes(searchValue) || content.includes(searchValue)) {
      container.style.display = 'block';
    } else {
      container.style.display = 'none';
    }
  });
});

//deixa o coração vermelho ao clicar e chama a funçao de incrementar
const hearts = document.querySelectorAll('.heart');
let idCurtidasLocalstorage = localStorage.getItem('idCurtidas');
let curtidasLocalStorage = JSON.parse(idCurtidasLocalstorage) || [];

hearts.forEach((heart) => {
  heart.addEventListener('click', async function () {
    const id = this.getAttribute('data-id');

    if (!idCurtidasLocalstorage || !idCurtidasLocalstorage.includes(id)) {
      await incrementarCurtidas(id);
      curtidasLocalStorage.push({ id: id });
      localStorage.setItem('idCurtidas', JSON.stringify(curtidasLocalStorage));
      idCurtidasLocalstorage = localStorage.getItem('idCurtidas');
      heart.classList.add('heart-clicked');
    } else {
      await decrementarCurtidas(id);
      curtidasLocalStorage = curtidasLocalStorage.filter((item) => item.id !== id);
      localStorage.setItem('idCurtidas', JSON.stringify(curtidasLocalStorage));
      idCurtidasLocalstorage = localStorage.getItem('idCurtidas');
      heart.classList.remove('heart-clicked');
    }
  });
});

hearts.forEach(function (heart) {
  const dataId = heart.getAttribute('data-id');
  if (idCurtidasLocalstorage && idCurtidasLocalstorage.includes(dataId)) {
    heart.classList.add('heart-clicked');
  }
});

//efeito no click na pergunta
questionsContainer.addEventListener('click', (e) => {
  const questionTitle = e.target.closest('.question-title');
  if (questionTitle) {
    const dropIcon = questionTitle.querySelector('.drop');
    const content = questionTitle.parentElement.nextElementSibling;

    content.classList.toggle('show');
    dropIcon.classList.toggle('rotate');

    if (content.classList.contains('show')) {
      content.style.maxHeight = `${content.scrollHeight}px`;
    } else {
      content.style.maxHeight = null;
    }
  }
});
