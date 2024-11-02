<div class="container">
    <form class="formElimnar" action="<?php echo URL . 'pedidoController/eliminarTodosLosPedidos'; ?>" method="POST">
        <button class="btnEliminar" type="submit"
            onclick="return confirm('¿Estás seguro de eliminar todos los pedidos?')">Eliminar Todos los Pedidos</button>
    </form>

    <?php
    if (!empty($pedidosConDetalles)) {
        foreach ($pedidosConDetalles as $pedidoId => $pedido) {
            ?>
            <div class="pedido">
                <h2 class="titulo" onclick="togglePedido('<?php echo $pedidoId; ?>')">Pedido #<?php echo $pedidoId; ?></h2>
                <form class="formElimnar" action="<?php echo URL . 'pedidoController/eliminarPedido'; ?>" method="POST">
                    <input type="hidden" name="idPedido" value="<?php echo $pedidoId; ?>">
                    <button class="btnEliminar" type="submit" onclick="return confirm('¿Estás seguro de eliminar el pedido?')">
                        <img id="eliminarPedido" src="<?php echo URL; ?>img/eliminarProductoNegro.svg" alt="">
                    </button>
                </form>
                <div class="pedido-detalles" id="detalles_<?php echo $pedidoId; ?>" style="display: none;">
                    <p><strong>Cliente:</strong> <?php echo $pedido['nombre_cliente']; ?></p>
                    <p><strong>Teléfono:</strong> <?php echo $pedido['telefono']; ?></p>
                    <p><strong>Dirección de Entrega:</strong> <?php echo $pedido['direccion_entrega']; ?></p>
                    <?php if ($pedido['pagado'] == '1'): ?>
                        <p><strong>Estado:</strong> Pagado</p>
                    <?php else: ?>
                        <p><strong>Estado:</strong> No pagado</p>
                    <?php endif; ?>
                    <?php if ($pedido['recoger'] == '1'): ?>
                        <p><strong>Para Recoger:</strong> Si</p>
                    <?php else: ?>
                        <p><strong>Para recoger:</strong> No</p>
                    <?php endif; ?>
                    <p><strong>Valor sin Excedente:</strong> $<?php echo $pedido['valor_total']; ?></p>
                    <p><strong>Excedente:</strong> $<?php echo $pedido['excedente']; ?></p>
                    <p><strong>VALOR TOTAL:</strong> $<?php echo $pedido['suma_valores']; ?></p>
                    <p><strong>Observaciones:</strong> <?php echo $pedido['observacion']; ?></p>
                    <p><strong>Fecha del pedido: </strong> <?php echo $pedido['fecha_creacion']; ?></p>
                    <a href="<?php echo URL . 'pedidoController/generarPDFPedido/' . $pedidoId; ?>" target="_blank">
                        Descargar PDF del Pedido
                    </a>
                    <ul class="detalles">
                        <?php foreach ($pedido['detalles'] as $detalle) { ?>
                            <li class="detalle">
                                <p><strong>Producto:</strong> <?php echo $detalle['nombre']; ?></p>
                                <p><strong>Cantidad:</strong> <?php echo $detalle['cantidad']; ?></p>
                                <!-- <p><strong>Salsas:</strong> <?php echo $detalle['salsas']; ?></p> -->
                                <p><strong>Valor por Producto:</strong> $<?php echo $detalle['valor_producto']; ?></p>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<style>
        p {
            font-family: "Montserrat", sans-serif;
        }
      </style>';
        echo "<p>No hay pedidos actualmente.</p>";
    }
    ?>
</div>

<script>
    function togglePedido(pedidoId) {
        var detalles = document.getElementById('detalles_' + pedidoId);
        if (detalles.style.display === 'none' || detalles.style.display === '') {
            detalles.style.display = 'block';
        } else {
            detalles.style.display = 'none';
        }
    }

</script>