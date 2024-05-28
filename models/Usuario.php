<?php
namespace Model;

class Usuario extends ActiveRecord 
{
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Validacion para la creacion de la cuenta
    public function validarNuevaCuenta(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'El telefono es obligatorio';
        }
        return self::$alertas;
    }

    // Validacion para el inicio de sesion
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        return self::$alertas;
    }

    public function validarPassword(){
        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = "La contraseña debe tener una longitud minima de 6 caracteres";
        }

        return self::$alertas;
    }

    // Existe el usuario?
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        // Si existe ese resultado del query
        // Es que el usuario si existe
        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El correo electronico ya esta registrado';
        }

        return $resultado;
        
    }

    // Hashear el password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordyVerificado($password){
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'La contraseña es incorrecta o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }
}
