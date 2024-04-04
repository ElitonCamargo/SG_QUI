<html lang="pt-br"><head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Login</title>
  <!-- Bootstrap CSS -->
  <link href="/front/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Centralizar o formulário */
    .centralizado {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <form class="mt-5 centralizado" id="loginForm">
        <h2 class="mb-4">Login</h2>
        <div class="mb-3">
          <label for="inputUsuario" class="form-label">Usuário</label>
          <input type="text" class="form-control" id="inputUsuario" placeholder="Digite seu usuário">
        </div>
        <div class="mb-3">
          <label for="inputSenha" class="form-label">Senha</label>
          <input type="password" class="form-control" id="inputSenha" placeholder="Digite sua senha" autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS e dependências opcionais para funcionalidades como dropdowns -->
<script src="/front/script/bootstrap.bundle.min.js"></script>
<script src="/front/script/jquery-3.7.1.min.js"></script>
<script src="/front/script/recursos.js"></script>
<script>
  $(document).ready(function() {

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

    $("#loginForm").submit(function(event) {
        event.preventDefault();
        var usuario = $("#inputUsuario").val();
        var senha = $("#inputSenha").val();

        let PHPSESSID = getPHPSessionID()
        const options = {
            method: 'GET',
            headers: {
              cookie: `PHPSESSID=${PHPSESSID}`,
              'Content-Type': 'application/json'
            }
          };

        fetch(`/back/usuario?login=${usuario}&senha=${senha}`, options)
          .then(result => result.json()).then(result => {
            if(result.sucesso){            
              location.reload();
            }
            else{
              console.log(result);
            }
          }).catch(err => console.error(err));
        });
  });
</script>

</body>
</html>