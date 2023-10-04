<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../../../styles/global.css" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../../../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../../../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../../../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../../../img/favicon/site.webmanifest" />

  <script src="script.js" defer></script>
  <title>Sistema FAQ | Editar Perguntas</title>
</head>

<body>
  <?php
  $dir = '../../..';
  include '../../../layouts/painel-lateral.php';
  ?>

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
          <img src="https://github.com/timbl.png" />
        </div>
        <div class="nome">
          <span>Tim Berners-Lee</span>
          <span>Diretor(a)</span>
        </div>
        <i class="fas fa-angle-down botao"></i>
        <div class="dropdown">
          <a href="../../../sistema/editar-dados">Editar dados</a>
          <a href="../../../login">Deslogar</a>
        </div>
      </div>
    </div>
    <div class="editar-pergunta">
      <div class="titulo">
        <h1>Editar pergunta</h1>
      </div>
      <form>
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" placeholder="Escreva o título da pergunta" value="Qual é a duração dos cursos na Fatec?" required />
        <label for="resposta">Resposta</label>
        <textarea name="resposta" id="resposta" placeholder="Escreva a resposta da pergunta" required>
Os cursos da Fatec tem duração de no mínimo 3 anos e no máximo 5 anos.</textarea>
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