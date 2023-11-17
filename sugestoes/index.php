<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sugestões</title>
  <link rel="stylesheet" href="../styles/global.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../img/favicon/site.webmanifest" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="../scripts/global.js" defer></script>
  <script type="module" src="script.js" defer></script>
</head>

<body>
  <?php
  $dir = '..';
  $pagina = 'sugestoes';
  include "../layouts/header.php";
  ?>
  <main>
    <form class="box-sugestao">
      <h1 id="suaduvida">
        <span>Sua dúvida não foi respondida?</span>
        <span>Deixe sua sugestão e iremos analisar.</span>
      </h1>
      <div class="inputs">
        <div class="nome">
          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nome" required placeholder="Digite seu nome" />
        </div>
        <div>
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" required placeholder="Digite seu E-mail" />
        </div>
        <div>
          <label for="telefone">Telefone</label>
          <input type="text" id="phone" name="telefone" required placeholder="Digite seu telefone" />
        </div>
      </div>
      <div class="duvida-sugestao">
        <label for="mensagem">Dúvida/Sugestão</label>
        <textarea class="texto-sugestao" id="mensagem" name="mensagem" required placeholder="Digite sua dúvida ou sugestão"></textarea>
      </div>
      <button class="botao mostrar" type="submit">ENVIAR</button>
      <div class="spinner loader"></div>
    </form>
  </main>



  <?php include "../layouts/footer.php" ?>
</body>

</html>