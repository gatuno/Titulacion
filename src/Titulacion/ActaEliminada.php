<?php

class Titulacion_ActaEliminada extends Gatuf_Model {
	public $acta;
	public $razon;
	public $usuario;
	public $timestamp;
	
	function __construct() {
		$this->_getConnection ();
		$this->tabla = 'Actas_Eliminadas';
	}
	
	function get ($acta) {
		$req = sprintf('SELECT * FROM %s WHERE acta=%s', $this->getSqlViewTable (), Gatuf_DB_IntegerToDb ($acta, $this->_con));
		
		if (false === ($rs = $this->_con->select ($req))){
			throw new Exception ($this->_con->getError());
		}
		
		if (count ($rs)== 0){
			return false;
		}
		foreach ($rs[0] as $col =>$val){
			$this->$col = $val;
		}
		return true;
	}
	
	public function create() {
		$this->preSave (true);
		$req = sprintf ('INSERT INTO %s (acta, razon, usuario, timestamp) VALUES (%s, %s, %s, %s);', $this->getSqlTable (), Gatuf_DB_IntegerToDb ($this->acta, $this->_con), Gatuf_DB_IdentityToDb ($this->razon, $this->_con), Gatuf_DB_IntegerToDb ($this->usuario, $this->_con), Gatuf_DB_IdentityToDb ($this->timestamp, $this->_con));
		
		$this->_con->execute ($req);
		
		return true;
	}
	
	public function update () {
		throw new Exception ('No se puede actualizar una acta eliminada');
	}
	
	function preSave ($create=true) {
		if ($create) $this->timestamp = date ('Y-m-d H:i:s');
	}
}
