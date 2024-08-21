@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
@extends('header')
@section('content')

<head>
    <title>Shopping Cart</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Shopping Cart</h2>
        @if($cart->isEmpty())
            <p class="text-center">Your cart is empty!</p>
        @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vegetable</th>
                        <th>Mass (g)</th>
                        <th>Price (RM)</th>
                        <th>Total Price (RM)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart as $item)
                    <tr>
                        <td>
                            <img src="{{ asset("storage/".$item->product->picture) }}" alt="{{ $item->product->p_name }}" class="cart-img">
                            {{ $item->product->p_name }}
                        </td>
                        <td>
                            <input type="number" name="mass" value="{{ $item->cart_mass }}" min="100" step="50" class="mass-input" data-price="{{ $item->product->price }}">
                        </td>
                        <td>{{ number_format($item->product->price, 2) }}</td>
                        <td class="total-price">{{ number_format($item->cart_price, 2) }}</td>
                        <td>
                            <form action="{{ route('deletecart',$item->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @php $total += $item->cart_price; @endphp
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <h4 class="text-right">Total: RM<span id="grand-total">{{ number_format($total, 2) }}</span></h4>
                <a href="" class="btn btn-primary btn-lg float-right">Checkout</a>
            </div>
        @endif
    </div>
</body>

<script>
    document.querySelectorAll('.mass-input').forEach(function(input) {
        input.addEventListener('input', function() {
            const price = parseFloat(this.dataset.price);
            const mass = parseFloat(this.value);
            const newTotalPrice = (mass / 100) * price;

            this.closest('tr').querySelector('.total-price').textContent = newTotalPrice.toFixed(2);

            // Recalculate the grand total
            let grandTotal = 0;
            document.querySelectorAll('.total-price').forEach(function(priceElement) {
                grandTotal += parseFloat(priceElement.textContent);
            });
            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
        });
    });
</script>

<style>
    .container {
        margin-top: 30px;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .cart-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 10px;
    }
    .total-section {
        margin-top: 20px;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
</style>
@endsection
