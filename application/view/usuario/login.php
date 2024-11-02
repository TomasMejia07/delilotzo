<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Software de Pedidos</title>
    <link rel="stylesheet" href="<?php echo URL; ?>css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;0,600;1,200&display=swap" rel="stylesheet">
</head>

<body>
    <div class="contenedorrr">
            <div class="logotipo">
                <img src="<?php echo URL; ?>img/logotipo.png" alt="Logotipo">
            </div>
            <hr>
            <h1 class="titulo">Iniciar Sesión</h1>
            <form id="login-form" action="" method="post">
                <div class="form-group">
                    <input type="text" id="username" name="username" required placeholder="Usuario">
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" required placeholder="Contraseña">
                </div>
                <input type="submit" name='btnIngresar' value="Ingresar">
            </form>
    </div>
    <footer>
        <p>© Deli lotzo <span id="year"></span> By Tycom</p>
        <a href="https://tycom.co/">
            <img src="<?php echo URL; ?>img/simbolo_negro.png" alt="Logo" class="logoTycom">
        </a>
    </footer>

    <script>
        const year = new Date().getFullYear();
        document.getElementById('year').textContent = year;
    </script>
</body>

</html>