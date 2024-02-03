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
        <th scope="col">Nombre</th>
        <th scope="col">Prestado</th>
        <th scope="col">Pagado</th>
        <th scope="col">Cuotas</th> 
    </thead>
    <tbody>
        <tr>
            @foreach($result as $results)
                <tr>
                    <td>{{$results->nombre}}</td>
                    <td>{{$results->valorPrestado}}</td>
                    <td>{{$results->valorTotal}}</td>
                    <td>{{$results->numCuotas}}</td>
                </tr>
            @endforeach
        </tr>
    </tbody>
</table>    
</body>
</html>
  
    

    

    

