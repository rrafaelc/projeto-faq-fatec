<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://kit.fontawesome.com/1aacb3a88a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../../styles/global.css" />
  <link rel="stylesheet" href="https://faqfatecitapira-projeto-faq-fatec.mdbgo.io/sistema/pesquisar/styles.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png" />
  <link rel="manifest" href="../../img/favicon/site.webmanifest" />

  <script type="module" src="https://faqfatecitapira-projeto-faq-fatec.mdbgo.io/sistema/pesquisar/script.js" defer></script>
  <title>Sistema FAQ | Pesquisar</title>
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
        <h1 class="title">Pesquisar</h1>
        <div class="subgrupo">
          <a href="../../sistema">Início</a>
          <i class="fas fa-angle-right"></i>
          <span>Pesquisar</span>
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
    <div class="pesquisar-por">
      <div class="titulo">
        <h1>Pesquisar por</h1>
      </div>
      <form>
        <div class="opcoes">
          <div class="opcao">
            <input type="radio" name="opcao" id="id" value="id" checked />
            <label for="id">ID</label>
          </div>
          <div class="opcao">
            <input type="radio" name="opcao" id="titulo" value="titulo" />
            <label for="titulo">Título</label>
          </div>
          <div class="opcao">
            <input type="radio" name="opcao" id="colaborador" value="colaborador" />
            <label for="colaborador">Colaborador</label>
          </div>
        </div>

        <div class="inputs">
          <div id="id" class="input ativo">
            <input type="text" name="valor" id="id" placeholder="Digite o ID" />
          </div>
          <div id="titulo" class="input">
            <input type="text" name="titulo" id="titulo" placeholder="Digite o título" />
          </div>
          <div id="colaborador" class="input">
            <div class="usuarios">
              <div class="usuario">
                <input type="radio" name="usuario" id="usuario1" value="f749b7ca-8868-4225-ae3f-c6f1b659a3fe" />
                <label for="usuario1">
                  <div class="avatar">
                    <img src="../../img/junior.jpeg" />
                  </div>
                  <span>Júnior Gonçalves</span>
                </label>
              </div>
              <div class="usuario">
                <input type="radio" name="usuario" id="usuario2" value="bb7d5d61-cb48-4fb5-a70a-be294ee16266" />
                <label for="usuario2">
                  <div class="avatar">
                    <img src="../../img/junior.jpeg" />
                  </div>
                  <span>Júnior Gonçalves</span>
                </label>
              </div>
              <div class="usuario">
                <input type="radio" name="usuario" id="usuario3" value="e6cab7a4-8075-4186-9c42-e31042bb771d" />
                <label for="usuario3">
                  <div class="avatar">
                    <img src="../../img/junior.jpeg" />
                  </div>
                  <span>Júnior Gonçalves</span>
                </label>
              </div>
              <div class="usuario">
                <input type="radio" name="usuario" id="usuario4" value="525fb523-54cf-4647-8ec2-377dc2e04de4" />
                <label for="usuario4">
                  <div class="avatar">
                    <img src="../../img/thiago.jpeg" />
                  </div>
                  <span>Thiago Alves</span>
                </label>
              </div>
              <div class="usuario">
                <input type="radio" name="usuario" id="usuario5" value="fb653929e-0880-4e36-ab8e-488c9bd3e7f4" />
                <label for="usuario5">
                  <div class="avatar">
                    <img src="../../img/thiago.jpeg" />
                  </div>
                  <span>Thiago Alves</span>
                </label>
              </div>
              <div class="usuario">
                <input type="radio" name="usuario" id="usuario6" value="347e4c40-1097-49e1-8f0f-f6f07d7fe5ab" />
                <label for="usuario6">
                  <div class="avatar">
                    <img src="../../img/thiago.jpeg" />
                  </div>
                  <span>Thiago Alves</span>
                </label>
              </div>
              <div class="usuario">
                <input type="radio" name="usuario" id="usuario7" value="029ed740-3168-46e1-ba19-934208556637" />
                <label for="usuario7">
                  <div class="avatar">
                    <img src="../../img/marcia.jpeg" />
                  </div>
                  <span>Marcia Reggiolli</span>
                </label>
              </div>
              <div class="usuario">
                <input type="radio" name="usuario" id="usuario8" value="b2a60ac2-4149-4218-91e2-2ddbb89909a0" />
                <label for="usuario8">
                  <div class="avatar">
                    <img src="../../img/marcia.jpeg" />
                  </div>
                  <span>Marcia Reggiolli</span>
                </label>
              </div>
              <div class="usuario">
                <input type="radio" name="usuario" id="usuario9" value="3369227b-7af4-4804-a46f-bd44ff03f448" />
                <label for="usuario9">
                  <div class="avatar">
                    <img src="../../img/marcia.jpeg" />
                  </div>
                  <span>Marcia Reggiolli</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <button type="submit">Pesquisar</button>
      </form>
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
              <div id="editado" class="avatar">
                <img src="../../img/junior.jpeg" />
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
                <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody class="nao-mostrar">
          <tr>
            <td>
              <div id="id">
                <span>2</span>
              </div>
            </td>
            <td>
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
              <div id="editado" class="avatar">
                <img src="../../img/thiago.jpeg" />
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
                <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody class="nao-mostrar">
          <tr>
            <td>
              <div id="id">
                <span>3</span>
              </div>
            </td>
            <td>
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
              <div id="editado" class="avatar">
                <img src="../../img/marcia.jpeg" />
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
                <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody class="nao-mostrar">
          <tr>
            <td>
              <div id="id">
                <span>4</span>
              </div>
            </td>
            <td>
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
              <div id="editado" class="avatar">
                <img src="../../img/thiago.jpeg" />
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
                <a href="../../sistema/perguntas/editar/"><i class="fas fa-pencil"></i></a>
                <a href="#"><i class="fas fa-trash-can"></i></a>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody class="nao-mostrar">
          <tr>
            <td>
              <div id="id">
                <span>5</span>
              </div>
            </td>
            <td>
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
              <div id="editado" class="avatar">
                <img src="../../img/junior.jpeg" />
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