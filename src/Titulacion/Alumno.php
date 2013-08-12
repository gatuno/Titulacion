<?php

class Titulacion_Alumno extends Gatuf_Model {
	public $nombre;
	public $apellido;
	public $codigo;

	function __construct () {
		$this->_getConnection();
		$this->tabla = 'Alumnos';
	}
	
	function getAlumno ($codigo) {
		/* Recuperar un alumno */
		$req = sprintf ('SELECT * FROM %s WHERE Codigo = %s', $this->getSqlTable(), Gatuf_DB_IdentityToDb($codigo, $this->_con));
		
		if (false === ($rs = $this->_con->select($req))) {
			throw new Exception($this->_con->getError());
		}
		
		if (count ($rs) == 0) {
			return false;
		}
		foreach ($rs[0] as $col => $val) {
			$this->$col = $val;
		}
		return true;
	}
	
	function create() {
		$req = sprintf('INSERT INTO %s (codigo, nombre, apellido) VALUES (%s, %s, %s)', $this->getSqlTable (), Gatuf_DB_IdentityToDB ($this->codigo, $this->_con), Gatuf_DB_IdentityToDB ($this->nombre, $this->_con), Gatuf_DB_IdentityToDB ($this->apellido, $this->_con));
		
		$this->_con->execute ($req);
		
		return true;
	}
}
