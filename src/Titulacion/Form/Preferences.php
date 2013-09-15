<?php

class Titulacion_Form_Preferences extends Gatuf_Form {
	public $gconf;
	
	public function initFields($extra=array()) {
		$this->gconf = new Gatuf_GSetting ('Titulacion');
		
		/* Cargar el catalogo de maestros */
		$choices_maestros = array ();
		$maestros = Gatuf::factory ('Titulacion_Maestro')->getList ();
		foreach ($maestros as $m) {
			$choices_maestros [$m->apellido.' '.$m->nombre] = $m->codigo;
		}
		
		$this->fields['director'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Director de la división',
				'initial' => $this->gconf->getVal ('director', ''),
				'help_text' => 'El director de división por defecto en cada acta',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
		
		$this->fields['secretario'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Secretario de la división',
				'initial' => $this->gconf->getVal ('secretario', ''),
				'help_text' => 'El secretario de división por defecto en cada acta',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
	}
	
	public function save ($commit=true) {
		if ($commit) {
			$this->gconf->setVal ('director', $this->cleaned_data['director']);
			$this->gconf->setVal ('secretario', $this->cleaned_data['secretario']);
		}
		return true;
	}
}
