<main class="container mt-4">
    <h2 class="mb-4">Resumen de Pedidos</h2>

    <!-- Formulario para buscar pedidos por fecha -->
    <form action="<?php echo URL . 'pedidoController/buscarPorFecha'; ?>" method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="date" name="fecha_inicio" class="form-control" placeholder="Fecha de inicio">
            </div>
            <div class="col-md-4">
                <input type="date" name="fecha_fin" class="form-control" placeholder="Fecha de fin">
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
                    <th>Excedente</th>
                    <th>Total Sin excedente</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resumen as $index => $dia): ?>
                    <tr style="background-color: <?php echo ($index % 2 == 0) ? '#374151' : '#2E3B4E'; ?>;">
                        <td><?php echo $dia->fecha; ?></td>
                        <td><?php echo $dia->cantidad_pedidos; ?></td>
                        <td><?php echo number_format($dia->suma_total_sin_excedente, 2); ?> COP</td> <!-- Suma de excedente -->
                        <td><?php echo number_format($dia->suma_total, 2); ?> COP</td> <!-- Suma total de valor_total -->
                        <td><?php echo number_format($dia->suma_total_con_excedente, 2); ?> COP</td> <!-- Suma de suma_valores -->

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
