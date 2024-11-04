<?php
class pedidoController extends Controller
{
    private $modeloP;

    public function __construct()
    {
        $this->modeloP = $this->loadModel("mdlPedido");
    }

    public function principal()
    {
        header("Location: " . URL . "asignaturaController/principal");
    }

    public function crearPedido()
    {
        $fecha_creacion = date('Y-m-d H:i:s');
        $error = false;

        //validar si las variables $_SESSION están activas
        if (isset($_POST['crear_pedido'])) {
            if (isset($_POST['crear'])) {
                $infoCategoria = $this->modeloP->obtenerCategoria();
                $n = 0;

                require APP . 'view/_templates/header.php';
                require APP . 'view/admin/pedidos.php';
                require APP . 'view/_templates/footer.php';
            } else {
                $this->modeloP->__SET('nombre', $_POST['nombre']);
                $this->modeloP->__SET('telefono', $_POST['tel']);
                $this->modeloP->__SET('direccion', $_POST['direccion']);
                $this->modeloP->__SET('valor_total', 0);
                $this->modeloP->__SET('Excedente', $_POST['excedente']); // Asigna el valor del formulario a la propiedad Excedente
                $pedidosConDetalles = $this->modeloP->obtenerPedidosConDetalles();

                $this->modeloP->__SET('fecha_creacion', $fecha_creacion);
                // Iterar sobre los pedidos con detalles
                foreach ($pedidosConDetalles as &$pedido) {
                    if (isset($pedido['id'])) {
                        $excedente = $this->modeloP->obtenerExcedenteParaPedido($pedido['id']);
                    } else {
                        echo "La clave 'id' no está definida para el pedido.";
                    }
                    $pedido['excedente'] = $excedente;
                }

                if ($_POST['pagado'] == 'si') {
                    $this->modeloP->__SET('pagado', '1');
                } else {
                    $this->modeloP->__SET('pagado', '0');
                }

                if ($_POST['recoger'] == 'si') {
                    $this->modeloP->__SET('recoger', '1');
                } else {
                    $this->modeloP->__SET('recoger', '0');
                }

                $ultimo_id = $this->modeloP->crearPedido();
                $_SESSION['ultimo_id'] = $ultimo_id;

                header("Location: " . URL . "pedidoController/crearDetalles");
            }
        } else {
            $infoCategoria = $this->modeloP->obtenerCategoria();
            $n = 0;
            $categorias = $this->modeloP->obtenerProductos();

            require APP . 'view/_templates/header.php';
            require APP . 'view/admin/pedidos.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function crearDetalles()
    {
        if (isset($_POST['detalles'])) {
            if (isset($_POST['detalles'])) {
                $id_pedido = $_POST['id_pedido'];
                $productos_seleccionados = $_POST['productos_seleccionados'];
                $observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : '';

                $idPedido = isset($_POST['id_pedido']) ? $_POST['id_pedido'] : null;
                $observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : '';

                $guardarObservaciones = $this->modeloP->guardarObservaciones($idPedido, $observaciones);

                foreach ($productos_seleccionados as $producto_id) {
                    $cantidadInput = $_POST['cantidad_' . $producto_id];
                    $cantidad = isset($cantidadInput) ? intval($cantidadInput) : 0;

                    // Bloque de salsas comentado por si es necesario en el futuro
                    /*
                $salsas = array();
                for ($i = 1; $i <= $cantidad; $i++) {
                    $salsasProducto = [];
                    for ($j = 1; $j <= 18; $j++) {
                        $salsaKey = 'salsa' . $j . '_' . $producto_id . '_' . $i;
                        if (isset($_POST[$salsaKey])) {
                            $salsasProducto[] = $_POST[$salsaKey];
                        }
                    }
                    $salsas[] = $salsasProducto ? implode(", ", $salsasProducto) : "Sin salsas";
                }
                $salsas_str = implode(' | ', $salsas);
                */

                    $valor = $_POST['valor_' . $producto_id];
                    $producto = $_POST['producto_' . $producto_id];
                    $observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : '';

                    // Configuramos los valores en el modelo
                    $this->modeloP->__SET('observaciones', $observaciones);
                    $this->modeloP->__SET('id_pedido', $id_pedido);
                    $this->modeloP->__SET('producto', $producto);
                    // $this->modeloP->__SET('salsas', $salsas_str); // Comentado el envío de las salsas
                    $this->modeloP->__SET('cantidad', $cantidad);
                    $this->modeloP->__SET('valor_producto', $valor);
                    $this->modeloP->__SET('valor_total', $_POST['valor_total']);

                    $this->modeloP->crearDetalles(); // Insertar los detalles del pedido
                }

                $this->modeloP->__SET('id_pedido', $id_pedido);
                $this->modeloP->valorTotal();
                $this->modeloP->calcularSumaValores();
            } else {
                echo "Faltan datos del formulario.";
            }
            header("Location: " . URL . "pedidoController/ver");
        } else {
            // Si no hay detalles enviados, mostramos la vista de crear detalles
            $ultimo_id = $_SESSION['ultimo_id'];
            $infoCategoria = $this->modeloP->obtenerCategoria();
            $n = 0;
            $categorias = $this->modeloP->obtenerProductos();

            require APP . 'view/_templates/header.php';
            require APP . 'view/admin/detalles.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function generarPDFPedido($idPedido)
    {
        // Obtener información del pedido desde la base de datos
        $pedidoInfo = $this->modeloP->obtenerPedido($idPedido);
        $detallesPedido = $this->modeloP->obtenerDetallesPedido($idPedido);
        $observaciones = $pedidoInfo['observacion_texto']; // Asegúrate de obtener las observaciones correctamente

        // Eliminar saltos de línea y espacios adicionales

        // Incluir la librería de generación de PDF (TCPDF)
        require('../TCPDF-main/tcpdf.php'); // Asegúrate de que la ruta sea correcta

        // Estimar la altura necesaria para el contenido
        $alturaEstimada = $this->estimarAlturaContenido($pedidoInfo, $detallesPedido, $observaciones);

        // Crear un nuevo objeto PDF con configuración de tamaño de papel dinámico
        $pdf = new TCPDF('P', 'mm', array(80, $alturaEstimada), 'UTF-8', false);
        $pdf->SetMargins(5, 5, 5); // Establecer márgenes
        $pdf->SetAutoPageBreak(false, 0); // Desactivar el salto automático de página
        $pdf->AddPage();

        // Agregar imagen al PDF (encabezado)
        $imagePath = '../public/img/logotipo.jpg'; // Asegúrate de que la ruta sea correcta
        $pdf->Image($imagePath, 25, 10, 30, 30, 'JPG'); // Ajusta las coordenadas y el tamaño según sea necesario
        $pdf->Ln(35); // Añadir espacio después de la imagen

        // Nombre de la tienda
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Delilotzo', 0, 1, 'C');

        // Información de la factura
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 8, 'Factura de Venta #' . $idPedido, 0, 1, 'C');
        $pdf->Cell(0, 8, 'Fecha: ' . $pedidoInfo['fecha_creacion'], 0, 1, 'C');

        // Información del cliente
        $pdf->Cell(0, 8, 'Cliente: ' . $pedidoInfo['nombre_cliente'], 0, 1, 'C');
        $pdf->Cell(0, 8, 'Teléfono: ' . $pedidoInfo['telefono'], 0, 1, 'C');
        $pdf->MultiCell(0, 8, 'Dirección: ' . $pedidoInfo['direccion_entrega'], 0, 'C');


        // Detalles del pedido
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 10, 'Productos', 0, 1);

        $pdf->SetFont('helvetica', '', 10);
        foreach ($detallesPedido as $detalle) {
            $pdf->MultiCell(0, 8, 'Producto: ' . $detalle['producto'], 0, 'L');
            $pdf->MultiCell(0, 8, 'Cantidad: ' . $detalle['cantidad'], 0, 'L');
            $pdf->MultiCell(0, 8, 'Valor: ' . $detalle['valor_producto'], 0, 'L');
            $pdf->Ln(2); // Añadir un pequeño espacio entre los productos
        }

        // Resumen de pago
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 10, 'Resumen de Pago', 0, 1);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 8, 'Valor sin Excedente:', 0, 0);
        $pdf->Cell(0, 8, $pedidoInfo['valor_total'], 0, 1, 'R');
        if (isset($pedidoInfo['excedente'])) {
            $pdf->Cell(0, 8, 'Excedente:', 0, 0);
            $pdf->Cell(0, 8, $pedidoInfo['excedente'], 0, 1, 'R');
        } else {
            $pdf->Cell(0, 8, 'Excedente:', 0, 0);
            $pdf->Cell(0, 8, 'No Impuesto', 0, 1, 'R');
        }
        $sumaValores = $pedidoInfo['excedente'] + $pedidoInfo['valor_total'];
        $pdf->Cell(0, 8, 'VALOR TOTAL:', 0, 0);
        $pdf->Cell(0, 8, $sumaValores, 0, 1, 'R');
        $pdf->Cell(0, 8, 'Pagado:', 0, 0);
        $pdf->Cell(0, 8, ($pedidoInfo['pagado'] ? 'Sí' : 'No'), 0, 1, 'R');
        $pdf->Cell(0, 8, 'Para Recoger:', 0, 0);
        $pdf->Cell(0, 8, ($pedidoInfo['recoger'] ? 'Sí' : 'No'), 0, 1, 'R');

        // Observaciones
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(0, 10, 'Observaciones:', 0, 1);
        $pdf->SetFont('helvetica', '', 12);
        if (!empty($observaciones)) {
            $pdf->MultiCell(0, 8, $observaciones, 0, 'L');
        } else {
            $pdf->Cell(0, 8, 'No hay observaciones', 0, 1);
        }

        // Salida del PDF (descarga o visualización en el navegador)
        $pdf->Output('pedido_' . $idPedido . '.pdf', 'D'); // Descargar el PDF con un nombre específico
    }
    private function estimarAlturaContenido($pedidoInfo, $detallesPedido, $observaciones)
    {
        // Estimar la altura basada en el contenido
        $altura = 0;

        // Altura fija para encabezado e información general
        $altura += 30; // Espacio para la imagen (30 mm + 5 mm de margen)
        $altura += 10; // Altura del nombre de la tienda
        $altura += 8 * 4; // Información de la factura y cliente (4 líneas de 8 mm cada una)

        // Altura para los detalles del pedido
        $altura += 10; // Título 'Productos'
        foreach ($detallesPedido as $detalle) {
            $altura += 8 * 3 + 2; // 3 líneas por producto + 2 mm de espacio entre productos
        }

        // Altura para el resumen de pago
        $altura += 10; // Título 'Resumen de Pago'
        $altura += 8 * 8; // Detalles del pago (8 líneas de 8 mm)

        // Altura para las observaciones
        $altura += 10; // Título 'Observaciones'

        if (!empty($observaciones)) {
            // Contar el número de saltos de línea
            $lineasObservaciones = substr_count($observaciones, "\n") + 1; // +1 para la última línea
            // Calcular la longitud del texto en caracteres
            $textoLargo = strlen($observaciones); // Mantener el texto original
            // Aproximar el número de líneas necesarias para el texto largo
            $lineasTexto = ceil($textoLargo / 50); // Ajusta 50 según el ancho

            // Sumar la altura para las líneas de observaciones
            $altura += ($lineasTexto + $lineasObservaciones) * 8; // Sumar 8 mm por cada línea
        }

        return $altura;
    }


