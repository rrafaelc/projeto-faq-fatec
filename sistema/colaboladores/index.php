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

  <script type="module" src="script.js" defer></script>
  <title>Sistema FAQ | Colaboladores</title>
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
        <h1 class="title">Colaboladores</h1>
        <div class="subgrupo">
          <a href="../../sistema">Início</a>
          <i class="fas fa-angle-right"></i>
          <span>Colaboladores</span>
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
    <div class="criar-conta">
      <div class="titulo">
        <h1>Criar conta</h1>
        <i class="fas fa-angle-down botao"></i>
      </div>
      <form>
        <label for="conta-nome">Nome</label>
        <input type="text" name="nome" id="conta-nome" placeholder="Escreva o nome do colaborador" required />
        <label for="conta-ra">RA (Registro Acadêmico)</label>
        <input type="text" name="ra" id="conta-ra" placeholder="Escreva o RA do colaborador" required />
        <label for="conta-email">E-mail</label>
        <input type="email" name="email" id="conta-email" placeholder="Escreva o e-mail do colaborador" required />

        <label for="conta-senha">Senha</label>
        <input type="password" name="senha" id="conta-senha" placeholder="Escreva a senha do colaborador" required />
        <label for="conta-confirmar-senha">Confirmar senha</label>
        <input type="password" name="confirmar-senha" id="conta-confirmar-senha" placeholder="Confirme a senha do colaborador" required />

        <button type="submit">Criar conta</button>
      </form>
    </div>
    <div class="pesquisar-por">
      <div class="titulo">
        <h1>Pesquisar por</h1>
      </div>
      <form>
        <div class="opcoes">
          <div class="opcao">
            <input type="radio" name="opcao" id="input-todos" value="todos" checked />
            <label for="input-todos">Todos</label>
          </div>
          <div class="opcao">
            <input type="radio" name="opcao" id="id" value="id" />
            <label for="id">ID</label>
          </div>
          <div class="opcao">
            <input type="radio" name="opcao" id="nome" value="nome" />
            <label for="nome">Nome</label>
          </div>
        </div>

        <div class="inputs">
          <div id="input-id" class="input">
            <input type="text" name="valor" id="input-id" placeholder="Digite o ID" />
          </div>
          <div id="input-nome" class="input">
            <input type="text" name="valor" id="input-nome" placeholder="Digite o nome" />
          </div>
        </div>
        <button type="submit" class="nao-mostrar">Pesquisar</button>
      </form>
    </div>
    <div class="dados">
      <table id="tabela-1" class="mostrar">
        <thead>
          <tr>
            <th>
              <span>ID <i class="fas fa-sort-down"></i></span>
            </th>
            <th>
              <span>Colaborador <i class="fas fa-sort-down"></i></span>
            </th>
            <th id="cargo">
              <span>Cargo <i class="fas fa-sort-down"></i></span>
            </th>
            <th id="suspenso">
              <span>Suspenso <i class="fas fa-sort-down"></i></span>
            </th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="id">
              <div id="id">
                <span>1</span>
              </div>
            </td>
            <td class="colaborador">
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
            <td class="cargo administrador">
              <button>Administrador</button>
            </td>
            <td class="suspenso nao">
              <button>Não</button>
            </td>
            <td class="acao">
              <div>
                <button>Resetar senha</button>
                <button>Deletar conta</button>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td class="id">
              <div id="id">
                <span>2</span>
              </div>
            </td>
            <td class="colaborador">
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
            <td class="cargo moderador">
              <button>Moderador</button>
            </td>
            <td class="suspenso nao">
              <button>Não</button>
            </td>
            <td class="acao">
              <div>
                <button>Resetar senha</button>
                <button>Deletar conta</button>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td class="id">
              <div id="id">
                <span>3</span>
              </div>
            </td>
            <td class="colaborador">
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
            <td class="cargo colaborador">
              <button>Colaborador</button>
            </td>
            <td class="suspenso nao">
              <button>Não</button>
            </td>
            <td class="acao">
              <div>
                <button>Resetar senha</button>
                <button>Deletar conta</button>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody>
          <tr>
            <td class="id">
              <div id="id">
                <span>4</span>
              </div>
            </td>
            <td class="colaborador">
              <div id="colaborador">
                <div class="avatar">
                  <img src="../../img/engracadinho.webp" />
                </div>
                <div class="nome">
                  <span>Engraçadinho</span>
                  <span></span>
                </div>
              </div>
            </td>
            <td class="cargo colaborador">
              <button>Colaborador</button>
            </td>
            <td class="suspenso sim">
              <button>Sim</button>
            </td>
            <td class="acao">
              <div>
                <button>Resetar senha</button>
                <button>Deletar conta</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <table id="tabela-2">
        <thead>
          <tr>
            <th>
              <span>ID <i class="fas fa-sort-down"></i></span>
            </th>
            <th>
              <span>Colaborador <i class="fas fa-sort-down"></i></span>
            </th>
            <th id="cargo">
              <span>Cargo <i class="fas fa-sort-down"></i></span>
            </th>
            <th id="suspenso">
              <span>Suspenso <i class="fas fa-sort-down"></i></span>
            </th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="id">
              <div id="id">
                <span>2</span>
              </div>
            </td>
            <td class="colaborador">
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
            <td class="cargo moderador">
              <button>Moderador</button>
            </td>
            <td class="suspenso nao">
              <button>Não</button>
            </td>
            <td class="acao">
              <div>
                <button>Resetar senha</button>
                <button>Deletar conta</button>
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