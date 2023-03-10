<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD USUARIOS</title>
    <link rel="stylesheet" href="{!! asset('../resources/css/app.css') !!}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/2b5286e1aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>


<body class="padding-crud">



    {{-- MODAL PARA CREAR --}}
    <div id="mdlcrear" class="modalcrear">
        <div class="modalcrear__content">
            <h1 class="texto-arriba-modal">Crear</h1>
            <div class="inputs_modal">
                <form action="usuarios" method="POST" id="form-insert">
                    @csrf
                    <input type="text" name="nombre" placeholder="Nombre">
                    <input type="text" name="email" placeholder="Email">
                    <input type="text" name="pswd" placeholder="Password">
                    <button type="submit">Insertar</button>
                </form>
            </div>
            <a href="#" class="modalcrear__close">&times;</a>
        </div>
    </div>


    {{-- MODAL PARA EDITAR --}}
    <div id="mdl-editar" class="modaleditar">
        <div class="modaleditar__content">
            <h1 class="texto-arriba-modal">Editar</h1>
            <div class="inputs_modal">
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
                <form action="usuarios" method="POST" id="form-edit" style="display:none;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">
                    <input type="text" name="email" id="edit-email" placeholder="Email">
                    <input type="text" name="pswd" id="edit-pswd" placeholder="Password">
                    <button type="submit">Actualizar</button>
                </form>
            </div>
            <a href="#" class="modaleditar__close">&times;</a>
        </div>
    </div>

    {{-- NAV CON IMAGEN Y LOG OUT --}}
    <div class="nav-crud">
        <img src="img/logo.png" alt="">
        <button><i class="fa-solid fa-right-from-bracket"></i></button>
    </div>

    <div class="buttons-nav">
        <a href="{{ route('webcategorias') }}"><button>Categorias</button></a>
        <a href="{{ route('webusuarios') }}"><button>Usuarios</button></a>
        <a href="{{ route('webchecks') }}"><button>Lugares</button></a>
    </div>

  {{-- TITULO PAGINA --}}
  <h1 class="titulo-crud">Usuarios</h1>
  {{-- BUSCADOR --}}
  <div class="buscador-crud">
      <input type="text" name="buscador" id="buscador" placeholder="Buscador...">
  </div>
  {{-- BOTON PARA CREAR --}}
  <a href="#mdlcrear"><button class="btn-modalcrear" ><i class="fa-solid fa-plus"></i></button></a>



    <div class="crud" id="usuarios">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Admin</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>







    <script>
        $(document).ready(function() {

            // Cargar usuarios al cargar la página con AJAX/JQUERY
            loadUsuarios();

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR USUARIOS CON AJAX/JQUERY Y BUSCAR SI ES NECESARIO
            function loadUsuarios() {
                // Obtener las categorías y agregar opciones al desplegable
                $.ajax({
                    url: 'usuarios',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var tableRows = '';
                        var searchString = $('#buscador').val()
                            .toLowerCase(); // Obtener el texto del buscador y pasarlo a minúsculas
                        $.each(data, function(i, usuario) {
                            var nombre = usuario.nombre.toLowerCase();
                            var email = usuario.email.toLowerCase();
                            var pswd = usuario.pswd.toLowerCase();


                            // Si se ha escrito algo en el buscador y no se encuentra en ningún campo, omitir este registro
                            if (searchString && nombre.indexOf(searchString) == -1 &&
                                email.indexOf(searchString) == -1 &&
                                pswd.indexOf(searchString) == -1) {
                                return true; // Continue
                            }

                            tableRows += '<tr>';
                            tableRows += '<td>' + usuario.nombre + '</td>';
                            tableRows += '<td>' + usuario.email + '</td>';
                            tableRows += '<td>' + usuario.admin + '</td>';
                            // tableRows += '<td>' + usuario.pswd + '</td>'; // ESTA COMENTADO PARA NO VER EL PASSWORD
                            tableRows += '<td>';
                            tableRows += '<a href="#mdl-editar"><button class="edit-usuario btn-editar" data-id="' + usuario.id +
                                '" data-nombre="' + usuario.nombre +
                                '" data-email="' + usuario.email +
                                '" data-pswd="' + usuario.pswd +
                                '"><i class="fa-solid fa-pen-to-square"></i></button></a>';

                            tableRows += '<button class="delete-usuario btn-eliminar" data-id="' + usuario.id +
                                '"><i class="fa-solid fa-trash"></i></button>';
                            tableRows += '</td>';
                            tableRows += '</tr>';
                        });
                        $('#usuarios tbody').html(tableRows);
                    }
                });
            }

            $('#buscador').on('keyup', function() {
                loadUsuarios();
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para enviar los datos del formulario al servidor con AJAX/JQUERY
            $('#form-insert').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this)
                    .serialize(); // cambiar a $(this) para serializar solo el formulario actual

                $.ajax({
                    url: 'usuarios',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        // Limpiar el formulario
                        $('form')[0].reset();

                        // Recargar la lista de usuarios
                        loadUsuarios();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para eliminar los datos del CRUD al servidor con AJAX/JQUERY
            $('body').on('click', '.delete-usuario', function() {
                var checkId = $(this).data('id');

                if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                    $.ajax({
                        url: 'usuarios/' + checkId,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(response) {
                            loadUsuarios();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para editar los datos del CRUD al servidor con AJAX/JQUERY
            $(document).ready(function() {
                // asignar evento submit al formulario de edición
                $('#form-edit').on('submit', function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    var id = $('#edit-id').val();
                    $.ajax({
                        url: 'usuarios/' + id,
                        type: 'PUT',
                        dataType: 'json',
                        data: formData,
                        success: function(response) {
                            // hide the edit form
                            $('#form-edit').hide();
                            // clear the form fields
                            $('#edit-nombre').val('');
                            $('#edit-email').val('');
                            $('#edit-pswd').val('');
                            // reload the user list
                            loadUsuarios();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                function editUsuario(id, nombre, email, pswd) {
                    // set the form values
                    $('#edit-id').val(id);
                    $('#edit-nombre').val(nombre);
                    $('#edit-email').val(email);
                    // $('#edit-pswd').val(pswd); // ESTA COMENTADO PARA NO VER EL PASSWORD


                    // mostrar el form de editar
                    $('#form-edit').show();
                }

                // FUNCION QUE AL CLICAR RECOGE LOS DATOS ENVIADOS Y ACTIVA LA FUNCION DE ARRIBA PARA ENVIAR LOS DATOS AL SERVIDOR
                $('body').on('click', '.edit-usuario', function() {
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    var email = $(this).data('email');
                    var pswd = $(this).data('pswd');

                    // llama a la funcion editUser 
                    editUsuario(id, nombre, email, pswd);
                });
            });


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::


        });
    </script>
</body>

</html>
