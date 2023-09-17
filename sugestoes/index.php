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
  <script src="../scripts/global.js" defer></script>
  <script src="script.js" defer></script>
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
        <div class="email">
          <label for="email">Email</label>
          <input id="email" type="email" name="email" required placeholder="Digite seu email" />
        </div>
      </div>
      <label class="aluno" for="aluno">Você é aluno da Fatec?</label>
      <div id="sim-nao">
        <input type="radio" name="aluno" value="sim" id="sim" />
        <label for="sim">Sim</label>

        <input type="radio" name="aluno" value="nao" id="nao" />
        <label for="nao">Não</label>
      </div>
      <div class="duvida-sugestao">
        <label for="mensagem">Dúvida/Sugestão</label>
        <textarea cols="50" rows="50" class="texto-sugestao" id="mensagem" name="mensagem" required placeholder="Digite sua dúvida ou sugestão"></textarea>
      </div>
      <button class="botao" type="submit">ENVIAR</button>
    </form>
  </main>

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
      <div class="fatec-footer-logo">
        <img src="../img/fatec footer branco.png" alt="Logo fatec" />
      </div>
      <div class="cps-logo-footer">
        <div class="img-1">
          <img src="../img/logo_cps_versao_br.png" alt="logo centro paula souza" />
        </div>
        <div class="img-2">
          <img src="../img/GOV_LOGO_HORIZONTAL_versaÌ_o MONOCROMATICA BRANCA.png" alt="logo governo do estado de sp" />
        </div>
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