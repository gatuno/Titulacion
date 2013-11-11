<?php

class Titulacion_Domicilio extends Gatuf_Model {
	public $_model = __CLASS__;
	
	public function init () {
		$this->_a['table'] = 'domicilios';
		$this->_a['model'] = __CLASS__;
		$this->primary_key = 'id';
		
		$this->_a['cols'] = array (
			'id' =>
			array (
			       'type' => 'Gatuf_DB_Field_Sequence',
			       'blank' => true,
			),
			'alumno' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'blank' => false,
			       'model' => 'Calif_Alumno',
			),
			'calle' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 150,
			),
			'numero_exterior' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 20,
			),
			'numero_interior' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 20,
			),
			'colonia' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 150,
			),
			'ciudad' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 150,
			),
			'estado' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 150,
			),
			'codigo_postal' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 6,
			),
			'telefono_casa' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 10,
			),
			'telefono_celular' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'blank' => false,
			       'size' => 10,
			),
		);
	}
}
