<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD USUARIOS</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/2b5286e1aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="../resources/css/app.css">
    <meta name="csrf-token" content="{{csrf_token()}}" id="token">
</head>
<body class="padding-crud">
{{-- NAV CON IMAGEN Y LOG OUT --}}
    <div class="nav-crud">
        <img src="../resources/img/logo.png" alt="">
        <button><i class="fa-solid fa-right-from-bracket"></i></button>
    </div>

    <div class="buttons-nav">
        <a><button>Categorias</button></a>
        <a><button>Usuarios</button></a>
        <a><button>Lugares</button></a>
    </div>

  {{-- TITULO PAGINA --}}
  <h1 class="titulo-crud">Usuarios</h1>
  {{-- BUSCADOR --}}


  <div class="buscador-crud" id="formulario_busqueda">
       <input type="text" name="filtro" id="buscador" placeholder="Buscador...">
 </div>
<button onclick="crear()" class="btn-modalcrear"><i class="fa-solid fa-plus"></i></button>
<div class="crud">
    <table class="table" id="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Admin</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody id="usuarios">

        </tbody>
    </table>
   </div>
    <div id="crear">
        </div>
    <div id="modificar"></div>

    <script src="../resources/js/usuarios.js"></script>

</body>
</html>

