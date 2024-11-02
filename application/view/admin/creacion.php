
    
    <main class="container_main">
        <div class="container2">
            <form action="<?php echo URL; ?>productoController/crearProducto" method="POST">
                <h1>Nuevo producto</h1>
                <div class="form-group">
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" required>
                </div>
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" required>
                </div>
                <div class="form-group">
                    <label hidden for="id_categoria">ID Categoría:</label>
                    <input hidden type="text" id="id_categoria" name="id_categoria" value='<?php echo $id_categoria ?>' required>
                </div>
                <input type="submit" name='crear' value="Guardar producto">
            </form>
        </div>
    </main>