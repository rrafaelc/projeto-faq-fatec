<?php
$baseUrl = 'http://localhost/projeto-faq-fatec';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../../styles/global.css" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../../img/favicon/site.webmanifest" />

  <script type="module" src="script.js" defer></script>
  <title>Sistema FAQ | Sugestões</title>
</head>

<body class="no-scroll">
  <?php
  $dir = '../..';
  ?>
  <main>
    <div class="sugestoes-base">
      <div class="dados">
        <div class="titulo">
          <h1>Sugestões</h1>
        </div>
        <table class="perguntas">
          <thead>
            <tr>
              <th>
                <span>Nome <i class="fas fa-sort-down"></i></span>
              </th>
              <th>
                <span>Email <i class="fas fa-sort-down"></i></span>
              </th>
              <th>
                <span>Telefone<i class="fas fa-sort-down"></i></span>
              </th>
              <th id="pergunta">
                <span>Sugestão <i class="fas fa-sort-down"></i></span>
              </th>
              <th>
                <span>Ações</span>
              </th>
            </tr>
          </thead>

          <tbody>
          </tbody>
        </table>
        <div class="paginacao">
          <div class="pg disabled">
            <span>Anterior</span>
          </div>
          <div class="numeros">
            <div class="numero active">1</div>
            <div class="numero">2</div>
            <div class="numero">3</div>
            <div class="numero">4</div>
            <div class="numero">5</div>
          </div>
          <div class="pg">
            <span>Próximo</span>
          </div>
        </div>
      </div>
    </div>
  </main>

</body>

</html>
