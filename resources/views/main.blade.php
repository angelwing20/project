@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
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
                    <p>{{ $product->mass }}g</p>
                    <p>RM{{ $product->price }}</p>
                </a>
                <form action="{{ route('addcart', $product->id) }}" method="post">
                    @csrf
                    <button class="btn btn-cart" type="submit">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </form>
            </div>
            @endforeach
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Vegetable</th>
                    <th>Per Mass (g)</th>
                    <th>Per Price (RM)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data2 as $item)
                <tr>
                    <td>
                        <img src="{{ asset("storage/".$item->picture) }}" alt="{{ $item->p_name }}" class="product-img"> 
                            {{ $item->p_name }}
                    </td>
                    <td>{{ $item->mass }}</td>
                    <td>{{ $item->price }}</td>
                    <td>
                        <a href="{{ route('view_detail', $item->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i> View Detail
                        </a><br>
                        <form action="{{ route('addcart', $item->id) }}" method="post" style="margin-top: 5px;">
                            @csrf
                            <button class="btn btn-cart" type="submit">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
        gap: 36px;
        border-bottom: 1px solid #ced4da;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .product-item {
        width: 150px;
        height: 225px; /* Increased height to accommodate button */
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
        margin-right: 5px; /* Space between icon and text */
    }
    .btn-cart:hover {
        background-color: #0056b3;
    }

    /* Table Styles */
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
</style>
@endsection
