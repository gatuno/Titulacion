<?php

class Titulacion_Carrera extends Gatuf_Model {
	public $clave;
	public $descripcion;

	function __construct () {
		$this->_getConnection ();
		$this->tabla = 'Carreras';
	}
	
	function create () {
		$req = sprintf ('INSERT INTO %s (clave, descripcion) VALUES (%s, %s)', $this->getSqlTable (), Gatuf_DB_IdentityToDB ($this->clave, $this->_con), Gatuf_DB_IdentityToDB ($this->descripcion, $this->_con));
		
		$this->_con->execute ($req);
		
		return true;
	}	
}
