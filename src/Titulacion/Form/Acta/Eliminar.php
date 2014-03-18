<?php

class Titulacion_Form_Acta_Eliminar extends Gatuf_Form {
	private $acta;
	
	public function initfields ($extra = array ()) {
		$this->acta = $extra['acta'];
		
		$this->fields['razon'] = new Gatuf_Form_Field_Varchar (
			array (
				'required' => true,
				'label' => 'Razon',
				'initial' => '',
				'help_text' => 'Las razones por las que se da de baja este folio',
				'widget' => 'Gatuf_Form_Widget_TextareaInput',
		));
	}
	
	public function save ($commit = true) {
		$acta_eliminada = new Titulacion_ActaEliminada ();
		
		$acta_eliminada->acta = $this->acta;
		$acta_eliminada->razon = $this->cleaned_data['razon'];
		
		if ($commit) $acta_eliminada->create ();
		
		return $acta_eliminada;
	}
}
