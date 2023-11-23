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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="../../scripts/autocomplete/css/autoComplete.custom.01.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script type="module" src="script.js" defer></script>
  <title>Sistema FAQ | Pesquisar</title>
</head>

<body class="no-scroll">
  <?php
  $dir = '../..';
  include '../../layouts/painel-lateral.php';
  ?>
  <div class="spinnerFull">
    <div class="loader"></div>
  </div>
  <main>
    <div class="header">
      <div class="grupo">
        <h1 class="title">Pesquisar</h1>
        <div class="subgrupo">
          <a href="../../sistema">Início</a>
          <i class="fas fa-angle-right"></i>
          <span>Pesquisar</span>
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
          <a href="../../sistema/editar-dados">Editar dados</a>
          <a id="deslogar">Deslogar</a>
        </div>
      </div>
    </div>
    <div class="pesquisar-por">
      <div class="autoComplete_wrapper">
        <input disabled placeholder="Quando abre o vestibular?" id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off" maxlength="2048" tabindex="1">
      </div>
    </div>
    <div class="dados">
      <table class="perguntas">
        <thead>
          <tr>
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
        <tbody class="perguntas-tbody"></tbody>
      </table>
      <div class="spinnerContainer mostrar">
        <div class="spinner loader"></div>
      </div>
      <div class="paginacao">
        <div class="pg">
          <span class="pg-inicio-pesquisar disabled" title="Ínicio"><i class="bi bi-chevron-double-left"></i></span>
          <span class="pg-anterior-pesquisar disabled" title="Anterior"><i class="bi bi-chevron-left"></i></span>
        </div>
        <div class="numeros pg-numeros-pesquisar">
        </div>
        <div class="pg">
          <span class="pg-proximo-pesquisar" title="Próximo"><i class="bi bi-chevron-right"></i></span>
          <span class="pg-ultimo-pesquisar" title="Último"><i class="bi bi-chevron-double-right"></i></span>
        </div>
      </div>
    </div>
  </main>
</body>

</html>