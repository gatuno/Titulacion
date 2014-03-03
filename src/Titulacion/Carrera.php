<?php

class Titulacion_Carrera extends Gatuf_Model {
	/* Manejador de la tabla de carreras */
	public $_model = __CLASS__;
	
	public function init () {
		$this->_a['table'] = 'titulacion_carreras';
		$this->_a['model'] = __CLASS__;
		$this->primary_key = 'clave';
		
		$this->_a['cols'] = array (
			'clave' =>
			array (
			       'type' => 'Gatuf_DB_Field_Char',
			       'blank' => false,
			       'size' => 5,
			),
			'descripcion' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 120,
			),
			'grado' =>
			array (
			       'type' => 'Gatuf_DB_Field_Char',
			       'blank' => false,
			       'size' => 1,
			),
			'grado_m' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 100,
			),
			'grado_f' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 100,
			),
			'nombre_largo' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 100,
			),
		);
		
		$this->default_order = 'clave ASC, descripcion ASC';
	}
	
	public function preSave ($create = false) {
		$carrera = new Calif_Carrera ();
		if ($create) {
			/* Cuando creamos, asegurarnos de que esta carrera también exista como Calif_Carrera */
			if (false === ($carrera->get($this->clave))) {
				$carrera->clave = $this->clave;
				$carrera->descripcion = $this->descripcion;
				$carrera->create ();
			} else {
				$carrera->descripcion = $this->descripcion;
				$carrera->update ();
			}
		} else {
			$carrera->get($this->clave);
			$carrera->descripcion = $this->descripcion;
			$carrera->update ();
		}
	}
	
	public function displaylinkedclave () {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index', array (), array ('f_carrera' => $this->clave));
		return '<a href="'.$url.'">'.$this->clave.'</a>';
	}
	
	function _getConnection () {
		static $con = null;
		if ($this->_con !== null) {
			return $this->_con;
		}
		if ($con !== null) {
			$this->_con = $con;
			return $this->_con;
		}
		Gatuf::loadFunction('Titulacion_DB_getConnection');
		$this->_con = Titulacion_DB_getConnection();
		$con = $this->_con;
		return $this->_con;
	}
}