    public function eliminarTodosLosPedidos()
    {
        try {
            // Llamar al método eliminarTodosLosPedidos del modelo
            $exito = $this->modeloP->eliminarTodosLosPedidos();

            if ($exito) {
                // Redirigir a la vista correspondiente si la eliminación fue exitosa
                $infoCategoria = $this->modeloP->obtenerCategoria();
                require APP . 'view/_templates/header.php';
                require APP . 'view/admin/ver.php';
                require APP . 'view/_templates/footer.php';
            } else {
                // Manejo del error si la eliminación falla
                throw new Exception("Error al eliminar todos los pedidos.");
            }
        } catch (Exception $e) {
            // Manejo del error
            echo "Error: " . $e->getMessage();
        }
    }





    public function ver()
    {
        $ultimo_id = isset($_SESSION['ultimo_id']) ? $_SESSION['ultimo_id'] : '';
        $infoCategoria = $this->modeloP->obtenerCategoria();
        $n = isset($n) ? $n : 0;
        $categorias = $this->modeloP->obtenerProductos();
        $pedidosConDetalles = $this->modeloP->obtenerPedidosConDetalles();
        $pedidosConDetalles = isset($pedidosConDetalles) ? $pedidosConDetalles : [];

        require APP . 'view/_templates/header.php';
        require APP . 'view/admin/ver.php';
        require APP . 'view/_templates/footer.php';
    }

