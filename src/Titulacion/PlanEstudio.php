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
}
