<?php
//requerir mdlPersona.php para evitar redundancia de dato
require_once "mdlPersona.php";

//crear la clase u objeto necesario para poder heradar si es necesario
class mdlPedido extends mdlPersona
{
    private $id_pedido;
    private $producto;
    private $salsas;
    private $cantidad;
    private $valor_producto;
    private $valor_total;
    private $pagado;
    private $recoger;
    private $nombre;
    private $fecha_creacion;
    private $id; // Definición de la propiedad $id

    public function __SET($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function __GET($atributo)
    {
        return $this->$atributo;
    }
    public function obtenerCategoria()
    {
        $sql = 'SELECT * from categorias_de_productos';

        $stm = $this->db->prepare($sql);

        if ($stm->execute()) {
            $infoCategoria = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $infoCategoria;
        } else {
            return false;
        }
    }
    public function obtenerPedido($idPedido)
    {
        // Lógica para obtener los detalles del pedido desde la base de datos
        // Debes implementar la lógica para obtener los detalles del pedido usando $idPedido
        // Esto puede ser mediante una consulta SQL a la tabla `pedidos`

        // Ejemplo de consulta SQL
        $sql = "SELECT * FROM pedidos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $idPedido);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function obtenerProductos()
    {
        $sql = "SELECT c.id AS categoria_id, c.nombre AS categoria, c.adicion, p.id AS producto_id, p.nombre AS producto_nombre, p.precio, p.descripcion FROM categorias_de_productos c
        LEFT JOIN productos p ON c.id = p.id_categoria
        ORDER BY c.id";
        $stm = $this->db->prepare($sql);

        $stm->execute();

        $categorias = array();

        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            $categoriaNombre = $row['categoria'];

            if (!array_key_exists($categoriaNombre, $categorias)) {
                $categorias[$categoriaNombre] = array(
                    'id' => $row['categoria_id'],
                    'adicion' => $row['adicion'],
                    'productos' => array()
                );
            }

            if (!empty($row['producto_id'])) {
                $producto = array(
                    'id' => $row['producto_id'],
                    'nombre' => $row['producto_nombre'],
                    'precio' => $row['precio'],
                    'descripcion' => $row['descripcion']
                );

                $categorias[$categoriaNombre]['productos'][] = $producto;
            }
        }

        return $categorias;
    }
    public function eliminarTodosLosPedidos()
    {
        $sql1 = "TRUNCATE TABLE detalles_de_pedido";
        $sql2 = "TRUNCATE TABLE pedidos";

        try {
            // Iniciar la transacción
            $this->db->beginTransaction();

            // Ejecutar la primera consulta
            $stm1 = $this->db->prepare($sql1);
            $stm1->execute();

            // Ejecutar la segunda consulta
            $stm2 = $this->db->prepare($sql2);
            $stm2->execute();

            // Confirmar la transacción
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Verificar si hay una transacción activa antes de hacer rollback
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            // Registrar el error para depuración
            error_log("Error al eliminar todos los pedidos: " . $e->getMessage());
            return true;
        }
    }

    public function guardarObservaciones($idPedido, $observaciones)
    {
        // Realizar la inserción de observaciones en la tabla 'observaciones' con la clave foránea del pedido
        $sql = "UPDATE pedidos SET observacion_texto = ? WHERE id = ?";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $observaciones);
        $stm->bindParam(2, $idPedido);

        return $stm->execute();
    }

    public function calcularSumaValores()
    {
        $sql = "UPDATE pedidos SET suma_valores = excedente + valor_total";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function obtenerExcedenteParaPedido($idPedido)
    {
        // Lógica para obtener el excedente para el pedido con el ID proporcionado
        // Supongamos que el excedente se obtiene de una tabla llamada 'excedentes' y se asocia con el pedido por su ID

        $sql = "SELECT excedente FROM pedidos WHERE id = ?";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $idPedido);
        $stm->execute();

        $excedente = $stm->fetch(PDO::FETCH_ASSOC);

        // Verifica si se obtuvo un resultado
        if ($excedente) {
            return $excedente['excedente'];
        } else {
            // Si no se encuentra ningún excedente para el pedido, puedes devolver un valor predeterminado o manejarlo según sea necesario
            return 0;
        }
    }



