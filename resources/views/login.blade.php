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
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .input-group-text {
            cursor: pointer;
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
        a {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #000;
        }
        a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Login Form</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="toggle-password">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                            <a href="{{ route('registerpage') }}">Register Account</a>
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
    <!-- FontAwesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#toggle-password').click(function() {
                let passwordField = $('#password');
                let passwordFieldType = passwordField.attr('type');
                if (passwordFieldType == 'password') {
                    passwordField.attr('type', 'text');
                    $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
