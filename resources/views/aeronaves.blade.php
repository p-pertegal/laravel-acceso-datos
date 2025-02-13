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
    
    <h2>Agregar Nueva Aeronave</h2>
    <form id="aeronaveForm">
        <input type="text" id="nombreAeronave" placeholder="Nombre" required>
        <select id="fabricante" required>
            <option value="">Seleccione un Fabricante</option>
        </select>
        <input type="number" id="anyoFabricacion" placeholder="Año de Fabricación" required>
        <button type="submit">Agregar Aeronave</button>
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
                          <button onclick="deleteFabricante(${fabricante.id})">Eliminar</button>
                      </div>`;
                  document.getElementById('fabricante').innerHTML += `<option value="${fabricante.id}">${fabricante.nombre}</option>`;
                  document.getElementById('fabricanteForm').reset();
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

