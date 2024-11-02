<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo URL; ?>img/delico.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URL; ?>css/categoria_creacion_pedidos.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/recordatorios.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/detalles.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/admin.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/ver.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;0,600;1,200&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/029f250479.js" crossorigin="anonymous"></script>
    <title>Delilotzo-Pedidos</title>
</head>

<body>
    <header>
        <div class="invisible"></div>
        <div class="visible">

            <?php
            $n = 0;
            foreach ($infoCategoria as $categoria) : ?>
                <?php $n = $n + 1; ?>

                <button class="categorias">
                    <span class="span-p">
                        <a class="titulo_rol" href="#categoria<?php echo $n ?>"><?php echo $categoria['nombre']; ?></a>
                    </span>
                    <span class="span-s">
                        <span>
                            <form class="formR" action="<?php echo URL; ?>productoController/crearProducto/" method="POST">
                                <input type="hidden" name="id_categoria" value="<?php echo $categoria['id']; ?>">
                                <input type="image" name="crear" src="<?php echo URL; ?>img/añadirBlanco.png" alt="Editar">
                            </form>
                            <form class="formR" action="<?php echo URL; ?>categoriaController/eliminarCategoria/" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta Categoria?');">
                                <input type="hidden" name="eliminarCategoria" value="<?php echo $categoria['id']; ?>">
                                <input type="image" id="eliminar" name="eliminar" src="<?php echo URL; ?>img/eliminarProductoBlanco.svg" alt="Eliminar">
                            </form>

                        </span>
                    </span>
                </button>
            <?php endforeach; ?>

        </div>
    </header>
    <nav class="gestion">
        <div class="note">
            <div>
                <img src="<?php echo URL; ?>img/logotipo.png" alt="Logotipo">
            </div>
        </div>

        <div class="observacion">
            <a class="observar" href="<?php echo URL; ?>categoriaController/principal">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ffffff" d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
            </a>
            <a class="observar" href="<?php echo URL; ?>categoriaController/crearCategoria">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ffffff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
            </a>
            <a class="observar" href="<?php echo URL; ?>pedidoController/crearPedido">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ffffff" d="M416 0C400 0 288 32 288 176V288c0 35.3 28.7 64 64 64h32V480c0 17.7 14.3 32 32 32s32-14.3 32-32V352 240 32c0-17.7-14.3-32-32-32zM64 16C64 7.8 57.9 1 49.7 .1S34.2 4.6 32.4 12.5L2.1 148.8C.7 155.1 0 161.5 0 167.9c0 45.9 35.1 83.6 80 87.7V480c0 17.7 14.3 32 32 32s32-14.3 32-32V255.6c44.9-4.1 80-41.8 80-87.7c0-6.4-.7-12.8-2.1-19.1L191.6 12.5c-1.8-8-9.3-13.3-17.4-12.4S160 7.8 160 16V150.2c0 5.4-4.4 9.8-9.8 9.8c-5.1 0-9.3-3.9-9.8-9L127.9 14.6C127.2 6.3 120.3 0 112 0s-15.2 6.3-15.9 14.6L83.7 151c-.5 5.1-4.7 9-9.8 9c-5.4 0-9.8-4.4-9.8-9.8V16zm48.3 152l-.3 0-.3 0 .3-.7 .3 .7z"/></svg>
            </a>
            <a class="observar" href="<?php echo URL;?>pedidoController/ver">
                <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#ffffff" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H288V368c0-26.5 21.5-48 48-48H448V96c0-35.3-28.7-64-64-64H64zM448 352H402.7 336c-8.8 0-16 7.2-16 16v66.7V480l32-32 64-64 32-32z"/></svg>            
            </a>
                        <a class="observar" href="<?php echo URL;?>pedidoController/verResumenPedidos">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#e8eaed"><path d="M560-440q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM280-320q-33 0-56.5-23.5T200-400v-320q0-33 23.5-56.5T280-800h560q33 0 56.5 23.5T920-720v320q0 33-23.5 56.5T840-320H280Zm80-80h400q0-33 23.5-56.5T840-480v-160q-33 0-56.5-23.5T760-720H360q0 33-23.5 56.5T280-640v160q33 0 56.5 23.5T360-400Zm440 240H120q-33 0-56.5-23.5T40-240v-440h80v440h680v80ZM280-400v-320 320Z"/></svg>
            </a>
        </div>
        <a class="exit" href="<?php echo URL; ?>usuarioController/cerrarSesion">Salir</a>
    </nav>

    <div class="normalizar">
        <p>d</p>
    </div>
