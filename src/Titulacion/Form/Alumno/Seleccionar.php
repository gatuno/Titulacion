<?php

class Titulacion_Form_Alumno_Seleccionar extends Gatuf_Form {
	public function initfields ($extra = array ()) {
		$this->fields['codigo'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Código',
				'initial' => '',
				'help_text' => 'El código de alumno de 9 caracteres',
				'max_length' => 9,
				'min_length' => 9,
				'widget_attrs' => array(
					'maxlength' => 9,
					'size' => 12,
				),
			)
		);
	}
	
	public function clean_codigo () {
		$codigo = mb_strtoupper($this->cleaned_data['codigo']);

		if (!preg_match ('/^\w\d{8}$/', $codigo)) {
			throw new Gatuf_Form_Invalid ('El código del alumno es incorrecto');
		}
		
		return $codigo;
	}
	
	public function save ($commit = true) {
		if (!$this->isValid ()){
			throw new Exception ('El formulario no tiene datos validos');
		}
		
		return $this->cleaned_data['codigo'];
	}
}
