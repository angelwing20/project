@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
@extends('header')
@section('content')
<head>
    <title>Address</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Address</h1>
                <a href="{{ route('addaddress') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Add New Address
                </a>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Address</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->address1 }}, {{ $item->address2 }}, {{ $item->poscode }}, {{ $item->city }}, {{ $item->state }}</td>
                        <td>
                            <a href="{{ route('editaddress',$item->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Address
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('deleteaddress',$item->id ) }}" method="post" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Delete Address
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this address?");
        }
    </script>
</body>
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }
    .container {
        margin-top: 50px;
    }
    .table-container {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .table-container h1 {
        font-size: 2.5rem;
        color: #000;
        margin-bottom: 20px;
        text-align: center;
        border-bottom: 2px solid #ced4da;
        padding-bottom: 10px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
    }
    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ced4da;
    }
    th {
        background-color: #343a40;
        font-weight: bold;
        color: #fff;
    }
    tr:hover {
        background-color: #f2f2f2;
    }
    .btn {
        margin: 5px;
    }
    .btn-primary {
        background-color: #000;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #333;
    }
    .btn-warning {
        background-color: #ffc107;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }
    .btn-warning:hover {
        background-color: #e0a800;
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
</style>
@endsection
