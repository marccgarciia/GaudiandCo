<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD CHECKS</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>CRUD USUARIOS</h1>
    <a href="{{ route('webcategorias') }}">CATEGORÍAS</a>
    <a href="{{ route('webchecks') }}">CHECKS</a>
    <a href="{{ route('webusuarios') }}">USUARIOS</a>

    <input type="text" name="buscador" id="buscador" placeholder="Buscador...">

    <div id="usuarios">
        <h2>Lista de usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div>
        <form action="usuarios" method="POST" id="form-insert">
            <h2>Formulario de Insertar</h2>
            @csrf
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="email" placeholder="Email">
            <input type="text" name="pswd" placeholder="Password">

            <button type="submit">Insertar</button>
        </form>
    </div>

    <div>
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
        <form action="usuarios" method="POST" id="form-edit" style="display:none;">
            <h2>Formulario de Editar</h2>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">
            <input type="text" name="email" id="edit-email" placeholder="Email">
            <input type="text" name="pswd" id="edit-pswd" placeholder="Password">
            <button type="submit">Actualizar</button>
        </form>
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
                            tableRows += '<button class="edit-usuario" data-id="' + usuario.id +
                                '" data-nombre="' + usuario.nombre +
                                '" data-email="' + usuario.email +
                                '" data-pswd="' + usuario.pswd +
                                '">Editar</button>';

                            tableRows += '<button class="delete-usuario" data-id="' + usuario.id +
                                '">Eliminar</button>';
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
