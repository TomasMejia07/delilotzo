<?php
class usuarioController extends Controller{
    private $modeloU;

    public function __construct(){
        $this->modeloU = $this->loadModel("mdlUsuario");

        

    }

    public function principal(){
        if(!isset($_SESSION['SESION INICIADA'])){
            header("Location:" .URL); 

            exit();
        }
            
        header("Location:" .URL . 'categoriaController/principal'); 


    }

    public function iniciar(){
        
        $error = false;

        //validar si las variables $_SESSION están activas
        if(isset($_SESSION['SESION INICIADA']) && $_SESSION['SESION INICIADA'] == true){
            header("Location: " . URL . "usuarioController/principal");
            exit();
        }

        if(isset($_POST['btnIngresar']) && $_POST['username']){
  
            $this->modeloU->__SET('usuario', $_POST['username']);
            $this->modeloU->__SET('contrasena', $_POST['password']);


        $validar = $this->modeloU->validarUsuario();
        // var_dump($validar);
        // exit();

        if($validar == true){
            $_SESSION['SESION INICIADA'] = true;
            $error = false;

            $_SESSION['id'] = $validar['id'];
            $_SESSION['nombre'] = $validar['nombre'];
            $_SESSION['contrasena'] = $validar['contrasena'];

            header("Location:" .URL. "usuarioController/principal");
        }else{
            $error = true;
        }
    }
        require APP . 'view/usuario/login.php'; 
    }



    public function cerrarSesion(){
        if(isset($_SESSION['SESION INICIADA'])){
            session_destroy();
            setcookie('shownVideo', '', time() - 3600, '/');
        }

        header("Location:".URL);
    }

    public function datoUsuario(){
        $usuario = $this->modeloU->usuarioId($_POST['id']);
        echo json_encode($usuario);
    }

    public function cambiarEstado(){
        $estado = $this->modeloU->cambiarEstado($_POST['id']);
        echo 1;
    }

    public function eliminarUsuario(){
        $estado = $this->modeloU->eliminarUsuario($_POST['id']);
        echo 1;
    }
}
?>