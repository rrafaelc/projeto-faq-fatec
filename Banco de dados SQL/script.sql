USE `faqfatecitapira_projetofaq`;

CREATE TABLE usuario (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  nome_completo VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  foto_uri VARCHAR(255),
  senha VARCHAR(255) NOT NULL,
  cargo VARCHAR(255) NOT NULL DEFAULT 'Moderador',
  esta_suspenso BOOLEAN NOT NULL DEFAULT false,
  access_token VARCHAR(255),
  refresh_token VARCHAR(255),
  refresh_token_expiration DATETIME,
  criado_em DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE pergunta (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  pergunta TEXT NOT NULL,
  resposta TEXT NOT NULL,
  curtidas INT NOT NULL default 0,
  prioridade VARCHAR(255) NOT NULL DEFAULT 'Normal',
  criado_por INT(11),
  criado_em DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
  FOREIGN KEY (criado_por) REFERENCES usuario(id)
);

CREATE TABLE pergunta_editada_por (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  usuario_id INT(11),
  pergunta_id INT(11) NOT NULL,
  criado_em DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE SET NULL,
  FOREIGN KEY (pergunta_id) REFERENCES pergunta(id) ON DELETE CASCADE
);

CREATE TABLE pergunta_sugerida (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  pergunta TEXT NOT NULL,
	email TEXT,
	telefone TEXT,
  respondido_por INT(11),
  foi_respondido BOOLEAN NOT NULL DEFAULT false,
  criado_em DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
  FOREIGN KEY (respondido_por) REFERENCES usuario(id) ON DELETE SET NULL
);

INSERT INTO pergunta (pergunta, resposta) VALUES
('Como faço para trancar minha matrícula?', 'De acordo com o artigo 35 do Regulamento Geral dos Cursos das Fatecs, o aluno veterano tem a opção de fazer até dois trancamentos de matrícula, seja de forma consecutiva ou não. Para solicitar o trancamento, o aluno deve comparecer à Secretaria Acadêmica da Unidade com a sua carteirinha e preencher um requerimento de solicitação de trancamento. É importante observar que o pedido de trancamento de matrícula só pode ser realizado dentro do prazo final estipulado no Calendário Acadêmico, disponível no site da Fatec de Itapira https://fatecitapira.edu.br'),
('Como faço para pedir um atestado?', 'Os atestados devem ser solicitados no sistema SIGA (Sistema Integrado de Gestão Acadêmica), na opção Solicitação de Documentos.

      O acesso ao SIGA pode ser feito pelo seguinte link: https://siga.cps.sp.gov.br/aluno/login.aspx

      Após 3 dias úteis o atestado ficará disponível na tela de Solicitação de Documentos e também será enviado para o aluno na plataforma Ms Teams.'),
('Como faço para ver o meu horário de aula?', 'Para obter o horário de aula atualizado da Fatec de Itapira, aconselho acessar o site oficial da instituição em https://fatecitapira.edu.br. Lá, você encontrará informações detalhadas sobre os horários de aula de cada curso oferecido, bem como outras informações relevantes sobre a instituição. É sempre recomendável verificar o site da Fatec de Itapira regularmente, pois o horário de aula pode ser atualizado a cada semestre ou período letivo.'),
('Como fazer minha rematrícula?', 'Para fazer a rematrícula o aluno deve acessar o sistema SIGA (Sistema Integrado de Gestão Acadêmica) dentro do prazo de rematrícula, conforme previsão do Calendário de Escolar e clicar em Rematrícula. Cabe lembrar que a rematrícula só estará liberada após a entrega de todos os documentos originais solicitados pela secretaria, e após a confirmação de recebimento do e-mail com as instruções para a rematrícula.

      O acesso ao SIGA pode ser feito pelo seguinte link https://siga.cps.sp.gov.br/aluno/login.aspx e o Calendário Escolar poderá ser consultado em https://fatecitapira.edu.br
      '),
('Perdi minha senha do e-mail, como eu resolvo?', 'O aluno que perder a sua senha do e-mail deve procurar a Secretaria Acadêmica da Unidade para solicitar a redefinição de senha do e-mail.'),
('Não consigo acessar o SIGA, como eu faço?', 'O aluno que não conseguir acessar o sistema SIGA (Sistema Integrado de Gestão Acadêmica) deverá enviar uma mensagem eletrônica, DO SEU E-MAIL INSTITUCIONAL, para o endereço f278acad@cps.sp.gov.br solicitando uma nova senha ou o desbloqueio do seu acesso. Caso o problema de acesso seja o esquecimento da senha, a Secretaria Acadêmica irá responder este e-mail com a nova senha temporária.'),
('Quem é o coordenador? (alunos ingressantes)', 'Cada curso na Fatec de Itapira possui um coordenador responsável por auxiliar os alunos. O Coordenador é um docente eleito pelos docentes e designado pela Direção para desempenhar um papel importante na orientação dos estudantes, no acompanhamento do currículo do curso e na resolução de questões acadêmicas relacionadas ao programa de estudos.
      O Coordenador do curso está disponível para esclarecer dúvidas, fornecer orientações sobre disciplinas, carga horária, estágios, projetos, entre outros assuntos relacionados ao curso. Além disso, o Coordenador pode ajudar a resolver questões administrativas e fornecer informações relevantes sobre a área de estudo do curso.
    Coordenadores:
    CST em Gestão da Produção Industrial – Prof. José Marcos Romão Júnior  (jose.romao@fatec.sp.gov.br)

    CST em Gestão Empresarial – Prof. Gilberto Brandão Marcon (gilberto.marcon@fatec.sp.gov.br)

    CST em Desenvolvimento de Software Multiplataforma – Profa. Márcia Regina Reggiolli (marcia.reggiolli@fatec.sp.gov.br)

    CST em Gestão da Tecnologia da Informação – Prof. Mateus Guilherme Fuini (mateus.fuini@fatec.sp.gov.br)> '),
('Posso usar a biblioteca/laboratório fora do horário de aula?', 'Sim, os alunos da Fatec de Itapira têm permissão para utilizar a biblioteca e as salas de estudos fora do horário de aula, desde que esses espaços estejam abertos e haja funcionários presentes. A Fatec de Itapira reconhece a importância do acesso a recursos educacionais e espaços adequados para estudo, e, portanto, permite que os alunos façam uso dessas instalações quando disponíveis.
      É importante ressaltar que o acesso à biblioteca e às salas de estudos fora do horário de aula pode variar de acordo com as políticas internas da instituição e as restrições aplicáveis em determinados períodos. Por isso, é recomendável verificar os horários de funcionamento e as regras específicas junto à administração da Fatec de Itapira ou com os responsáveis pela biblioteca e pelas salas de estudos.
      '),
('Qual o horário de funcionamento da biblioteca?', 'O horário de funcionamento da biblioteca e da sala de estudos neste 1º semestre de 2023 ocorre:
    Segunda-feira – das 14h às 19h e das 21h às 22h
    Terça-feira – das 17h às 22h
    Quarta-feira – das 13h às 22h
    Quinta-feira – das 18h às 20h
    Sexta-feira – das 13h às 18h
    Sábado – das 10h às 14h'),
('Quando abre o vestibular?', 'O Processo Seletivo Vestibular da Fatec de Itapira para ingresso de novos alunos acontece duas vezes por ano. Essas datas costumam ser nos últimos meses de cada semestre.
      As aulas para o 1º semestre geralmente começam na primeira quinzena do mês de fevereiro. Esse é o período em que os alunos aprovados no vestibular iniciam suas atividades acadêmicas na instituição.
      Já as aulas para o 2º semestre normalmente têm início na primeira quinzena do mês de agosto. Nesse momento, novos alunos aprovados no processo seletivo têm a oportunidade de começar sua trajetória na Fatec de Itapira.
      É importante lembrar que essas informações são baseadas em padrões gerais e podem estar sujeitas a alterações. Recomenda-se que os interessados em ingressar na Fatec de Itapira consultem o site oficial da instituição ou entrem em contato com a Fatec de Itapira para obter informações atualizadas sobre o calendário do processo seletivo e o início das aulas em cada semestre.
      '),
('Quais os cursos?', 'Atualmente a Fatec de Itapira oferece um total de 120 vagas, distribuídas entre os seguintes Cursos Superiores Tecnológicos:

      - CST em Gestão da Produção Industrial – saiba mais em https://fatecitapira.edu.br/gpi.html

      - CST em Gestão Empresarial – saiba mais em https://fatecitapira.edu.br/ge.html

      - CST em Desenvolvimento de Software Multiplataforma – saiba mais em https://fatecitapira.edu.br/dsm.html'),
('Posso trocar de curso?', 'De acordo com o Regulamento dos Cursos de Graduação das Fatecs existe a opção de transferência intercursos dentro das Fatecs, porém como pré-requisito o aluno deve possuir pelo menos metade das disciplinas do 1º semestre do curso desejado eliminadas com aproveitamento de estudos. Em seguida o candidato deverá acessar o site da Fatec de Itapira https://fatecitapira.edu.br e fazer o download do Edital de Transferência Interna. A divulgação do edital ocorre um pouco antes período das inscrições para transferência cujas datas estão especificadas no Calendário Escolar também disponível no site https://fatecitapira.edu.br.');

INSERT INTO pergunta_editada_por (pergunta_id) VALUES
(1), (2), (3), (4), (5), (6), (7), (8), (9), (10), (11), (12);

