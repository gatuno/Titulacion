<?php

class Titulacion_Opcion extends Gatuf_Model {
	public $id;
	public $modalidad;
	public $modalidad_descripcion; /* Llave foranea */
	public $descripcion;
	public $articulo, $fraccion;
	public $articulo_cucei, $fraccion_cucei;
	
	public function __construct () {
		$this->_getConnection ();
		$this->tabla = 'Opciones';
		$this->tabla_view = 'Opciones_View';
		$this->default_order = 'modalidad ASC';
	}
	
	public function getOpcion ($id) {
		$req = sprintf ('SELECT * FROM %s WHERE id=%s', $this->getSqlViewTable (), Gatuf_DB_IntegerToDb ($id, $this->_con));
		
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
		$req = sprintf ('INSERT INTO %s (modalidad, descripcion, articulo, fraccion, articulo_cucei, fraccion_cucei) VALUES (%s, %s, %s, %s, %s, %s)', $this->getSqlTable (), Gatuf_DB_IntegerToDb ($this->modalidad, $this->_con), Gatuf_DB_IdentityToDb ($this->descripcion, $this->_con), Gatuf_DB_IntegerToDb ($this->articulo, $this->_con), Gatuf_DB_IdentityToDb ($this->fraccion, $this->_con), Gatuf_DB_IntegerToDb ($this->articulo_cucei, $this->_con), Gatuf_DB_IdentityToDb ($this->fraccion_cucei, $this->_con));
		
		$this->_con->execute ($req);
		return true;
	}
	
	public function update () {
		throw new Exception ("No implementado");
	}
	
	public function displayudg ($extra=null) {
		return $this->articulo.' - '.$this->fraccion;
	}
	
	public function displaycucei ($extra=null) {
		return $this->articulo_cucei.' - '.$this->fraccion_cucei;
	}
}
