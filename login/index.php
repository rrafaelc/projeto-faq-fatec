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
  <footer>
    <div class="footer-container">
      <div class="fatec-contact">
        <h1>Fatec Itapira</h1>
        <h2><span>Endereço: </span>Rua Tereza Lera Paoletti, 570/590 - Jardim Bela Vista</h2>
        <h2><span>CEP: </span>13974-080</h2>
        <h2><span>Telefone: </span> (19) 3843-1996</h2>
        <h2><span>Whatsapp: </span> (19) 98933-6291 | (19) 3863-5210</h2>
        <h2><span>E-mail: </span> contato@fatecitapira.edu.br</h2>
      </div>
      <a href="https://fatecitapira.edu.br/" target="_blank" class="fatec-footer-logo">
        <img src="/img/fatec footer branco.png" alt="Logo fatec" />
      </a>
      <div class="cps-logo-footer">
        <a href="https://www.cps.sp.gov.br/" target="_blank" class="img-1">
          <img src="/img/logo_cps_versao_br.png" alt="logo centro paula souza" />
        </a>
        <a href="https://www.saopaulo.sp.gov.br/" target="_blank" class="img-2">
          <img src="/img/GOV_LOGO_HORIZONTAL_versaÌ_o MONOCROMATICA BRANCA.png" alt="logo governo do estado de sp" />
        </a>
      </div>
    </div>
    <div class="copyright">
      <p>
        Copyright © <span id="copyright-date"></span> Fatec Itapira - Todos os Direitos Reservados
        - Desenvolvido pelos alunos de DSM do 1º Semestre de 2023
      </p>
    </div>
  </footer>
</body>

</html>