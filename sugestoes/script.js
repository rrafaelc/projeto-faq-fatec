const form = document.querySelector('form');
import { apiUrl } from '../scripts/constants/apiUrl.js';
const insertSuggestionsUrl = `${apiUrl}/pergunta-sugerida`;

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const inputName = form.querySelector('[name="nome"]');
  const inputEmail = form.querySelector('[name="email"]');
  const inputPhone = form.querySelector('[name="telefone"]');
  const inputMessage = form.querySelector('[name="mensagem"]');

  const userName = inputName.value;
  const userEmail = inputEmail.value;
  const userPhone = inputPhone.value;
  const userSuggestion = inputMessage.value;

  const data = {
    nome: userName,
    pergunta: userSuggestion,
    email: userEmail,
    telefone: userPhone,
  };

  const insertSuggestedQuestion = async () => {
    try {
      await fetch(insertSuggestionsUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      });
    } catch (err) {
      console.log(err);
    }
  };

  insertSuggestedQuestion();
});
