<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <style>
        .formreset {
            width: 40%;
            background-color: #fafafa;
            border-radius: .5rem;
            padding: 2rem;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .buttongo {
            padding: 0.8rem 1.2rem;
            border: none;
            background-color: #e7ff00f7;
            border-radius: 5px;
        }
    </style>
    <h3>{{ $messenger }}</h3>
    <form action="http://localhost/Shop_clothes/public/auth/reset-password" method="GET" class="formreset">
        {{-- @csrf --}}
        <input type="text" style="display: none;" name='email' value='{{ $email }}'>
        <input type="text" style="display: none;" name='token' value='{{ $token }}'>
        <button class="btn btn-primary mb-3 buttongo">Go</button>
    </form>
</body>

</html>
