@if (session()->has('message'))
    <script>
        window.alert("{{ session('message') }}")
    </script>
@endif
@extends('header')
@section('content')  
<head>
    <title>VegetableSHOP</title>
</head>
<body>
    <form action="">
        <table>
            
        </table>
    </form>
</body>
@endsection