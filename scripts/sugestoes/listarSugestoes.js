import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

/**
 * Função assíncrona para listar sugestões de perguntas.
 *
 * @returns {Promise<Array>} - Uma Promise que resolve para um array de objetos representando as perguntas sugeridas.
 * @throws {Error} - Lança um erro se ocorrer um problema durante a requisição ou processamento.
 */
export const listarSugestoes = async ({ pagina = 1, qtdPorPg = 5, order = 'asc' } = {}) => {
  try {
    // Realiza uma requisição GET para a API para obter as perguntas sugeridas.
    const response = await fetch(
      `${apiUrl}/pergunta-sugerida?pagina=${pagina}&quantidade_por_pagina=${qtdPorPg}&order=${order}`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          Authorization: await getAuthorization(),
        },
      },
    );

    // Converte a resposta para JSON, representando as perguntas sugeridas.
    const perguntasSugeridas = await response.json();

    return perguntasSugeridas;
  } catch (error) {
    // Em caso de erro, lança uma exceção com a mensagem de erro.
    throw new Error(error.message);
  }
};
