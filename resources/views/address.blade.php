<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Address</title>
</head>
<body>
    <table>
        <tr>
            <th><h1>Address</h1></th>
        </tr>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->address1,$item->address2,$item->poscode,$item->city,$item->state }}</td>
            <td>
                <form action="{{ route('editpage',$item->user_id) }}" method="post">
                    <button type="submit">Edit</button>
                </form>
            </td>
            <td>
                <form action="{{ route('delete') }}">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>