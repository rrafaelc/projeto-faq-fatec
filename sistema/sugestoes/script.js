// =============================================================================

import { deslogar } from '../../scripts/auth/deslogar.js';
import { apiUrl } from '../../scripts/constants/apiUrl.js';
import { serverUrl } from '../../scripts/constants/serverUrl.js';
import { isLoggedIn } from '../../scripts/middlewares/isLoggedIn.js';
import { getLoggedUseInfo } from '../../scripts/user/getLoggedUserInfo.js';
import { fillHeaderUserData } from '../../scripts/utils/fillHeaderUserData.js';

const spinner = document.querySelector('.spinnerFull');
const deslogarBotao = document.querySelector('#deslogar');
spinner.classList.remove('hideElement');

const loggedIn = await isLoggedIn();
if (!loggedIn) window.location.href = `${serverUrl}/login`;

const execute = async () => {
  document.body.classList.remove('no-scroll');
  spinner.classList.add('hideElement');
  deslogarBotao.addEventListener('click', async () => await deslogar());

  const user = await getLoggedUseInfo();
  fillHeaderUserData(user);
};

loggedIn && (await execute());

//==============================================================================
//Perguntas sugeridas

const tbody = document.querySelector('tbody');

const suggestionsUrl = `${apiUrl}/pergunta-sugerida`;
const getSuggesttedQuestions = async () => {
  const response = await fetch(suggestionsUrl);
  return response.json();
};

const suggestedQuestions = await getSuggesttedQuestions();

const submitQuestionsInfo = async (name, phone, question, email) => {
  const data = {
    name,
    phone,
    question,
    email,
  };

  fetch(`${serverUrl}/sistema/perguntas`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (response.ok) {
        window.location.href = `${serverUrl}/sistema/perguntas`;
      } else {
        throw new Error('Erro ao enviar dados');
      }
    })
    .then((responseData) => {
      console.log(responseData); // Processa a resposta do servidor
    })
    .catch((error) => {
      console.error(error);
    });
};

tbody.innerHTML += suggestedQuestions.map((suggestedQuestion) => {
  const url =
    `${serverUrl}/sistemas/perguntas?` +
    `nome=${encodeURIComponent(suggestedQuestion.nome)}` +
    `&email=${encodeURIComponent(suggestedQuestion.email)}` +
    `&telefone=${encodeURIComponent(suggestedQuestion.telefone)}` +
    `&pergunta=${encodeURIComponent(suggestedQuestion.pergunta)}`;

  return ` <tr><td>
    <div id="id">
      <input type='text' class='no-style-input' value='${suggestedQuestion.nome}' name='name'>
    </div>
  </td>
  <td>
    <div id="email">
    <input type='text' class='no-style-input' value='${suggestedQuestion.email}' name='email'>
    </div>
  </td>
  <td>
    <div id="telefone">
    <input type='text' class='no-style-input' value='${suggestedQuestion.telefone}' name='phone'>
    </div>
  </td>
  <td>
    <div id="pergunta">
    <input type='text' class='no-style-input' value="${suggestedQuestion.pergunta}" name='question'>
    </div>
  </td>
  <td>
    <div id="acao">
    <a href="${url}" class="comment-link">
        <i class="fas fa-comment"></i>
      </a>
    </div>
  </td>
</tr>`;
});

const commentLinks = document.querySelectorAll('.comment-link');
commentLinks.forEach((commentLink, index) => {
  commentLink.addEventListener('click', () => {
    const selectedData = suggestedQuestions[index];
    // Agora, você tem os dados do suggestedQuestion selecionado dentro do loop
    console.log(selectedData);
    submitQuestionsInfo(
      selectedData.name,
      selectedData.phone,
      selectedData.question,
      selectedData.email,
    );
  });
});
