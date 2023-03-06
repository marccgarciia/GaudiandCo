
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
