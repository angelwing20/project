@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
@extends('header')
@section('content')  
<head>
    <title>VegetableSHOP</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #343a40;
            color: #fff;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="">
            <table>
                <tr>
                    <th>Vegatable</th>
                    <th>Per Mass</th>
                    <th>Per Price</th>
                    <th>Action</th>
                </tr>
                @foreach ($data as $item)
                <tr>
                    <td>
                        <img src="{{ asset("storage/".$item->picture) }}" alt=""><br>
                        <strong>{{ $item->p_name }}</strong>
                    </td>
                    <td>{{ $item->mass }}</td>
                    <td>{{ $item->price }}</td>
                    <td>
                        <a href="{{ route('view',$item->id) }}" class="btn">View</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </form>
    </div>
</body>
@endsection
