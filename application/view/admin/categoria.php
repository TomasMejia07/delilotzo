
    <main class="container_main">
    <div class="container2">

        <form  action="<?php echo URL;?>categoriaController/crearCategoria" method="POST">
            <h1>Nueva Categoría de Productos</h1>

            <div class="form-group">
                <label for="nombre">Nombre de la Categoría:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <span>¿Se le adicionan salsas?</span>
                <input type="checkbox" id="adicion" name="adicion">
            </div>
            <input type="submit" name='crear' value="Guardar Categoría">
        </form>
    </div>
    </main>

