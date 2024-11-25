<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #000 !important;
        }
        .navbar-light .navbar-brand,
        .navbar-light .navbar-nav .nav-link {
            color: #fff !important;
        }
        .navbar-light .navbar-brand:hover,
        .navbar-light .navbar-nav .nav-link:hover {
            color: #ddd !important;
        }
        .navbar-light .navbar-toggler {
            border-color: #fff !important;
        }
        .navbar-light .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-width='2' linecap='round' linejoin='round' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .btn-link {
            color: #fff;
        }
        .btn-link:hover {
            color: #ddd;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #000;
            color: white;
            text-align: center;
        }
        .btn-primary {
            background-color: #000;
            border: none;
        }
        .btn-primary:hover {
            background-color: #333;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #000;
        }
        .alert-danger {
            margin-top: 10px;
        }
        .navbar-nav .nav-item {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .navbar .form-inline {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0; 
        }
        .navbar .form-inline .btn-link.logout-btn {
            margin: 0; 
            display: flex;
            align-items: center;
            justify-content: center; 
        }
        .navbar .nav-link.user-name {
            display: flex;
            align-items: center;
            color: #fff;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #333;
            transition: background-color 0.3s, color 0.3s;
            text-decoration: none; 
        }
        .navbar .nav-link.user-name i {
            margin-right: 8px; 
        }
        .navbar .nav-link.user-name:hover {
            background-color: #555;
            color: #ddd;
        }
        .navbar .btn-link.logout-btn {
            color: #fff;
            background-color: #dc3545; 
            border: none;
            border-radius: 5px;
            padding: 8px 15px; 
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s, border 0.3s;
            text-decoration: none; 
        }
        .navbar .btn-link.logout-btn i {
            margin-right: 8px; 
        }
        .navbar .btn-link.logout-btn:hover {
            background-color: #c82333; 
            color: #fff;
        }
        .navbar .btn-link.logout-btn:focus {
            box-shadow: none; 
        }
        .navbar .nav-item.cart {
            position: relative;
            margin-right: 20px; 
        }
        .navbar .nav-item.cart .cart-icon {
            color: #fff;
            font-size: 1.5rem;
        }
        .navbar .nav-item.cart .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: #dc3545;
            color: #fff;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
        }
        .navbar .nav-item.purchase-list {
            margin-right: 15px; 
        }
        .navbar .nav-item.purchase-list .purchase-icon {
            color: #fff;
            font-size: 1.5rem; 
        }
    </style>
</head>
<body style="font-family: 'Arial', sans-serif;">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="{{ route('main') }}">VegetableSHOP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto" style="display: flex;justify-content: center;flex-direction: row;align-items: center;margin:10px;">
                @auth
                    <li class="nav-item cart">
                        <a href="{{ route('cart') }}" class="nav-link position-relative">
                            <i class="fas fa-cart-arrow-down cart-icon"></i>

                            @if (auth()->check() && auth()->user()->cart->count() > 0)
                                <span class="badge badge-pill badge-danger position-absolute translate-middle" 
                                    style="top: 20%; right: 10%; transform: translate(50%, -50%);">
                                    {{ auth()->user()->cart->count() }}
                                </span>
                            @endif
                            
                        </a>
                    </li>      
                    <li class="nav-item purchase-list">
                        <a href="{{ route('purchase_list') }}" class="nav-link">
                            <i class="fas fa-clipboard-list purchase-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user') }}" class="btn nav-link user-name"><i class="fas fa-user"></i>{{ auth()->user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="form-inline">
                            @csrf
                            <button type="submit" class="btn btn-link logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('registerpage') }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('loginpage') }}">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    
    <div class="container mt-4">
        @yield('content')
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
