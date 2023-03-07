function crear() {

    const formContainer = document.getElementById('crear');
    let form = document.createElement('form');
    form.innerHTML = `
    <h1>CREAR USUARIO</h1>
    <h3>Nombre</h3>
    <input type="text" name="nombre" required/><br>
    <h3>Email</h3>
    <input type="email" name="email" required/><br>
    <h3>Password</h3>
    <input id="pass" type="password" name="password" required/><br>
    <h3>Admin</h3>
    <input type="number" name="admin" required/><br>
    <button type="submit">Crear</button>
  `;
    formContainer.appendChild(form);

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'crear', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.response);
            } else {
                console.error(xhr.response);
            }
        };
        xhr.send(formData);
    });
}

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
            <td>${product.password}</td>
            <td>${product.admin}</td>
            <td><button onclick="editar(${product.id})">Modificar</button><td>
            <td><button onclick="el(${product.id})">Eliminar</button><td>
        `;
        usuarios.appendChild(tr);
    });
});
}
getUsers();

// formulario modificar usuarios
function editar(id) {
    console.log(id);
    const xhr = new XMLHttpRequest();
    const modificar = document.getElementById('modificar');
    xhr.open('GET', 'editar?id=' + id, true);
    xhr.onload = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            // console.log(data);
            data.forEach(product => {
                let form = document.createElement('form');
                form.innerHTML = `
          <h1>MODIFICAR USUARIO</h1>

          <h3>Nombre</h3>
          <input type="text" name="nombre" value="${product.nombre}" required/><br>
          <h3>Email</h3>
          <input type="email" name="email" value="${product.email}" required/><br>
          <h3>Password</h3>
          <input id="pass" name="password" type="text" value="${product.password}" required/><br>
          <h3>Admin</h3>
          <input type="number" name="admin" value="${product.admin}" required/><br>
          <button type="submit">Modificar</button>
        `;
                modificar.appendChild(form);
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const formData2 = new FormData(form);
                    const xhr2 = new XMLHttpRequest();
                    console.log(id);
                    xhr2.open('PUT', `usuarios/${id}`, true);
                    xhr2.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    xhr2.onreadystatechange = function () {
                        if (xhr2.readyState === 4 && xhr2.status === 200) {
                            if (xhr2.status === 200) {
                                console.log(xhr2.response);
                            } else {
                                console.error(xhr2.response);
                            }
                        }
                    };
                    xhr2.send(formData2);
                });
            });
        }
    };
    xhr.send();
}
function el(id) {
    console.log(id);
    const xhr = new XMLHttpRequest();
    xhr.open('DELETE', `eliminar/${id}`, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
        } else {
            console.error(xhr.response);
        }
    };
    xhr.send();
}
