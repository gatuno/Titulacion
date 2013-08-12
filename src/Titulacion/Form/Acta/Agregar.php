<?php

class Titulacion_Form_Acta_Agregar extends Gatuf_Form {
	public function initfields ($extra = array ()) {
		/* Preparar algunos catalogos */
		$planes = Gatuf::factory ('Titulacion_PlanEstudio')->getList ();
		
		$choices_planes = array ();
		foreach ($planes as $plan) {
			$choices_planes[$plan->plan] = $plan->id;
		}
		
		$modalidaes = Gatuf::factory ('Titulacion_Modalidad')->getList ();
		
		$choices_modalidades = array();
		foreach ($modalidaes as $modalidad) {
			$sql = new Gatuf_SQL ('modalidad=%s', $modalidad->id);
			
			$opciones = Gatuf::factory ('Titulacion_Opcion')->getList (array ('filter' => $sql->gen ()));
			
			if (count ($opciones) == 0) continue;
			
			$choices_modalidades [$modalidad->descripcion] = array ();
			
			foreach ($opciones as $opcion) {
				$choices_modalidades[$modalidad->descripcion][$opcion->descripcion] = $opcion->id;
			}
		}
		
		$maestros = Gatuf::factory ('Titulacion_Maestro') ->getList ();
		$choices_maestros = array ();
		foreach ($maestros as $maestro){
			$choices_maestros[$maestro->apellido.' '.$maestro->nombre] = $maestro->codigo;
		}
		
		$carreras = Gatuf::factory ('Titulacion_Carrera') ->getList ();
		$choices_carreras = array ();
		foreach ($carreras as $carrera){
			$choices_carreras[$carrera->descripcion] = $carrera->clave;
		}
		
		$choices_cal = array ();
		
		for ($g = date ('Y'); $g > 1968; $g--) {
			$choices_cal [$g] = array ('A' => $g.'A', 'B' => $g.'B');
		}
		
		$this->fields['planEstudios'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Plan de estudios',
				'initial' => '',
				'help_text' => 'El plan de estudios',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_planes
				)
		));
		
		$this->fields['carrera'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Carrera',
				'initial' => '',
				'help_text' => 'Carrera de la que egresa',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_carreras
				),
		));
		
		$this->fields['folio'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Folio',
				'initial' => '', /* FIXME: Deberiamos calcularlo automáticamente en base a la carrera y el plan de estudios */
				'widget_attrs' => array (
					'size' => 10
				),
		));
		
		$this->fields['numeroActa']= new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Numero de acta',
				'initial' => '',
				'help_text'=> 'El numero de el acta',
				'min' => 1,
				'widget_attrs' => array(
					'size' => 10
				)
		));
		
		$this->fields['opcTitulacion'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Opcion de titulacion',
				'initial' => '',
				'help_text' => 'La opcion de titulacion',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_modalidades
				)
		));
		
		$this->fields['alumno']= new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Alumno',
				'initial' => '',
				'help_text'=> 'El codigo del alumno',
				'max_length' => 9,
				'min_length' => 9,
				'widget_attrs' => array(
					'maxlenght' => 9,
					'size' => 12,
				),
		));
		
		$this->fields['ingreso']= new Gatuf_Form_Field_Varchar (
			array(
				'required' => true,
				'label' => 'Calendario de ingreso',
				'initial' => '',
				'widget_attrs' => array(
					'choices' => $choices_cal
				),
				'widget' => 'Gatuf_Form_Widget_DobleInput'
		));
		
		$this->fields['egreso']= new Gatuf_Form_Field_Varchar (
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
				'label' => 'Fecha y hora',
				'initial' =>'',
				'help_text'=>'Fecha y hora de la ceremonia de titulacion'
		));
		
		$this->fields['director'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Director',
				'initial' => '', /* FIXME: Configuraciones por default */
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
				'initial' => '', /* FIXME: Configuraciones por default */
				'help_text' => 'Secretario de la división',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
		
		$this->fields['jurado1'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Jurado 1. FIXME, También comité',
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
				'label' => 'Jurado 2',
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
				'label' => 'Jurado 3',
				'initial' => '',
				'help_text'=> 'Nombre del miembro del jurado',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros
				),
		));
	}
	
	public function clean_alumno () {
		$codigo = mb_strtoupper($this->cleaned_data['alumno']);
		
		if (!preg_match ('/^\w\d{8}$/', $codigo)) {
			throw new Gatuf_Form_Invalid ('El código del alumno es incorrecto');
		}
		
		$sql = new Gatuf_SQL ('codigo=%s', array ($codigo));
		$l = Gatuf::factory('Titulacion_Alumno')->getList(array ('filter' => $sql->gen(), 'count' => true));
		
		if ($l == 0) {
			throw new Gatuf_Form_Invalid ('El alumno especificado no existe');
		}
		
		return $codigo;
	}
	
	public function save ($commit=true){
		if(!$this->isValid()) {
			throw new Exception ('El formulario no tiene datos validos');
		}
		
		$acta = new Titulacion_Acta ();
		
		$acta->plan = $this->cleaned_data['planEstudios'];
		$acta->folio = $this->cleaned_data['folio'];
		$acta->acta = $this->cleaned_data['numeroActa'];
		$acta->modalidad = $this->cleaned_data['opcTitulacion'];
		$acta->carrera = $this->cleaned_data['carrera'];
		$acta->alumno = $this->cleaned_data['alumno'];
		$acta->fechaHora = $this->cleaned_data['fechaHora'];
		$acta->ingreso = $this->cleaned_data['ingreso'];
		$acta->egreso = $this->cleaned_data['egreso'];
		$acta->secretario_division = $this->cleaned_data['secretario'];
		$acta->director_division = $this->cleaned_data['director'];
		$acta->jurado1 = $this->cleaned_data['jurado1'];
		$acta->jurado2 = $this->cleaned_data['jurado2'];
		$acta->jurado3 = $this->cleaned_data['jurado3'];
		
		if ($commit) $acta->create ();
		
		return $acta;
	}
}
