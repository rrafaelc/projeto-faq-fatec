<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../../styles/global.css" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../../img/favicon/site.webmanifest" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="module" src="script.js" defer></script>
  <title>Sistema FAQ | Colaboladores</title>
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
        <h1 class="title">Colaboladores</h1>
        <div class="subgrupo">
          <a href="../../sistema">Início</a>
          <i class="fas fa-angle-right"></i>
          <span>Colaboladores</span>
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
    <div class="criar-conta">
      <div class="titulo">
        <h1>Criar conta</h1>
        <i class="fas fa-angle-down botao"></i>
      </div>
      <form>
        <label for="conta-nome">Nome</label>
        <input type="text" name="nome" id="conta-nome" placeholder="Escreva o nome do colaborador" required />
        <label for="conta-email">E-mail</label>
        <input type="email" name="email" id="conta-email" placeholder="Escreva o e-mail do colaborador" required />
        <label for="conta-senha">Senha</label>
        <div id="senha">
          <input type="password" name="senha" id="conta-senha" placeholder="Escreva a senha do colaborador" required />
          <div class="eye-container">
            <i class="eye bi bi-eye-slash"></i>
          </div>
        </div>
        <label for="conta-confirmar-senha">Confirmar senha</label>
        <div id="confirmarSenha">
          <input type="password" name="confirmar-senha" id="conta-confirmar-senha" placeholder="Confirme a senha do colaborador" required />
          <div class="eye-container">
            <i class="eye bi bi-eye-slash"></i>
          </div>
        </div>

        <button type="submit">Criar conta</button>
      </form>
    </div>
    <div class="dados">
      <table id="tabela" class="usuarios-tabela">
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