<?php

class Titulacion_Form_Carrera_Actualizar extends Gatuf_Form {
	private $carrera;
	
	public function initFields($extra=array()) {
		$this->carrera = $extra['carrera'];
		
		$choices = array ();
		$divisiones = Gatuf::factory ('Calif_Division')->getList ();
		foreach ($divisiones as $division) {
			$choices[$division->nombre] = $division->id;
		}
		
		$this->fields['division'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'División',
				'initial' => $this->carrera->division,
				'help_text' => 'La división a la que pertenece',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices,
				),
		));
		
		$this->fields['descripcion'] = new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Descripción',
				'initial' => $this->carrera->descripcion,
				'help_text' => 'Una descripción como Ingeniería en Computación',
				'max_length' => 100,
				'widget_attrs' => array(
					'maxlength' => 100,
					'size' => 30,
				),
		));
		
		$choices = array ('Licenciatura' => 'L',
		                  'Ingeniería' => 'I',
		                  'Maestría' => 'M',
		                  'Doctorado' => 'D');
		$this->fields['grado'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Grado',
				'initial' => $this->carrera->grado,
				'help_text' => 'El grado de la carrera',
				'widget_attrs' => array (
					'choices' => $choices,
				),
				'widget' => 'Gatuf_Form_Widget_SelectInput',
		));
		
		$this->fields['grado_m'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Grado (Masculino)',
				'initial' => $this->carrera->grado_m,
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
				'initial' => $this->carrera->grado_f,
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
				'initial' => $this->carrera->nombre_largo,
				'help_text' => 'Nombre de la carrera con artículo',
				'max_length' => 100,
				'widget_attrs' => array(
					'maxlength' => 100,
					'size' => 30,
				),
		));
	}
	
	public function save ($commit=true) {
		if (!$this->isValid()) {
			throw new Exception('Cannot save the model from an invalid form.');
		}
		
		$this->carrera->setFromFormData ($this->cleaned_data);
		
		if ($commit) $this->carrera->update();
		
		return $this->carrera;
	}
}
