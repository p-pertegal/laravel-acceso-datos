<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabricante y Aeronave Management</title>
    <style>
        body {
            font-family: "MS Sans Serif", sans-serif;
            background-color: #c0c0c0;
            color: black;
            margin: 20px;
        }
        h1, h2 {
            background-color: #000080;
            color: white;
            padding: 5px;
            border: 2px solid white;
            text-align: center;
        }
        .item {
            margin-bottom: 10px;
            padding: 10px;
            border: 2px solid black;
            background-color: #d4d0c8;
            box-shadow: 2px 2px 0px white, -2px -2px 0px #808080;
        }
        button {
            font-family: inherit;
            background-color: #d4d0c8;
            border: 2px solid black;
            padding: 2px 5px;
            box-shadow: 2px 2px 0px white, -2px -2px 0px #808080;
            cursor: pointer;
        }
        button:active {
            box-shadow: inset 2px 2px 0px #808080, inset -2px -2px 0px white;
        }
        input, select {
            font-family: inherit;
            border: 2px solid black;
            background-color: #fff;
            padding: 2px;
        }
        form {
            background-color: #d4d0c8;
            padding: 10px;
            border: 2px solid black;
            box-shadow: 2px 2px 0px white, -2px -2px 0px #808080;
            margin-bottom: 10px;
        }
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
</body>
</html>
