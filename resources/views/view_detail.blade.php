@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
@extends('header')
@section('content')
<head>
    <title>Product Detail</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 0px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .product-img {
            width: 100%;
            height: auto;
            max-height: 350px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 0px;
        }

        .product-name {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
            margin-right: 10px;
        }

        .form-group input {
            width: 100px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            text-align: center;
        }

        .total-price {
            font-size: 1.4rem;
            font-weight: bold;
            color: #000;
            text-align: center;
            margin-top: 20px;
        }

        .cart-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cart-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="{{ route('addcart_view',$data->id) }}" method="post">
        @csrf
        <div class="container">
            <img src="{{ asset("storage/".$data->picture) }}" alt="{{ $data->p_name }}" class="product-img">
            <p class="product-name">{{ $data->p_name }}</p>

            <div class="form-group">
                <label for="mass">Mass (g):</label>
                <input type="number" name="mass" id="mass" value="100" min="100" step="50" oninput="updateTotalPrice({{ $data->price }})">
            </div>

            <div class="total-price">
                <label for="total-price">Total Price:</label>
                <p id="total-price">RM{{ number_format($data->price, 2) }}</p>
            </div>

            <button type="submit" class="cart-btn">Add To Cart</button>
        </div>
    </form>
    

    <script>
        function updateTotalPrice(perprice) {
            const massInput = document.getElementById('mass');
            let mass = parseFloat(massInput.value);

            // 确保质量至少为 100g 且为 50g 的倍数
            if (isNaN(mass) || mass < 100) {
                mass = 100;
                massInput.value = mass;
            } else if (mass % 50 !== 0) {
                mass = Math.round(mass / 50) * 50;
                massInput.value = mass;
            }

            // 计算总价格，将质量转换为千克
            const totalPrice = perprice * (mass / 100);
            document.getElementById('total-price').textContent = `RM${totalPrice.toFixed(2)}`;
        }
    </script>
</body>
@endsection
