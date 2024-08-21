@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
@extends('header')
@section('content')
<head>
    <title>Add Address</title>
</head>
<body>
    <div class="container">
        <div class="address-form">
            <h1 class="text-center mb-4">Add New Address</h1>
            <form action="{{ route('addaddress') }}" method="post">
                @csrf
                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}" placeholder="Enter description">
                    </div>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Address 1 -->
                <div class="form-group">
                    <label for="address1">Address 1:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                        </div>
                        <input type="text" class="form-control" name="address1" id="address1" value="{{ old('address1') }}" placeholder="Enter address line 1">
                    </div>
                    @error('address1')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Address 2 -->
                <div class="form-group">
                    <label for="address2">Address 2:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                        </div>
                        <input type="text" class="form-control" name="address2" id="address2" value="{{ old('address2') }}" placeholder="Enter address line 2">
                    </div>
                    @error('address2')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Poscode -->
                <div class="form-group">
                    <label for="poscode">Poscode:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                        </div>
                        <input type="text" class="form-control" name="poscode" id="poscode" value="{{ old('poscode') }}" placeholder="Enter postal code">
                    </div>
                    @error('poscode')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- City -->
                <div class="form-group">
                    <label for="city">City:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                        </div>
                        <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}" placeholder="Enter city">
                    </div>
                    @error('city')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- State/Province -->
                <div class="form-group">
                    <label for="state">State/Province:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map"></i></span>
                        </div>
                        <input type="text" class="form-control" name="state" id="state" value="{{ old('state') }}" placeholder="Enter state/province">
                    </div>
                    @error('state')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Add Address">
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }
    .container {
        margin-top: 50px;
    }
    .address-form {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .address-form h1 {
        font-size: 2.5rem;
        color: #000;
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: bold;
        color: #333;
    }
    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px;
        position: relative;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #000;
    }
    .input-group-text {
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 5px 0 0 5px;
    }
    .btn-primary {
        background-color: #000;
        border: none;
        border-radius: 5px;
        padding: 10px;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #333;
    }
    .btn-primary:active {
        background-color: #000;
        box-shadow: 0 5px #666;
        transform: translateY(4px);
    }
    .alert-danger {
        margin-top: 10px;
    }
</style>
@endsection