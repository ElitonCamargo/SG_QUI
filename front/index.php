<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema Gerenciador de Projetos de Química</title>
  <!-- Bootstrap CSS -->
  <link href="/front/css/bootstrap.min.css" rel="stylesheet">
  <link href="/front/script/vendor/DataTables/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    #root {
      overflow-y: auto;
      height: calc(100vh - 140px);
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">SG_QUI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Elemento
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
            <li><a class="dropdown-item" href="/elemento/cadastrar">Cadastrar</a></li>
            <li><a class="dropdown-item" href="/elemento/listar">Listar</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Compostos
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
            <li><a class="dropdown-item" href="/composto/cadastrar">Cadastrar</a></li>
            <li><a class="dropdown-item" href="/composto/listar">Listar</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Projetos
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown3">
            <li><a class="dropdown-item" href="/projeto/cadastrar">Cadastrar</a></li>
            <li><a class="dropdown-item" href="/projeto/listar">Listar</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cliente
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown4">
            <li><a class="dropdown-item" href="#">Cadastrar</a></li>
            <li><a class="dropdown-item" href="#">Listar</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown5" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Usuários
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown5">
            <li><a class="dropdown-item" href="#">Cadastrar</a></li>
            <li><a class="dropdown-item" href="/usuario/listar">Listar</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" id="btnLogoff">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- ********************* -->
<div class="container mt-4" id="root">
  
</div>
<!-- ********************** -->

<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted">Sistema Gerenciador de Projetos de Química &copy; 2024</span>
  </div>
</footer>

<!-- Bootstrap JS (opcional, dependendo dos recursos que você usa) -->
<script src="/front/script/bootstrap.bundle.min.js"></script>
<script src="/front/script/jquery-3.7.1.min.js"></script>
<script src="/front/script/vendor/DataTables/datatables.min.js"></script>
<script src="/front/script/datatables.custom.js"></script>
<script src="/front/script/recursos.js"></script>
<script src="/front/script/roteamento.js"></script>
<script>
  function getPHPSessionID() {
    let cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
          let cookie = cookies[i].trim();
          if (cookie.indexOf('PHPSESSID=') === 0) {
              return cookie.substring('PHPSESSID='.length, cookie.length);
          }
      }
      return null;
  }
  $("#btnLogoff").on('click', () => {
    let PHPSESSID = getPHPSessionID()
    const options = {
        method: 'GET',
        headers: {
          cookie: `PHPSESSID=${PHPSESSID}`,
          'Content-Type': 'application/json'
        }
      };

    fetch(`/back/usuario?logoff`, options)
      .then(result => result.json()).then(result => {
        if(result.sucesso){            
          location.reload();
        }
        else{
          console.log(result);
        }
      }).catch(err => console.error(err));
  });
</script>


</body>
</html>
