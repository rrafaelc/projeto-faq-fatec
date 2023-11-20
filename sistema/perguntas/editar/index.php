<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../../../styles/global.css" />
  <link rel="stylesheet" href="https://fatecitapirafaq.mdbgo.io/sistema/perguntas/editar/styles.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../../../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../../../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../../../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../../../img/favicon/site.webmanifest" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <script type="module" src="https://fatecitapirafaq.mdbgo.io/sistema/perguntas/editar/script.js" defer></script>
  <title>Sistema FAQ | Editar Perguntas</title>
</head>

<body class="no-scroll">
  <?php
  $dir = '../../..';
  include '../../../layouts/painel-lateral.php';
  ?>
  <div class="spinnerFull">
    <div class="loader"></div>
  </div>

  <main>
    <div class="header">
      <div class="grupo">
        <h1 class="title">Editar pergunta</h1>
        <div class="subgrupo">
          <a href="../../../sistema">Início</a>
          <i class="fas fa-angle-right"></i>
          <span>Editar pergunta</span>
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
          <a href="../../../sistema/editar-dados">Editar dados</a>
          <a id="deslogar">Deslogar</a>
        </div>
      </div>
    </div>
    <div class="editar-pergunta">
      <div class="titulo">
        <h1>Editar pergunta</h1>
      </div>
      <form>
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" placeholder="Escreva o título da pergunta" required />
        <label for="resposta">Resposta</label>
        <textarea name="resposta" id="resposta" placeholder="Escreva a resposta da pergunta" required></textarea>
        <div>
          <div class="prioridade">
            <label for="prioridade">Defina o nível de prioridade</label>
            <input class="normal" type="button" id="prioridade" value="Normal" />
          </div>

          <div class="botoes">
            <a href="<?php echo isset($_SERVER['HTTP_REFERER'])
                        ? $_SERVER['HTTP_REFERER']
                        : '../../../sistema'; ?>">
              <button type="button" id="voltar">Voltar</button></a>
            <button type="submit">Editar</button>
          </div>
        </div>
      </form>
    </div>
  </main>
</body>

</html>