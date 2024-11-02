<main class="cont_all">
  <div class="container">
    <div id="reminderList" class="reminder-listt">
      <?php foreach ($categorias as $categoria => $productos) : ?>
        <h2><?php echo $categoria; ?></h2>
        <?php foreach ($productos as $producto) : ?>
          <div class="reminder-item">
            <h2 class="reminder-title">
              <span>
                <span><?php echo $producto['nombre']; ?></span>
                <a href="<?php echo URL . 'productoController/editarOActualizarProducto?id=' . $producto['id']; ?>">
                  <img class="imgEditar" src="<?php echo URL; ?>img/pen-to-square-regular.svg" alt="">
                </a>
                <a id="iconos" href="<?php echo URL . 'productoController/eliminarProducto?id=' . $producto['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                  <img class="imgEditar" src="<?php echo URL; ?>img/eliminarProductoNegro.svg" alt="">
                </a>

                <span class="spanDesplegar">
                  <img class="imgDesplegar" src="<?php echo URL; ?>img/desplegar.png" alt="">
                </span>
              </span>
              <?php if (!empty($esAdmin['es_administrador'])) : ?>
                <form class="formR" action="<?php echo URL; ?>recordatorioController/eliminarRecordatorio" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este recordatorio?');">
                  <input type="hidden" name="id_recordatorio" value="<?php echo $producto['producto_id']; ?>" id="">
                  <input class="marcarHecho" name="eliminar_recordatorio" type="submit" value="Eliminar">
                </form>
                <form class="formR" action="<?php echo URL; ?>recordatorioController/editarRecordatorio" method="POST">
                  <input type="hidden" name="id_recordatorio" value="<?php echo $producto['producto_id']; ?>" id="">
                  <input type="hidden" name="titulo" value="<?php echo $producto['producto_nombre']; ?>" id="">
                  <input type="hidden" name="fecha_limite" value="<?php echo $producto['descripcion']; ?>" id="">
                  <input type="hidden" name="priorida" value="<?php echo $producto['precio']; ?>" id="">
                  <input class="marcarHecho" name="recordatorio_editar" type="submit" value="Editar">
                </form>
              <?php endif; ?>


            </h2>
            <div class="reminder-content">
              <div class="reminder-description">Descripción del producto: </br> <?php echo nl2br($producto['descripcion']) ?></div>
              <p class="reminder-date">Valor de producto:</br> <?php echo $producto['precio']; ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
  </div>
</main>