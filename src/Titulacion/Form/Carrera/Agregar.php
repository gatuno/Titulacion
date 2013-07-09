<?php
class Titulacion_Form_Carrera_Agregar extends Gatuf_Form{
	public function initfield($extra=array()){
	
	
		$this->fields['clave']= new Gatuf_Form_Field_Varchar(
			array(
					'required' => true,
					'label' => 'Clave',
					'initial' => '',
					'help_text'=> 'La clave debe de tener minimo 5 caracteres',
					'max_length' => 5,
					'min_length' => 3,
					'widget_attr' => array(
						'maxlenght' => 5,
						'size' => 12,
					),
					
			
			)
		);
		
		$this->fields['descripcion']= new Gatuf_Form_Field_Varchar(
			array(
					'required' => true,
					'label' => 'Descripcion',
					'initial' => '',
					'max_length'=> 100,
					'min_length' => 20,
					'widget_attr' => array (
						'maxlenght' => 5,
						'size' =>12,
					),
			)
		
		);
	}
	
	public function save ($commit=true){
		if(!$this->isValid()){
			throw new Exception ('El formulario no tiene datos validos');
		}
		$carrera = new Titulacion_Carrera ();
		
	$carrera->clave= $this->cleaned_data['clave'];
	$carrera->descripcion= $this->cleaned_data['descripcion'];
	
	
	if($commit) $carrera->create ();

	return $carrera;	
	}
}