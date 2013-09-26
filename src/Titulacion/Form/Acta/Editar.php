<?php

	class Titulacion_Form_Acta_Editar extends Gatuf_Form {
		public $acta;
			
			$choices_cal = array ();
			for($g = date ('Y'); $g> 1968' $g--){
				$choices_cal [$g] = array ('A' => $g.'A', 'B' => $g.'B');
			}
			
			
			$this->fields['calificacion'] = new Gatuf_Form_Field_Float (
			array (
				'required' => false,
				'label' => 'Calificacion',
				'initial' => '',
				'help_text'=> $this->$acta->calificacion;
				'widget_attrs' => array(
					'size' => 10
				)
		));

			$this->fields['numeroActa'] = new Gatuf_Form_Fiel_Integer (
					array(
							'required' => false,
							'label' => 'Numero de acta',
							'initial' => $this->$acta->codigo,
							'help_text' => 'El nÃºmero de acta',
							'max_length' => 9,
							'widget_attrs' => array (
								'maxlength' => 9,
								'size' => 12,
		
							),

							
						)
			);
			
			$this->fields['folio'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Folio',
				'initial' => $this->$acta->folio,
				'widget_attrs' => array (
					'size' => 10
					'readonly' => 'readonly',

				),
		));
		
		$this->fields['cantidad_materias'] = new Gatuf_Form_Field_Integer (
				array (
				'required' => false,
				'label' => 'Cantidad de materias',
				'initial' => $this->$acta->cantidad_materias,
				'min' => 1,
		));
	
		$this->fields['nombre_maestria'] = new Gatuf_Form_Field_Varchar (
				array (
				'required' => false,
				'label' => 'Nombre del posgrado',
				'initial' => $this->$acta->nombre_maestria,
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
				'initial' => $this->$acta->'escuela_maestria,
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
		0
		

			
			
	
	}



?>
