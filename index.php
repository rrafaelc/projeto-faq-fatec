<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FAQ FATEC</title>
  <link rel="stylesheet" href="./styles/global.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="./img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="./img/favicon/site.webmanifest" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <script src="index.js" defer></script>
  <script src="./scripts/global.js" defer></script>
</head>

<body>
  <?php
  $dir = '.';
  $pagina = 'principal';
  include "./layouts/header.php";
  ?>

  <section id="keywordSection">
    <div class="keyword-container">
      <div class="keyword-content">
        <h1>Filtre sua dúvida</h1>
        <form id="formulary">
          <div class="input-container">
            <i class="fas fa-search"></i>
            <input id="search-input" type="text" placeholder="Ex: O que é a Fatec Itapira?" />
          </div>
        </form>
      </div>
    </div>
  </section>
  <main>
    <div class="wrapper">
      <div class="container"></div>
    </div>
  </main>
  <footer>
    <div class="footer-container">
      <div class="fatec-contact">
        <h1>Fatec Itapira</h1>
        <h2><span>Endereço: </span>Rua Tereza Lera Paoletti, 570/590 - Jardim Bela Vista</h2>
        <h2><span>CEP: </span>13974-080</h2>
        <h2><span>Telefone: </span> (19) 3843-1996</h2>
        <h2><span>Whatsapp: </span> (19) 98933-6291 | (19) 3863-5210</h2>
        <h2><span>E-mail: </span> contato@fatecitapira.edu.br</h2>
      </div>
      <a href="https://fatecitapira.edu.br/" target="_blank" class="fatec-footer-logo">
        <img src="/img/fatec footer branco.png" alt="Logo fatec" />
      </a>
      <div class="cps-logo-footer">
        <a href="https://www.cps.sp.gov.br/" target="_blank" class="img-1">
          <img src="/img/logo_cps_versao_br.png" alt="logo centro paula souza" />
        </a>
        <a href="https://www.saopaulo.sp.gov.br/" target="_blank" class="img-2">
          <img src="/img/GOV_LOGO_HORIZONTAL_versaÌ_o MONOCROMATICA BRANCA.png" alt="logo governo do estado de sp" />
        </a>
      </div>
    </div>
    <div class="copyright">
      <p>
        Copyright © <span id="copyright-date"></span> Fatec Itapira - Todos os Direitos Reservados
        - Desenvolvido pelos alunos de DSM do 1º Semestre de 2023
      </p>
    </div>
  </footer>
</body>

</html>