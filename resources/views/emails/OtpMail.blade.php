<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password OTP!</title>
</head>
<body>
    <form action="post">
        <h1>Important Message!</h1>
        <p>This is your verify code: {{ $user->verify_code }}</p>
        <a href="{{ route('verify_forgot',$user->email) }}">Click Here to Verify</a>
    </form>
</body>
</html>