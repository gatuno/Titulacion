<?php

class Titulacion_PlanEstudio extends Gatuf_Model {
	public $id;
	public $plan;
	
	public function __construct () {
		$this->_getConnection ();
		$this->tabla = 'Planes_Estudio';
	}
	
	public function getPlan ($id) {
		$req = sprintf ('SELECT * FROM %s WHERE id=%s', $this->getSqlTable (), Gatuf_DB_IntegerToDb ($id, $this->_con));
		
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
}
