@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
@extends('header')
@section('content')
<head>
    <title>User Detail</title>
</head>
<body>
    <div class="container mt-5">
        <div class="user-details">
            <h1 class="text-center mb-4">User Detail</h1>
            <form action="{{ route('edituser',auth()->user()->id) }}" method="post" id="user-form">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name }}" readonly>
                        @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}" readonly>
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ic_number" class="col-sm-2 col-form-label">IC Number:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ic_number" id="ic_number" value="{{ auth()->user()->ic_number }}" readonly>
                        @error('ic_number')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gender" class="col-sm-2 col-form-label">Gender:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="gender" id="gender" value="{{ auth()->user()->gender }}" readonly>
                        @error('gender')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gender" class="col-sm-2 col-form-label">Address:</label>
                    <div class="col-sm-10">
                        <a href="{{ route('address') }}" class="view-address-link">
                            <button type="button" class="form-control view-address-button" name="gender" id="gender" readonly><b>View Address</b></button>
                        </a>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="button" class="btn btn-primary btn-block" id="edit-btn">Edit</button>
                        <button type="submit" class="btn btn-success btn-block d-none" id="success-btn">Success</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }
    .container {
        margin-top: 50px;
    }
    .user-details {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .user-details h1 {
        font-size: 2.5rem;
        color: #000;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        font-weight: bold;
        color: #333;
    }
    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #000;
    }
    .btn-primary {
        background-color: #000;
        border: none;
        border-radius: 5px;
        padding: 10px;
    }
    .btn-primary:hover {
        background-color: #333;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
        border-radius: 5px;
        padding: 10px;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    .alert-danger {
        margin-top: 10px;
        border-radius: 5px;
    }
    .view-address-link {
        text-decoration: none; /* 移除链接的下划线 */
        color: inherit; /* 继承父元素颜色 */
    }

    .view-address-button {
        cursor: pointer;
        border: none;
        background-color: transparent; /* 使按钮背景透明 */
        font-family: inherit;
        font-size: inherit;
        color: inherit; /* 保持按钮的文字颜色 */
        transition: background-color 0.3s; /* 添加背景颜色变化的过渡效果 */
    }

    .view-address-button:hover {
        text-decoration: none; /* 确保悬停时没有下划线 */
        background-color: #d0d0d0 !important; /* 悬停时背景变灰色，使用 !important 确保优先级 */
    }

    /* 额外样式以确保按钮不变色 */
    .view-address-link,
    .view-address-link:hover,
    .view-address-link:focus,
    .view-address-link:active {
        color: inherit;
        text-decoration: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('edit-btn');
        const successBtn = document.getElementById('success-btn');
        const formInputs = document.querySelectorAll('#user-form .form-control');

        editBtn.addEventListener('click', function() {
            formInputs.forEach(input => input.removeAttribute('readonly'));
            editBtn.classList.add('d-none');
            successBtn.classList.remove('d-none');
        });

        successBtn.addEventListener('click', function() {
            formInputs.forEach(input => input.setAttribute('readonly', true));
            editBtn.classList.remove('d-none');
            successBtn.classList.add('d-none');
        });
    });
</script>
