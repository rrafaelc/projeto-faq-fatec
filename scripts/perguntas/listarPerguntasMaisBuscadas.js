import { apiUrl } from '../constants/apiUrl.js';

export const listarPerguntasMaisBuscadas = async ({
  pagina = 1,
  qtdPorPg = 5,
  order = 'desc',
} = {}) => {
  try {
    const perguntas = await fetch(
      `${apiUrl}/pergunta/mais-buscados?pagina=${pagina}&quantidade_por_pagina=${qtdPorPg}&order=${order}`,
      {
        method: 'GET',
      },
    );

    return perguntas.json();
  } catch (error) {
    throw new Error(error.message);
  }
};
