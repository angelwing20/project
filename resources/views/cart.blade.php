@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
@extends('header')
@section('content')
<head>
    <title>Shopping Cart</title>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4"><i class="fas fa-shopping-cart"></i> Shopping Cart</h2>
        @if($cart->isEmpty())
            <p class="text-center"><i class="fas fa-exclamation-circle"></i> Your cart is empty!</p>
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
                        <td class="total-price">{{ number_format($item->cart_price*($item->cart_mass/100), 2) }}</td>
                        <td>
                            <a href="{{ route('deletecart',$item->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Remove</a>
                        </td>
                    </tr>
                    @php $total += $item->cart_price*($item->cart_mass/100); @endphp
                    @endforeach
                </tbody>
            </table>

            <!-- Pick-up or Delivery selection -->
            <div class="delivery-options mb-4">
                <label for="delivery-type">Select Pick-up or Delivery:</label>
                <div>
                    <input type="radio" name="delivery_type" id="pick-up" value="pick-up" checked>
                    <label for="pick-up">Pick-up</label>
                    <input type="radio" name="delivery_type" id="delivery" value="delivery" style="margin-left: 20px;">
                    <label for="delivery">Delivery</label>
                </div>
            </div>

            <!-- Address selection for Delivery -->
            <div class="address-selection mb-4" style="display: none;">
                <label for="address">Select Your Address:</label>
                <select class="form-control" id="address" name="address">
                    @foreach ($addresses as $address)
                        <option value="{{ $address->address1 }},{{ $address->address2 }},{{ $address->poscode }},{{ $address->city }},{{ $address->state }}">{{ $address->description }}</option>
                    @endforeach
                </select>
            </div>

            <div class="total-section">
                <h4 class="text-right">Total: RM<span id="grand-total">{{ number_format($total, 2) }}</span></h4>
                <button type="submit" class="btn btn-primary btn-lg float-right">
                    <i class="fas fa-credit-card"></i> Checkout
                </button>
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

    // Toggle address selection visibility based on delivery type
    document.querySelectorAll('input[name="delivery_type"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const addressSelection = document.querySelector('.address-selection');
            if (this.value === 'delivery') {
                addressSelection.style.display = 'block';
            } else {
                addressSelection.style.display = 'none';
            }
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
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-danger i, .btn-primary i {
        margin-right: 5px;
    }
</style>
@endsection
