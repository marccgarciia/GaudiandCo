<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hola</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <meta name="csrf-token" content="{{csrf_token()}}" id="token">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Password</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody id="usuarios">

        </tbody>
    </table>
    <script src="../resources/js/usuarios.js"></script>

    </script>
</body>
</html>
