<!DOCTYPE html>
<html>

<head>
    <style>
        /* Estilos CSS para la tabla de registros */
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-top: 50px;
            color: #333;
            margin: 0;
        }

        h1 {
            text-align: center;
            margin-top: 0px;
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border: 1px solid #464343;
        }

        h4 {
            text-align: left;
            margin-top: 0px;
            color: #333;
            margin: 0;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #5f5a5a;
        }

        tr:nth-child(even) {
            background-color: #8b8787;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .container {
            text-align: center;
        }

        .left-image {
            float: left;
            margin-right: 5px;
            width: 90px;
            height: 100px;
            /* Ajusta el margen derecho según tus necesidades */
        }

        .text-container {

            text-align: center;
        }
    </style>

</head>

<body>

    <div class="container">
        <img src="https://www.unsaac.edu.pe/wp-content/uploads/2023/03/escudo-1-1.png" class="left-image">
        <div class="text-container">
            <h2>MINISTERIO DE EDUCACIÓN</h2>
            <h2>GERENCIA REGIONAL DE EDUCACIÓN CUSCO</h2>
            <h2>{{ $institutoSeleccionado }}</h2>
            <h2 style="position:center">AUXILIAR ESTANDAR LIBRO BANCOS</h2>
        </div>
        <h2 style="float:right">MES DE {{ $mesSeleccionado }} DEL {{ $anioSeleccionado }}</h2>
        <h4>CUENTA CORRIENTE N° {{ $institutoCuentaCorriente }}</h4>
    </div>



    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>N°_Voucher</th>
                <th>N°_Cheque</th>
                <th>C_P</th>
                <th>Nombre y apellidos</th>
                <th>Detalle</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Saldo</th>
                <!-- Agrega más encabezados según tu estructura de tabla -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>SALDO ANTERIOR</th>
                <th></th>
                <th></th>
                <th>{{ $saldoAnterior }}</th>
                <!-- Agrega más encabezados según tu estructura de tabla -->
            </tr>
            @foreach ($registros as $registro)
                <tr>

                    <td>{{ $registro->Fecha }}</td>
                    <td>{{ $registro->N°_Voucher }}</td>
                    <td>{{ $registro->N°_Cheque }}</td>
                    <td>{{ $registro->C_P }}</td>
                    <td>{{ $registro->Nombres_y_Apellidos }}</td>
                    <td>{{ $registro->Detalle }}</td>
                    <td>{{ $registro->Entrada }}</td>
                    <td>{{ $registro->Salida }}</td>
                    <td>{{ $registro->Saldo }}</td>
                    <!-- Agrega más columnas según tu estructura de tabla -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
