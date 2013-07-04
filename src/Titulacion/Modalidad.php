<?php

class Titulacion_Modalidad extends Gatuf_Model {
	public $id;
	public $descripcion;
	
	public function __construct () {
		$this->_getConnection ();
		$this->tabla = 'Modalidades';
	}
	
	public function getModalidad ($id) {
		$req = sprintf ('SELECT * FROM %s WHERE id=%s', $this->getSqlTable (), Gatuf_DB_IdentityToDb ($id, $this->_con));
		
		if (false === ($rs = $this->_con->select ($req))) {
			throw new Exception ($this->_con->getError ());
		}
		
		if (count ($rs) == 0) {
			return false;
		}
		
		foreach ($rs[0] as $col => $val) {
			$this->$col = $val;
		}
		
		return true;
	}
	
	public function create () {
		$req = sprintf ('INSERT INTO %s (descripcion) VALUES (%s)', $this->getSqlTable (), Gatuf_DB_IdentityToDb ($this->descripcion, $this->_con));
		$this->_con->execute ($req);
		
		$this->id = $this->_con->getLastId ();
		
		return true;
	}
	
	public function update () {
		$req = sprintf ('UPDATE %s SET descripcion = %s WHERE id = %s', $this->getSqlTable (), Gatuf_DB_IdentityToDb ($this->descripcion, $this->_con), Gatuf_DB_IntegerToDb ($this->id, $this->_con));
		$this->_con->execute ($req);
		
		return true;
	}
}
