<?php

class Titulacion_Form_Maestro_Buscar extends Gatuf_Form {
	public function initfields ($extra = array ()) {
		
			$this->fields['primeraFecha'] = new Gatuf_Form_Field_Datetime (
			array(
				'required' => true,
				'label' => 'Desde la fecha',
				'initial' =>'',
				'help_text'=>'Fecha a partir de la cual deseas hacer el filtrado',
				'widget' => 'Gatuf_Form_Widget_DatetimeJSInput',
				'widget_attrs' => array (
					'js_attrs' => array (
						'minDate' => 0,
					),
				)
		));
		
				$this->fields['ltimaFecha'] = new Gatuf_Form_Field_Datetime (
			array(
				'required' => true,
				'label' => 'Hasta la fecha',
				'initial' =>'',
				'help_text'=>'Fecha a hasta la cual deseas hacer el filtrado',
				'widget' => 'Gatuf_Form_Widget_DatetimeJSInput',
				'widget_attrs' => array (
					'js_attrs' => array (
						'minDate' => 0,
					),
				)
		));
	
	}

}