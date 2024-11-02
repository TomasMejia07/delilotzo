<?php
//requerir mdlPersona.php para evitar redundancia de dato
require_once "mdlPersona.php";

//crear la clase u objeto necesario para poder heradar si es necesario
class mdlProducto extends mdlPersona
{
    //crear los parámetros para las consultas

    private $idUsuario;
    private $usuario;
    private $clave;
    private $idRol;
    private $estado;
    private $nombre;
    private $precio;
    private $descripcion;
    private $id_categoria;
    private $atributos = array();

    public function __SET($atributo, $valor)
    {
        $this->atributos[$atributo] = $valor;
    }

    public function __GET($atributo)
    {
        return isset($this->atributos[$atributo]) ? $this->atributos[$atributo] : null;
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



    // Método para obtener un producto por su ID
    public function obtenerProductoPorId($idProducto)
    {
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $idProducto);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function agregarProducto()
    {
        try {
            $sql = "INSERT INTO productos(nombre, precio, descripcion, id_categoria) VALUES (?, ?, ?, ?)";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $this->__GET('nombre'));
            $stm->bindValue(2, $this->__GET('precio'));
            $stm->bindValue(3, $this->__GET('descripcion'));
            $stm->bindValue(4, $this->__GET('id_categoria'));
            if ($stm->execute()) {
                return true;
            } else {
                $errorInfo = $stm->errorInfo();
                echo "Error al ejecutar la consulta: " . $errorInfo[2];
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function actualizarProducto($idProducto, $nombre, $descripcion, $precio)
    {
        try {
            $sql = "UPDATE productos 
                    SET nombre = ?, precio = ?, descripcion = ? 
                    WHERE id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $nombre);
            $stm->bindValue(2, $precio);
            $stm->bindValue(3, $descripcion);
            $stm->bindValue(4, $idProducto);
    
            $result = $stm->execute(); // Ejecuta la actualización
    
            if ($result) {
                // Éxito en la actualización
                return true;
            } else {
                // Falla en la actualización
                return false;
            }
        } catch (PDOException $e) {
            // Manejo de errores: puedes imprimir el mensaje de error para depurar
            echo "Error al actualizar: " . $e->getMessage();
            return false; // Indica que hubo un error
        }
    }

    public function eliminarProductoPorId($idProducto){
        try {
            $sql = "DELETE FROM productos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $idProducto, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e){
            echo "Error al eliminar: ". $e->getMessage();
            return false;
        }
    }
    
    







}





?>