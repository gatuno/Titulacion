<?php

class Titulacion_Form_Acta_Editar extends Gatuf_Form {
	public $acta;
	public $alumno;
	
	
	
	public function initfields($extra=array()) {
		
		$maestros = Gatuf::factory ('Titulacion_Maestro') ->getList ();	
		$choices_maestros = array ();
		foreach ($maestros as $maestro){
			$choices_maestros[$maestro->apellido.' '.$maestro->nombre] = $maestro->codigo;
		}
		
		$choices_cal = array ();
		$this->acta = $extra['acta'];
		$this->alumno = $extra['alumno'];
		
		for ($g = date ('Y'); $g > 1968; $g--) {
			$choices_cal [$g] = array ('A' => $g.'A', 'B' => $g.'B');
		}
		
		$choices_des = array ('Sobresaliente' => 'Sobresaliente', 'Satisfactorio' => 'Satisfactorio');
		
		$this->fields['numeroActa'] = new Gatuf_Form_Field_Integer (
			array(
				'required' => false,
				'label' => 'Numero de acta',
				'initial' => $this->acta->acta,
				'help_text' => 'El número de acta',
				'min' => 1,
				'widget_attrs' => array (
					'size' => 10,
				),
		));
		
		
		$this->fields['alumno'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => false,
				'label' => 'Alumno',
				'initial' => $this->alumno->codigo,
				'widget_attrs' => array(
					'readonly' => 'readonly',
					'size' => 12,
				),
		));

		$this->fields['alumno_nombre'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => false,
				'label' => 'Nombre',
				'initial' => $this->alumno->nombre,
				'widget_attrs' => array(
					'readonly' => 'readonly',
					'size' => 40,
				),
		));

		$this->fields['alumno_apellido'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => false,
				'label' => 'Alumno',
				'initial' => $this->alumno->apellido,
				'widget_attrs' => array(
					'readonly' => 'readonly',
					'size' => 40,
				),
		));
		
		$this->fields['calificacion'] = new Gatuf_Form_Field_Float (
			array (
				'required' => false,
				'label' => 'Calificacion',
				'initial' =>  $this->acta->calificacion,
				'help_text'=> 'La calificación del alumno',
				'widget_attrs' => array(
					'size' => 10
				)
		));
		
			$this->fields['ingreso'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Calendario de ingreso',
				'initial' => '',
				'widget_attrs' => array(
					'choices' => $choices_cal
				),
				'widget' => 'Gatuf_Form_Widget_DobleInput'
		));
		
		$this->fields['egreso'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Calendario de egreso',
				'initial' => date ('Y'). (date ('n') > 6 ? 'B' : 'A'),
				'widget_attrs' => array(
					'choices' => $choices_cal
				),
				'widget' => 'Gatuf_Form_Widget_DobleInput'
		));
		
		
		$this->fields['fechaHora'] = new Gatuf_Form_Field_Datetime (
			array(
				'required' => true,
				'label' => 'Fecha y hora ceremonia',
				'initial' =>'',
				'help_text'=>'Fecha y hora de la ceremonia de titulacion',
				'widget' => 'Gatuf_Form_Widget_DatetimeJSInput',
				'widget_attrs' => array (
					'js_attrs' => array (
						'minDate' => 0,
					),
				)
		));
		$this->fields['cantidad_materias'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => false,
				'label' => 'Cantidad de materias',
				'initial' => $this->acta->materias_maestria,
				'min' => 1,
		));
		
		$this->fields['nombre_maestria'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Nombre del posgrado',
				'initial' => $this->acta->nombre_maestria,
				//'maxlength' => 150,
				'widget_attrs' => array (
					//'maxlength' => 150,
					'size' => 30,
				),
		));
		
		$this->fields['escuela_maestria'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Nombre de la universidad donde se encuentra cursandola',
				'initial' => $this->acta->escuela_maestria,
				'max_length' => 150,
				'widget_attrs' => array (
					//'maxlength' => 150,
					'size' => 30,
				),
		));
		
		$this->fields['nombre_trabajo'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Titulo del trabajo',
				'initial' => '',
				//'maxlength' => 150,
				'widget_attrs' => array (
					//'maxlength' => 150,
					'size' => 30,
				),
		));
		
		
		$this->fields['desempeno'] = new Gatuf_Form_Field_Varchar (
				array (
				'required' => false,
				'label' => 'Desempeño',
				'initial' => '',
				'max_length' => 50,
				'widget_attrs' => array (
					'choices' => $choices_des
				),
		));
		
		$gconf = new Gatuf_GSetting ('Titulacion');
		
		$this->fields['director'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Director',
				'initial' => $gconf->getVal ('director', ''),
				'help_text' => 'Director de la división',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
		
		$this->fields['secretario'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Secretario',
				'initial' => $gconf->getVal ('secretario', ''),
				'help_text' => 'Secretario de la división',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
		
		$this->fields['jurado1'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Jurado 1/Comité 1',
				'initial' => '',
				'help_text'=> 'Nombre del miembro del jurado',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros
				),
		));
		
		$this->fields['jurado2']= new Gatuf_Form_Field_Integer (
			array(
				'required' => true,
				'label' => 'Jurado 2/Comité 2',
				'initial' => '',
				'help_text'=> 'Nombre del miembro del jurado',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros
				),
		));
		
		$this->fields['jurado3']= new Gatuf_Form_Field_Integer (
			array(
				'required' => true,
				'label' => 'Jurado 3/Comité 3',
				'initial' => '',
				'help_text'=> 'Nombre del miembro del jurado',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros
				),
		));

			
		
	}
	
	public function save($commit = true){
	if(!$this->isValid()){
			throw new Exception ('El formulario contiene datos invÃ¡lidos');
		}
		if($commit) $this->acta->update ();
		return $this->acta;

		
	
	}
}
