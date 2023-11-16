import { listarPerguntasMaisBuscadas } from '../scripts/perguntas/listarPerguntasMaisBuscadas.js';
import {
  addLinksToContent,
  replaceLineBreaks,
} from '../scripts/utils/addLinksAndReplaceLineBreaks.js';
import { toast } from '../scripts/utils/toast.js';
const mostSearchedQuestionsContainer = document.querySelector('.container');

const spinnerContainer = document.querySelector('.spinnerContainer');
let perguntasMaisBuscadas = [];

try {
  perguntasMaisBuscadas = await listarPerguntasMaisBuscadas();
} catch (error) {
  toast('Houve um erro ao carregar as perguntas', true);
  console.log(error);
} finally {
  spinnerContainer.classList.remove('mostrar');
}

// Mostrar as perguntas na tela
mostSearchedQuestionsContainer.innerHTML = perguntasMaisBuscadas
  .map(
    (pergunta) =>
      `
      <div class="faq-container">
        <div class="question">
          <h2 class="question-title">
            ${pergunta.pergunta}
            <i class="fa-solid fa-chevron-down drop"> </i>
          </h2>
        </div>
        <div class="content">
          <p>
            ${replaceLineBreaks(addLinksToContent(pergunta.resposta))}
          </p>
          <p>${pergunta.curtidas} likes <i class="fa-regular fa-thumbs-up"></i></p>
        </div>
      </div>`,
  )
  .join('');

const form = document.querySelector('form');
const hearts = document.querySelectorAll('#heart');

//efeito no click na pergunta
mostSearchedQuestionsContainer.addEventListener('click', (e) => {
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
