<?php

class Titulacion_Form_Opcion_Actualizar extends Gatuf_Form {
	private $opcion;
	
	public function initfields ($extra = array ()) {
		$this->opcion = $extra['opcion'];
		$this->fields['descripcion'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Descripción',
				'initial' => $this->opcion->descripcion,
				'help_text' => 'Un nombre descriptivo de esta opción de titulación',
				'max_length' => 150,
				'widget_attrs' => array (
					'maxlength' => 150,
					'size' => 100,
				)
		));
		
		$choices = array ('Comité' => 'C', 'Jurado' => 'J');
		
		$this->fields['tipo'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Tipo',
				'initial' => $this->opcion->tipo,
				'help_text' => 'Si esta opcion utiliza comité o jurado',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices,
				)
		));
		
		$this->fields['articulo'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Articulo (U de G)',
				'initial' => $this->opcion->articulo,
				'help_text' => 'El artículo que describe esta opción de titulación',
				'min' => 0,
				'widget_attrs' => array (
					'size' => 5,
				)
		));
		
		$this->fields['fraccion'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Fracción (U de G)',
				'initial' => $this->opcion->fraccion,
				'help_text' => 'La fracción del artículo que describe esta opción de titulación',
				'max_length' => 10,
				'widget_attrs' => array (
					'maxlength' => 10,
					'size' => 5,
				)
		));
				
		$this->fields['articulo_cucei'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Articulo (CUCEI)',
				'initial' => $this->opcion->articulo_cucei,
				'help_text' => 'El artículo que describe esta opción de titulación',
				'min' => 0,
				'widget_attrs' => array (
					'size' => 5,
				)
		));
		
		$this->fields['fraccion_cucei'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Fracción (CUCEI)',
				'initial' => $this->opcion->fraccion_cucei,
				'help_text' => 'La fracción del artículo que describe esta opción de titulación',
				'max_length' => 10,
				'widget_attrs' => array (
					'maxlength' => 10,
					'size' => 5,
				)
		));
		
		$this->fields['trabajo'] = new Gatuf_Form_Field_Boolean (
			array (
				'required' => true,
				'label' => 'Nombre del trabajo',
				'initial' => $this->opcion->trabajo,
				'help_text' => 'Active esta casiila si la opción de titulación requiere un nombre del trabajo',
		));
		
		$this->fields['desempeno'] = new Gatuf_Form_Field_Boolean (
			array (
				'required' => true,
				'label' => 'Desempeño',
				'initial' => $this->opcion->desempeno,
				'help_text' => 'Active esta casilla si la opción de titulación requiere un desempeño',
		));
		
		$this->fields['maestria'] = new Gatuf_Form_Field_Boolean (
			array (
				'required' => true,
				'label' => 'Maestria',
				'initial' => $this->opcion->maestria,
				'help_text' => 'Active esta casilla si la opción de titulación requiere campos extras de maestria (nombre de la maestria, universidad donde se cursa, cantidad de materias)',
		));
		
		$this->fields['leyenda'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Leyenda',
				'initial' => $this->opcion->leyenda,
				'help_text' => 'La leyenda que va abajo en el acta',
				'widget' => 'Gatuf_Form_Widget_TextareaInput',
				'widget_attrs' => array (
					'cols' => 100,
					'rows' => 16,
				)
		));
	}
	
	public function clean_fraccion () {
		$fraccion = mb_strtoupper($this->cleaned_data['fraccion']);
		
		if (!preg_match ('/^[IVXLCD]+$/', $fraccion)) {
			throw new Gatuf_Form_Invalid ('La fracción es incorrecta. Sólo son válidos números romanos');
		}
		
		return $fraccion;
	}
	
	public function clean_fraccion_cucei () {
		$fraccion = mb_strtoupper($this->cleaned_data['fraccion_cucei']);
		
		if (!preg_match ('/^[IVXLCD]+$/', $fraccion)) {
			throw new Gatuf_Form_Invalid ('La fracción es incorrecta. Sólo son válidos números romanos');
		}
		
		return $fraccion;
	}
	
	public function save ($commit=true) {
		if (!$this->isValid ()) {
			throw new Exception ('Cannot save the model from and invalid form.');
		}
		
		$this->opcion->setFromFormData ($this->cleaned_data);
		
		if ($commit) $this->opcion->update ();
		
		return $this->opcion;
	}
}
