import { listarPerguntasMaisBuscadas } from "../scripts/perguntas/listarPerguntasMaisBuscadas.js";
const mostSearchedQuestionsContainer = document.querySelector('.container');

const perguntasMaisBuscadas = await listarPerguntasMaisBuscadas();
console.log(perguntasMaisBuscadas)



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
            ${pergunta.resposta }
          </p>
          <p>${pergunta.curtidas} likes <i class="fa-regular fa-thumbs-up"></i> </p>
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
