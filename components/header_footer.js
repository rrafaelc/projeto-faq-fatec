// https://stackoverflow.com/questions/18712338/make-header-and-footer-files-to-be-included-in-multiple-html-pages

// Usar esse componente para carregar o header e o footer em todas as paginas
// sem precisar ficar copiando e colando muito

document.getElementById('header').innerHTML = `<p>Cabecalho</p>`;
// document.getElementById('navbar').innerHTML = `<p>Menu</p>`;
document.getElementById('footer').innerHTML = `<p>Rodape</p>`;

