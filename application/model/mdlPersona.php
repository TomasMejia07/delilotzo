<?php
//creamos la clase principal o padre
class mdlPersona{
    //definimos los atributos
    public $idPersona;
    public $documento;
    public $idTipoDocumento;
    public $nombres;
    public $apellidos;
    public $telefono;
    public $direccion;
    public $genero;
    public $email;
    public $fechaNacimiento;
    public $db;

    //creamos el método para enviar los datos
    public function __SET($atributo,$valor){
        $this->$atributo=$valor;
    }

    //creamos la comunicación o conexión con la BD
    public function __construct($db){
        try{
            $this->db = $db;
        }catch(PDOException $e){
            exit("Error al conectar a la base de datos");
        }
    }

    //creamos el método para registrar las personas
    public function registrarPersona(){
        $sql = "INSERT INTO personas(Documento, Nombres, Apellidos, Email, Telefono, Direccion, Genero, Fecha_Nacimiento, idTipoDocumento) VALUES (?,?,?,?,?,?,?,?,?)";
        //preparamos la consulta de insertar datos
        $stm = $this->db->prepare($sql);

        //instanciamos o reemplazamos los atributos
        $stm->bindParam(1, $this->documento);
        $stm->bindParam(2, $this->nombres);
        $stm->bindParam(3, $this->apellidos);
        $stm->bindParam(4, $this->email);
        $stm->bindParam(5, $this->telefono);
        $stm->bindParam(6, $this->direccion);
        $stm->bindParam(7, $this->genero);
        $stm->bindParam(8, $this->fechaNacimiento);
        $stm->bindParam(9, $this->idTipoDocumento);
        $resultado = $stm->execute();

        //devolvemos el arreglo o resultado
        return $resultado;
    }

    public function listarTipoDocumento(){
        $sql = "SELECT idTipoDocumento, Descripcion AS doc FROM tipodocumentos";
        $query = $this->db->prepare($sql);
        $query->execute();
        $doc = $query->fetchAll(PDO::FETCH_ASSOC);
        return $doc;
    }

     //funcion para retornar el id de la última persona registrada
     public function ultimoIdPersona(){
        $sql = "SELECT MAX(idPersona) AS ultimoIdPersona FROM personas";
        $query = $this->db->prepare($sql);
        $query->execute();
        $ultimoId = $query->fetchAll(PDO::FETCH_ASSOC);
        return $ultimoId;
    }
}
?>