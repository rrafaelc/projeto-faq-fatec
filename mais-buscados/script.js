const questionDiv = document.querySelectorAll('.question');

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
