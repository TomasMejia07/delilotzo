<?php
//requerir mdlPersona.php para evitar redundancia de dato
require_once "mdlPersona.php";

//crear la clase u objeto necesario para poder heradar si es necesario
class mdlCategoria extends mdlPersona{
    //crear los parámetros para las consultas

    private $idUsuario;
    private $usuario;
    private $clave;
    private $idRol;
    private $estado;
    private $nombreCategoria;
    private $adicion;


    public function __SET($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function __GET($atributo){
        return $this->$atributo;
    }



    public function crearCategoria(){
        $sql = "INSERT INTO categorias_de_productos (nombre, adicion) VALUES (?, ?)";

        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $this->nombreCategoria);
        $stm->bindParam(2, $this->adicion);

        if($stm->execute()){
            return true;
            }
            else{
                return false;
            }
    }



    public function obtenerCategoria(){
        $sql = 'SELECT * from categorias_de_productos';

        $stm = $this->db->prepare($sql);

        if($stm->execute()){
            $infoCategoria = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $infoCategoria;
        }else {
            return false;
        }
    }

    public function obtenerProductos(){
        $sql = "SELECT c.nombre AS categoria, p.id AS producto_id, p.nombre AS producto_nombre, p.precio, p.descripcion FROM categorias_de_productos c
        LEFT JOIN productos p ON c.id = p.id_categoria
        ORDER BY c.id";
        $stm = $this->db->prepare($sql);

        $stm->execute();

        $categorias = array();

        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            $categoriaNombre = $row['categoria'];

            if (!array_key_exists($categoriaNombre, $categorias)) {
                $categorias[$categoriaNombre] = array();
            }

            if (!empty($row['producto_id'])) {
                $producto = array(
                    'id' => $row['producto_id'],
                    'nombre' => $row['producto_nombre'],
                    'precio' => $row['precio'],
                    'descripcion' => $row['descripcion']
                );

                $categorias[$categoriaNombre][] = $producto;
            }
        }

        return $categorias;
    
    }

    public function eliminarProductosPorCategoria($idCategoria) {
        $sql = "DELETE FROM productos WHERE id_categoria = ?";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $idCategoria);
        return $stm->execute();
    }
    
    public function eliminarCategoriaPorId($idCategoria) {
        $sql = "DELETE FROM categorias_de_productos WHERE id = ?";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $idCategoria);
        return $stm->execute();
    }
    

 





}
?>