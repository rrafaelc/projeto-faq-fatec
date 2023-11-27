import { listarPerguntasMaisBuscadas } from '../scripts/perguntas/listarPerguntasMaisBuscadas.js';
import {
  addLinksToContent,
  replaceLineBreaks,
} from '../scripts/utils/addLinksAndReplaceLineBreaks.js';
import { toast } from '../scripts/utils/toast.js';

const main = document.querySelector('main');
const spinnerContainer = document.querySelector('.spinnerContainer');
const mostSearchedQuestionsContainer = document.querySelector('.container');
const pgInicioMaisBuscadas = document.querySelector('.pg-inicio-mais-buscados');
const pgAnteriorMaisBuscadas = document.querySelector('.pg-anterior-mais-buscados');
const pgProximoMaisBuscadas = document.querySelector('.pg-proximo-mais-buscados');
const pgUltimoMaisBuscadas = document.querySelector('.pg-ultimo-mais-buscados');
const pgNumerosMaisBuscadas = document.querySelector('.pg-numeros-mais-buscados');

pgNumerosMaisBuscadas.innerHTML = `
  <div class="numero">1</div>
  <div class="numero">2</div>
  <div class="numero active">3</div>
  <div class="numero">4</div>
  <div class="numero">5</div>
  `;

let paginas = 1;
let qtdPgs = 0;
const renderMaisBuscadas = async ({ pagina = 1, qtdPorPg = 20, order = 'desc' } = {}) => {
  try {
    spinnerContainer.classList.add('mostrar');
    mostSearchedQuestionsContainer.innerHTML = '';
    pgNumerosMaisBuscadas.innerHTML = '';

    const perguntasMaisBuscadas = await listarPerguntasMaisBuscadas({
      pagina,
      qtdPorPg,
      order,
    });

    paginas = perguntasMaisBuscadas.pagina;
    qtdPgs = perguntasMaisBuscadas.qtd_pg;

    const maxLinks = 2;
    const numBotoesLado = maxLinks * 2 + 1;

    let startPage = Math.max(1, paginas - maxLinks);
    let endPage = Math.min(qtdPgs, startPage + numBotoesLado - 1);

    if (endPage - startPage + 1 < numBotoesLado) {
      startPage = Math.max(1, endPage - numBotoesLado + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
      pgNumerosMaisBuscadas.innerHTML += `<div class="numero ${
        i === paginas ? 'active' : ''
      }">${i}</div>`;
    }

    // Mostrar as perguntas na tela
    mostSearchedQuestionsContainer.innerHTML = perguntasMaisBuscadas.resultado
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

    //efeito no click na pergunta
    const faqContainer = document.querySelectorAll('.faq-container');

    faqContainer.forEach((container) => {
      const question = container.querySelector('.question');

      question.addEventListener('click', function () {
        const dropIcon = container.querySelector('.drop');
        const content = container.querySelector('.content');

        content.classList.toggle('show');
        dropIcon.classList.toggle('rotate');

        if (content.classList.contains('show')) {
          content.style.maxHeight = `${content.scrollHeight + 100}px`;
        } else {
          content.style.maxHeight = null;
        }
      });
    });

    window.scrollTo({
      top: 0,
      behavior: 'smooth',
    });
  } catch (error) {
    toast('Houve um erro ao carregar as perguntas', true);
    console.log(error);
  } finally {
    spinnerContainer.classList.remove('mostrar');
  }

  if (paginas === 1) {
    pgInicioMaisBuscadas.classList.add('disabled');
    pgAnteriorMaisBuscadas.classList.add('disabled');
  } else {
    pgInicioMaisBuscadas.classList.remove('disabled');
    pgAnteriorMaisBuscadas.classList.remove('disabled');
  }

  if (paginas === qtdPgs) {
    pgProximoMaisBuscadas.classList.add('disabled');
    pgUltimoMaisBuscadas.classList.add('disabled');
  } else {
    pgProximoMaisBuscadas.classList.remove('disabled');
    pgUltimoMaisBuscadas.classList.remove('disabled');
  }

  const numerosMaisBuscadas = pgNumerosMaisBuscadas.querySelectorAll('.numero');

  numerosMaisBuscadas.forEach((numero) => {
    numero.addEventListener('click', async function () {
      await renderMaisBuscadas({
        pagina: numero.textContent,
      });
    });
  });
};

await renderMaisBuscadas();

pgInicioMaisBuscadas.addEventListener('click', async function () {
  if (pgInicioMaisBuscadas.classList.contains('disabled')) return;

  await renderMaisBuscadas({
    pagina: 1,
  });
});

pgAnteriorMaisBuscadas.addEventListener('click', async function () {
  if (pgAnteriorMaisBuscadas.classList.contains('disabled')) return;

  const pgAnt = paginas - 1 >= 1 ? paginas - 1 : 1;
  await renderMaisBuscadas({
    pagina: pgAnt,
  });
});

pgProximoMaisBuscadas.addEventListener('click', async function () {
  if (pgProximoMaisBuscadas.classList.contains('disabled')) return;

  const pgDep = paginas + 1 > qtdPgs ? qtdPgs : paginas + 1;
  await renderMaisBuscadas({
    pagina: pgDep,
  });
});

pgUltimoMaisBuscadas.addEventListener('click', async function () {
  if (pgUltimoMaisBuscadas.classList.contains('disabled')) return;

  await renderMaisBuscadas({
    pagina: qtdPgs,
  });
});
