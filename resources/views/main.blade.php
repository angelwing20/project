@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}");
    </script>
@endif
@extends('header')
@section('content')
<head>
    <title>VegetableSHOP</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <div class="container">
        <h2>New Products</h2>
        <div class="latest-products d-flex justify-content-start flex-wrap mb-4">
            @foreach ($data as $product)
            <div class="product-item text-center">
                <a href="{{ route('view_detail', $product->id) }}">
                    <img src="{{ asset("storage/".$product->picture) }}" alt="{{ $product->p_name }}" class="product-img">
                    <h5>{{ $product->p_name }}</h5>
                    <p>100 g</p>
                    <p>RM{{ $product->price }}</p>
                    <p><b>Stock: {{ $product->mass }} g</b></p>
                </a>
                <form action="{{ route('addcart', $product->id) }}" method="post">
                    @csrf
                    <button class="btn btn-cart" type="submit" {{ $product->mass <= 0 ? 'disabled style=opacity:0.5' : '' }}>
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </form>
            </div>
            @endforeach
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vegetable</th>
                        <th>Stock (g)</th>
                        <th>Per Price (RM)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data2 as $item)
                    <tr>
                        <td>
                            <a href="{{ route('view_detail', $item->id) }}">
                                <img src="{{ asset("storage/".$item->picture) }}" alt="{{ $item->p_name }}" class="product-img">
                            </a>
                            <div style="display: flex; justify-content: space-between;">
                                <p><b>{{ $item->p_name }}</b></p>
                                
                            </div> <p>From {{ $item->created_at }}</p>
                        </td>
                        <td>{{ $item->mass }} g</td>
                        <td>RM {{ $item->price }}</td>
                        <td>
                            <a href="{{ route('view_detail', $item->id) }}" class="btn btn-primary">
                                <i class="fas fa-eye"></i> View Detail
                            </a><br>
                            <form action="{{ route('addcart', $item->id) }}" method="post" style="margin-top: 5px;">
                                @csrf
                                <button class="btn btn-cart" type="submit" {{ $item->mass <= 0 ? 'disabled style=opacity:0.5' : '' }}>
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $data2->links('pagination::bootstrap-4') }}
        </div>        
    </div>
</body>
<style>
    .container {
        margin-top: 20px;
    }
    .latest-products {
        display: flex;
        border-bottom: 1px solid #ced4da;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .product-item {
        width: 150px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }
    .product-img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        margin-bottom: 5px;
    }
    .product-item h5 {
        margin: 0;
        font-size: 0.9rem;
    }
    .product-item p {
        margin: 0;
        font-size: 0.8rem;
        color: #666;
    }
    .btn-cart {
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        color: #fff;
        padding: 10px;
        font-size: 0.9rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: background-color 0.3s;
    }
    .btn-cart i {
        margin-right: 5px;
    }
    .btn-cart:hover {
        background-color: #0056b3;
        color: white;
    }

    .table-responsive {
        overflow-x: auto;
        margin-top: 20px;
    }
    .table {
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
        color: #fff;
    }
    tr {
        background-color: #fff;
    }
    tr:hover {
        background-color: #d0d0d0;
    }
    .btn-primary {
        background-color: #000;
        border: none;
        border-radius: 5px;
        padding: 10px;
        display: flex;
        align-items: center;
    }
    .btn-primary i {
        margin-right: 5px;
    }
    .btn-primary:hover {
        background-color: #333;
    }

    @media (max-width: 768px) {
        .table {
            font-size: 0.9rem;
        }

        th, td {
            padding: 10px;
        }

        th:nth-child(3), td:nth-child(3) {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .table {
            font-size: 0.8rem;
        }

        th, td {
            padding: 8px;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        th:nth-child(2), td:nth-child(2) {
            display: none;
        }
    }
</style>
@endsection
