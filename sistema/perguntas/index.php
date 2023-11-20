<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../../styles/global.css" />
  <link rel="stylesheet" href="https://fatecitapirafaq.mdbgo.io/sistema/perguntas/styles.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../../img/favicon/site.webmanifest" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="module" src="https://fatecitapirafaq.mdbgo.io/sistema/perguntas/script.js" defer></script>
  <title>Sistema FAQ | Perguntas</title>
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
        <h1 class="title">Perguntas</h1>
        <div class="subgrupo">
          <a href="../../sistema">Início</a>
          <i class="fas fa-angle-right"></i>
          <span>Perguntas</span>
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

    <div class="container sugestao-container">
      <div class="titulo titulo-sugestao">
        <h1>Sugestões dos visitantes</h1>
        <i class="fas fa-angle-down botao"></i>
      </div>
      <div class="dados-sugestoes">
        <table class="sugestoes">
          <thead>
            <tr>
              <th>
                <span>Nome</span>
              </th>
              <th>
                <span>Email</span>
              </th>
              <th>
                <span>Telefone</span>
              </th>
              <th id="pergunta">
                <span>Sugestão</span>
              </th>
              <th class="th-acao-sugestao">
                <span>Ações</span>
              </th>
            </tr>
          </thead>
          <tbody class="sugestoes-tbody">
          </tbody>
        </table>
        <div class="spinnerContainer mostrar">
          <div class="spinner loader"></div>
        </div>
        <div class="paginacao">
          <div class="pg">
            <span class="pg-inicio-sugestoes disabled" title="Ínicio"><i class="bi bi-chevron-double-left"></i></span>
            <span class="pg-anterior-sugestoes disabled" title="Anterior"><i class="bi bi-chevron-left"></i></span>
          </div>
          <div class="numeros pg-numeros-sugestoes">
          </div>
          <div class="pg">
            <span class="pg-proximo-sugestoes" title="Próximo"><i class="bi bi-chevron-right"></i></span>
            <span class="pg-ultimo-sugestoes" title="Último"><i class="bi bi-chevron-double-right"></i></span>
          </div>
        </div>
      </div>
    </div>

    <div class="container adicionar-pergunta">
      <div class="titulo titulo-pergunta">
        <h1>Adicionar pergunta</h1>
        <i class="fas fa-angle-down botao"></i>
      </div>
      <form>
        <input id="sugestao-id" name="sugestao-id" type="hidden">
        <label class="pergunta-sugestao-classe" for="pergunta-sugestao">Responda a essa sugestão</label>
        <textarea name="pergunta-sugestao" id="pergunta-sugestao" class="pergunta-sugestao-classe" disabled></textarea>
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" placeholder="Escreva o título da pergunta" required />
        <label for="resposta">Resposta</label>
        <textarea name="resposta" id="resposta" placeholder="Escreva a resposta da pergunta" required></textarea>
        <div>
          <div class="prioridade">
            <label for="prioridade">Defina o nível de prioridade</label>
            <input class="normal" type="button" id="prioridade" value="Normal" />
          </div>
          <button class="enviar" type="submit">Adicionar</button>
        </div>
      </form>
    </div>

    <div class="dados">
      <div class="titulo">
        <h1>Suas perguntas</h1>
      </div>
      <table class="perguntas">
        <thead>
          <tr>
            <th>
              <span>ID</span>
            </th>
            <th id="pergunta">
              <span>Pergunta</span>
            </th>
            <th>
              <span>Editado por</span>
            </th>
            <th>
              <span>Prioridade</span>
            </th>
            <th>
              <span>Data de edição</span>
            </th>
            <th>
              <span>Ação</span>
            </th>
          </tr>
        </thead>
        <tbody class="suas-perguntas-tbody">
        </tbody>
      </table>
      <div class="spinnerContainerSuasPerguntas mostrar">
        <div class="spinner loader spinner-suas-perguntas"></div>
      </div>
      <div class="paginacao">
        <div class="pg">
          <span class="pg-inicio-suas-perguntas disabled" title="Ínicio"><i class="bi bi-chevron-double-left"></i></span>
          <span class="pg-anterior-suas-perguntas disabled" title="Anterior"><i class="bi bi-chevron-left"></i></span>
        </div>
        <div class="numeros pg-numeros-suas-perguntas">
        </div>
        <div class="pg">
          <span class="pg-proximo-suas-perguntas" title="Próximo"><i class="bi bi-chevron-right"></i></span>
          <span class="pg-ultimo-suas-perguntas" title="Último"><i class="bi bi-chevron-double-right"></i></span>
        </div>
      </div>
    </div>
  </main>
</body>

</html>