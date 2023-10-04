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

  <?php include "./layouts/footer.php" ?>
</body>

</html>