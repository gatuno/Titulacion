<?php

class Titulacion_Form_Maestro_Actualizar extends Gatuf_Form {
	private $maestro;
	
	public function initFields ($extra = array ()) {
		$this->maestro = $extra['maestro'];
		
		/* Preparar catalogos */
		$choices_grados = array ('Lic.' => 'L', 'Ing.' => 'I', 'Mtro./Mtra' => 'M', 'Dr./Dra.' => 'D');
		$choices_sex = array ('Masculino' => 'M', 'Femenino' => 'F');
		
		$this->fields['nombre'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Nombre',
				'initial' => $this->maestro->nombre,
				'help_text' => 'El nombre o nombres del maestro',
				'max_length' => 50,
				'widget_attrs' => array (
					'maxlength' => 50,
					'size' => 30,
				),
		));
		
		$this->fields['apellido'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Apellido',
				'initial' => $this->maestro->apellido,
				'help_text' => 'Los apellidos del maestro',
				'max_length' => 100,
				'widget_attrs' => array (
					'maxlength' => 100,
					'size' => 30,
				),
		));
		
		$this->fields['sexo'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Sexo',
				'initial' => $this->maestro->sexo,
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array(
					'choices' => $choices_sex,
				),
		));
		
		$this->fields['grado'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Grado de estudios',
				'initial' => $this->maestro->grado,
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array(
					'choices' => $choices_grados,
				),
		));
		
		$this->fields['correo'] = new Gatuf_Form_Field_Email (
			array (
				'required' => true,
				'label' => 'Correo',
				'initial' => $this->maestro->correo,
				'help_text' => 'Un correo',
		));
	}
	
	public function save ($commit = true) {
		if (!$this->isValid ()) {
			throw new Exception ('Cannot save the model from and invalid form.');
		}
		
		$this->maestro->nombre = $this->cleaned_data['nombre'];
		$this->maestro->apellido = $this->cleaned_data['apellido'];
		$this->maestro->correo = $this->cleaned_data['correo'];
		$this->maestro->grado = $this->cleaned_data['grado'];
		$this->maestro->sexo = $this->cleaned_data['sexo'];
		
		$this->maestro->update();
		
		return $this->maestro;
	}
}