    public function eliminarPedido()
    {
        try {
            // Obtener el ID del pedido desde el formulario (método POST)
            $idPedido = isset($_POST['idPedido']) ? $_POST['idPedido'] : null;

            // Verificar si se proporcionó un ID válido
            if ($idPedido !== null && filter_var($idPedido, FILTER_VALIDATE_INT)) {
                // Llamar al método eliminarPedidoPorId del modelo
                $exito = $this->modeloP->eliminarPedidoPorId($idPedido);

                if ($exito) {
                    // Redirigir a la vista correspondiente si la eliminación fue exitosa
                    $infoCategoria = $this->modeloP->obtenerCategoria();
                    $categorias = $this->modeloP->obtenerProductos();
                    $pedidosConDetalles = $this->modeloP->obtenerPedidosConDetalles();
                    $pedidosConDetalles = isset($pedidosConDetalles) ? $pedidosConDetalles : [];
                    require APP . 'view/_templates/header.php';
                    require APP . 'view/admin/ver.php';
                    require APP . 'view/_templates/footer.php';
                } else {
                    // Manejo del error si la eliminación falla
                    throw new Exception("Error al eliminar el pedido. Intenta nuevamente.");
                }
            } else {
                throw new Exception("ID de pedido no válido.");
            }
        } catch (Exception $e) {
            // Manejo del error
            echo "Error: " . $e->getMessage();
            // Podrías redirigir a una página de error o mostrar un mensaje en la misma vista
            // header('Location: ' . URL . 'errorPage');
        }
    }

