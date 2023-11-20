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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="./scripts/autocomplete/css/autoComplete.custom.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="index.js" type="module" defer></script>
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
        <div class="autoComplete_wrapper">
          <input disabled placeholder="Quando abre o vestibular?" id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off" maxlength="2048" tabindex="1">
        </div>
      </div>
    </div>
  </section>

  <main>
    <div class="spinnerContainer mostrar">
      <div class="spinner loader"></div>
    </div>
    <div class="wrapper">
      <div class="container"></div>

    </div>
  </main>

  <div class="paginacao">
    <div class="pg">
      <span class="pg-inicio-perguntas disabled" title="Ínicio"><i class="bi bi-chevron-double-left"></i></span>
      <span class="pg-anterior-perguntas disabled" title="Anterior"><i class="bi bi-chevron-left"></i></span>
    </div>
    <div class="numeros pg-numeros-perguntas">
    </div>
    <div class="pg">
      <span class="pg-proximo-perguntas" title="Próximo"><i class="bi bi-chevron-right"></i></span>
      <span class="pg-ultimo-perguntas" title="Último"><i class="bi bi-chevron-double-right"></i></span>
    </div>
  </div>

  <?php include "./layouts/footer.php" ?>
</body>

</html>