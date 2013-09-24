<?php

class Titulacion_Form_Alumno_Agregar extends Gatuf_Form {
	public function initfields($extra=array()){
	
	$choices_sex = array ('Masculino' => 'M', 'Femenino' => 'F');
	
		$this->fields['codigo'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Código',
				'initial' => $extra['alumno'],
				'help_text' => 'El código de alumno de 9 caracteres',
				'max_length' => 9,
				'min_length' => 9,
				'widget_attrs' => array (
					'maxlength' => 9,
					'size' => 12,
				),
			)
		);
	
		$this->fields['nombre']= new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Nombre',
				'initial' =>'',
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
				'initial' => '',
				'help_text'=> 'Los apellidos del alumno',
				'max_length' => 100,
				'widget_attrs' => array (
					'maxlength' => 100,
					'size' => 30,
				),
			)
		);
		
		/* Los datos correspondientes al domicilio */
		$this->fields['calle'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
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
		
		
			$this->fields['sexo'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Sexo',
				'initial' => '',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array(
					'choices' => $choices_sex
				),
		));
		
		$this->fields['numero_ext'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
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
				'required' => true,
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
				'required' => true,
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
				'required' => true,
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
	
	public function save ($commit=true){
		if(!$this->isValid()){
			throw new Exception ('El formulario no tiene datos validos');
		}
		$alumno = new Titulacion_Alumno ();
		
		$alumno->nombre = $this->cleaned_data['nombre'];
		$alumno->apellido = $this->cleaned_data['apellido'];
		$alumno->codigo = $this->cleaned_data['codigo'];
		$alumno->sexo = $this->cleaned_data['sexo'];
	
		if ($commit) $alumno->create ();
		
		$domicilio = new Titulacion_Domicilio ();
		
		$domicilio->numero_exterior = $this->cleaned_data['numero_ext'];
		$domicilio->numero_interior = $this->cleaned_data['numero_int'];
		$domicilio->calle = $this->cleaned_data['calle'];
		$domicilio->ciudad = $this->cleaned_data['ciudad'];
		$domicilio->codigo_postal = $this->cleaned_data['cp'];
		$domicilio->colonia = $this->cleaned_data['colonia'];
		$domicilio->telefono_casa = $this->cleaned_data['tel_casa'];
		$domicilio->telefono_celular = $this->cleaned_data['tel_cel'];
		
		$domicilio->alumno = $alumno->codigo;
		
		$domicilio->create ();
		
		return $domicilio;
	}
		
}
