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
            <i class="fa-brands fa-php"></i>
            <p>PHP</p>
          </div>
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
              <img src="../img/sobre/linkedin.png" alt="Claudinei Rodrigues" />
              <h5>Claudinei Rodrigues</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/João_Pedro_Doni.jpeg" alt="João Pedro Doni" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/jo%C3%A3o-pedro-doni/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="João Pedro Doni" />
              <h5>João Pedro Doni</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/Luan_Francisco.jpeg" alt="Luan Francisco" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/luan-frc/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="Luan Francisco" />
              <h5>Luan Francisco</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/Erick_Silva.png" alt="Erick Vinicius Perereira Silva" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/erickvps/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="Erick P Silva" />
              <h5>Erick P Silva</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/Leandro_Ribeiro.png" alt="Leandro Ribeiro" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/leandro-ribeiro82/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="Leandro Ribeiro" />
              <h5>Leandro Ribeiro</h5>
            </a>
          </div>
        </div>
        <div class="avatar">
          <img src="../img/sobre/Rafael_Costa.jpeg" alt="Rafael Costa" />
          <div class="linkedin">
            <a href="https://www.linkedin.com/in/rrafaelc/" target="_blank">
              <img src="../img/sobre/linkedin.png" alt="Rafael Costa" />
              <h5>Rafael Costa</h5>
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include "../layouts/footer.php" ?>
</body>

</html>
