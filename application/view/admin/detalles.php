<main>
    <form class="pedido-form" method="post" action="<?php echo URL; ?>pedidoController/crearDetalles">
        <input type="hidden" name="id_pedido" value="<?php echo $ultimo_id; ?>" required>

        <div class="contboton" id="mov1">
            <li class="liboton"><a href="#mov2"><i class="fas fa-arrow-down icon-custom"></i></a></li>
        </div>

        <?php foreach ($categorias as $categoriaNombre => $categoria) : ?>
            <h2 class="category-title" onclick="toggleTable('<?php echo $categoriaNombre; ?>')"><?php echo $categoriaNombre; ?></h2>
            <table class="pedido-table" id="table_<?php echo $categoriaNombre; ?>">
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categoria['productos'] as $producto) : ?>
                        <tr>
                            <td><input type="checkbox" name="productos_seleccionados[]" value="<?php echo $producto['id']; ?>" onchange="mostrarSalsas(this, <?php echo $producto['id']; ?>)" class="pedido-checkbox"></td>
                            <td><?php echo $producto['nombre']; ?></td>
                            <input type="hidden" name="producto_<?php echo $producto['id']; ?>" value="<?php echo $producto['nombre']; ?>">
                            <td><input type="number" id="cantidad_<?php echo $producto['id']; ?>" name="cantidad_<?php echo $producto['id']; ?>" value="1" min="1" class="pedido-quantity"></td>
                            <td><input type="number" name="valor_<?php echo $producto['id']; ?>" value="<?php echo $producto['precio']; ?>" min="0.01" step="0.01" readonly class="pedido-value"></td>
                        </tr>
                        <?php 
                        // Comentamos la sección de salsas, por si se requiere en el futuro
                        if ($categoria['adicion'] == '1') : ?>
                            <!--
                            <tr>
                                <td colspan="4">
                                    <div class="salsas-container" id="salsas_<?php echo $producto['id']; ?>"></div>
                                </td>
                            </tr>
                            -->
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>

        <div class="contboton" id="mov2">
            <li class="liboton"><a href="#mov1"><i class="fas fa-arrow-up icon-custom"></i></a></li>
        </div>

        <textarea name="observaciones" placeholder="Ingrese observaciones" class="pedido-input"></textarea>
        <input type="number" name="valor_total" id="total" readonly class="pedido-total">
        <input type="submit" name="detalles" value="Crear" class="pedido-submit">
    </form>
</main>