    public function sumarPedidosDelDia()
    {
        try {
            $inicioDia = date('Y-m-d 02:00:00', strtotime('-1 day'));
            $finDia = date('Y-m-d 01:59:59', strtotime('today'));

            // Llama a obtenerSumaYCantidadPedidos para obtener los valores correctos
            $resultado = $this->modeloP->obtenerSumaYCantidadPedidos($inicioDia, $finDia);

            if ($resultado && $resultado->cantidad_pedidos > 0) {
                $fechaActual = date('Y-m-d');
                $exito = $this->modeloP->insertarResumenPedidos(
                    $fechaActual,
                    $resultado->suma_total,              // Suma de valor_total (total de pedidos)
                    $resultado->cantidad_pedidos,        // Cantidad de pedidos
                    $resultado->suma_total_con_excedente, // Suma de suma_valores (pedidos con excedente)
                    $resultado->suma_excedentes           // Suma de excedente
                );

                if ($exito) {
                    $this->verResumenPedidos();
                } else {
                    throw new Exception("Error al insertar el resumen de pedidos.");
                }
            } else {
                echo "No se encontraron pedidos en el rango de tiempo seleccionado.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }




    public function verResumenPedidos()
    {
        // Obtener todos los pedidos
        $resumen = $this->modeloP->obtenerTodosLosPedidos();
        $totalDias = $this->modeloP->contarTotalDias();

        // Pasar datos a la vista
        $infoCategoria = $this->modeloP->obtenerCategoria();
        $n = isset($n) ? $n : 0;

        // Renderizar la vista
        require APP . 'view/_templates/header.php';
        require APP . 'view/admin/resumenPedidos.php';
        require APP . 'view/_templates/footer.php';
    }

    public function buscarPorFecha()
    {
        // Validar que las fechas no estén vacías
        if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin']) && !empty($_POST['fecha_inicio']) && !empty($_POST['fecha_fin'])) {
            // Obtener fechas del formulario
            $fechaInicio = $_POST['fecha_inicio'];
            $fechaFin = $_POST['fecha_fin'];

            // Llamar al método del modelo para obtener pedidos por rango de fechas
            $resumen = $this->modeloP->buscarPedidosPorFecha($fechaInicio, $fechaFin);
            $totalDias = $this->modeloP->contarTotalDias();  // O contar los días filtrados, si así lo prefieres
        } else {
            // Si no se enviaron fechas o están vacías, mostrar todos los pedidos
            $resumen = $this->modeloP->obtenerTodosLosPedidos();
            $totalDias = $this->modeloP->contarTotalDias();
        }

        // Pasar datos a la vista
        $infoCategoria = $this->modeloP->obtenerCategoria();
        $n = isset($n) ? $n : 0;

        // Renderizar la vista
        require APP . 'view/_templates/header.php';
        require APP . 'view/admin/resumenPedidos.php';
        require APP . 'view/_templates/footer.php';
    }
}
