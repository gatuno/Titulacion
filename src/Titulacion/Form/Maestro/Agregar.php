<?php

class Titulacion_Form_Maestro_Agregar extends Gatuf_Form {
	public function initFields ($extra = array ()) {
		/* Preparar catalogos */
		$choices_grados = array ('Lic.' => 'L', 'Ing.' => 'I', 'Mtro./Mtra' => 'M', 'Dr./Dra.' => 'D');
		$choices_sex = array ('Masculino' => 'M', 'Femenino' => 'F');
		
		$this->fields['codigo'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Código',
				'initial' => '',
				'help_text' => 'El código del maestro de 7 caracteres',
				'min' => 1000000,
				'max' => 9999999,
				'widget_attrs' => array (
					'maxlength' => 7,
					'size' => 12,
				),
		));
		
		$this->fields['nombre'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Nombre',
				'initial' => '',
				'help_text' => 'El nombre o nombres del maestro',
				'max_length' => 50,
				'widget_attrs' => array (
					'maxlength' => 50,
					'size' => 30,
				),
		));
		
		$this->fields['apellido'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Apellido',
				'initial' => '',
				'help_text' => 'Los apellidos del maestro',
				'max_length' => 100,
				'widget_attrs' => array (
					'maxlength' => 100,
					'size' => 30,
				),
		));
		
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
		
		$this->fields['grado'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Grado de estudios',
				'initial' => '',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array(
					'choices' => $choices_grados
				),
		));
		
		$this->fields['email'] = new Gatuf_Form_Field_Email (
			array (
				'required' => true,
				'label' => 'Correo',
				'initial' => '',
				'help_text' => 'Un correo',
		));
	}
	
	public function clean_codigo () {
		$codigo = $this->cleaned_data['codigo'];
		$sql = new Gatuf_SQL ('codigo=%s', array ($codigo));
		$l = Gatuf::factory('Calif_Maestro')->getList(array ('filter' => $sql->gen(), 'count' => true));
		
		if ($l > 0) {
			throw new Gatuf_Form_Invalid (sprintf ('El código %s del maestro especificado ya existe', $codigo));
		}
		
		return $codigo;
	}
	
	public function save ($commit = true) {
		if (!$this->isValid ()) {
			throw new Exception ('Cannot save the model from and invalid form.');
		}
		
		$maestro = new Calif_Maestro ();
		$user = new Calif_User ();
		
		$maestro->setFromFormData ($this->cleaned_data);
		
		$user->login = $this->cleaned_data['codigo'];
		$user->email = $this->cleaned_data['email'];
		$user->type = 'm';
		$user->administrator = false;
		
		$maestro->user = $user;
		
		if ($commit) {
			$maestro->create();
			$user->create ();
		}
		
		return $maestro;
	}
}
