import './scripts/autocomplete/autoComplete.js';
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
const pgInicioPerguntas = document.querySelector('.pg-inicio-perguntas');
const pgAnteriorPerguntas = document.querySelector('.pg-anterior-perguntas');
const pgProximoPerguntas = document.querySelector('.pg-proximo-perguntas');
const pgUltimoPerguntas = document.querySelector('.pg-ultimo-perguntas');
const pgNumerosPerguntas = document.querySelector('.pg-numeros-perguntas');

pgNumerosPerguntas.innerHTML = `
  <div class="numero">1</div>
  <div class="numero">2</div>
  <div class="numero active">3</div>
  <div class="numero">4</div>
  <div class="numero">5</div>
  `;

let paginas = 1;
let qtdPgs = 0;
let loading = false;
const renderPerguntas = async ({
  maisAlta = true,
  pagina = 1,
  qtdPorPg = 20,
  order = 'asc',
  titulo = '',
} = {}) => {
  try {
    loading = true;
    spinnerContainer.classList.add('mostrar');
    questionsContainer.innerHTML = '';
    pgNumerosPerguntas.innerHTML = '';

    const perguntas = await listarPerguntas({
      maisAlta,
      pagina,
      qtdPorPg,
      order,
      titulo,
    });

    paginas = perguntas.pagina;
    qtdPgs = perguntas.qtd_pg;

    const maxLinks = 2;
    const numBotoesLado = maxLinks * 2 + 1;

    let startPage = Math.max(1, paginas - maxLinks);
    let endPage = Math.min(qtdPgs, startPage + numBotoesLado - 1);

    if (endPage - startPage + 1 < numBotoesLado) {
      startPage = Math.max(1, endPage - numBotoesLado + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
      pgNumerosPerguntas.innerHTML += `<div class="numero ${
        i === paginas ? 'active' : ''
      }">${i}</div>`;
    }

    questionsContainer.innerHTML += perguntas.resultado
      .map(
        (question) =>
          `
      <div class="faq-container">
        <div class="question">
          <h2 class="question-title">
            ${question.pergunta}
            <i class="fa-solid fa-chevron-down drop"></i>
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

    //deixa o coração vermelho ao clicar e chama a funçao de incrementar
    const hearts = document.querySelectorAll('.heart');
    let idCurtidasLocalStorage = localStorage.getItem('idCurtidas');
    let curtidasLocalStorage = JSON.parse(idCurtidasLocalStorage) || [];

    hearts.forEach((heart) => {
      heart.addEventListener('click', async function () {
        const id = this.getAttribute('data-id');

        if (!idCurtidasLocalStorage || !idCurtidasLocalStorage.includes(id)) {
          await incrementarCurtidas(id);
          curtidasLocalStorage.push({ id: id });
          localStorage.setItem('idCurtidas', JSON.stringify(curtidasLocalStorage));
          idCurtidasLocalStorage = localStorage.getItem('idCurtidas');
          heart.classList.add('heart-clicked');
        } else {
          await decrementarCurtidas(id);
          curtidasLocalStorage = curtidasLocalStorage.filter((item) => item.id !== id);
          localStorage.setItem('idCurtidas', JSON.stringify(curtidasLocalStorage));
          idCurtidasLocalStorage = localStorage.getItem('idCurtidas');
          heart.classList.remove('heart-clicked');
        }
      });
    });

    hearts.forEach(function (heart) {
      const dataId = heart.getAttribute('data-id');
      if (idCurtidasLocalStorage && idCurtidasLocalStorage.includes(dataId)) {
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
  } catch (error) {
    toast('Houve um erro ao carregar as perguntas', true);
    console.log(error);
  } finally {
    loading = false;
    spinnerContainer.classList.remove('mostrar');
    window.scrollTo({
      top: 0,
      behavior: 'smooth',
    });
  }

  if (paginas === 1) {
    pgInicioPerguntas.classList.add('disabled');
    pgAnteriorPerguntas.classList.add('disabled');
  } else {
    pgInicioPerguntas.classList.remove('disabled');
    pgAnteriorPerguntas.classList.remove('disabled');
  }

  if (paginas === qtdPgs) {
    pgProximoPerguntas.classList.add('disabled');
    pgUltimoPerguntas.classList.add('disabled');
  } else {
    pgProximoPerguntas.classList.remove('disabled');
    pgUltimoPerguntas.classList.remove('disabled');
  }

  const numerosPerguntas = pgNumerosPerguntas.querySelectorAll('.numero');

  numerosPerguntas.forEach((numero) => {
    numero.addEventListener('click', async function () {
      await renderPerguntas({
        pagina: numero.textContent,
      });
    });
  });
};

await renderPerguntas();

pgInicioPerguntas.addEventListener('click', async function () {
  if (pgInicioPerguntas.classList.contains('disabled')) return;

  await renderPerguntas({
    pagina: 1,
  });
});

pgAnteriorPerguntas.addEventListener('click', async function () {
  if (pgAnteriorPerguntas.classList.contains('disabled')) return;

  const pgAnt = paginas - 1 >= 1 ? paginas - 1 : 1;
  await renderPerguntas({
    pagina: pgAnt,
  });
});

pgProximoPerguntas.addEventListener('click', async function () {
  if (pgProximoPerguntas.classList.contains('disabled')) return;

  const pgDep = paginas + 1 > qtdPgs ? qtdPgs : paginas + 1;
  await renderPerguntas({
    pagina: pgDep,
  });
});

pgUltimoPerguntas.addEventListener('click', async function () {
  if (pgUltimoPerguntas.classList.contains('disabled')) return;

  await renderPerguntas({
    pagina: qtdPgs,
  });
});

const autoCompleteJS = new autoComplete({
  data: {
    src: async () => {
      try {
        document.getElementById('autoComplete').disabled = true;
        document.getElementById('autoComplete').setAttribute('placeholder', 'Carregando...');

        const data = await listarPerguntas({ qtdPorPg: 2000 });

        document
          .getElementById('autoComplete')
          .setAttribute('placeholder', autoCompleteJS.placeHolder);

        const { resultado } = data;

        const perguntasArray = resultado.map((item) => item.pergunta);

        return perguntasArray;
      } catch (error) {
        return error;
      } finally {
        document.getElementById('autoComplete').disabled = false;
      }
    },
    cache: true,
  },
  placeHolder: 'Quando abre o vestibular?',
  resultsList: {
    element: (list, data) => {
      const info = document.createElement('p');
      if (data.results.length > 0) {
        info.innerHTML = `Mostrando <strong>${data.results.length}</strong> de <strong>${data.matches.length}</strong> resultados`;
      } else {
        info.innerHTML = `Encontrado <strong>${data.matches.length}</strong> resultados que combinam com <strong>"${data.query}"</strong>`;
      }
      list.prepend(info);
    },
    noResults: true,
    tabSelect: true,
  },
  resultItem: {
    element: (item, data) => {
      item.style = 'display: flex; justify-content: space-between;';
      item.innerHTML = `
      <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
        ${data.match}
      </span>
      `;
    },
    highlight: true,
  },
  events: {
    input: {
      focus: () => {
        if (autoCompleteJS.input.value.length) autoCompleteJS.start();
      },
    },
  },
});

autoCompleteJS.input.addEventListener('input', async function (event) {
  if (loading) return;
  if (!event.target.value) {
    await renderPerguntas();
  }
});

autoCompleteJS.input.addEventListener('blur', async function (event) {
  if (loading) return;
  if (!event.target.value) {
    await renderPerguntas();
  }
});

autoCompleteJS.input.addEventListener('results', async function (event) {
  if (loading) return;
  await renderPerguntas({
    titulo: event.detail.query,
  });
});

autoCompleteJS.input.addEventListener('selection', async function (event) {
  if (loading) return;
  const feedback = event.detail;
  autoCompleteJS.input.blur();

  document.querySelector('#autoComplete');
  autoCompleteJS.input.value = feedback.selection.value;
  await renderPerguntas({
    titulo: feedback.selection.value,
  });
});
