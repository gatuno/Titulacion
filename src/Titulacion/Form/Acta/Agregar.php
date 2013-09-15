<?php

class Titulacion_Form_Acta_Agregar extends Gatuf_Form {
	private $alumno, $domicilio;
	
	public function initfields ($extra = array ()) {
		$this->alumno = $extra['alumno'];
		$this->domicilio = $extra['domicilio'];
		
		/* Preparar algunos catalogos */
		$planes = Gatuf::factory('Titulacion_PlanEstudio')->getList();
		
		$choices = array();
		foreach($planes as $m){
			$choices[$m->plan] = $m ->id;
			$choices_planes = array();
			foreach ($planes as $plan){
				$choices_planes[$plan->plan] = $plan->id;
			}
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
		
		
		$this->fields['calificacion'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => false,
				'label' => 'Calificacion',
				'initial' => '',
				'help_text'=> 'Calificacion con la que se titula',
				'min' => 1,
				'widget_attrs' => array(
					'size' => 10
				)
		));
		
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
		
		//aqui ponemos los campos donde se capuraran diferentes datos 
		//sgun la opcion de titulacion, estos estaran con required =>false
		$this->fields['desempeno'] = new Gatuf_Form_Field_Varchar (
				array (
				'required' => false,
				'label' => 'Desempeño',
				'initial' => '',
				'max_length' => 50,
				'widget_attrs' => array (
					/* TODO: Poner opciones 'choices' => */
					'maxlength' => 50,
					'size' => 30,
				),
		));
		
		$this->fields['cantidad_materias'] = new Gatuf_Form_Field_Integer (
				array (
				'required' => false,
				'label' => 'Cantidad de materias',
				'initial' => '',
				'min' => 1,
		));
	
		$this->fields['nombre_maestria'] = new Gatuf_Form_Field_Varchar (
				array (
				'required' => false,
				'label' => 'Nombre del posgrado',
				'initial' => '',
				'max_length' => 200,
				'widget_attrs' => array (
					'maxlength' => 200,
					'size' => 30,
				),
		));
		
		$this->fields['escuela_maestria'] = new Gatuf_Form_Field_Varchar (
				array (
				'required' => false,
				'label' => 'Nombre de la universidad donde se encuentra cursandola',
				'initial' => '',
				'max_length' => 200,
				'widget_attrs' => array (
					'maxlength' => 200,
					'size' => 30,
				),
		));
		
		$this->fields['nombre_trabajo'] = new Gatuf_Form_Field_Varchar (
				array (
				'required' => false,
				'label' => 'Titulo del trabajo',
				'initial' => '',
				'max_length' => 300,
				'widget_attrs' => array (
					'maxlength' => 300,
					'size' => 30,
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
		Gatuf::loadFunction ('Titulacion_Utils_formatearDomicilio');
		$cadena_domicilio = Titulacion_Utils_formatearDomicilio ($this->domicilio);
		
		$this->fields['domicilio'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Domicilio',
				'initial' => $cadena_domicilio,
				'widget_attrs' => array (
					'readonly' => 'readonly',
					'size' => 50,
				),
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
				'label' => 'Fecha y hora',
				'initial' =>'',
				'help_text'=>'Fecha y hora de la ceremonia de titulacion',
				'widget' => 'Gatuf_Form_Widget_DatetimeJSInput',
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
	
	public function clean () {
		/* Hay varias validaciones pendientes */
		/* La primera es sobre el calendario de ingreso y egreso */
		$cal_in = $this->cleaned_data['ingreso'];
		$cal_out = $this->cleaned_data['egreso'];
		
		if ($cal_in == $cal_out) {
			throw new Gatuf_Form_Invalid ('El calendario de ingreso debe ser diferente al de egreso');
		}
		
		$cal_a = substr ($cal_in, 0, 4);
		$cal_b = substr ($cal_out, 0, 4);
		
		if ($cal_a > $cal_b) {
			throw new Gatuf_Form_Invalid ('El calendario de egreso debe ser posterior al de ingreso');
		} else if ($cal_a == $cal_b && substr ($cal_in, 4) == 'B') {
			throw new Gatuf_Form_Invalid ('El calendario de egreso debe ser posterior al de ingreso');
		}
		/* TODO: Cuando agreguemos los calendarios C, D y E,
		 * verificar que ambos sean trimestres */
		
		/* Las opciones de titulación que requieren desempeño, verificar que pongan un desempeño */
		$opcion = $this->cleaned_data['opcTitulacion'];
		
		/* FIXME: No debería estar códificado manualmente */
		if (in_array ($opcion, array (3, 4, 5, 6))) {
			/* Estos requiren desempeño */
			if ($this->cleaned_data['desempeno'] == '') {
				throw new Gatuf_Form_Invalid ('Se requiere poner un desempeño');
			}
		}
		
		if (in_array ($opcion, array (7, 8, 10, 11, 12, 13, 14, 15, 16))) {
			/* Estos requiren Nombre del trabajo */
			if ($this->cleaned_data['nombre_trabajo'] == '') {
				throw new Gatuf_Form_Invalid ('Se requiere un nombre de trabajo');
			}
		}
		
		if ($opcion == 9) {
			/* Se requieren los 3 campos extras de la maestria */
			if ($this->cleaned_data['cantidad_materias'] == '' || $this->cleaned_data['nombre_maestria'] == '' || $this->cleaned_data['escuela_maestria'] == '') {
				throw new Gatuf_Form_Invalid ('Algunos campos sobre la maestria se encuentran vacios');
			}
		}
		
		return $this->cleaned_data;
	}
	
	public function save ($commit=true){
		if(!$this->isValid()) {
			throw new Exception ('El formulario contiene datos inválidos');
		}
		
		$acta = new Titulacion_Acta ();
		
		$acta->plan = $this->cleaned_data['planEstudios'];
		$acta->folio = $this->cleaned_data['folio'];
		$acta->calificacion = $this->cleaned_data['calificacion'];
		$acta->acta = $this->cleaned_data['numeroActa'];
		$acta->modalidad = $this->cleaned_data['opcTitulacion'];
		$acta->carrera = $this->cleaned_data['carrera'];
		$acta->alumno = $this->alumno->codigo;
		$acta->fechaHora = $this->cleaned_data['fechaHora'];
		$acta->ingreso = $this->cleaned_data['ingreso'];
		$acta->egreso = $this->cleaned_data['egreso'];
		$acta->secretario_division = $this->cleaned_data['secretario'];
		$acta->director_division = $this->cleaned_data['director'];
		$acta->jurado1 = $this->cleaned_data['jurado1'];
		$acta->jurado2 = $this->cleaned_data['jurado2'];
		$acta->jurado3 = $this->cleaned_data['jurado3'];
		
		/* Campos extras */
		$acta->desempeno = $this->cleaned_data['desempeno'];
		$acta->nombre_trabajo = $this->cleaned_data['nombre_trabajo'];
		$acta->materias_maestria = $this->cleaned_data['cantidad_materias'];
		$acta->nombre_maestria = $this->cleaned_data['nombre_maestria'];
		$acta->escuela_maestria = $this->cleaned_data['escuela_maestria'];
		
		if ($commit) $acta->create ();
		
		return $acta;
	}
}
