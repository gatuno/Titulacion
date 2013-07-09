<?php

class Titulacion_PlanEstudio extends Gatuf_Model {
	public $id;
	public $plan;
	
	public function __construct () {
		$this->_getConnection ();
		$this->tabla = 'Planes_Estudio';
	}
}
