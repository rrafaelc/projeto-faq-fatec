const hamburgerIcon = document.querySelector('.menu-hamburger');
const hamburgerContent = document.querySelector('.menu-hamburger-content');

hamburgerIcon.addEventListener('click', function () {
  hamburgerContent.classList.toggle('show');
});
