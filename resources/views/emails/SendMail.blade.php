<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to VegeTable Shop!</title>
</head>
<body>
    <form action="post">
        <h1>Welcome to VegeTable Shop!</h1>
        <p>This is your verify code: {{ $user->verify_code }}</p>
        <a href="{{ route('verifypage') }}">Click Here To Active Your Account</a>
    </form>
</body>
</html>