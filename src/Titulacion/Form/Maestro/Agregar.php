<?php

class Titulacion_Form_Maestro_Agregar extends Gatuf_Form {
	public function initFields ($extra = array ()) {
	
	$grados = Gatuf::factory ('Titulacion_Grado')->getList ();
		
		$choices_grados = array ();
		foreach ($grados as $descripcion) {
			$choices_grados[$descripcion->descripcion] = $descripcion->id;
		}
	
	
		$this->fields['codigo'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Código',
				'initial' => '',
				'help_text' => 'El código del maestro de 7 caracteres',
				'min' => 1000000,
				'max' => 9999999,
				'widget_attrs' => array (
					'maxlength' => 7,
					'size' => 12,
				),
		));
		
		$this->fields['nombre'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Nombre',
				'initial' => '',
				'help_text' => 'El nombre o nombres del maestro',
				'max_length' => 50,
				'min_length' => 5,
				'widget_attrs' => array (
					'maxlength' => 50,
					'size' => 30,
				),
		));
		
		$this->fields['apellido'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Apellido',
				'initial' => '',
				'help_text' => 'Los apellidos del maestro',
				'max_length' => 100,
				'min_length' => 5,
				'widget_attrs' => array (
					'maxlength' => 100,
					'size' => 30,
				),
		));
		
		$this->fields['grado'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Grado de estudios',
				'initial' => '',
				'help_text' => 'El plan de estudios',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_grados
				)
		));
	
		$this->fields['sexo'] = new Gatuf_Form_Field_Email (
			array (
				'required' => true,
				'label' => 'Sexo',
				'initial' => '',
				'help_text' => 'M masculino, F femenino',
		));
	
		$this->fields['correo'] = new Gatuf_Form_Field_Email (
			array (
				'required' => true,
				'label' => 'Correo',
				'initial' => '',
				'help_text' => 'Un correo',
		));
	}
	
	public function clean_codigo () {
		$codigo = $this->cleaned_data['codigo'];
		$sql = new Gatuf_SQL ('codigo=%s', array ($codigo));
		$l = Gatuf::factory('Titulacion_Maestro')->getList(array ('filter' => $sql->gen(), 'count' => true));
		
		if ($l > 0) {
			throw new Gatuf_Form_Invalid (sprintf ('El código %s del maestro especificado ya existe', $codigo));
		}
		
		return $codigo;
	}
	
	public function save ($commit = true) {
		if (!$this->isValid ()) {
			throw new Exception ('Cannot save the model from and invalid form.');
		}
		
		$maestro = new Titulacion_Maestro ();
		
		$maestro->codigo = $this->cleaned_data['codigo'];
		$maestro->nombre = $this->cleaned_data['nombre'];
		$maestro->apellido = $this->cleaned_data['apellido'];
		$maestro->correo = $this->cleaned_data['correo'];
		$maestro->grado = $this->cleaned_data['grado'];
		$maestro->sexo = $this->cleaned_data['sexo'];
		
		$maestro->create();
		
		return $maestro;
	}
}
