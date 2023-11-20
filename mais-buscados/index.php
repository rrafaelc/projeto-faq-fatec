<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mais Buscados</title>
  <link rel="stylesheet" href="../styles/global.css" />
  <link rel="stylesheet" href="https://fatecitapirafaq.mdbgo.io/mais-buscados/style.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../img/favicon/site.webmanifest" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script type='module' src="https://fatecitapirafaq.mdbgo.io/mais-buscados/script.js" defer></script>
  <script src="../scripts/global.js" defer></script>
</head>

<body>
  <?php
  $dir = '..';
  $pagina = 'mais-buscados';
  include "../layouts/header.php";
  ?>

  <main>
    <div class="spinnerContainer mostrar">
      <div class="spinner loader"></div>
    </div>
    <div class="wrapper">
      <div class="container">
      </div>
    </div>
    <div class="paginacao">
      <div class="pg">
        <span class="pg-inicio-mais-buscados disabled" title="Ínicio"><i class="bi bi-chevron-double-left"></i></span>
        <span class="pg-anterior-mais-buscados disabled" title="Anterior"><i class="bi bi-chevron-left"></i></span>
      </div>
      <div class="numeros pg-numeros-mais-buscados">
      </div>
      <div class="pg">
        <span class="pg-proximo-mais-buscados" title="Próximo"><i class="bi bi-chevron-right"></i></span>
        <span class="pg-ultimo-mais-buscados" title="Último"><i class="bi bi-chevron-double-right"></i></span>
      </div>
    </div>
  </main>

  <?php include "../layouts/footer.php" ?>
</body>

</html>