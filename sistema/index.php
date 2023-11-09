<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../styles/global.css" />
  <link rel="stylesheet" href="https://faqfatecitapira-projeto-faq-fatec.mdbgo.io/sistema/styles.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../img/favicon/site.webmanifest" />

  <script type="module" src="https://faqfatecitapira-projeto-faq-fatec.mdbgo.io/sistema/script.js"></script>
  <title>Sistema FAQ</title>
</head>

<body class="no-scroll">

  <?php
  $dir = '..';
  include '../layouts/painel-lateral.php';
  ?>
  <div class="spinnerFull">
    <div class="loader"></div>
  </div>
  <main>
    <div class="header">
      <div class="grupo">
        <h1 class="title">Início</h1>
        <div class="subgrupo">
          <a href="../sistema">Início</a>
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
          <a href="../sistema/editar-dados">Editar dados</a>
          <a id="deslogar">Deslogar</a>
        </div>
      </div>
    </div>
    <div class="cards">
      <div class="card">
        <div class="icon">
          <i class="fas fa-database"></i>
        </div>
        <div class="info">
          <div class="numero">135</div>
          <div class="descricao">Total de perguntas</div>
        </div>
      </div>
      <div class="card">
        <div class="icon prioridade">
          <i class="fas fa-exclamation"></i>
        </div>
        <div class="info">
          <div class="numero">26</div>
          <div class="descricao">Total de prioridades</div>
        </div>
      </div>
      <div class="card">
        <div class="icon">
          <i class="fas fa-heart"></i>
        </div>
        <div class="info">
          <div class="numero">541</div>
          <div class="descricao">Total de curtidas</div>
        </div>
      </div>
    </div>
    <div class="dados">
      <table class="perguntas">
        <thead>
          <tr>
            <th>
              <span>ID <i class="fas fa-sort-down"></i></span>
            </th>
            <th>
              <span>Colaborador <i class="fas fa-sort-down"></i></span>
            </th>
            <th id="pergunta">
              <span>Pergunta <i class="fas fa-sort-down"></i></span>
            </th>
            <th>
              <span>Editado por <i class="fas fa-sort-down"></i></span>
            </th>
            <th>
              <span>Prioridade <i class="fas fa-sort-down"></i></span>
            </th>
            <th>
              <span>Data de edição <i class="fas fa-sort-down"></i></span>
            </th>
            <th>
              <span>Ação</span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div id="id">
                <span>1</span>
              </div>
            </td>
            <td>
              <div id="colaborador">
                <div class="avatar">
                  <img src="../img/junior.jpeg" />
                </div>
                <div class="nome">
                  <span>Júnior</span>
                  <span>Gonçalves</span>
                </div>
              </div>
            </td>
            <td>
              <div id="pergunta">
                A Fatec oferece algum tipo de suporte para alunos com dificuldades de
                aprendizagem?
              </div>
            </td>
            <td>
              <div id="editado" class="avatar">
                <img src="../img/junior.jpeg" />
              </div>
            </td>
            <td>
              <div id="prioridade" class="alta">
                <span>Alta</span>
              </div>
            </td>

            <td>
              <div id="edicao"><span>08/11/2023</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td>
              <div id="id">
                <span>2</span>
              </div>
            </td>
            <td>
              <div id="colaborador">
                <div class="avatar">
                  <img src="../img/thiago.jpeg" />
                </div>
                <div class="nome">
                  <span>Thiago</span>
                  <span>Alves</span>
                </div>
              </div>
            </td>
            <td>
              <div id="pergunta">
                Quais são as possibilidades de carreira para os profissionais formados na Fatec?
              </div>
            </td>
            <td>
              <div id="editado" class="avatar">
                <img src="../img/thiago.jpeg" />
              </div>
            </td>
            <td>
              <div id="prioridade" class="normal">
                <span>Normal</span>
              </div>
            </td>

            <td>
              <div id="edicao"><span>08/11/2023</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td>
              <div id="id">
                <span>3</span>
              </div>
            </td>
            <td>
              <div id="colaborador">
                <div class="avatar">
                  <img src="../img/marcia.jpeg" />
                </div>
                <div class="nome">
                  <span>Marcia</span>
                  <span>Reggiolli</span>
                </div>
              </div>
            </td>
            <td>
              <div id="pergunta">Quais são as formas de ingresso na Fatec?</div>
            </td>
            <td>
              <div id="editado" class="avatar">
                <img src="../img/marcia.jpeg" />
              </div>
            </td>
            <td>
              <div id="prioridade" class="normal">
                <span>Normal</span>
              </div>
            </td>

            <td>
              <div id="edicao"><span>08/11/2023</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td>
              <div id="id">
                <span>4</span>
              </div>
            </td>
            <td>
              <div id="colaborador">
                <div class="avatar">
                  <img src="../img/thiago.jpeg" />
                </div>
                <div class="nome">
                  <span>Thiago</span>
                  <span>Alves</span>
                </div>
              </div>
            </td>
            <td>
              <div id="pergunta">
                A Fatec oferece algum tipo de suporte para alunos com dificuldades de
                aprendizagem?
              </div>
            </td>
            <td>
              <div id="editado" class="avatar">
                <img src="../img/thiago.jpeg" />
              </div>
            </td>
            <td>
              <div id="prioridade" class="alta">
                <span>Alta</span>
              </div>
            </td>

            <td>
              <div id="edicao"><span>08/11/2023</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td>
              <div id="id">
                <span>5</span>
              </div>
            </td>
            <td>
              <div id="colaborador">
                <div class="avatar">
                  <img src="../img/junior.jpeg" />
                </div>
                <div class="nome">
                  <span>Júnior</span>
                  <span>Gonçalves</span>
                </div>
              </div>
            </td>
            <td>
              <div id="pergunta">
                A Fatec oferece algum tipo de suporte para alunos com dificuldades de
                aprendizagem?
              </div>
            </td>
            <td>
              <div id="editado" class="avatar">
                <img src="../img/junior.jpeg" />
              </div>
            </td>
            <td>
              <div id="prioridade" class="alta">
                <span>Alta</span>
              </div>
            </td>

            <td>
              <div id="edicao"><span>08/11/2023</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td>
              <div id="id">
                <span>6</span>
              </div>
            </td>
            <td>
              <div id="colaborador">
                <div class="avatar">
                  <img src="../img/thiago.jpeg" />
                </div>
                <div class="nome">
                  <span>Thiago</span>
                  <span>Alves</span>
                </div>
              </div>
            </td>
            <td>
              <div id="pergunta">
                Quais são as possibilidades de carreira para os profissionais formados na Fatec?
              </div>
            </td>
            <td>
              <div id="editado" class="avatar">
                <img src="../img/thiago.jpeg" />
              </div>
            </td>
            <td>
              <div id="prioridade" class="normal">
                <span>Normal</span>
              </div>
            </td>

            <td>
              <div id="edicao"><span>08/11/2023</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td>
              <div id="id">
                <span>7</span>
              </div>
            </td>
            <td>
              <div id="colaborador">
                <div class="avatar">
                  <img src="../img/marcia.jpeg" />
                </div>
                <div class="nome">
                  <span>Marcia</span>
                  <span>Reggiolli</span>
                </div>
              </div>
            </td>
            <td>
              <div id="pergunta">Quais são as formas de ingresso na Fatec?</div>
            </td>
            <td>
              <div id="editado" class="avatar">
                <img src="../img/marcia.jpeg" />
              </div>
            </td>
            <td>
              <div id="prioridade" class="normal">
                <span>Normal</span>
              </div>
            </td>

            <td>
              <div id="edicao"><span>08/11/2023</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td>
              <div id="id">
                <span>8</span>
              </div>
            </td>
            <td>
              <div id="colaborador">
                <div class="avatar">
                  <img src="../img/thiago.jpeg" />
                </div>
                <div class="nome">
                  <span>Thiago</span>
                  <span>Alves</span>
                </div>
              </div>
            </td>
            <td>
              <div id="pergunta">
                A Fatec oferece algum tipo de suporte para alunos com dificuldades de
                aprendizagem?
              </div>
            </td>
            <td>
              <div id="editado" class="avatar">
                <img src="../img/thiago.jpeg" />
              </div>
            </td>
            <td>
              <div id="prioridade" class="alta">
                <span>Alta</span>
              </div>
            </td>

            <td>
              <div id="edicao"><span>08/11/2023</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
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