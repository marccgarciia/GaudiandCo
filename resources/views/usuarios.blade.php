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
    <!-- <script src="usuarios.js"></script> -->
    <script type="text/javascript">
                function getUsers() {
            fetch('usuarios')
                .then(response => response.json())
                .then(data => {
                    let usuarios = document.getElementById('usuarios');
                    data.forEach(product => {
                        let tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${product.id}</td>
                            <td>${product.nombre}</td>
                            <td>${product.email}</td>
                            <td>${product.password} €</td>
                            <td>${product.admin}</td>
                            <td><button onclick="mod(${product.id})">Modificar</button><td>
                            <td><button onclick="el(${product.id})">Eliminar</button><td>
                        `;
                        usuarios.appendChild(tr);
                    });
                });
        }
        getUsers();
    </script>
</body>
</html>
