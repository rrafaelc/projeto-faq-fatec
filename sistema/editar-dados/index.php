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
  <title>Sistema FAQ | Editar dados</title>
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
        <h1 class="title">Editar dados</h1>
        <div class="subgrupo">
          <a href="../../sistema">Início</a>
          <i class="fas fa-angle-right"></i>
          <span>Editar dados</span>
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

    <div class="editar-dados">
      <div class="titulo">
        <h1>Editar dados</h1>
        <span>Deixe em branco dados que não deseja alterar</span>
      </div>
      <form>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" placeholder="Nome" />

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email" />

        <label for="senha">Nova senha</label>
        <input type="password" name="senha" id="senha" placeholder="Nova senha" />

        <label for="confirmar-senha">Confirmar senha</label>
        <input type="password" name="confirmar-senha" id="confirmar-senha" placeholder="Digite a senha novamente" />

        <label for="foto">Foto</label>
        <input type="text" name="foto" id="foto" placeholder="URL da foto" />

        <label for="senha-atual">Senha atual (obrigatório)</label>
        <input type="password" name="senha-atual" id="senha-atual" placeholder="Senha atual" required />

        <button type="submit">Atualizar dados</button>
      </form>
    </div>
  </main>
</body>

</html>