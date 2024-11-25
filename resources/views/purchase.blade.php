@session('message')
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endsession

@extends('header')

@section('content')
<body style="background-color: #f8f9fa;">
   <div class="container mt-5">
        <h2 class="text-center mb-4">Purchase List</h2>
        
        @if($checkout->isEmpty())
            <div class="alert alert-info text-center">
                No purchases found.
            </div>
        @else
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Total Mass (g)</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checkout as $order_code => $purchases)
                        <tr>
                            <td colspan="6"><strong>Order Code: {{ $order_code }}</strong></td>
                        </tr>
                        @foreach($purchases as $index => $purchase)
                            <tr {{ $purchase->status == 'cancelled'? 'style=opacity:0.6' : '' }}>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><a href="{{ route('view_detail',$purchase->product->id) }}">
                                    <img src="{{ asset('storage/'.$purchase->product->picture) }}" alt="{{ $purchase->product->picture }}">
                                    {{ $purchase->product->p_name }}</a>
                                </td>
                                <td>{{ $purchase->mass }} g</td>
                                <td>RM {{ number_format($purchase->price, 2) }}</td>
                                <td>{{ $purchase->status }}</td>
                                <td>   
                                    <a href="{{ route('cancel_order',$purchase->id) }}" style="text-decoration: none; color: white;">
                                        <button type="button" class="btn btn-danger" {{ $purchase->status == 'cancelled'? 'disabled' : '' }}>Cancel</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        
                    @endforeach
                </tbody>
            </table>
        @endif
    </div> 
</body>
<style>
    img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 10px;
    }
</style>

@endsection