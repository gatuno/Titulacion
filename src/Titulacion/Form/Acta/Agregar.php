<?php

class Titulacion_Form_Acta_Agregar extends Gatuf_Form {
	public function initfields ($extra = array ()) {
		$planes = Gatuf::factory ('Titulacion_PlanEstudio')->getList ();
		
		$choices = array ();
		foreach ($planes as $m) {
			$choices[$m->plan] = $m->id;
		}
		
		$modalidaes = Gatuf::factory ('Titulacion_Opcion')->getList ();
		
		$choicesmod =array();
		foreach ($modalidaes  as $o) {
			$choicesmod[$o->descripcion] = $o->id;

		}
		
		$maestros = Gatuf::factory ('Titulacion_Maestro') ->getList ();
		$choicesmae = array ();
		foreach ($maestros as $j){
			//$choicesmae[$j->apellido] = $j->codigo;
		$choicesmae[$j->apellido.' '.$j->nombre] = $j->codigo;
		}
		
		$carreras = Gatuf::factory ('Titulacion_Carrera') ->getList ();
		$choicescarr = array ();
		foreach ($carreras as $c){
			$choicescarr[$c->descripcion] = $c->clave;
		}
	
	
	$this->fields['planEstudios'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Plan de estudios',
				'initial' => '',
				'help_text' => 'El plan de estudios',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices
				),
			)
		);
	$this->fields['folio'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Folio',
				'initial' => '',
				'max_length' => 10,
				'widget_attrs' => array (
					'maxlength' => 10,
					'size' => 10,
				),
			)
		);
		
		$this->fields['numeroActa']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Numero de acta',
				'initial' => '',
				'help_text'=> 'El numero de el acta',
				'max_length' => 10,
				'min_length' => 1,
				'widget_attrs' => array(
					'maxlenght'=>10,
					'size'=>10,
				),

			)
		);
		
		$this->fields['opcTitulacion'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Opcion de titulacion',
				'initial' => '',
				'help_text' => 'La opcion de titulacion',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choicesmod
				)
			)
		);
		
		$this->fields['alumno']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Codigo',
				'initial' => '',
				'help_text'=> 'El codigo del alumno',
				'max_length' => 9,
				'min_length' => 9,
				'widget_attrs' => array(
					'maxlenght' =>9,
					'size' =>12,
				),
			)
		);
		
		$this->fields['carrera'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Carrera',
				'initial' => '',
				'help_text' => 'Carrera de la que egresa',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choicescarr
				),
			)
		);
		
		$this->fields['fechaHora'] = new Gatuf_Form_Field_Datetime(
			array(
				'required' => true,
				'label' => 'Fecha y hora',
				'initial' =>'',
				'help_text'=>'Fecha y hora de la ceremonia de titulacion'
			)
		);
		
		$this->fields['ingreso']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Calendario de ingreso',
				'initial' => '',
				'help_text'=> 'Año mas letra A/B',
				'max_length' => 5,
				'min_length' => 5,
				'widget_attrs' => array(
					'maxlenght' =>5,
					'size' =>6,
				),
			)
		);
		
		$this->fields['egreso']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Calendario de egreso',
				'initial' => '',
				'help_text'=> 'Año mas letra A/B',
				'max_length' => 5,
				'min_length' => 5,
				'widget_attrs' => array(
					'maxlenght' =>5,
					'size' =>6,
				),
			)
		);
		
		$this->fields['jurado1']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Jurado',
				'initial' => '',
				'help_text'=> 'Año mas letra A/B',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choicesmae
				),
			)
		);
		$this->fields['jurado2']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Jurado',
				'initial' => '',
				'help_text'=> 'Año mas letra A/B',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choicesmae
				),
			)
		);
		$this->fields['jurado3']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Jurado',
				'initial' => '',
				'help_text'=> 'Año mas letra A/B',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choicesmae
				),
			)
		);
		
			
		
	}
	
	public function clean_codigo () {
		$codigo = mb_strtoupper($this->cleaned_data['codigo']);

		if (!preg_match ('/^\w\d{8}$/', $codigo)) {
			throw new Gatuf_Form_Invalid ('El cÃ³digo del alumno es incorrecto');
		}

		$sql = new Gatuf_SQL ('codigo=%s', array ($codigo));
		$l = Gatuf::factory('Titulacion_Alumno')->getList(array ('filter' => $sql->gen(), 'count' => true));

		if ($l > 0) {
			throw new Gatuf_Form_Invalid (sprintf ('El cÃ³digo \'<a href="%s">%s</a>\' de alumno especificado ya existe', Gatuf_HTTP_URL_urlForView('Titulacion_Views_Acta::verActa', array ($codigo)), $codigo));
		}

		return $codigo;
	}
	
	public function save ($commit=true){
		if(!$this->isValid()) {
			throw new Exception ('El formulario no tiene datos validos');
		}
		$acta = new Titulacion_Actas ();
		
		$acta->planEstudios = $this->cleaned_data['plaEstudios'];
		$acta->folio = $this->cleaned_data['folio'];
		$acta->numeroActa = $this->cleaned_data['numeroActa'];
		$acta->opcTitulacion= $this->cleaned_data['opcTitulacion'];
		$acta->carrera = $this->cleaned_data['carrera'];
		$acta->alumno = $this->cleaned_data['alumno'];
		$acta->fechaHora = $this->cleaned_data['fechaHora'];
		$acta->ingreso = $this->cleaned_data['ingreso'];
		$acta->egreso = $this->cleaned_data['egreso'];
		$acta->jurado1 = $this->cleaned_data['jurado1'];
		$acta->jurado2 = $this->cleaned_data['jurado2'];
		$acta->jurado3 = $this->cleaned_data['jurado3'];

		
		if ($commit) $acta->create ();
		
		return $acta;
	}

}