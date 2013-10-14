<?php

class Titulacion_Opcion extends Gatuf_Model {
	public $id;
	public $modalidad;
	public $modalidad_descripcion; /* Llave foranea */
	public $descripcion;
	public $articulo, $fraccion;
	public $articulo_cucei, $fraccion_cucei;
	public $tipo;
	public $leyenda;
	public $desempeno, $trabajo, $maestria;
	
	public function __construct () {
		$this->_getConnection ();
		$this->tabla = 'Opciones';
		$this->tabla_view = 'Opciones_View';
		$this->default_order = 'modalidad ASC';
		
		$this->leyenda = '';
		$this->desempeno = $this->trabajo = $this->maestria = 0;
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
		$req = sprintf ('INSERT INTO %s (modalidad, descripcion, articulo, fraccion, articulo_cucei, fraccion_cucei, leyenda, desempeno, trabajo, maestria) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)', $this->getSqlTable (), Gatuf_DB_IntegerToDb ($this->modalidad, $this->_con), Gatuf_DB_IdentityToDb ($this->descripcion, $this->_con), Gatuf_DB_IntegerToDb ($this->articulo, $this->_con), Gatuf_DB_IdentityToDb ($this->fraccion, $this->_con), Gatuf_DB_IntegerToDb ($this->articulo_cucei, $this->_con), Gatuf_DB_IdentityToDb ($this->fraccion_cucei, $this->_con), Gatuf_DB_IdentityToDb ($this->leyenda, $this->_con), Gatuf_DB_BooleanToDb ($this->desempeno, $this->_con), Gatuf_DB_BooleanToDb ($this->trabajo, $this->_con), Gatuf_DB_BooleanToDb ($this->maestria, $this->_con));
		
		$this->_con->execute ($req);
		
		$this->id = $this->_con->getLastId ();
		
		return true;
	}
	
	public function update () {
		$req = sprintf ('UPDATE %s SET descripcion = %s, articulo = %s, fraccion = %s, articulo_cucei = %s, fraccion_cucei = %s, leyenda = %s, desempeno = %s, trabajo = %s, maestria = %s WHERE id = %s', $this->getSqlTable (), Gatuf_DB_IdentityToDb ($this->descripcion, $this->_con), Gatuf_DB_IntegerToDb ($this->articulo, $this->_con), Gatuf_DB_IdentityToDb ($this->fraccion, $this->_con), Gatuf_DB_IntegerToDb ($this->articulo_cucei, $this->_con), Gatuf_DB_IdentityToDb ($this->fraccion_cucei, $this->_con), Gatuf_DB_IdentityToDb ($this->leyenda, $this->_con), Gatuf_DB_BooleanToDb ($this->desempeno, $this->_con), Gatuf_DB_BooleanToDb ($this->trabajo, $this->_con), Gatuf_DB_BooleanToDb ($this->maestria, $this->_con), Gatuf_DB_IntegerToDb ($this->id, $this->_con));
		
		$this->_con->execute ($req);
		
		return true;
	}
	
	public function restore () {
		$this->maestria = Gatuf_DB_BooleanFromDb ($this->maestria);
		$this->trabajo = Gatuf_DB_BooleanFromDb ($this->trabajo);
		$this->desempeno = Gatuf_DB_BooleanFromDb ($this->desempeno);
	}
	
	public function displayudg ($extra=null) {
		return $this->articulo.' - '.$this->fraccion;
	}
	
	public function displaycucei ($extra=null) {
		return $this->articulo_cucei.' - '.$this->fraccion_cucei;
	}
	
	public function displaylinkeddescripcion ($extra = null) {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index', array (), array ('f_modalidad' => $this->id));
		
		return '<a href="'.$url.'">'.$this->descripcion.'</a>';
	}
}
