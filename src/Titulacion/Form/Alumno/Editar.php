<?php

class Titulacion_Form_Alumno_Editar extends Gatuf_Form {
	public $alumno;
	
	public function initfields($extra=array()){
		Gatuf::loadFunction ('Titulacion_Utils_formatearTelefono');
		Gatuf::loadFunction ('Titulacion_Utils_formatearDomicilio');
		
		$this->alumno = $extra['alumno'];
		
		$this->fields['codigo'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Código',
				'initial' => $this->alumno->codigo,
				'help_text' => 'El código de alumno de 9 caracteres',
				'max_length' => 9,
				'min_length' => 9,
				'widget_attrs' => array (
					'maxlength' => 9,
					'size' => 12,
					'readonly' => 'readonly',
				),
			)
		);
	
		$this->fields['nombre']= new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Nombre',
				'initial' => $this->alumno->nombre,
				'help_text' => 'El nombre o nombres el alumno',
				'max_length' => 50,
				'widget_attrs' => array (
					'maxlength'=> 50,
					'size' =>30,
				),
			)
		);
		$this->fields['apellido']= new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Apellido',
				'initial' => $this->alumno->apellido,
				'help_text'=> 'Los apellidos del alumno',
				'max_length' => 100,
				'widget_attrs' => array (
					'maxlength' => 100,
					'size' => 30,
				),
			)
		);
		
		/* Recoger todos los domicilios existentes, dar a elegir entre alguno */
		$sql = new Gatuf_SQL ('alumno=%s', $this->alumno->codigo);
		$domicilios = Gatuf::factory ('Titulacion_Domicilio')->getList (array ('filter' => $sql->gen()));
		
		$choices_dom = array ();
		$last_id = -1;
		foreach ($domicilios as $dom) {
			/* Generar una cadena de resumen del domicilio */
			$cad = Titulacion_Utils_formatearDomicilio ($dom);
			$choices_dom[$cad] = $dom->id;
			$last_id = $dom->id;
		}
		
		$choices_dom['Nuevo'] = -1;
		
		$this->fields['domicilios'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Domicilios',
				'initial' => $last_id,
				'widget_attrs' => array (
					'choices' => $choices_dom,
				),
				'widget' => 'Gatuf_Form_Widget_RadioInput',
			)
		);
		/* Los datos correspondientes al domicilio */
		$this->fields['calle'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Calle',
				'initial' => '',
				'help_text' => 'La calle de su domicilio actual',
				'max_length' => 150,
				'widget_attrs' => array (
					'maxlength' => 150,
					'size' => 40,
				),
			)
		);
		
		$this->fields['numero_ext'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Número exterior',
				'initial' => '',
				'help_text' => 'Número exterior',
				'max_length' => 20,
				'widget_attrs' => array (
					'maxlength' => 20,
				),
			)
		);
		
		$this->fields['numero_int'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Número interior',
				'initial' => '',
				'help_text' => 'Número interior, si tiene uno',
				'max_length' => 20,
				'widget_attrs' => array (
					'maxlength' => 20,
				),
			)
		);
		
		$this->fields['colonia'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Colonia',
				'initial' => '',
				'help_text' => 'Colonia o delegación',
				'max_length' => 150,
				'widget_attrs' => array (
					'maxlength' => 150,
					'size' => 30,
				),
			)
		);
		
		$this->fields['ciudad'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Ciudad',
				'initial' => '',
				'help_text' => 'Ciudad',
				'max_length' => 150,
				'widget_attrs' => array (
					'maxlength' => 150,
					'size' => 30,
				),
			)
		);
		
		$this->fields['cp'] = new Gatuf_Form_Field_Varchar ( /* Código Postal */
			array (
				'required' => false,
				'label' => 'C.P.',
				'initial' => '',
				'help_text' => 'Código Postal',
				'max_length' => 5,
				'widget_attrs' => array (
					'maxlength' => 5,
				),
			)
		);
		
		$this->fields['tel_casa'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Teléfono de casa',
				'initial' => '',
				'help_text' => 'Teléfono de casa, si tiene alguno',
				'max_length' => 20,
				'widget_attrs' => array (
					'maxlength' => 20
				),
			)
		);
		
		$this->fields['tel_cel'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => false,
				'label' => 'Teléfono celular',
				'initial' => '',
				'help_text' => 'Teléfono celular, si tiene alguno',
				'max_length' => 20,
				'widget_attrs' => array (
					'maxlength' => 20
				),
			)
		);
		
		$this->fields['acta'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => false,
				'initial' => $extra['acta'],
				'widget' => 'Gatuf_Form_Widget_HiddenInput',
			)
		);
	}
	
	public function clean_tel_casa () {
		$tel_casa = $this->cleaned_data ['tel_casa'];
		
		$limpio = str_replace (array (' ', '-'), '', $tel_casa);
		
		if (!preg_match ('/^[0-9]*$/', $limpio)) {
			throw new Gatuf_Form_Invalid ('El teléfono de casa sólo pueden ser dígitos');
		}
		
		return $limpio;
	}
	
	public function clean_tel_cel () {
		$tel_cel = $this->cleaned_data ['tel_cel'];
		
		$limpio = str_replace (array (' ', '-'), '', $tel_cel);
		
		if (!preg_match ('/^[0-9]*$/', $limpio)) {
			throw new Gatuf_Form_Invalid ('El teléfono celular sólo pueden ser dígitos');
		}
		
		return $limpio;
	}
	
	public function clean () {
		$dom_nue = $this->cleaned_data['domicilios'];
		
		if ($dom_nue == -1) {
			if ($this->cleaned_data['numero_ext'] == '' ||
			    $this->cleaned_data['calle'] == '' ||
			    $this->cleaned_data['ciudad'] == '' ||
			    $this->cleaned_data['cp'] == '' ||
			    $this->cleaned_data['colonia'] == '') { /* Los campos obligatorios NO tan obligatorios */
				throw new Gatuf_Form_Invalid ('Faltan campos en el formulario');
			}
		}
		
		return $this->cleaned_data;
	}
	
	public function save ($commit=true){
		if(!$this->isValid()){
			throw new Exception ('El formulario contiene datos inválidos');
		}
		
		$this->alumno->nombre = $this->cleaned_data['nombre'];
		$this->alumno->apellido = $this->cleaned_data['apellido'];
		
		if ($commit) $this->alumno->update ();
		
		if ($this->cleaned_data['domicilios'] == -1) {
			/* Crear el nuevo domicilio */
			$domicilio = new Titulacion_Domicilio ();
			
			$domicilio->numero_exterior = $this->cleaned_data['numero_ext'];
			$domicilio->numero_interior = $this->cleaned_data['numero_int'];
			$domicilio->calle = $this->cleaned_data['calle'];
			$domicilio->ciudad = $this->cleaned_data['ciudad'];
			$domicilio->codigo_postal = $this->cleaned_data['cp'];
			$domicilio->colonia = $this->cleaned_data['colonia'];
			$domicilio->telefono_casa = $this->cleaned_data['tel_casa'];
			$domicilio->telefono_celular = $this->cleaned_data['tel_cel'];
			
			$domicilio->alumno = $this->alumno->codigo;
			
			$domicilio->create ();
		} else {
			$sql = new Gatuf_SQL ('alumno=%s', $this->alumno->codigo);
			$domicilios = Gatuf::factory ('Titulacion_Domicilio')->getList (array ('filter' => $sql->gen ()));
			
			$domicilio = null;
			foreach ($domicilios as $dom) {
				if ($dom->id == $this->cleaned_data['domicilios']) {
					$domicilio = $dom;
				}
			}
		}

		return $domicilio;
	}
		
}
