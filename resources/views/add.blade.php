@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Vegetable</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #000;
            color: white;
            text-align: center;
        }
        .card-body {
            background: linear-gradient(145deg, #f0f0f0, #ffffff);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1>Add Vegetable</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('add') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="p_name">Vegetable Name:</label>
                                <input type="text" class="form-control" name="p_name" id="p_name" value="{{ old('p_name') }}">
                                @error('p_name')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="picture">Picture:</label>
                                <input type="file" class="form-control-file" name="picture" id="picture">
                                @error('picture')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="mass">Mass (Per g):</label>
                                <!-- Adding the min and step attributes as per your requirement -->
                                <input type="number" class="form-control" name="mass" id="mass" value="{{ old('mass', 100) }}" min="100" step="50" oninput="enforceMassLimit()">
                                @error('mass')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Price (RM):</label>
                                <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}">
                                @error('price')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Add Vegetable</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function enforceMassLimit() {
            const massInput = document.getElementById('mass');
            let mass = parseFloat(massInput.value);

            // Ensure mass is at least 100g and a multiple of 50g
            if (isNaN(mass) || mass < 100) {
                mass = 100;
            } else if (mass % 50 !== 0) {
                mass = Math.round(mass / 50) * 50;
            }
            massInput.value = mass;
        }

        document.addEventListener('DOMContentLoaded', function() {
            enforceMassLimit();
        });
    </script>
</body>
</html>
