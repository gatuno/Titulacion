<?php

class Titulacion_Form_Maestro_Buscar extends Gatuf_Form {
	public function initfields ($extra = array ()) {
		
			$this->fields['primeraFecha'] = new Gatuf_Form_Field_Datetime (
			array(
				'required' => true,
				'label' => 'Desde la fecha',
				'initial' =>'',
				'help_text'=>'Fecha a partir de la cual deseas hacer el filtrado',
				'widget' => 'Gatuf_Form_Widget_DatetimeJSInput'
				
		));
		
				$this->fields['ultimaFecha'] = new Gatuf_Form_Field_Datetime (
			array(
				'required' => true,
				'label' => 'Hasta la fecha',
				'initial' =>'',
				'help_text'=>'Fecha a hasta la cual deseas hacer el filtrado',
				'widget' => 'Gatuf_Form_Widget_DatetimeJSInput'
				
		));
		
	
	
	}
	
	
	public function save($commit=true){
	$fecha1 = $this->cleaned_data['primeraFecha'];
	$fecha2 = $this->cleaned_data['ultimaFecha'];
	$fechas = array ($fecha1,$fecha2);
	return $fechas;
	}

}