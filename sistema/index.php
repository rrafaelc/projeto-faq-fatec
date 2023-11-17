<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../styles/global.css" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../img/favicon/site.webmanifest" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="module" src="script.js"></script>
  <title>Sistema FAQ</title>
</head>

<body class="no-scroll">

  <?php
  $dir = '..';
  include '../layouts/painel-lateral.php';
  ?>
  <div class="spinnerFull">
    <div class="loader"></div>
  </div>
  <main>
    <div class="header">
      <div class="grupo">
        <h1 class="title">Início</h1>
        <div class="subgrupo">
          <a href="../sistema">Início</a>
        </div>
      </div>
      <div class="usuario">
        <div class="foto">
          <img src="" />
        </div>
        <div class="nome">
          <span class="nome_completo"></span>
          <span class="cargo"></span>
        </div>
        <i class="fas fa-angle-down botao"></i>
        <div class="dropdown">
          <a href="../sistema/editar-dados">Editar dados</a>
          <a id="deslogar">Deslogar</a>
        </div>
      </div>
    </div>
    <div class="cards">
      <div class="card">
        <div class="icon">
          <i class="fas fa-database"></i>
        </div>
        <div class="info">
          <div id="totais-pergunta" class="numero"></div>
          <div class="descricao">Total de perguntas</div>
        </div>
      </div>
      <div class="card">
        <div class="icon prioridade">
          <i class="fas fa-exclamation"></i>
        </div>
        <div class="info">
          <div id="totais-alta" class="numero"></div>
          <div class="descricao">Total de prioridades</div>
        </div>
      </div>
      <div class="card">
        <div class="icon">
          <i class="fas fa-thumbs-up"></i>
        </div>
        <div class="info">
          <div id="totais-curtidas" class="numero"></div>
          <div class="descricao">Total de curtidas</div>
        </div>
      </div>
    </div>
    <div class="dados">
      <table class="perguntas">
        <thead>
          <tr>
            <th>
              <span>ID</span>
            </th>
            <th>
              <span>Colaborador</span>
            </th>
            <th id="pergunta">
              <span>Pergunta</span>
            </th>
            <th>
              <span>Editado por</span>
            </th>
            <th>
              <span>Prioridade</span>
            </th>
            <th>
              <span>Data de edição</span>
            </th>
            <th>
              <span>Ação</span>
            </th>
          </tr>
        </thead>
        <tbody class="perguntas-tbody">
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
  </main>
</body>

</html>