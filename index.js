const questionsContainer = document.querySelector('.container');

// Mostrar as perguntas na tela
const questions = [
  {
    titulo: 'O que é a Fatec Itapira?',
    conteudo:
      'A Fatec Itapira é uma instituição de ensino superior localizada na cidade de Itapira, no estado de São Paulo, Brasil. Ela faz parte do Centro Estadual de Educação Tecnológica Paula Souza (CEETEPS) e oferece cursos superiores de tecnologia.',
  },
  {
    titulo: 'Quais cursos são oferecidos pela Fatec Itapira?',
    conteudo:
      'A Fatec Itapira oferece cursos superiores de tecnologia em Análise e Desenvolvimento de Sistemas (ADS) e em Gestão da Tecnologia da Informação (GTI). Esses cursos têm duração de três anos.',
  },
  {
    titulo: 'Como é o processo seletivo para ingressar na Fatec Itapira?',
    conteudo:
      'O processo seletivo da Fatec Itapira é realizado por meio de um vestibular, que geralmente ocorre duas vezes ao ano. Os candidatos precisam se inscrever, realizar a prova e obter uma pontuação mínima para serem classificados.',
  },
  {
    titulo: 'A Fatec Itapira é uma instituição gratuita?',
    conteudo:
      'Sim, a Fatec Itapira é uma instituição pública e, portanto, seus cursos são gratuitos. Os alunos aprovados não precisam pagar mensalidades para estudar na Fatec. No entanto, é importante observar que existem outros custos associados à vida acadêmica, como material didático e transporte.',
  },
  {
    titulo: 'Quais são as áreas de atuação dos cursos da Fatec Itapira?',
    conteudo:
      'Os cursos de Análise e Desenvolvimento de Sistemas e Gestão da Tecnologia da Informação da Fatec Itapira capacitam os alunos para atuarem em diversas áreas do mercado de tecnologia da informação. Os formados podem trabalhar como programadores, desenvolvedores de software, analistas de sistemas, gerentes de projetos de TI, entre outras possibilidades.',
  },
  {
    titulo: 'A Fatec Itapira oferece algum tipo de suporte aos estudantes?',
    conteudo:
      'Sim, a Fatec Itapira oferece suporte aos estudantes de várias formas. Existem programas de assistência estudantil, como bolsas de estudo e auxílio transporte, para aqueles que se qualificam. Além disso, a instituição conta com biblioteca, laboratórios de informática e outros recursos para auxiliar no aprendizado dos alunos.',
  },
  {
    titulo: 'Qual é a localização da Fatec Itapira?',
    conteudo:
      'A Fatec Itapira está localizada na Rua São Paulo, 720 - Centro, Itapira - SP, CEP 13970-160, Brasil.',
  },
  {
    titulo: 'A Fatec Itapira oferece cursos de pós-graduação?',
    conteudo:
      'Atualmente, a Fatec Itapira oferece apenas cursos de graduação, não oferecendo programas de pós-graduação.',
  },
  {
    titulo: 'Como posso entrar em contato com a Fatec Itapira?',
    conteudo:
      'Você pode entrar em contato com a Fatec Itapira através do telefone (19) 3863-7240 ou pelo e-mail fatec.itapira@fatec.sp.gov.br. Também é possível visitar o site oficial da instituição para obter mais informações.',
  },
  {
    titulo: 'A Fatec Itapira possui parcerias com empresas ou instituições?',
    conteudo:
      'Sim, a Fatec Itapira busca estabelecer parcerias com empresas e instituições do mercado, proporcionando oportunidades de estágio e projetos conjuntos. Essas parcerias visam aproximar os estudantes do ambiente profissional e promover a inserção no mercado de trabalho.',
  },
  {
    titulo: 'A Fatec Itapira possui programas de intercâmbio?',
    conteudo:
      'A Fatec Itapira pode oferecer programas de intercâmbio acadêmico em parceria com outras instituições de ensino, proporcionando aos alunos a oportunidade de vivenciar experiências internacionais. É recomendado verificar junto à instituição quais são as possibilidades e requisitos para participar de programas de intercâmbio.',
  },
];

questionsContainer.innerHTML = questions
  .map(
    question =>
      `
      <div class="faq-container">
        <div class="question">
          <h2 class="question-title">
            ${question.titulo}
            <i class="fa-solid fa-chevron-down drop"> </i>
          </h2>
        </div>
        <div class="content">
          <p>
            ${question.conteudo}
          </p>
          <p>
            Essa resposta foi útil?
            <i id="heart" class="fa-solid fa-heart"></i>
          </p>
        </div>
      </div>`,
  )
  .join('');

const form = document.querySelector('form');
const hearts = document.querySelectorAll('#heart');

// pega todas as divs containers que tem a tag faq-container para filtrar
const containers = document.querySelectorAll('.faq-container');
form.addEventListener('keyup', event => {
  event.preventDefault();
  const searchValue = form.querySelector('input').value.toLowerCase();
  containers.forEach(container => {
    const questionTitleText = container.querySelector('.question-title').textContent.toLowerCase();
    const content = container.querySelector('.content').textContent.toLowerCase();

    if (questionTitleText.includes(searchValue) || content.includes(searchValue)) {
      container.style.display = 'block';
    } else {
      container.style.display = 'none';
    }
  });
});

//deixa o coração vermelho ao clicar
hearts.forEach(heart => {
  heart.addEventListener('click', () => {
    heart.classList.toggle('heart-clicked');
  });
});

//efeito no click na pergunta

questionsContainer.addEventListener('click', e => {
  const questionTitle = e.target.closest('.question-title');
  if (questionTitle) {
    const dropIcon = questionTitle.querySelector('.drop');
    const content = questionTitle.parentElement.nextElementSibling;

    content.classList.toggle('show');
    dropIcon.classList.toggle('rotate');

    if (content.classList.contains('show')) {
      content.style.maxHeight = `${content.scrollHeight}px`;
    } else {
      content.style.maxHeight = null;
    }
  }
});
