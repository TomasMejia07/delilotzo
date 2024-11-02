<?php
class productoController extends Controller
{
    private $modeloP;
    private $idproducto;
    public function __construct()
    {
        $this->modeloP = $this->loadModel("mdlProducto");
        if (!isset($_SESSION['SESION INICIADA'])) {
            header("Location:" . URL);

            exit();
        }
    }

    public function principal()
    {
        header("Location:" . URL . 'categoriaController/principal');
    }
    public function editarOActualizarProducto()
    {
        if (isset($_GET['id'])) {
            $idProducto = $_GET['id'];
    
            // Obtener los datos del producto para prellenar el formulario
            $datosProducto = $this->modeloP->obtenerProductoPorId($idProducto);
            $infoCategoria = $this->modeloP->obtenerCategoria();
            $n = 0;
    
            if ($datosProducto) {
                // Pasa los datos del producto a la vista
                require APP . 'view/_templates/header.php';
                require APP . 'view/admin/editar.php'; // Vista de edición
                require APP . 'view/_templates/footer.php';
            } else {
                // Manejar el caso en que el producto no se encuentra
                header("Location:" . URL . "productoController/principal");
            }
        } else {
            header("Location:" . URL);
            exit();
        }
    }
    public function editarProducto()
    {
        if (isset($_POST['id'])) {
            $idProducto = $_POST['id'];
    
            if (isset($_POST['Editar'])) {
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = $_POST['precio'];
    
                // Llamar al modelo para actualizar el producto
                $this->modeloP->actualizarProducto($idProducto, $nombre, $descripcion, $precio);
    
                // Redirigir después de la actualización
                header("Location:" . URL . "productoController/principal");
                exit();
            }
        }
    }

    public function crearProducto()
    {
        if (isset($_POST['id_categoria'])) {
            if (isset($_POST['crear'])) {
                $this->modeloP->__SET('id_categoria', $_POST['id_categoria']);
                $this->modeloP->__SET('nombre', $_POST['nombre']);
                $this->modeloP->__SET('descripcion', $_POST['descripcion']);
                $this->modeloP->__SET('precio', $_POST['precio']);

                if ($this->modeloP->agregarProducto()) {
                    header("Location:" . URL . "productoController/principal");
                } else {
                    echo "Error al agregar el producto.";
                }
            } else {
                $infoCategoria = $this->modeloP->obtenerCategoria();
                $n = 0;
                $id_categoria = $_POST['id_categoria'];
                require APP . 'view/_templates/header.php';
                require APP . 'view/admin/creacion.php';
                require APP . 'view/_templates/footer.php';
            }
        } else {
            header("Location:" . URL);
        }
    }

    public function eliminarProducto(){
        if(isset($_GET['id'])) {
            $idProducto = $_GET['id'];
            if($this->modeloP->eliminarProductoPorId($idProducto)){
                header("Location:" . URL . "productoController/principal");
            }else {
                echo "Error al eliminar el producto";
            }
        }else{
            header("Location:" . URL . "productoController/principal");
        }
    }


    public function cerrarSesion()
    {
        if (isset($_SESSION['SESION INICIADA'])) {
            session_destroy();
        }

        header("Location:" . URL . "home/index");
    }
}
