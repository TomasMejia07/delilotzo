<main class="container mt-4">
    <h2 class="mb-4">Resumen de Pedidos</h2>

    <!-- Formulario para buscar pedidos por fecha -->
    <form id="buscador-form" action="<?php echo URL . 'pedidoController/verResumenPedidos'; ?>" method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" placeholder="Fecha de inicio">
            </div>
            <div class="col-md-4">
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" placeholder="Fecha de fin">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100" style="background-color: #ED1C24;">Buscar por fecha</button>
            </div>
        </div>
    </form>

    <!-- Botón de sumar pedidos del día -->
    <div class="d-flex justify-content-end mb-4">
        <form action="<?php echo URL . 'pedidoController/sumarPedidosDelDia'; ?>" method="POST" class="mb-0">
            <button type="submit" class="btn btn-primary" style="background-color: #ED1C24;">
                Sumar pedidos del día
            </button>
        </form>
    </div>

    <!-- Tabla de resumen de pedidos -->
    <div>
        <table class="table table-striped table-bordered text-center" style="border-radius: 10px; overflow: hidden; background-color: #212B3A; color: white;">
            <thead style="background-color: #ED1C24; color: #FDFBFB;">
                <tr>
                    <th>Fecha</th>
                    <th>Cantidad de Pedidos</th>
                    <th>Suma Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resumen as $index => $dia): ?>
                    <tr style="background-color: <?php echo ($index % 2 == 0) ? '#374151' : '#2E3B4E'; ?>;">
                        <td><?php echo $dia->fecha; ?></td>
                        <td><?php echo $dia->cantidad_pedidos; ?></td>
                        <td><?php echo number_format($dia->suma_total, 2); ?> COP</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    // Limpia el formulario después de buscar
    document.getElementById('buscador-form').addEventListener('submit', function() {
        setTimeout(function() {
            document.getElementById('fecha_inicio').value = '';
            document.getElementById('fecha_fin').value = '';
        }, 1000); // Espera un segundo antes de limpiar los campos
    });
</script>
