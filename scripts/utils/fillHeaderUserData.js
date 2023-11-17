import { serverUrl } from '../constants/serverUrl.js';

export const fillHeaderUserData = (user) => {
  const foto = document.querySelector('.foto').querySelector('img');
  const nome_completo = document.querySelector('.nome_completo');
  const cargo = document.querySelector('.cargo');

  foto.src = user.foto_uri ?? `${serverUrl}/img/userFallback.jpg`;
  nome_completo.textContent = user.nome_completo;
  cargo.textContent = `${user.cargo}(a)`;

  foto.onerror = () => {
    foto.src = `${serverUrl}/img/userFallback.jpg`;
  };
};