    //validar usuario
    public function crearPedido()
    {
        $sql = "INSERT INTO pedidos (direccion_entrega, nombre_cliente, telefono, valor_total, pagado, recoger, Excedente, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";


        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $this->direccion);
        $stm->bindParam(2, $this->nombre);
        $stm->bindParam(3, $this->telefono);
        $stm->bindParam(4, $this->valor_total);
        $stm->bindParam(5, $this->pagado);
        $stm->bindParam(6, $this->recoger);
        $stm->bindParam(7, $this->Excedente);
        $stm->bindParam(8, $this->fecha_creacion);
        if ($stm->execute()) {
            $sql = "SELECT MAX(id) AS ultimoIdPedido FROM pedidos";
            $query = $this->db->prepare($sql);
            $query->execute();
            $ultimoId = $query->fetch(PDO::FETCH_ASSOC);
            $ultimoIdValor = $ultimoId['ultimoIdPedido'];

            return $ultimoIdValor;

        } else {
            return false;
        }

    }
    public function obtenerPedidosConDetalles()
    {
        // se eliminó d.salsas del SELECT
        $sql = "SELECT p.*, d.producto, d.cantidad, d.valor_producto, p.excedente, p.observacion_texto, p.suma_valores 
                FROM pedidos p
                INNER JOIN detalles_de_pedido d ON p.id = d.id_pedido 
                ORDER BY p.id DESC";

        $stm = $this->db->prepare($sql);
        $stm->execute();

        $pedidosConDetalles = array();

        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            $pedidoId = $row['id'];
            $producto = array(
                'nombre' => $row['producto'],
                'cantidad' => $row['cantidad'],
                //'salsas' => $row['salsas'], // Comentado por si lo necesitas en el futuro
                'valor_producto' => $row['valor_producto'],
            );

            if (!array_key_exists($pedidoId, $pedidosConDetalles)) {
                $pedidosConDetalles[$pedidoId] = array(
                    'id' => $row['id'],
                    'direccion_entrega' => $row['direccion_entrega'],
                    'nombre_cliente' => $row['nombre_cliente'],
                    'telefono' => $row['telefono'],
                    'pagado' => $row['pagado'],
                    'recoger' => $row['recoger'],
                    'valor_total' => $row['valor_total'],
                    'excedente' => $row['excedente'],
                    'observacion' => $row['observacion_texto'],
                    'suma_valores' => $row['suma_valores'], // Agrega la columna 'suma_valores'
                    'fecha_creacion' => $row['fecha_creacion'],
                    'detalles' => array(),
                );
            }

            $pedidosConDetalles[$pedidoId]['detalles'][] = $producto;
        }

        return $pedidosConDetalles;
    }




    public function obtenerDetallesPedido($idPedido)
    {
        // Aquí debes escribir la lógica para obtener los detalles de los productos asociados a un pedido específico desde la base de datos
        // Esto puede ser mediante una consulta SQL a la tabla `detalles_de_pedido` usando el ID del pedido

        // Ejemplo simplificado
        $sql = "SELECT * FROM detalles_de_pedido WHERE id_pedido = :id_pedido";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedido', $idPedido);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function crearDetalles()
    {
        // Eliminar llamada recursiva innecesaria
        $sql = "INSERT INTO detalles_de_pedido (id_pedido, producto, cantidad, valor_producto) VALUES (?, ?, ?, ?)";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $this->id_pedido);
        $stm->bindValue(2, $this->producto);
        // $stm->bindValue(3, $this->salsas); // Comentado por si decides volver a usarlo
        $stm->bindValue(3, $this->cantidad);
        $stm->bindValue(4, $this->valor_producto);

        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function valorTotal()
    {
        $sql = "UPDATE pedidos SET valor_total = ? WHERE id = ?";

        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $this->valor_total);
        $stm->bindParam(2, $this->id_pedido);
        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }

    }
    public function eliminarPedidoPorId($idPedido)
    {
        // Iniciar la transacción
        try {
            $this->db->beginTransaction();

            // Primero, eliminar los detalles asociados al pedido en la tabla 'detalles_de_pedido'
            $sqlDetalles = "DELETE FROM detalles_de_pedido WHERE id_pedido = ?";
            $stmDetalles = $this->db->prepare($sqlDetalles);
            $stmDetalles->bindParam(1, $idPedido, PDO::PARAM_INT);
            $stmDetalles->execute();

            // Luego, eliminar el pedido en la tabla 'pedidos'
            $sqlPedido = "DELETE FROM pedidos WHERE id = ?";
            $stmPedido = $this->db->prepare($sqlPedido);
            $stmPedido->bindParam(1, $idPedido, PDO::PARAM_INT);
            $stmPedido->execute();

            // Confirmar la transacción
            $this->db->commit();

            // Verificar si la tabla 'pedidos' está vacía
            $sqlCount = "SELECT COUNT(*) FROM pedidos";
            $result = $this->db->query($sqlCount)->fetchColumn();

            if ($result == 0) {
                // Si la tabla está vacía, restablecer el AUTO_INCREMENT
                $sqlResetAutoIncrement = "ALTER TABLE pedidos AUTO_INCREMENT = 1";
                $this->db->exec($sqlResetAutoIncrement);
            }

            return true; // Eliminación exitosa

        } catch (Exception $e) {
            // Si ocurre un error, deshacer la transacción
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            // Registrar el error para depuración
            error_log("Error al eliminar el pedido y sus detalles: " . $e->getMessage());
            return false; // Fallo en la eliminación
        }
    }

    // Método para obtener la suma y cantidad de pedidos entre un rango de fechas
    public function obtenerSumaYCantidadPedidos($inicioDia, $finDia)
    {
        $sql = "SELECT 
                 SUM(valor_total) AS suma_total, 
                 SUM(suma_valores) AS suma_total_con_excedente, 
                 SUM(IFNULL(excedente, 0)) AS suma_excedentes, 
                 COUNT(*) AS cantidad_pedidos 
                   FROM pedidos 
                   WHERE fecha_creacion BETWEEN ? AND ?
                                                        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$inicioDia, $finDia]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }




    // Método para insertar el resumen de los pedidos del día en la tabla resumen_pedidos// Método para insertar el resumen de los pedidos del día en la tabla resumen_pedidos
    public function insertarResumenPedidos($fecha, $sumaTotal, $cantidadPedidos, $sumaConExcedente, $sumaExcedentes)
    {
        try {
            // Verificar si ya existe un resumen para esa fecha y eliminarlo si es necesario
            $existe = $this->existeResumenPorFecha($fecha);
            if ($existe) {
                $this->eliminarResumenPorFecha($fecha);
            }

            // Insertar el nuevo resumen del día
            $sql = "INSERT INTO resumen_pedidos (fecha, suma_total, cantidad_pedidos, suma_total_con_excedente, suma_total_sin_excedente) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$fecha, $sumaTotal, $cantidadPedidos, $sumaConExcedente, $sumaExcedentes]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    // Verificar si ya existe un resumen para una fecha
    public function existeResumenPorFecha($fecha)
    {
        try {
            $sql = "SELECT COUNT(*) FROM resumen_pedidos WHERE fecha = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$fecha]);
            return $stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Eliminar el resumen de una fecha específica
    public function eliminarResumenPorFecha($fecha)
    {
        try {
            $sql = "DELETE FROM resumen_pedidos WHERE fecha = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$fecha]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Obtener todos los pedidos de la tabla "resumen_pedidos"
    public function obtenerTodosLosPedidos()
    {
        try {
            $sql = "SELECT fecha, suma_total, cantidad_pedidos, suma_total_con_excedente,suma_total_sin_excedente
                FROM resumen_pedidos 
                ORDER BY fecha DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Buscar pedidos por rango de fecha en la tabla "resumen_pedidos"
    public function buscarPedidosPorFecha($fechaInicio, $fechaFin)
    {
        try {
            $sql = "SELECT fecha, suma_total, cantidad_pedidos, suma_total_sin_excedente,suma_total_con_excedente
                FROM resumen_pedidos 
                WHERE fecha BETWEEN ? AND ? 
                ORDER BY fecha DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$fechaInicio, $fechaFin]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Contar el total de días en la tabla "resumen_pedidos"
    public function contarTotalDias()
    {
        try {
            $sql = "SELECT COUNT(DISTINCT fecha) AS total_dias FROM resumen_pedidos";
            return $this->db->query($sql)->fetchColumn();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}


?>