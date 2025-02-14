<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabricante y Aeronave Management</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .item { margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .item h3 { margin: 0; }
        .item p { margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Fabricante y Aeronave Management</h1>
    
    <h2>Fabricantes</h2>
    <div id="fabricantes"></div>
    <h2>Aeronaves</h2>
    <div id="aeronaves"></div>
    
    <h2>Agregar Nuevo Fabricante</h2>
    <form id="fabricanteForm">
        <input type="text" id="nombreFabricante" placeholder="Nombre" required>
        <input type="text" id="pais" placeholder="País" required>
        <button type="submit">Agregar Fabricante</button>
    </form>

    <h2>Actualizar Fabricante</h2>
    <form id="fabricanteUpdateForm" style="display:none;">
        <input type="hidden" id="updateFabricanteId">
        <input type="text" id="updateNombreFabricante" placeholder="Nuevo Nombre" required>
        <input type="text" id="updatePais" placeholder="Nuevo País" required>
        <button type="submit">Actualizar Fabricante</button>
    </form>
    
    <h2>Agregar Nueva Aeronave</h2>
    <form id="aeronaveForm">
        <input type="text" id="nombreAeronave" placeholder="Nombre" required>
        <select id="fabricante" required>
            <option value="">Seleccione un Fabricante</option>
        </select>
        <input type="number" id="anyoFabricacion" placeholder="Año de Fabricación" required>
        <button type="submit">Agregar Aeronave</button>
    </form>

    <h2>Actualizar Aeronave</h2>
    <form id="aeronaveUpdateForm" style="display:none;">
        <input type="hidden" id="updateAeronaveId">
        <input type="text" id="updateNombreAeronave" placeholder="Nuevo Nombre" required>
        <select id="updateFabricante" required></select>
        <input type="number" id="updateAnyoFabricacion" placeholder="Nuevo Año de Fabricación" required>
        <button type="submit">Actualizar Aeronave</button>
    </form>

    <script>
        let fabricantes = {};

        // Cargar fabricantes
        fetch('/api/fabricantes')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('fabricantes');
                const fabricanteSelect = document.getElementById('fabricante');
                data.forEach(fabricante => {
                    fabricantes[fabricante.id] = fabricante.nombre;
                    container.innerHTML += `
                        <div class="item" data-id="${fabricante.id}">
                            <h3>${fabricante.nombre} (${fabricante.pais})</h3>
                            <button onclick="editFabricante(${fabricante.id})">Editar</button>
                            <button onclick="deleteFabricante(${fabricante.id})">Eliminar</button>
                        </div>`;
                    fabricanteSelect.innerHTML += `<option value="${fabricante.id}">${fabricante.nombre}</option>`;
                });
                cargarAeronaves();
            });

        // Cargar aeronaves
        function cargarAeronaves() {
            fetch('/api/aeronaves')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('aeronaves');
                    container.innerHTML = '';
                    data.forEach(aeronave => {
                        const fabricanteNombre = fabricantes[aeronave.fabricante] || 'Desconocido';
                        container.innerHTML += `
                            <div class="item" data-id="${aeronave.id}">
                                <h3>${aeronave.nombre} (${fabricanteNombre}, ${aeronave.anyoFabricacion})</h3>
                                <button onclick="editAeronave(${aeronave.id})">Editar</button>
                                <button onclick="deleteAeronave(${aeronave.id})">Eliminar</button>
                            </div>`;
                    });
                });
        }

        // Agregar Fabricante
        document.getElementById('fabricanteForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const nombre = document.getElementById('nombreFabricante').value;
            const pais = document.getElementById('pais').value;
            fetch('/api/fabricantes', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, pais })
            }).then(response => response.json())
              .then(fabricante => {
                  fabricantes[fabricante.id] = fabricante.nombre;
                  document.getElementById('fabricantes').innerHTML += `
                      <div class="item" data-id="${fabricante.id}">
                          <h3>${fabricante.nombre} (${fabricante.pais})</h3>
                          <button onclick="editFabricante(${fabricante.id})">Editar</button>
                          <button onclick="deleteFabricante(${fabricante.id})">Eliminar</button>
                      </div>`;
                  document.getElementById('fabricante').innerHTML += `<option value="${fabricante.id}">${fabricante.nombre}</option>`;
                  document.getElementById('fabricanteForm').reset();
              });
        });

        // Editar Fabricante
        function editFabricante(id) {
            const fabricante = fabricantes[id];
            const fabricanteData = document.querySelector(`.item[data-id="${id}"]`);
            const nombre = fabricanteData.querySelector('h3').textContent.split(' ')[0];
            const pais = fabricanteData.querySelector('h3').textContent.split(' ')[1];

            document.getElementById('updateFabricanteId').value = id;
            document.getElementById('updateNombreFabricante').value = nombre;
            document.getElementById('updatePais').value = pais;
            document.getElementById('fabricanteUpdateForm').style.display = 'block';
        }

        // Actualizar Fabricante
        document.getElementById('fabricanteUpdateForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('updateFabricanteId').value;
            const nombre = document.getElementById('updateNombreFabricante').value;
            const pais = document.getElementById('updatePais').value;
            fetch(`/api/fabricantes/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, pais })
            }).then(response => response.json())
              .then(fabricante => {
                  const fabricanteData = document.querySelector(`.item[data-id="${id}"]`);
                  fabricanteData.querySelector('h3').textContent = `${fabricante.nombre} (${fabricante.pais})`;
                  document.getElementById('fabricanteUpdateForm').style.display = 'none';
              });
        });

        // Agregar Aeronave
        document.getElementById('aeronaveForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const nombre = document.getElementById('nombreAeronave').value;
            const fabricanteId = document.getElementById('fabricante').value;
            const anyoFabricacion = document.getElementById('anyoFabricacion').value;
            fetch('/api/aeronaves', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, fabricante: fabricanteId, anyoFabricacion })
            }).then(response => response.json())
              .then(() => {
                  cargarAeronaves();
                  document.getElementById('aeronaveForm').reset();
              });
        });

        // Editar Aeronave
        function editAeronave(id) {
            fetch(`/api/aeronaves/${id}`)
                .then(response => response.json())
                .then(aeronave => {
                    document.getElementById('updateAeronaveId').value = aeronave.id;
                    document.getElementById('updateNombreAeronave').value = aeronave.nombre; // Ahora debería estar correcto
                    document.getElementById('updateAnyoFabricacion').value = aeronave.anyoFabricacion;

                    const fabricanteSelect = document.getElementById('updateFabricante');
                    fabricanteSelect.innerHTML = ''; // Limpiar las opciones anteriores
                    Object.keys(fabricantes).forEach(fabricanteId => {
                        const option = document.createElement('option');
                        option.value = fabricanteId;
                        option.textContent = fabricantes[fabricanteId];
                        if (fabricanteId == aeronave.fabricante) option.selected = true;
                        fabricanteSelect.appendChild(option);
                    });

                    document.getElementById('aeronaveUpdateForm').style.display = 'block';
                })
                .catch(error => console.error("Error al obtener la aeronave:", error));
        }

        // Actualizar Aeronave
        document.getElementById('aeronaveUpdateForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('updateAeronaveId').value;
            const nombre = document.getElementById('updateNombreAeronave').value;
            const fabricanteId = document.getElementById('updateFabricante').value;
            const anyoFabricacion = document.getElementById('updateAnyoFabricacion').value;
            fetch(`/api/aeronaves/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, fabricante: fabricanteId, anyoFabricacion })
            }).then(response => response.json())
              .then(() => {
                  cargarAeronaves();
                  document.getElementById('aeronaveUpdateForm').style.display = 'none';
              });
        });

        // Eliminar Fabricante
        function deleteFabricante(id) {
            fetch(`/api/fabricantes/${id}`, { method: 'DELETE' })
                .then(() => {
                    document.querySelector(`.item[data-id="${id}"]`).remove();
                    document.querySelector(`#fabricante option[value="${id}"]`).remove();
                    delete fabricantes[id];
                    cargarAeronaves();
                });
        }

        // Eliminar Aeronave
        function deleteAeronave(id) {
            fetch(`/api/aeronaves/${id}`, { method: 'DELETE' })
                .then(() => {
                    document.querySelector(`.item[data-id="${id}"]`).remove();
                });
        }
    </script>
</body>
</html>
