<header>
  <div class="header-content">
    <div class="logo">
      <a href=<?= "$dir/" ?>><img src=<?= "$dir/img/fatec_ra_campinas_itapira_cor.svg"  ?> alt="Logo da fatec" /></a>
    </div>
    <div class="nav-items">
      <a href=<?= "$dir/" ?> class=<?= $pagina == 'principal' ? 'active' : ''  ?>>Página inicial</a>
      <a href=<?= "$dir/mais-buscados/" ?> class=<?= $pagina == 'mais-buscados' ? 'active' : ''  ?>>Mais buscados</a>
      <a href=<?= "$dir/sugestoes" ?> class=<?= $pagina == 'sugestoes' ? 'active' : ''  ?>>Sugestões</a>
      <a href=<?= "$dir/sobre" ?> class=<?= $pagina == 'sobre' ? 'active' : ''  ?>>Sobre</a>
    </div>
    <div class="login">
      <a href=<?= "$dir/login" ?> class=<?= $pagina == 'login' ? 'active' : ''  ?>>
        <p>Login</p>
      </a>
    </div>
    <div class="menu-hamburger">
      <i class="fa-solid fa-bars"></i>
      <div class="menu-hamburger-content">
        <a href=<?= "$dir/" ?>>Página inicial</a>
        <a href=<?= "$dir/mais-buscados" ?>>Mais buscados</a>
        <a href=<?= "$dir/sugestoes" ?>>Sugestões</a>
        <a href=<?= "$dir/sobre" ?>>Sobre</a>
        <a href=<?= "$dir/login" ?>>Login</a>
      </div>
    </div>
  </div>
</header>