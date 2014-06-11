<?php

class Titulacion_Form_Acta_Editar extends Gatuf_Form {
	private $acta;
	private $opcion;
	
	public function initfields($extra=array()) {
		$this->acta = $extra['acta'];
		
		$maestros = Gatuf::factory ('Calif_Maestro')->getList ();
		$choices_maestros = array ();
		foreach ($maestros as $maestro) {
			$choices_maestros[$maestro->apellido.' '.$maestro->nombre] = $maestro->codigo;
		}
		
		$choices_cal = array ();
		
		for ($g = date ('Y'); $g > 1968; $g--) {
			$choices_cal [$g] = array ('A' => $g.'A', 'B' => $g.'B');
		}
		
		$choices_des = array ('Sobresaliente' => 'Sobresaliente', 'Satisfactorio' => 'Satisfactorio');
		
		$this->opcion = $this->acta->get_opcion ();
		$this->fields['acta'] = new Gatuf_Form_Field_Integer (
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
		
		
		$this->fields['fechahora'] = new Gatuf_Form_Field_Datetime (
			array(
				'required' => true,
				'label' => 'Fecha y hora ceremonia',
				'initial' => $this->acta->fechahora,
				'help_text' => 'Fecha y hora de la ceremonia de titulacion',
				'widget' => 'Gatuf_Form_Widget_DatetimeJSInput',
				'widget_attrs' => array (
					'js_attrs' => array (
						'minDate' => 0,
					),
				)
		));
		
		if ($this->opcion->maestria) {
			$this->fields['materias_maestria'] = new Gatuf_Form_Field_Integer (
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
		
		$gconf = new Gatuf_GSetting ();
		$gconf->setApp ('Titulacion');
		
		$director_pre = $gconf->getVal ('director', '');
		$modificar_director = $gconf->getVal ('modificar_director', true);
		
		if ($director_pre != '' && !$modificar_director) {
			$director = new Calif_Maestro ($director_pre);
		}
		
		$this->fields['director'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Director',
				'initial' => $this->acta->director,
				'help_text' => 'Director de la división',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $modificar_director ? $choices_maestros : array ($director->apellido.' '.$director->nombre => $director->codigo),
				),
		));
		
		$secretario_pre = $gconf->getVal ('secretario', '');
		$modificar_secretario = $gconf->getVal ('modificar_secretario', true);
		
		if ($secretario_pre != '' && !$modificar_secretario) {
			$secretario = new Calif_Maestro ($secretario_pre);
		}
		
		$this->fields['secretario'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Secretario',
				'initial' => $this->acta->secretario,
				'help_text' => 'Secretario de la división',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $modificar_secretario ? $choices_maestros : array ($secretario->apellido.' '.$secretario->nombre => $secretario->codigo),
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
		
		$this->acta->setFromFormData ($this->cleaned_data);
		
		if($commit) $this->acta->update ();
		return $this->acta;
	}
}
