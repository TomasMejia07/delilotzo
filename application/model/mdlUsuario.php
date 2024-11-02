<?php
//requerir mdlPersona.php para evitar redundancia de dato
require_once "mdlPersona.php";

//crear la clase u objeto necesario para poder heradar si es necesario
class mdlUsuario extends mdlPersona{
    //crear los parámetros para las consultas

    private $idUsuario;
    private $clave;
    private $idRol;
    private $estado;
    private $usuario;
    private $contrasena;

    public function __SET($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function __GET($atributo){
        return $this->$atributo;
    }

    //validar usuario
    public function validarUsuario(){
        $sql = "SELECT * FROM usuarios WHERE nombre = ? AND contrasena = ?";

        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $this->usuario);
        $stm->bindParam(2, $this->contrasena);
        $stm->execute();             
        $user = $stm->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function obtenerUsuario(){
        $sql = "SELECT u.documento AS documento, u.nombre AS nombre, u.contrasena AS contrasena, ug.es_administrador AS esAdmin FROM usuarios u 
        INNER JOIN usuarios_grupos ug ON u.id = ug.id_usuario
        WHERE u.id = ?";
    
        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $_SESSION['id']);
        $stm->execute();
        $user = $stm->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    
    public function validarDocumento(){
        $sql = "SELECT * FROM usuarios WHERE documento = ?";

        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $this->documento);
        $stm->execute();
        $user = $stm->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function esAdmin(){
        $sql = "SELECT * FROM usuarios_grupos WHERE id_usuario = ? AND es_administrador = 1";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $_SESSION['id']);
        
        if($stm->execute()){
            $esAdmin = $stm->fetch(PDO::FETCH_ASSOC);
            return $esAdmin;
            }
            else{
                return false;
            }
    }

    public function idGrupoPorUsuario(){
        $sql = "SELECT id_grupo FROM usuarios_grupos WHERE id_usuario = ?";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $_SESSION['id']);
        
        if($stm->execute()){
            $idGrupo = $stm->fetch(PDO::FETCH_ASSOC);
            return $idGrupo['id_grupo'];
            }
            else{
                return false;
            }
}

    public function convertirEnAdministrador() {
        $sql = "UPDATE usuarios_grupos SET es_administrador = 1 WHERE id_usuario = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $this->usuario);
        return $stm->execute();
    }


    public function enGrupo(){
        $sql = "SELECT * FROM usuarios_grupos WHERE id_usuario = ?";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $_SESSION['id']);
        
        if($stm->execute()){
            if ($stm->rowCount() > 0) {
                return true; // Se encontraron filas
            } else {
                return false; // No se encontraron filas
            }
            }
            else{
                return false;
            }
    }

    //filtrar usuarios
    public function usuarioId($id){
        $sql = "SELECT P.idPersona, P.Documento, P.idTipoDocumento, P.Nombres, P.Apellidos, P.Email, P.Telefono, P.Direccion, U.idUsuario, U.idRol, R.Descripcion, U.Usuario FROM personas AS P INNER JOIN usuarios AS U ON P.idPersona = U.idPersona INNER JOIN roles AS R ON R.idRol = U.idRol WHERE idUsuario = ?";
        $query = $this->db->prepare($sql);
        $query ->bindParam(1, $id);
        $query -> execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function creacionUsuario(){
        $sql = "INSERT INTO usuarios(documento, nombre, contrasena) VALUES (?,?,?)";
        //preparamos la consulta de insertar datos
        $stm = $this->db->prepare($sql);

        //instanciamos o reemplazamos los atributos
        $stm->bindParam(1, $this->documento);
        $stm->bindParam(2, $this->nombre);
        $stm->bindParam(3, $this->contrasena);

        $resultado = $stm->execute();

        //devolvemos el arreglo o resultado
        return $resultado;
    }

    public function obtenerUsuariosPorGrupo(){
        $sql = "SELECT u.id AS id, u.documento AS documento, u.nombre AS nombre, u.contrasena AS contrasena, ug.es_administrador AS esAdmin FROM usuarios u JOIN usuarios_grupos ug ON u.id = ug.id_usuario WHERE ug.id_grupo = ?";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $this->id_grupo);
        
        if($stm->execute()){
            $usuarios = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $usuarios;
            }
            else{
                return false;
            }
    }



}
?>