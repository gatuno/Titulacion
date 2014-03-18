<?php

class Titulacion_PlanEstudio extends Gatuf_Model {
	/* Manejador de la tabla de los Planes de estudio */
	public $_model = __CLASS__;
	
	public function init () {
		$this->_a['table'] = 'planes_estudios';
		$this->_a['model'] = __CLASS__;
		$this->primary_key = 'id';
		
		$this->_a['cols'] = array (
			'id' =>
			array (
			       'type' => 'Gatuf_DB_Field_Sequence',
			       'blank' => true,
			),
			'descripcion' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 100,
			),
		);
	}
	
	public function displaylinkeddescripcion ($extra = null) {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::porPlan', array ($this->id));
		
		return '<a href="'.$url.'">'.$this->descripcion.'</a>';
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
