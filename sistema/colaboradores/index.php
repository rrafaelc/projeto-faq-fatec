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
  <link rel="stylesheet" href="https://fatecitapirafaq.mdbgo.io/sistema/colaboradores/styles.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../../img/favicon/site.webmanifest" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="module" src="https://fatecitapirafaq.mdbgo.io/sistema/colaboradores/script.js" defer></script>
  <title>Sistema FAQ | Colaboradores</title>
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
        <h1 class="title">Colaboradores</h1>
        <div class="subgrupo">
          <a href="../../sistema">Início</a>
          <i class="fas fa-angle-right"></i>
          <span>Colaboradores</span>
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
        <thead>
          <tr>
            <th>
              <span>Colaborador</span>
            </th>
            <th id="cargo">
              <span>Cargo</span>
            </th>
            <th id="suspenso">
              <span>Suspenso</span>
            </th>
            <th></th>
          </tr>
        </thead>
        <tbody class="colaboradores-tbody"></tbody>
      </table>
      <div class="spinnerContainer mostrar">
        <div class="spinner loader"></div>
      </div>
      <div class="paginacao">
        <div class="pg">
          <span class="pg-inicio-sistema-usuarios disabled" title="Ínicio"><i class="bi bi-chevron-double-left"></i></span>
          <span class="pg-anterior-sistema-usuarios disabled" title="Anterior"><i class="bi bi-chevron-left"></i></span>
        </div>
        <div class="numeros pg-numeros-sistema-usuarios">
        </div>
        <div class="pg">
          <span class="pg-proximo-sistema-usuarios" title="Próximo"><i class="bi bi-chevron-right"></i></span>
          <span class="pg-ultimo-sistema-usuarios" title="Último"><i class="bi bi-chevron-double-right"></i></span>
        </div>
      </div>
    </div>
  </main>
</body>

</html>