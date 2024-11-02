<?php
class categoriaController extends Controller{
    private $modeloC;

    public function __construct(){
        $this->modeloC = $this->loadModel("mdlCategoria");
        if(!isset($_SESSION['SESION INICIADA'])){
            header("Location:" .URL); 

            exit();
        }
    }

    public function principal(){

        $infoCategoria = $this->modeloC->obtenerCategoria();

        $n=0;

        $categorias = $this->modeloC->obtenerProductos();

        
       
        require APP . 'view/_templates/header.php';
        require APP . 'view/admin/admin.php';
        require APP . 'view/_templates/footer.php';
    }

    public function crearCategoria(){

        
        $error = false;

        //validar si las variables $_SESSION están activas
        if(isset($_POST['crear'])){

            $nombre = $_POST['nombre'];
            $this->modeloC->__SET('nombreCategoria', $nombre);
            if (isset($_POST['adicion'])) {
                $this->modeloC->__SET('adicion', 1);
            }else {
                $this->modeloC->__SET('adicion', 0);
            }

            $valido = $this->modeloC->crearCategoria();
            if ($valido) {
                header("Location:" .URL. "categoriaController/principal");
            }
        }else{

            $infoCategoria = $this->modeloC->obtenerCategoria();

            $n=0;
    
            $categorias = $this->modeloC->obtenerProductos();

            
            require APP . 'view/_templates/header.php';
            require APP . 'view/admin/categoria.php';
            require APP . 'view/_templates/footer.php';
        }

    }

    public function eliminarCategoria() {
        if(isset($_POST['eliminarCategoria'])) {
            $idCategoria = $_POST['eliminarCategoria'];
            
            // Eliminar productos asociados a la categoría
            $this->modeloC->eliminarProductosPorCategoria($idCategoria);
            
            // Eliminar la categoría
            $valido = $this->modeloC->eliminarCategoriaPorId($idCategoria);
    
            if($valido) {
                header("Location:" . URL . "categoriaController/principal");
            } else {
                echo "Error al eliminar la categoría y productos asociados.";
            }
        } else {
            header("Location:" . URL . "categoriaController/principal");
        }
    }
    

    public function cerrarSesion(){
        if(isset($_SESSION['SESION INICIADA'])){
            session_destroy();
        }

        header("Location:".URL."home/index");
    }

}
?>