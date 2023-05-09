// https://stackoverflow.com/questions/18712338/make-header-and-footer-files-to-be-included-in-multiple-html-pages

// Usar esse componente para carregar o header e o footer em todas as paginas
// sem precisar ficar copiando e colando muito

document.getElementById('header').innerHTML = `
<div class="header-content">
<div class="logo">
  <img
    src="../img/fatec_ra_campinas_itapira_cor.svg"
    alt="Logo da fatec"
  />
</div>
<div class="nav-items">
  <a href="/" class="active">Página inicial</a>
  <a href="">Mais buscados</a>
  <a href="">Sugestões</a>
  <a href="">Sobre</a>
</div>
<div class="login">
  <a href="/login">
    <p>Login</p>
    <p>(Somente autorizados)</p>
  </a>
</div>
</div>
`;
// document.getElementById('navbar').innerHTML = `<p>Menu</p>`;
document.getElementById('footer').innerHTML = `<p>Rodape</p>`;
