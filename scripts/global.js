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
