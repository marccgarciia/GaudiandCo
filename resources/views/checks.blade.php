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
    <h1>CRUD CHECKS</h1>
    <a href="{{ route('webcategorias') }}">CATEGORÍAS</a>
    <a href="{{ route('webchecks') }}">CHECKS</a>
    <a href="{{ route('webusuarios') }}">USUARIOS</a>

    <input type="text" name="buscador" id="buscador" placeholder="Buscador...">

    <div id="checks">
        <h2>Lista de checks</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Categoria</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div>
        <form action="checks" method="POST" id="form-insert">
            <h2>Formulario de Insertar</h2>
            @csrf
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="descripcion" placeholder="Descripción">
            <input type="text" name="latitud" placeholder="Latitud">
            <input type="text" name="longitud" placeholder="Longitud">
            <select name="categoria_id" id="categoria_id">
                <option value="">Selecciona una categoría</option>
            </select>
            <button type="submit">Insertar</button>
        </form>
    </div>

    <div>
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
        <form action="checks" method="POST" id="form-edit" style="display:none;">
            <h2>Formulario de Editar</h2>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">
            <input type="text" name="descripcion" id="edit-descripcion" placeholder="Descripción">
            <input type="text" name="latitud" id="edit-latitud" placeholder="Latitud">
            <input type="text" name="longitud" id="edit-longitud" placeholder="Longitud">
            <select name="categoria_id" id="categoria_id-edit">
                <option value="">Selecciona una categoría</option>
            </select>
            <button type="submit">Actualizar</button>
        </form>
    </div>



    <script>
        $(document).ready(function() {

            // Cargar usuarios al cargar la página con AJAX/JQUERY
            loadChecks();

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR USUARIOS CON AJAX/JQUERY Y BUSCAR SI ES NECESARIO
            function loadChecks() {
                // Obtener las categorías y agregar opciones al desplegable
                $.ajax({
                    url: 'checks',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var tableRows = '';
                        var searchString = $('#buscador').val()
                            .toLowerCase(); // Obtener el texto del buscador y pasarlo a minúsculas
                        $.each(data, function(i, check) {
                            var nombre = check.nombre.toLowerCase();
                            var descripcion = check.descripcion.toLowerCase();
                            var latitud = check.latitud.toLowerCase();
                            var longitud = check.longitud.toLowerCase();
                            var categoria_id = check.categoria.toString().toLowerCase();

                            // Si se ha escrito algo en el buscador y no se encuentra en ningún campo, omitir este registro
                            if (searchString && nombre.indexOf(searchString) == -1 &&
                                descripcion.indexOf(searchString) == -1 &&
                                latitud.indexOf(searchString) == -1 && longitud.indexOf(
                                    searchString) == -1 &&
                                categoria_id.indexOf(searchString) == -1) {
                                return true; // Continue
                            }

                            tableRows += '<tr>';
                            tableRows += '<td>' + check.nombre + '</td>';
                            tableRows += '<td>' + check.descripcion + '</td>';
                            tableRows += '<td>' + check.latitud + '</td>';
                            tableRows += '<td>' + check.longitud + '</td>';
                            tableRows += '<td>' + check.categoria + '</td>';
                            tableRows += '<td>';
                            tableRows += '<button class="edit-check" data-id="' + check.id +
                                '" data-nombre="' + check.nombre +
                                '" data-descripcion="' + check.descripcion +
                                '" data-latitud="' + check.latitud +
                                '" data-longitud="' + check.longitud +
                                '" data-categoria_id="' + check.categoria_id +
                                '">Editar</button>';

                            tableRows += '<button class="delete-check" data-id="' + check.id +
                                '">Eliminar</button>';
                            tableRows += '</td>';
                            tableRows += '</tr>';
                        });
                        $('#checks tbody').html(tableRows);
                    }
                });
            }

            $('#buscador').on('keyup', function() {
                loadChecks();
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para enviar los datos del formulario al servidor con AJAX/JQUERY
            $('#form-insert').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this)
                    .serialize(); // cambiar a $(this) para serializar solo el formulario actual

                $.ajax({
                    url: 'checks',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        // Limpiar el formulario
                        $('form')[0].reset();

                        // Recargar la lista de usuarios
                        loadChecks();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para eliminar los datos del CRUD al servidor con AJAX/JQUERY
            $('body').on('click', '.delete-check', function() {
                var checkId = $(this).data('id');

                if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                    $.ajax({
                        url: 'checks/' + checkId,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(response) {
                            loadChecks();
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
                        url: 'checks/' + id,
                        type: 'PUT',
                        dataType: 'json',
                        data: formData,
                        success: function(response) {
                            // hide the edit form
                            $('#form-edit').hide();
                            // clear the form fields
                            $('#edit-nombre').val('');
                            $('#edit-descripcion').val('');
                            $('#edit-latitud').val('');
                            $('#edit-longitud').val('');
                            $('#edit-categoria_id').val('');
                            // reload the user list
                            loadChecks();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                function editCheck(id, nombre, descripcion, latitud, longitud, categoria_id) {
                    // set the form values
                    $('#edit-id').val(id);
                    $('#edit-nombre').val(nombre);
                    $('#edit-descripcion').val(descripcion);
                    $('#edit-latitud').val(latitud);
                    $('#edit-longitud').val(longitud);
                    $('#edit-categoria_id').val(categoria_id);

                    // mostrar el form de editar
                    $('#form-edit').show();
                }

                // FUNCION QUE AL CLICAR RECOGE LOS DATOS ENVIADOS Y ACTIVA LA FUNCION DE ARRIBA PARA ENVIAR LOS DATOS AL SERVIDOR
                $('body').on('click', '.edit-check', function() {
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    var descripcion = $(this).data('descripcion');
                    var latitud = $(this).data('latitud');
                    var longitud = $(this).data('longitud');
                    var categoria_id = $(this).data('categoria_id');

                    // llama a la funcion editUser 
                    editCheck(id, nombre, descripcion, latitud, longitud, categoria_id);
                });
            });


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Cargar categorías al cargar la página con AJAX/JQUERY
            loadCategorias();

            // Función para cargar categorías con AJAX/JQUERY
            function loadCategorias() {
                $.ajax({
                    url: 'categorias',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var options = '';
                        $.each(data, function(i, categoria) {
                            options += '<option value="' + categoria.id + '">' + categoria
                                .nombre + '</option>';
                        });
                        $('#categoria_id').append(options);
                        $('#categoria_id-edit').append(options);

                    }
                });
            }


        });
    </script>
</body>

</html>
