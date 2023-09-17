<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/global.css" />
  <link href="styles.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../img/favicon/site.webmanifest" />
  <script src="../scripts/global.js" defer></script>
  <title>Sobre</title>
</head>

<body>
  <?php
  $dir = '..';
  $pagina = 'sobre';
  include "../layouts/header.php";
  ?>

  <section>
    <div class="container">
      <div class="corpo-site">
        <div>
          <h1>Tecnologias Utilizadas no Projeto</h1>
        </div>
        <div class="lista">
          <div>
            <i class="fa-brands fa-html5"></i>
            <p>HTML</p>
          </div>
          <div>
            <i class="fa-brands fa-css3-alt"></i>
            <p>CSS</p>
          </div>
          <div>
            <i class="fa-brands fa-figma"></i>
            <p>Figma</p>
          </div>
          <div>
            <i class="fa-brands fa-js"></i>
            <p>JavaScript</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <main>
    <div class="integrantes">
      <h1>Integrantes</h1>
      <div class="integrantes-info">
        <div class="avatar">
          <img src="../img/sobre/claudinei_pereira.png" alt="Claudinei Rodrigues" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/claudinei-pereira-rodrigues/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="" />
              <h5>Claudinei Rodrigues</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/João_Pedro_Doni.png" alt="João Pedro Doni" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/jo%C3%A3o-pedro-doni/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="" />
              <h5>João Pedro Doni</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/Luan_Francisco.png" alt="Luan Francisco" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/luan-frc/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="" />
              <h5>Luan Francisco</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/Erick_Silva.png" alt="Erick Vinicius Perereira Silva" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/erickvps/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="" />
              <h5>Erick P Silva</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/Leandro_Ribeiro.png" alt="Leandro Ribeiro" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/leandro-ribeiro82/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="" />
              <h5>Leandro Ribeiro</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/Rafael_Costa.png" alt="Rafael Costa" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/rrafaelc/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="" />
              <h5>Rafael Costa</h5>
            </a>
          </div>
        </div>
      </div>
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