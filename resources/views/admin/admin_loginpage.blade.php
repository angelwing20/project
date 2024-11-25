@session('message')
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endsession
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e1e2f 0%, #252539 100%);
            color: #ffffff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #373751;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            color: #ffffff;
            transition: box-shadow 0.3s ease;
        }

        .card:hover{
            box-shadow: 0px 12px 24px 24px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
            color: #ffffff;
        }

        .card-body {
            padding-top: 30px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #495057;
            border-radius: 10px;
            color: #ffffff;
            padding: 15px;
        }

        .form-control:focus {
            border-color: #ffb703;
            box-shadow: 0 0 10px rgba(255, 183, 3, 0.5);
        }

        .btn-primary {
            background: linear-gradient(135deg, #ffb703, #f77f00);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            color: #fff;
            margin-top: 30px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #f77f00, #ffb703);
            transform: scale(1.05);
        }

        .btn-primary:active{
            transform: scale(1);
        }

        .input-group-text {
            background: none;
            border: none;
            color: #ffffff;
            cursor: pointer;
        }

        .input-group-text:hover {
            color: #ffb703;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background: linear-gradient(180deg, black, transparent);">
                        Admin Login
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin_login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="name" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                @error('name')                                                                        
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text span1" id="toggle-password1">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <span class="input-group-text span2" id="toggle-password2">
                                            <i class="fa fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('.span2').hide();

            let password = $('#password');

            $('#toggle-password1').click(function() {
                let type = password.attr('type');
                if (type == 'password') {
                    password.attr('type', 'text');
                    $('.span1').hide();
                    $('.span2').show();
                }
            });

            $('#toggle-password2').click(function(){
                let type = password.attr('type');
                if (type == 'text') {
                    password.attr('type', 'password');
                    $('.span2').hide();
                    $('.span1').show();
                }
            });
        });

    </script>
</body>
</html>
