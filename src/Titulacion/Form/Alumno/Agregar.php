<?php

class Titulacion_Form_Alumno_Agregar extends Gatuf_Form{
	public function initfields($extra=array()){
		$this->fields['codigo'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Código',
				'initial' => '',
				'help_text' => 'El código de alumno de 9 caracteres',
				'max_length' => 9,
				'min_length' => 9,
				'widget_attrs' => array(
					'maxlenght' =>9,
					'size' =>12,
				),
			)
		);
	
		$this->fields['nombre']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Nombre',
				'initial' =>'',
				'help_text' => 'El nombre o nombres el alumno',
				'max_length' => 50,
				'min_length' => 5,
				'widget_attrs' => array(
					'maxlength'=> 50,
					'size' =>30,
				),
			)
		);
		$this->fields['apellidos']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Apellidos',
				'initial' => '',
				'help_text'=> 'Los apellidos del alumno',
				'max_length' => 100,
				'min_length' => 5,
				'widget_attrs' => array(
					'maxlenght'=>100,
					'size'=>30,
				),

			)
		);
	}
	
	public function clean_codigo () {
		$codigo = mb_strtoupper($this->cleaned_data['codigo']);

		if (!preg_match ('/^\w\d{8}$/', $codigo)) {
			throw new Gatuf_Form_Invalid ('El código del alumno es incorrecto');
		}

		$sql = new Gatuf_SQL ('codigo=%s', array ($codigo));
		$l = Gatuf::factory('Titulacion_Alumno')->getList(array ('filter' => $sql->gen(), 'count' => true));

		if ($l > 0) {
			throw new Gatuf_Form_Invalid (sprintf ('El código %s de alumno especificado ya existe', $codigo));
		}

		return $codigo;
	}
	
	public function save ($commit=true){
		if(!$this->isValid()){
			throw new Exception ('El formulario no tiene datos validos');
		}
		$alumno = new Titulacion_Alumno ();
		
		$alumno->nombre = $this->cleaned_data['nombre'];
		$alumno->apellidos = $this->cleaned_data['apellidos'];
		$alumno->codigo = $this->cleaned_data['codigo'];
	
		if ($commit) $alumno->create ();

		return $alumno;
	}
		
}
