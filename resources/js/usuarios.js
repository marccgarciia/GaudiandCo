function crear() {
    let modalcrear = document.createElement('div');
    modalcrear.className = "modalcrear"
    modalcrear.id = "mdlcrear2"
    document.body.appendChild(modalcrear);
    let modalcrear2 = document.createElement('div');
    modalcrear2.className = "modalcrear__content"
    modalcrear.appendChild(modalcrear2);

    let h1 = document.createElement('h1');
    h1.className = "texto-arriba-modal"
    h1.textContent = "Crear"
    modalcrear2.appendChild(h1);
    let a = document.createElement('a');
    a.className = "modalcrear__close"
    a.textContent = "\u00D7"
    a.href = "#"
    a.onclick = function() {
        eliminarDivC();
    };
    modalcrear2.appendChild(a);
    let inputs = document.createElement('div');
    inputs.className = "inputs_modal"
    modalcrear2.appendChild(inputs);

    let form = document.createElement('form');
    form.innerHTML = `
    <input type="text" name="nombre" placeholder="Nombre" required/><br>
    <input type="email" name="email" placeholder="Email" required/><br>
    <input id="pass" type="password" placeholder="Password" name="password" required/><br>
    <input type="number" name="admin" placeholder="Admin" required/><br>
    <button type="submit">Crear</button>
  `;
    inputs.appendChild(form);

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'crear', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.onreadystatechange = function() {
            if (xhr.status === 200) {
                console.log(xhr.response);
                const i="";
                buscarUsuarios(i);
            } else {
                console.error(xhr.response);

            }
        };
        xhr.send(formData);
        eliminarDivC();
    });
}
function getUsers() {
    let ultima_ejecucion = null;
    fetch('usuarios')
        .then(response => response.json())
        .then(data => {
            let usuarios = document.getElementById('usuarios');
            data.forEach(product => {
                let tr = document.createElement('tr');
                tr.innerHTML = ' ';
                tr.innerHTML = `
            <td>${product.nombre}</td>
            <td>${product.email}</td>
            <td>${product.admin}</td>
            <td><button onclick="editar(${product.id})" class="btn-editar"><i class="fa-solid fa-pen-to-square"></i></button>
            <button onclick="el(${product.id})" class="btn-eliminar"><i class="fa-solid fa-trash"></i></button></td>
        `;
                usuarios.appendChild(tr);
            });
        });
}
getUsers();


function editar(id) {
    console.log(id);
    const xhr = new XMLHttpRequest();
    const modificar = document.getElementById('modificar');
    let modaleditar = document.createElement('div');
    modaleditar.className = "modaleditar"
    modaleditar.id = "mdl-editar2"
    document.body.appendChild(modaleditar);
    const modal = document.getElementById('mdl-editar2');
    modal.style.visibility = "visible";
    modal.style.opacity = 1;
    let modaleditar2 = document.createElement('div');
    modaleditar2.className = "modaleditar__content"
    modaleditar.appendChild(modaleditar2);

    let h1 = document.createElement('h1');
    h1.className = "texto-arriba-modal"
    h1.textContent = "Modificar"
    modaleditar2.appendChild(h1);
    let a = document.createElement('a');
    a.className = "modaleditar__close"
    a.textContent = "\u00D7"
    a.href = "#"
    a.onclick = function() {
        eliminarDiv();
    };
    modaleditar2.appendChild(a);
    let inputs = document.createElement('div');
    inputs.className = "inputs_modal"
    modaleditar2.appendChild(inputs);
    xhr.open('GET', 'editar?id=' + id, true);
    xhr.onload = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            // console.log(data);
            data.forEach(product => {
                let form = document.createElement('form');
                form.id = "form-edit"
                form.innerHTML = `
           <input type="hidden" name="id" placeholder="Id" value="${product.id}" id="edit-id" required/>
          <input type="text" name="nombre" placeholder="Nombre" value="${product.nombre}" id="edit-nombre" required/>
          <input type="email" name="email" placeholder="Email" value="${product.email}" id="edit-email" required/>
          <input id="pass" name="password" placeholder="Password" type="text" value="${product.password}" id="edit-pswd" required/>
          <input type="number" name="admin" placeholder="Admin" value="${product.admin}" id="edit-admin" required/>
          <button type="submit">Modificar</button>
        `;
                inputs.appendChild(form);
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const formData2 = new FormData(form);
                    const xhr2 = new XMLHttpRequest();
                    console.log(id);
                    xhr2.open('POST', `usuarios/${id}`, true);
                    xhr2.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    xhr2.onreadystatechange = function () {
                        if (xhr2.readyState === 4 && xhr2.status === 200) {
                            if (xhr2.status === 200) {
                                console.log(xhr2.response);
                                const i="";
                                buscarUsuarios(i);
                            } else {
                                console.error(xhr2.response);
                            }
                        }
                    };
                    xhr2.send(formData2);
                    eliminarDiv();
                });
            });
        }
    };
    xhr.send();

}
function eliminarDiv() {
    const divAEliminar = document.getElementById('mdl-editar2');
    divAEliminar.childNodes.forEach(child => {
        divAEliminar.removeChild(child);
    });
    divAEliminar.parentNode.removeChild(divAEliminar);
}
function eliminarDivC() {
    const divAEliminar = document.getElementById('mdlcrear2');
    divAEliminar.childNodes.forEach(child => {
        divAEliminar.removeChild(child);
    });
    divAEliminar.parentNode.removeChild(divAEliminar);
}
function el(id) {
    console.log(id);
    const xhr = new XMLHttpRequest();
    xhr.open('DELETE', `eliminar/${id}`, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
            const i="";
            buscarUsuarios(i);
        }
    };
    xhr.send();
}

function buscarUsuarios(filtro) {
    xhr = new XMLHttpRequest();
    xhr.open('GET', 'filtrar?filtrar=' + filtro, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.onload = function() {
        if (this.status == 200) {
            let usuarios = JSON.parse(this.responseText);
            // Pintar los usuarios en la tabla
            tablaUsuarios.innerHTML = '';
            usuarios.forEach(function(usuario) {
                tablaUsuarios.innerHTML += `
                    <tr>
                        <td>${usuario.nombre}</td>
                        <td>${usuario.email}</td>
                        <td>${usuario.admin}</td>
                        <td><button onclick="editar(${usuario.id})" class="btn-editar"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button onclick="el(${usuario.id})" class="btn-eliminar"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                `;
            });
        }
    };
    xhr.send();
}

let inputBusqueda = document.getElementById('buscador');
let tablaUsuarios = document.getElementById('usuarios');
let xhr = null;

inputBusqueda.addEventListener('input', function(ev) {
    if (xhr !== null) {
        xhr.abort();
    }if (inputBusqueda.value.length >= 1) {
        buscarUsuarios(inputBusqueda.value);
    }else {
        const i="";
        buscarUsuarios(i);
    }
});
