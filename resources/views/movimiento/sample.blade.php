<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        /* Add your custom CSS styles here */
        h2 {
            color: #336699;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<table class="table table-sm table-condensed table-striped table-bordered" id="exTable">
    <thead class="tableThead thead-dark ">    
        <th scope="col">Abonos</th>
        <th scope="col">Prestamos</th>
        <th scope="col">Interes</th>
        <th scope="col">Salida</th>   
        <th scope="col">Entrada</th>
    </thead>
    <tbody>
        <tr>
        <td>{{$total}}</td>
        <td>{{$pr}}</td>
        <td>{{$interes}}</td>
        <td>{{$salida}}</td>
        <td>{{$entrada}}</td>
        </tr>
    </tbody>
</table>

<table class="table table-sm table-condensed table-striped table-bordered" id="exTable">
        <thead class="tableThead thead-dark ">
            <th scope="col">Valor</th>
            <th scope="col">Movimiento</th>
            <th scope="col">Cliente</th>
        </thead>
        <tbody>
            @foreach($movimiento as $movimientos)
                <tr>
                    @if($movimientos->entrada == '0')
                        <td>{{$movimientos->salida}}</td>
                    @else
                        <td>{{$movimientos->entrada}}</td>
                    @endif
                    <td>{{$movimientos->nomMvto}}</td>
                    <td>{{$movimientos->nombre}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>
  
    

    

    

