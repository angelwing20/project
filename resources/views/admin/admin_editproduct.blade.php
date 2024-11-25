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
    <title>Edit Product</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .back{
            background-color: #ffb703;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        .back:hover{
            color: black;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e1e2f 0%, #252539 100%);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #373751;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            color: #ffffff;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #495057;
            color: #ffffff;
        }

        .form-control:focus {
            border-color: #ffb703;
            box-shadow: 0 0 10px rgba(255, 183, 3, 0.5);
        }

        .btn-primary {
            background: linear-gradient(135deg, #ffb703, #f77f00);
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            color: #fff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #f77f00, #ffb703);
            transform: scale(1.05);
        }

        .product-img {
            width: 100%;
            max-width: 200px;
            max-height: 350px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        #total-price {
            font-weight: bold;
            font-size: 1.4rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div>
                        <a href="{{ route('admin_main') }}"><button type="button" class="back">Back</button></a>
                        <h2 class="text-center mb-4">Edit Product</h2> 
                    </div>
                    
                    <form action="{{ route('editproduct', $id->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center">
                            <img style="width: 600px;height: 200px;object-fit: cover;border-radius: 10px;margin-bottom: 20px;" src="{{ asset('storage/' . $id->picture) }}" alt="{{ $id->p_name }}" class="product-img" id="preview-img">
                        </div>
                        <div class="form-group">
                            <label for="picture">Picture:</label>
                            <input type="file" name="picture" id="picture" class="form-control" oninput="showPreview()">
                        </div>
                        <div class="form-group">
                            <label for="p_name">Product Name:</label>
                            <input type="text" name="p_name" id="p_name" class="form-control" value="{{ $id->p_name }}">
                        </div>
                        <div class="form-group">
                            <label for="mass">Stock (g):</label>
                            <input type="number" name="mass" id="mass" class="form-control" value="{{ $id->mass }}" min="100" step="50" oninput="updateTotalPrice()">
                        </div>
                        <div class="form-group">
                            <label for="price">Per 100g Price (RM):</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{ $id->price }}" min="1" oninput="updateTotalPrice()">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{ $id->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Total Price:</label>
                            <p id="total-price">RM{{ number_format($id->price, 2) }}</p>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPreview() {
            const fileInput = document.getElementById('picture');
            const previewImg = document.getElementById('preview-img');
            const file = fileInput.files[0];
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }

        function updateTotalPrice() {
            const massInput = document.getElementById('mass');
            const priceInput = document.getElementById('price');
            const totalPrice = document.getElementById('total-price');

            let mass = parseFloat(massInput.value);
            let price = parseFloat(priceInput.value);

            if (isNaN(mass) || mass < 100) mass = 100;
            if (isNaN(price) || price < 1) price = 1;

            const total = (price * mass) / 100;
            totalPrice.textContent = `RM${total.toFixed(2)}`;
        }

        updateTotalPrice();
    </script>
</body>
</html>
