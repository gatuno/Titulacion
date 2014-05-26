<?php

class Titulacion_Form_Preferences extends Gatuf_Form {
	public function initFields($extra=array()) {
		$gconf = new Gatuf_GSetting ();
		$gconf->setApp ('Titulacion');
		
		/* Cargar el catalogo de maestros */
		$choices_maestros = array ();
		$maestros = Gatuf::factory ('Calif_Maestro')->getList ();
		foreach ($maestros as $m) {
			$choices_maestros [$m->apellido.' '.$m->nombre] = $m->codigo;
		}
		
		$this->fields['director'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Director de la división',
				'initial' => $gconf->getVal ('director', ''),
				'help_text' => 'El director de división por defecto en cada acta',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
		
		$this->fields['modificar_director'] = new Gatuf_Form_Field_Boolean (
			array (
				'required' => true,
				'label' => 'Permitir modificar director en nuevas actas',
				'initial' => $gconf->getVal ('modificar_director', true),
				'help_text' => 'Si activa esta casilla, se puede modificar el director de la división en cada nueva acta',
		));
		
		$this->fields['secretario'] = new Gatuf_Form_Field_Integer (
			array (
				'required' => true,
				'label' => 'Secretario de la división',
				'initial' => $gconf->getVal ('secretario', ''),
				'help_text' => 'El secretario de división por defecto en cada acta',
				'widget' => 'Gatuf_Form_Widget_SelectInput',
				'widget_attrs' => array (
					'choices' => $choices_maestros,
				),
		));
		
		$this->fields['modificar_secretario'] = new Gatuf_Form_Field_Boolean (
			array (
				'required' => true,
				'label' => 'Permitir modificar secretario en nuevas actas',
				'initial' => $gconf->getVal ('modificar_secretario', true),
				'help_text' => 'Si activa esta casilla, se puede modificar el secretario de la división en cada nueva acta',
		));
	}
	
	public function save ($commit=true) {
		$gconf = new Gatuf_GSetting ();
		$gconf->setApp ('Titulacion');
		
		if ($commit) {
			$gconf->setVal ('director', $this->cleaned_data['director']);
			$gconf->setVal ('modificar_director', $this->cleaned_data['modificar_director']);
			$gconf->setVal ('secretario', $this->cleaned_data['secretario']);
			$gconf->setVal ('modificar_secretario', $this->cleaned_data['modificar_secretario']);
		}
		return true;
	}
}
