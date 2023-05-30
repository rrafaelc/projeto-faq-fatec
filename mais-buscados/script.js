const maisBuscadosQuestionsContainer = document.querySelector('.container');

// Mostrar as perguntas na tela
const perguntasMaisBuscadas = [
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

maisBuscadosQuestionsContainer.innerHTML = perguntasMaisBuscadas
  .map(
    pergunta =>
      `
      <div class="faq-container">
        <div class="question">
          <h2 class="question-title">
            ${pergunta.titulo}
            <i class="fa-solid fa-chevron-down drop"> </i>
          </h2>
        </div>
        <div class="content">
          <p>
            ${pergunta.conteudo}
          </p>
        </div>
      </div>`,
  )
  .join('');

const form = document.querySelector('form');
const hearts = document.querySelectorAll('#heart');

//efeito no click na pergunta
maisBuscadosQuestionsContainer.addEventListener('click', e => {
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
