<?php

class Titulacion_Alumno extends Gatuf_Model {
	public $nombre;
	public $apellidos;
	public $codigo;

	function __construct () {
		$this->_getConnection();
		$this->tabla = 'Alumno';
	}
	
	function create() {
		$req = sprintf('INSERT INTO %s (nombre,apellidos,codigo) VALUES (%s,%s,%s)', $this->getSqlTable (), Gatuf_DB_IdentityToDB ($this->nombre, $this->_con), Gatuf_DB_IdentityToDB ($this->apellidos, $this->_con), Gatuf_DB_IdentityToDB ($this->codigo, $this->_con));
		$this->_con->execute ($req);
		return true;
	}

}
