<?php

class Titulacion_ActaEliminada extends Gatuf_Model {
	public $_model = __CLASS__;
	
	function init () {
		$this->_a['table'] = 'actas_eliminadas';
		$this->_a['model'] = __CLASS__;
		$this->primary_key = 'id';
		
		$this->_a['cols'] = array (
			'id' =>
			array (
			       'type' => 'Gatuf_DB_Field_Sequence',
			       'blank' => true,
			),
			'acta' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'blank' => false,
			       'model' => 'Titulacion_Acta',
			),
			'razon' =>
			array (
			       'type' => 'Gatuf_DB_Field_Text',
			       'blank' => false,
			),
			'usuario' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Calif_User',
			       'blank' => false,
			),
			'timestamp' =>
			array (
			       'type' => 'Gatuf_DB_Field_Datetime',
			       'blank' => false,
			),
		);
	}
	
	public function preDelete () {
		/* Tampoco es posible eliminar un acta eliminada. */
		throw new Exception ('No se puede eliminar un acta');
	}
	
	function preSave ($create=false) {
		if ($create) {
			$this->timestamp = gmdate ('Y-m-d H:i:s');
			$acta = new Titulacion_Acta ($this->acta);
			
			$acta->eliminada = true;
			$acta->update ();
		} else {
			throw new Exception ('No se puede actualizar una acta eliminada');
		}
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
