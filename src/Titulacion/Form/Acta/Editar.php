<?php

class Titulacion_Form_Acta_Editar extends Gatuf_Form {
	private $acta;
	private $opcion;
	
	public function initfields($extra=array()) {
		$this->acta = $extra['acta'];
		
		$maestros = Gatuf::factory ('Titulacion_Maestro')->getList ();
		$choices_maestros = array ();
		foreach ($maestros as $maestro){
			$choices_maestros[$maestro->apellido.' '.$maestro->nombre] = $maestro->codigo;
		}
		
		$choices_cal = array ();
		
		for ($g = date ('Y'); $g > 1968; $g--) {
			$choices_cal [$g] = array ('A' => $g.'A', 'B' => $g.'B');
		}
		
		$choices_des = array ('Sobresaliente' => 'Sobresaliente', 'Satisfactorio' => 'Satisfactorio');
		
		$this->opcion = new Titulacion_Opcion ();
		$this->opcion->getOpcion ($this->acta->modalidad);
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
		
		$this->fields['calificacion'] = new Gatuf_Form_Field_Float (
			array (
				'required' => false,
				'label' => 'Calificacion',
				'initial' =>  $this->acta->calificacion,
				'help_text'=> 'La calificación del alumno',
				'widget_attrs' => array(
					'size' => 10,
				)
		));
		
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
		
		$this->fields['egreso'] = new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Calendario de egreso',
				'initial' => $this->acta->egreso,
				'widget_attrs' => array(
					'choices' => $choices_cal,
				),
				'widget' => 'Gatuf_Form_Widget_DobleInput'
		));
		
		
		$this->fields['fechaHora'] = new Gatuf_Form_Field_Datetime (
			array(
				'required' => true,
				'label' => 'Fecha y hora ceremonia',
				'initial' => $this->acta->fechaHora,
				'help_text' => 'Fecha y hora de la ceremonia de titulacion',
				'widget' => 'Gatuf_Form_Widget_DatetimeJSInput',
				'widget_attrs' => array (
					'js_attrs' => array (
						'minDate' => 0,
					),
				)
		));
		
		if ($this->opcion->maestria) {
			$this->fields['cantidad_materias'] = new Gatuf_Form_Field_Integer (
				array (
					'required' => true,
					'label' => 'Cantidad de materias',
					'initial' => $this->acta->materias_maestria,
					'min' => 1,
			));
			
			
			$this->fields['nombre_maestria'] = new Gatuf_Form_Field_Varchar (
				array (
					'required' => true,
					'label' => 'Nombre del posgrado',
					'initial' => $this->acta->nombre_maestria,
					'max_length' => 150,
					'widget_attrs' => array (
						'maxlength' => 150,
						'size' => 30,
					),
			));
			
			$this->fields['escuela_maestria'] = new Gatuf_Form_Field_Varchar (
				array (
					'required' => true,
					'label' => 'Nombre de la universidad donde se encuentra cursandola',
					'initial' => $this->acta->escuela_maestria,
					'max_length' => 150,
					'widget_attrs' => array (
						'maxlength' => 150,
						'size' => 30,
					),
			));
		}
		
		if ($this->opcion->trabajo) {
			$this->fields['nombre_trabajo'] = new Gatuf_Form_Field_Varchar (
				array (
					'required' => true,
					'label' => 'Titulo del trabajo',
					'initial' => $this->acta->nombre_trabajo,
					'max_length' => 150,
					'widget_attrs' => array (
						'maxlength' => 150,
						'size' => 30,
					),
			));
		}
		
		if ($this->opcion->desempeno) {
			$this->fields['desempeno'] = new Gatuf_Form_Field_Varchar (
					array (
					'required' => true,
					'label' => 'Desempeño',
					'initial' => $this->acta->desempeno,
					'widget' => 'Gatuf_Form_Widget_SelectInput',
					'widget_attrs' => array (
						'choices' => $choices_des,
					),
			));
		}
		
		$this->fields['director'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Director',
				'initial' => $this->acta->director_division,
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
				'initial' => $this->acta->secretario_division,
				'help_text' => 'Secretario de la división',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
		
		$this->fields['jurado1'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => ($this->opcion->tipo == 'C' ? 'Comité 1' : 'Jurado 1'),
				'initial' => $this->acta->jurado1,
				'help_text'=> 'Nombre del miembro del '.($this->opcion->tipo == 'C' ? 'comité' : 'jurado'),
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
		
		$this->fields['jurado2']= new Gatuf_Form_Field_Integer (
			array(
				'required' => true,
				'label' => ($this->opcion->tipo == 'C' ? 'Comité 2' : 'Jurado 2'),
				'initial' => $this->acta->jurado2,
				'help_text'=> 'Nombre del miembro del '.($this->opcion->tipo == 'C' ? 'comité' : 'jurado'),
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
		
		$this->fields['jurado3']= new Gatuf_Form_Field_Integer (
			array(
				'required' => true,
				'label' => ($this->opcion->tipo == 'C' ? 'Comité 3' : 'Jurado 3'),
				'initial' => $this->acta->jurado3,
				'help_text'=> 'Nombre del miembro del '.($this->opcion->tipo == 'C' ? 'comité' : 'jurado'),
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
	}
	
	public function save($commit = true){
		if(!$this->isValid()){
			throw new Exception ('El formulario contiene datos inválidos');
		}
		
		$this->acta->acta = $this->cleaned_data['numeroActa'];
		$this->acta->calificacion = $this->cleaned_data['calificacion'];
		$this->acta->ingreso = $this->cleaned_data['ingreso'];
		$this->acta->egreso = $this->cleaned_data['egreso'];
		$this->acta->fechaHora = $this->cleaned_data['fechaHora'];
		
		if ($this->opcion->maestria) {
			$this->acta->materias_maestria = $this->cleaned_data['cantidad_materias'];
			$this->acta->nombre_maestria = $this->cleaned_data['nombre_maestria'];
			$this->acta->escuela_maestria = $this->cleaned_data['escuela_maestria'];
		}
		
		if ($this->opcion->trabajo) {
			$this->acta->nombre_trabajo = $this->cleaned_data['nombre_trabajo'];
		}
		
		if ($this->opcion->desempeno) {
			$this->acta->desempeno = $this->cleaned_data['desempeno'];
		}
		
		$this->acta->director_division = $this->cleaned_data['director'];
		$this->acta->secretario_division = $this->cleaned_data['secretario'];
		$this->acta->jurado1 = $this->cleaned_data['jurado1'];
		$this->acta->jurado2 = $this->cleaned_data['jurado2'];
		$this->acta->jurado3 = $this->cleaned_data['jurado3'];
		
		if($commit) $this->acta->update ();
		return $this->acta;
	}
}
