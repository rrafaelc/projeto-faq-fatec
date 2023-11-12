import { apiUrl } from './scripts/constants/apiUrl.js';

const listarUrl = `${apiUrl}/pergunta`;

const listarPerguntas = async () => {
  const perguntas = await fetch(listarUrl);

  return perguntas.json();
};
const perguntas = await listarPerguntas();
const questionsContainer = document.querySelector('.container');

const addLinksToContent = (content) => {
  const linkRegex = /((http|https):\/\/[^\s.]+[^\s]*[^\s.])/g;
  const linkReplacement = '<a href="$1" target="_blank" style="display: inline">clique aqui</a>';

  return content.replace(linkRegex, linkReplacement);
};

const replaceLineBreaks = (content) => {
  return content.replace(/\n/g, '<br>');
};

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
            <i id="heart" class="fa-solid fa-heart"></i>
          </p>
        </div>
      </div>`,
  )
  .join('');

const form = document.querySelector('form');
const hearts = document.querySelectorAll('#heart');

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

//deixa o coração vermelho ao clicar
hearts.forEach((heart) => {
  heart.addEventListener('click', () => {
    heart.classList.toggle('heart-clicked');
  });
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
