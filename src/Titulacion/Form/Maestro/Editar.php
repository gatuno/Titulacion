<?php

class Titulacion_Form_Maestro_Editar extends Gatuf_Form {
	private $maestro;
	
	public function initfields($extra=array()) {
	
	$this->maestro = new $extr['maestro'];
	/*
	$this->fields['ingreso'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Calendario de ingreso',
				'initial' => $this->acta->ingreso,
				'widget_attrs' => array(
					'choices' => $choices_cal,
				),
				'widget' => 'Gatuf_Form_Widget_DobleInput'
		));
		
		$this->fields['calificacion'] = new Gatuf_Form_Field_Float (
			array (
				'required' => false,
				'label' => 'Calificacion',
				'initial' =>  $this->acta->calificacion,
				'help_text'=> 'La calificación del alumno',
				'widget_attrs' => array(
					'size' => 10,
				)
		));*/
		
	$this->fields['grado'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' =>true,
				'label' => 'Grado del maestro',
				'initial' => $this->maestro->grado,
				'help_text' => 'El grado que tiene el maestro',
				'widget_attrs' => array (
					'size' => 10,
				)
			
		
		));
	
	}
	
	
	public function save($commit = true){
		if(!$this->isValid()){
			throw new Exception ('El formulario contiene datos inválidos');
		}
		
		$this->meaestro->grado = $this->cleaned_data['numeroActa'];
		$this->maestro->codigo = $this->cleaned_data['codigo'];
		$this->maestro->nombre = $this->cleaned_data['nombre'];
		$this->maestro->apellido = $this->cleaned_data['apellido'];
		$this->maestro->coreo = $this->cleaned_data['correo'];
		
		
		if($commit) $this->maestro->update ();
		return $this->maestro;

}