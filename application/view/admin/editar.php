<body>
    <main class="container_main">
        <div class="container2">
            <form action="<?php echo URL; ?>productoController/editarproducto" method="POST">
                <h1>Editar Producto</h1>
                <input type="hidden" name="id" value="<?php echo $datosProducto['id']; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $datosProducto['nombre']; ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion"
                        value="<?php echo $datosProducto['descripcion']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" value="<?php echo $datosProducto['precio']; ?>"
                        required>
                </div>
                <input type="submit" name="Editar" value="Editar producto">
            </form>
        </div>
    </main>