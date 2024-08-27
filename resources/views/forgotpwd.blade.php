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
    <title>Reset Password</title>
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* 基础样式和页面布局 */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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

        /* 表单样式 */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            height: 45px;
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #000;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
        .input-group {
            position: relative;
        }
        .input-group-text {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
        .input-group-text:hover {
            color: #000;
        }

        /* 按钮样式 */
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

        /* 链接样式 */
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
                <h2>Reset Password</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('reset_pwd', $email->email) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password">
                            <span class="input-group-text" id="toggle-password">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for toggle password visibility -->
    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            let passwordField = document.getElementById('password');
            let passwordFieldType = passwordField.getAttribute('type');

            if (passwordFieldType === 'password') {
                passwordField.setAttribute('type', 'text');
                this.querySelector('i').classList.remove('fa-eye');
                this.querySelector('i').classList.add('fa-eye-slash');
            } else {
                passwordField.setAttribute('type', 'password');
                this.querySelector('i').classList.remove('fa-eye-slash');
                this.querySelector('i').classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
