<?php

class Titulacion_Domicilio extends Gatuf_Model {
	public $id;
	public $alumno;
	public $calle, $numero_exterior, $numero_interior;
	public $ciudad, $colonia, $codigo_postal;
	public $telefono_casa, $telefono_celular;
	
	function __construct () {
		$this->_getConnection ();
		
		$this->tabla = 'Domicilios';
	}
	
	function getDomicilio ($id) {
		$req = sprintf ('SELECT * FROM %s WHERE id=%s', $this->getSqlViewTable(), Gatuf_DB_IntegerToDb ($id, $this->_con));
		
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
		$req = sprintf ('INSERT INTO %s (alumno, calle, numero_exterior, numero_interior, colonia, ciudad, codigo_postal, telefono_casa, telefono_celular) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)', $this->getSqlTable (), Gatuf_DB_IdentityToDb ($this->alumno, $this->_con), Gatuf_DB_IdentityToDb ($this->calle, $this->_con), Gatuf_DB_IdentityToDb ($this->numero_exterior, $this->_con), Gatuf_DB_IdentityToDb ($this->numero_interior, $this->_con), Gatuf_DB_IdentityToDb ($this->colonia, $this->_con), Gatuf_DB_IdentityToDb ($this->ciudad, $this->_con), Gatuf_DB_IdentityToDb ($this->codigo_postal, $this->_con), Gatuf_DB_IdentityToDb ($this->telefono_casa, $this->_con), Gatuf_DB_IdentityToDb ($this->telefono_celular, $this->_con));
		
		$this->_con->execute ($req);
		
		$this->id = $this->_con->getLastId ();
		
		return true;
	}
	
}
