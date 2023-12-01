<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login no Sistema FAQ</title>
  <link rel="stylesheet" href="../styles/global.css" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../img/favicon/site.webmanifest" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script type="module" src="script.js" defer></script>
  <script src="../scripts/global.js" defer></script>
</head>

<body>
  <?php
  $dir = '..';
  $pagina = 'login';
  include "../layouts/header.php";
  ?>
  <div class="container">

    <h1>Fazer Login Sistema FAQ</h1>

    <form method="POST">
      <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" placeholder="Digite o email" required />
      </div>
      <div>
        <label for="senha">Senha</label>
        <div class="senha">
          <input id="senha" name="senha" type="password" placeholder="Digite a senha" required />
          <div class="eye-container">
            <i class="eye bi bi-eye-slash"></i>
          </div>
        </div>
      </div>

      <div class="submit">
        <button class="hideElement" type="submit">
          Login
        </button>
        <div class="spinner loader"></div>
        <span id="erro" class="hideElement">Email ou Senha incorretos</span>
      </div>
    </form>

    <span class="info">Entre em contato com a Secretaria Acadêmica Fatec Itapira para criar conta ou resetar a
      senha</span>
  </div>

  <?php include "../layouts/footer.php" ?>
</body>


</html>