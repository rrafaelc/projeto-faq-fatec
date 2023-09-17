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
  <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../img/favicon/site.webmanifest" />
  <script src="script.js" defer></script>
  <script src="../scripts/global.js" defer></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
  <?php
  $dir = '..';
  $pagina = 'login';
  include "../layouts/header.php";
  ?>
  <div class="container">
    <h1>Fazer Login Sistema FAQ</h1>

    <form>
      <div id="email">
        <label for="email">Email</label>
        <input type="email" placeholder="Seu email" required />
      </div>
      <div id="senha">
        <label for="senha">Senha</label>
        <input type="password" placeholder="Sua senha" required />
      </div>

      <div class="g-recaptcha" data-sitekey="6Lf_9folAAAAAMU9IJsYU3y0wR4wzZHs7-Wo1ED7"></div>

      <button type="submit">Login</button>
    </form>

    <span class="info">Entre em contato com a Secretaria Acadêmica Fatec Itapira para criar conta ou resetar a
      senha</span>
  </div>

  <?php include "../layouts/footer.php" ?>
</body>

</html>