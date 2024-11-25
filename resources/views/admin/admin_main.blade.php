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
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e1e2f 0%, #252539 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            background-attachment: fixed;
        }

        .sidebar {
            width: 250px;
            background: #1e1e2f;
            padding: 20px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar a {
            text-decoration: none;
            color: #fff;
            padding: 15px 20px;
            display: block;
            margin-bottom: 15px;
            background: #373751;
            border-radius: 10px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #ffb703;
            color: #000;
        }

        .sidebar .logout {
            background: #ff4d4d;
            margin-top: auto;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            width: 100%;
        }

        .dashboard-header {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .info-card {
            background: #373751;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease;
        }

        .info-card:hover {
            box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.3);
        }

        .info-card h5 {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .info-card .count {
            font-size: 3rem;
            font-weight: 600;
            margin-top: 10px;
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
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #f77f00, #ffb703);
            transform: scale(1.05);
        }

        .content-section {
            display: none;
        }

        #dashboard {
            display: block;
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

        .alert-danger {
            margin-top: 10px;
        }

        .vegetable-item {
            border-radius: 10px;
            background: #373751;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 5px;
        }

        .vegetable-img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <a href="#" class="sidebar-link" data-target="#dashboard" style="background: #ffb703">Dashboard</a>
        <a href="#" class="sidebar-link" data-target="#order-list">Order List</a>
        <a href="#" class="sidebar-link" data-target="#manage">Manage Vegetables</a>
        <a href="#" class="sidebar-link" data-target="#add-student">Add New Vegetable</a>
        <a href="{{ route('admin_logout') }}" class="logout">Logout</a>
    </div>

    <div class="main-content">
        <div id="dashboard" class="content-section">
            <div class="dashboard-header">Admin Dashboard</div>

            <div class="row">
                <div class="col-md-4">
                    <div class="info-card">
                        <h5>Total Vegetables</h5>
                        <div class="count">{{ count($all) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <h5>Active Vegetables</h5>
                        <div class="count">{{ count($active) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <h5>Empty Vegetables</h5>
                        <div class="count">{{ count($empty) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div id="order-list" class="content-section">
            <h2>Order List</h2>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">Order Code</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Total Mass</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Delivery Type</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->groupBy('order_code') as $ordercode => $items)
                        @foreach ($items as $array => $list)
                            <tr style="border:3px solid silver">
                                @if ($array == 0)
                                    <td rowspan="{{ count($items) }}" style="border:3px solid silver">{{ $ordercode }}</td>
                                @endif
                                <td>
                                    <img class="vegetable-img" src="{{ asset('storage/'.$list->product->picture) }}" alt="{{ $list->product->p_name }}">
                                </td>
                                <td>{{ $list->product->p_name }}</td>
                                <td>{{ $list->mass }}g</td>
                                <td>RM {{ number_format($list->price, 2) }}</td>
                                <td>{{ $list->delivery_type }}</td>
                                <td>{{ is_null($list->address) ? '' : $list->address }}</td>
                                <td style="color: {{ $list->status == 'pending' ? 'red' : ($list->status == 'on-the-way' ? 'yellow' : 'green') }};">
                                    {{ $list->status }}
                                </td>
                                @if ($array == 0)
                                    <td rowspan="{{ count($items) }}" style="border:3px solid silver;">
                                        <a href="" class="btn btn-success" style="display: flex;justify-content:center;">Ready</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
                    

        <div id="manage" class="content-section">
            <div class="row">
                @foreach ($all as $item)
                    <div class="col-md-3">
                        <div class="vegetable-item info-card">
                            <p><b>{{ $item->p_name }}</b></p>
                            <img style="margin-bottom:5px" class="vegetable-img" src="{{ asset('storage/'.$item->picture) }}" alt="">
                            <p style="margin-bottom:0px"><b>Price: </b> RM {{ number_format($item->price, 2) }}</p>
                            <p style="margin-bottom:0px"><b>Stock: </b>{{ $item->mass }} g</p>
                            <form action="{{ route('edit',$item->id) }}" method="POST">
                                @csrf
                                @if ( $item->p_status=='Active' )
                                    <p style="color:rgb(43, 240, 43);margin-top:10px;display:flex;justify-content:center;"><b>{{ $item->p_status }}</b></p>
                                    <a href="{{ route('editproduct_page',$item->id) }}"><button class="btn btn-warning" type="button">Edit</button></a>
                                    <button class="btn btn-danger" type="submit">Empty</button>
                                @else
                                    <p style="color:rgb(240, 43, 43);margin-top:10px;display:flex;justify-content:center;"><b>{{ $item->p_status }}</b></p>
                                    <a href="{{ route('editproduct_page',$item->id) }}"><button class="btn btn-warning" type="button">Edit</button></a>
                                    <button class="btn btn-success" type="submit">Active</button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>        

        <div id="add-student" class="content-section">
            <h2>Add New Vegetable</h2>
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
                    <label for="mass">Total Mass (g):</label>
                    <input type="number" class="form-control" name="mass" id="mass" value="{{ old('mass', 100) }}" min="100" step="50">
                    @error('mass')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">Per 100g Price (RM):</label>
                    <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}">
                    @error('price')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description: (Optional)</label><br>
                    <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add Vegetable</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.sidebar-link').click(function(e) {
                e.preventDefault();  // 阻止链接的默认跳转行为

                var target = $(this).data('target');

                $('.content-section').hide();
                
                $(target).show();

                $('.sidebar-link').css('background', '');
                $(this).css('background', '#ffb703');
            });
        });
    </script>
</body>
</html>
