import { apiUrl } from '../constants/apiUrl.js';
import { getAuthorization } from '../utils/getAuthorization.js';

/**
 * Função assíncrona para listar sugestões de perguntas.
 *
 * @param {boolean} mostrarRespondidas - Indica se as perguntas respondidas devem ser incluídas na lista (padrão: false).
 * @returns {Promise<Array>} - Uma Promise que resolve para um array de objetos representando as perguntas sugeridas.
 * @throws {Error} - Lança um erro se ocorrer um problema durante a requisição ou processamento.
 */
export const listarSugestoes = async (mostrarRespondidas = false) => {
  try {
    // Realiza uma requisição GET para a API para obter as perguntas sugeridas.
    const response = await fetch(`${apiUrl}/pergunta-sugerida`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: await getAuthorization(),
      },
    });

    // Converte a resposta para JSON, representando as perguntas sugeridas.
    const perguntasSugeridas = await response.json();

    // Se mostrarRespondidas for true, retorna todas as perguntas sugeridas.
    if (mostrarRespondidas) return perguntasSugeridas;

    // Filtra as perguntas sugeridas para incluir apenas aquelas não respondidas.
    return perguntasSugeridas.filter((p) => !p.foi_respondido);
  } catch (error) {
    // Em caso de erro, lança uma exceção com a mensagem de erro.
    throw new Error(error.message);
  }
};
