<style>
    .espacioExtra {
    height: 100px;
    
}
</style>

<main class="container_main">
<div class="espacioExtra">

</div>

    <div class="container2">

        <form action="<?php echo URL; ?>pedidoController/crearPedido" method="POST">
            <h1>Nuevo pedido</h1>

            <div class="form-group">
                <label for="nombre">Nombre del cliente:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="nombre">Direccion:</label>
                <input type="text" id="nombre" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono:</label>
                <input type="text" id="telefono" name="tel" required>
            </div>
            <div class="form-group">
                <label for="nombre">¿Fue pagado?</label>
                <select class="pedido-select" name="pagado">
                    <option value="no">No</option>
                    <option value="si">Si</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">¿Para Recoger?</label>
                <select class="pedido-select" name="recoger">
                    <option value="no">No</option>
                    <option value="si">Si</option>
                </select>
            </div>
            <div class="form-group">
                <label for="excedente">Excendente</label>
                <input type="number" id="excedente" name="excedente" required>
            </div>
            <input type="submit" name='crear_pedido' value="Realizar pedido">
        </form>
    </div>
</main>