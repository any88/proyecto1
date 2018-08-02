<?php

class Usuario
{
    private $idUsuario;
    private $idTipoUsuario;
    private $idCargoUsuario;
    private $nombre;
    private $user;
    private $pass;
    private $idEmpresa;
    private $dni;
    private $email;
    private $telefono;
    private $estado;

    public function __construct($idUsuario, $idTipoUsuario, $idCargoUsuario, $nombre, $user, $pass, $idEmpresa, $dni, $email, $telefono,$estado)
    {
        $this->idUsuario = $idUsuario;
        $this->idTipoUsuario = $idTipoUsuario;
        $this->idCargoUsuario = $idCargoUsuario;
        $this->nombre = $nombre;
        $this->apellido1 = $user;
        $this->apellido2 = $pass;
        $this->idEmpresa = $idEmpresa;
        $this->dni = $dni;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->estado=$estado;  
    }


    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getIdTipoUsuario()
    {
        return $this->idTipoUsuario;
    }

     public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre=$nombre;
    }

    public function getIdCargoUsuario()
    {
        return $this->idCargoUsuario;
    }

    public function setIdCargoUsuario($idCargoUsuario)
    {
        $this->idCargoUsuario = $idCargoUsuario;

    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

    }
     public function getPass()
    {
        return $this->pass;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;

    }

    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;

    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;

    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

       
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

    }
    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;

    }

}
