<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<form action="{{ url('registraruser') }}" method="POST">
                @csrf
                <a href="{{url('login')}}">
                    <img src="img/logo.png" alt="">
                </a>
                <input type="text" name="nom_user" id="nom_user" placeholder="Nombre">
                <input type="email" name="user_user" id="user_user" placeholder="Correo">
                <input type="password" name="pass_user" id="pass_user" placeholder="Password">
                <button type="submit" id="button" class="registrar">Registrar</button>
            </form>
</body>
</html>