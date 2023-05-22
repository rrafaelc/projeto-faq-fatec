const copyrightDate = document.querySelector('#copyright-date');
const currentlyYear = () => {
  const dataAtual = new Date();
  const ano = dataAtual.getFullYear();
  copyrightDate.innerHTML = ano;
};
currentlyYear();

const hamburgerIcon = document.querySelector('.menu-hamburger');
const hamburgerContent = document.querySelector('.menu-hamburger-content');

hamburgerIcon.addEventListener('click', function () {
  hamburgerContent.classList.toggle('show');
});

// deixa o link vermelho quando acessa a pagina dele

const urlDaPagina = window.location.pathname;
const paginaInicial = document.querySelector('.nav-items :nth-child(1)');
const maisBuscados = document.querySelector('.nav-items :nth-child(2)');
const sugestoes = document.querySelector('.nav-items :nth-child(3)');
const sobre = document.querySelector('.nav-items :nth-child(4)');
const areaRestrita = document.querySelectorAll('.area-r');

if (urlDaPagina.includes('/mais-buscados')) {
  maisBuscados.classList.add('.active');
} else if (urlDaPagina.includes('/sugestoes')) {
  sugestoes.classList.add('active');
} else if (urlDaPagina.includes('/sobre')) {
  sobre.classList.add('active');
} else if (urlDaPagina.includes('/login')) {
  areaRestrita.forEach(a => {
    a.classList.add('active');
  });
} else {
  paginaInicial.classList.add('active');
}
