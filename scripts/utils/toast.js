/**
 * Exibe um toast com uma mensagem personalizada.
 *
 * @param {string} mensagem - A mensagem a ser exibida no toast.
 * @param {boolean} [erro=false] - Indica se o toast deve ser estilizado como um erro.
 *                                 Se verdadeiro, o fundo será um gradiente de vermelho; caso contrário, será um gradiente de verde.
 * @throws {Error} Se ocorrer um erro durante a exibição do toast.
 *
 * @example
 * // Exemplo de uso para exibir um toast com uma mensagem de sucesso.
 * toast("Operação concluída com sucesso!");
 *
 * // Exemplo de uso para exibir um toast com uma mensagem de erro.
 * toast("Erro ao processar a operação!", true);
 *
 * @description
 * Esta função depende da biblioteca Toastify para exibir toasts. Certifique-se de incluir os seguintes links no seu arquivo HTML:
 *
 * ```html
 * <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
 * <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
 * ```
 */
export const toast = (mensagem, erro = false) => {
  try {
    const estilo = {
      background: erro
        ? 'linear-gradient(to right, #FF5E5E, #FF4242)'
        : 'linear-gradient(to right, #00b09b, #96c93d)',
    };

    Toastify({
      text: mensagem,
      duration: 4000,
      style: estilo,
    }).showToast();
  } catch (error) {
    console.error(error);
  }
};
