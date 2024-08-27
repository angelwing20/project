@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
<head>
    <title>Forgot Password</title>
    <style>
        /* 布局和对齐调整 */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
        }
        .card {
            width: 100%;
            max-width: 400px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-header {
            background-color: #000;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .card-body {
            padding: 30px;
        }
        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            height: 45px;
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #000;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #000;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            width: 100%;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #333;
        }
        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #000;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Forgot Password</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('forgot') }}" method="POST">
                    @csrf
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary">Send Verify Code</button>
                </form>
                <a href="{{ route('loginpage') }}">Back to Login</a>
            </div>
        </div>
    </div>
</body>
