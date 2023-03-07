<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

                <form action="{{ url('loginpost') }}" method="POST">
                @csrf
                    <div class="inputs-modal">
                        <input type="email" name="email" id="email" placeholder="Correo">
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="button-modal">
                        <button type="submit" id="button" class="nav-button"><b>Iniciar Sesión</b></button>
                    </div>
                </form>
                <a href="{{ url('registro') }}"><button class="boton-restaurantes"><b>Regístrate ahora</b></button></a>
     <!-- NAVBAR -->
    
</body>
</html>