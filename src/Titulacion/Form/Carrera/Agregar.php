<?php

class Titulacion_Form_Carrera_Agregar extends Gatuf_Form {
	public function initFields($extra=array()) {
		$this->fields['clave'] = new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Clave',
				'initial' => '',
				'help_text' => 'Debe ser una clave de carrera única',
				'max_length' => 5,
				'min_length' => 3,
				'widget_attrs' => array(
					'maxlength' => 5,
				),
		));
		
		$this->fields['descripcion'] = new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Descripción',
				'initial' => '',
				'help_text' => 'Una descripción como Ingeniería en Computación',
				'max_length' => 100,
				'widget_attrs' => array(
					'maxlength' => 100,
					'size' => 30,
				),
		));
		
		$this->fields['grado_m'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Grado (Masculino)',
				'initial' => '',
				'help_text' => 'El grado que esta carrera genera, en masculino',
				'max_length' => 100,
				'widget_attrs' => array(
					'maxlength' => 100,
					'size' => 30,
				),
		));
		
		$this->fields['grado_f'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Grado (Femenino)',
				'initial' => '',
				'help_text' => 'El grado que esta carrera genera, en femenino',
				'max_length' => 100,
				'widget_attrs' => array(
					'maxlength' => 100,
					'size' => 30,
				),
		));
		
		$this->fields['nombre_largo'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Nombre largo',
				'initial' => '',
				'help_text' => 'Nombre de la carrera con artículo',
				'max_length' => 100,
				'widget_attrs' => array(
					'maxlength' => 100,
					'size' => 30,
				),
		));
	}
	
	public function clean_clave () {
		$clave = mb_strtoupper($this->cleaned_data['clave']);
		
		if (!preg_match ("/^([A-Za-z]){3,5}$/", $clave)) {
			throw new Gatuf_Form_Invalid('La clave de la carrera contiene caracteres inválidos.');
		}
		
		$sql = new Gatuf_SQL('clave=%s', array($clave));
		$l = Gatuf::factory('Titulacion_Carrera')->getList(array('filter'=>$sql->gen(),'count' => true));
		if ($l > 0) {
			throw new Gatuf_Form_Invalid('Esta clave de carrera ya existe');
		}
		
		return $clave;
	}
	
	public function save ($commit=true) {
		if (!$this->isValid()) {
			throw new Exception('Cannot save the model from an invalid form.');
		}
		
		$carrera = new Titulacion_Carrera ();
		
		$carrera->clave = $this->cleaned_data['clave'];
		$carrera->descripcion = $this->cleaned_data['descripcion'];
		$carrera->grado_m = $this->cleaned_data['grado_m'];
		$carrera->grado_f = $this->cleaned_data['grado_f'];
		$carrera->nombre_largo = $this->cleaned_data['nombre_largo'];
		
		if ($commit) $carrera->create();
		
		return $carrera;
	}
}
