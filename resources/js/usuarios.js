
const tbody = document.querySelector('#usuarios');

fetch('mostrar')
  .then(response => response.json())
  .then(data => {
    data.usuarios.forEach(usuario => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${usuario.id}</td>
        <td>${usuario.nombre}</td>
        <td>${usuario.email}</td>
        <td>${usuario.password}</td>
        <td>${usuario.admin}</td>
      `;
      tbody.appendChild(tr);
    });
  })
  .catch(error => console.error(error));

// function getUsuarios() {
// fetch('mostrar')
// .then(response => response.json())
// .then(data => {
//     let usuarios = document.getElementById('usuarios');
//     data.forEach(usuario => {
//         let table = document.createElement('tr');
//         table.innerHTML = `
//             <td>${usuario.id}</td>
//             <td>${usuario.nombre}</td>
//             <td>${usuario.email}</td>
//             <td>${usuario.password} €</td>
//             <td>${usuario.admin}</td>
//             <button onclick="mod(${usuario.id})">Modificar</button>
//             <button onclick="el(${usuario.id})">Eliminar</button>

//         `;
//         usuarios.appendChild(table);
//     });
// });
// }
// getUsuarios();

function mostrarUsuarios() {
  var request = new XMLHttpRequest();
  request.open('GET', 'usuarios', true);
  request.responseType = 'json';

  request.onload = function() {
      if (request.status === 200) {
          var usuarios = request.response;
          mostrarListaUsuarios(usuarios);
      } else {
          console.log('Error al cargar los usuarios');
      }
  }

  request.send();
}

function mostrarListaUsuarios(usuarios) {
  var listaUsuarios = document.getElementById('usuarios');

  listaUsuarios.innerHTML = '';

  usuarios.forEach(function(usuario) {
      var tr = document.createElement('tr');
      var tdNombre = document.createElement('td');
      tdNombre.textContent = usuario.nombre;
      tr.appendChild(tdNombre);
      var tdEmail = document.createElement('td');
      tdEmail.textContent = usuario.email;
      tr.appendChild(tdEmail);
      var tdPassword = document.createElement('td');
      tdPassword.textContent = usuario.password;
      tr.appendChild(tdPassword);
      var tdAdmin = document.createElement('td');
      tdAdmin.textContent = usuario.admin;
      tr.appendChild(tdAdmin);
      listaUsuarios.appendChild(tr);
  });
}

mostrarUsuarios();
