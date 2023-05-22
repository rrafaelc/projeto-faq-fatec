const containers = document.querySelectorAll('.faq-container'); // pega todas as divs containers que tem a tag faq-container
const form = document.querySelector('#formulary');
const footer = document.querySelector('.footer-container');
const heart = document.querySelectorAll('#heart');
const questionDiv = document.querySelectorAll('.question');

//filter
form.addEventListener('keyup', event => {
  event.preventDefault();
  const searchValue = document.querySelector('#search-input').value.toLowerCase();
  containers.forEach(container => {
    const questionTitle = container.querySelector('.question-title').textContent.toLowerCase();
    const content = container.querySelector('.content').textContent.toLowerCase();

    if (questionTitle.includes(searchValue) || content.includes(searchValue)) {
      container.style.display = 'block';
    } else {
      container.style.display = 'none';
    }
  });
});

//deixa o coração vermelho ao clicar
heart.forEach(heart => {
  heart.addEventListener('click', () => {
    heart.classList.toggle('heart-clicked');
  });
});

//effect
questionDiv.forEach(question => {
  question.addEventListener('click', () => {
    const dropIcon = question.querySelector('.drop');
    const content = question.nextElementSibling;
    if (content.style.maxHeight) {
      content.style.maxHeight = null;
      dropIcon.classList.remove('rotate');
    } else {
      content.style.maxHeight = `${content.scrollHeight}px`;
      dropIcon.classList.add('rotate');
    }
  });
});
