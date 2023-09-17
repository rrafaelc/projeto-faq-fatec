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

  <script src="script.js" defer></script>
  <title>Sistema FAQ | Curtidas</title>
</head>

<body>
  <?php
  $dir = '../..';
  include '../../layouts/painel-lateral.php';
  ?>
  <main>
    <div class="header">
      <div class="grupo">
        <h1 class="title">Curtidas</h1>
        <div class="subgrupo">
          <a href="../../sistema">Início</a>
          <i class="fas fa-angle-right"></i>
          <span>Curtidas</span>
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
          <a href="../../sistema/editar-dados">Editar dados</a>
          <a href="../../login">Deslogar</a>
        </div>
      </div>
    </div>
    <div class="opcoes-div">
      <div class="titulo">
        <h1>Opções</h1>
      </div>
      <form>
        <div class="opcoes">
          <div class="opcao">
            <input type="radio" name="opcao" id="suas-perguntas" value="suas-perguntas" checked />
            <label for="suas-perguntas">Suas perguntas</label>
          </div>
          <div class="opcao">
            <input type="radio" name="opcao" id="outros" value="outros" />
            <label for="outros">Outros</label>
          </div>
        </div>
      </form>
    </div>
    <div class="dados">
      <table class="perguntas">
        <thead>
          <tr>
            <th>
              <span>ID <i class="fas fa-sort-down"></i></span>
            </th>
            <th class="nao-mostrar">
              <span>Colaborador <i class="fas fa-sort-down"></i></span>
            </th>
            <th id="pergunta">
              <span>Pergunta <i class="fas fa-sort-down"></i></span>
            </th>
            <th id="curtidas">
              <span>Curtidas <i class="fas fa-sort-down"></i></span>
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
            <td class="nao-mostrar">
              <div id="colaborador">
                <div class="avatar">
                  <img src="../../img/junior.jpeg" />
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
              <div id="curtidas"><span>16</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
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
            <td class="nao-mostrar">
              <div id="colaborador">
                <div class="avatar">
                  <img src="../../img/thiago.jpeg" />
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
              <div id="curtidas"><span>7</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
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
            <td class="nao-mostrar">
              <div id="colaborador">
                <div class="avatar">
                  <img src="../../img/marcia.jpeg" />
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
              <div id="curtidas"><span>4</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
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
            <td class="nao-mostrar">
              <div id="colaborador">
                <div class="avatar">
                  <img src="../../img/thiago.jpeg" />
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
              <div id="curtidas"><span>10</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
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
            <td class="nao-mostrar">
              <div id="colaborador">
                <div class="avatar">
                  <img src="../../img/junior.jpeg" />
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
              <div id="curtidas"><span>12</span></div>
            </td>
            <td>
              <div id="acao">
                <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="paginacao nao-mostrar">
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