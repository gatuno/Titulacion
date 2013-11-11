<?php

class Titulacion_Opcion extends Gatuf_Model {
	public $_model = __CLASS__;
	public function init () {
		$this->_a['table'] = 'opciones';
		$this->_a['model'] = __CLASS__;
		$this->primary_key = 'id';
		
		$this->_a['cols'] = array (
			'id' =>
			array (
			       'type' => 'Gatuf_DB_Field_Sequence',
			       'blank' => true,
			),
			'modalidad' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'blank' => false,
			       'model' => 'Titulacion_Modalidad',
			),
			'articulo' =>
			array (
			       'type' => 'Gatuf_DB_Field_Integer',
			       'blank' => false,
			),
			'fraccion' =>
			array (
			       'type' => 'Gatuf_DB_Field_Char',
			       'blank' => false,
			       'size' => 10,
			),
			'articulo_cucei' =>
			array (
			       'type' => 'Gatuf_DB_Field_Integer',
			       'blank' => false,
			),
			'fraccion_cucei' => 
			array (
			       'type' => 'Gatuf_DB_Field_Char',
			       'blank' => false,
			       'size' => 10,
			),
			'desempeno' =>
			array (
			       'type' => 'Gatuf_DB_Field_Boolean',
			       'default' => false,
			       'blank' => false,
			),
			'maestria' =>
			array (
			       'type' => 'Gatuf_DB_Field_Boolean',
			       'default' => false,
			       'blank' => false,
			),
			'trabajo' =>
			array (
			       'type' => 'Gatuf_DB_Field_Boolean',
			       'default' => false,
			       'blank' => false,
			),
		);
		
		$this->default_order = 'modalidad ASC';
		
		$this->_a['views'] = array (
			'paginador' => array (
				'select' => $this->_con->pfx.'opciones_view',
				'from' => $this->_con->pfx.'opciones_view',
				'props' => array ('modalidad_desc'),
			),
		);
	}
	
	public function displayudg ($extra=null) {
		return $this->articulo.' - '.$this->fraccion;
	}
	
	public function displaycucei ($extra=null) {
		return $this->articulo_cucei.' - '.$this->fraccion_cucei;
	}
	
	public function displaylinkeddescripcion ($extra = null) {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index', array (), array ('f_modalidad' => $this->id));
		
		return '<a href="'.$url.'">'.$this->descripcion.'</a>';
	}
}
