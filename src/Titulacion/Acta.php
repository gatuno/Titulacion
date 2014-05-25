<?php

class Titulacion_Acta extends Gatuf_Model {
	public $_model = __CLASS__;
	
	function init() {
		$this->_a['table'] = 'actas';
		$this->_a['model'] = __CLASS__;
		$this->primary_key = 'id';
		
		$this->_a['cols'] = array (
			'id' =>
			array (
			       'type' => 'Gatuf_DB_Field_Sequence',
			       'blank' => true,
			),
			'plan' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Titulacion_PlanEstudio',
			       'blank' => false,
			),
			'carrera' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Titulacion_Carrera',
			       'blank' => false,
			),
			'folio' =>
			array (
			       'type' => 'Gatuf_DB_Field_Integer',
			       'blank' => false,
			),
			'acta' =>
			array (
			       'type' => 'Gatuf_DB_Field_Integer',
			       'blank' => false,
			),
			'alumno' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Calif_Alumno',
			       'blank' => false,
			),
			'opcion' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Titulacion_Opcion',
			       'blank' => false,
			),
			'director' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Calif_Maestro',
			       'blank' => false,
			),
			'secretario' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Calif_Maestro',
			       'blank' => false,
			),
			'jurado1' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Calif_Maestro',
			       'blank' => false,
			),
			'jurado2' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Calif_Maestro',
			       'blank' => false,
			),
			'jurado3' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Calif_Maestro',
			       'blank' => false,
			),
			'fechahora' =>
			array (
			       'type' => 'Gatuf_DB_Field_Datetime',
			       'blank' => false,
			),
			'ingreso' =>
			array (
			       'type' => 'Gatuf_DB_Field_Char',
			       'size' => 5,
			       'blank' => false,
			),
			'egreso' =>
			array (
			       'type' => 'Gatuf_DB_Field_Char',
			       'size' => 5,
			       'blank' => false,
			),
			'calificacion' =>
			array (
			       'type' => 'Gatuf_DB_Field_Float',
			       'max_digits' => 5,
			       'decimal_places' => 1,
			       'blank' => false,
			),
			'domicilio' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Titulacion_Domicilio',
			       'blank' => false,
			),
			/* Campos extras opcionales */
			'nombre_trabajo' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'size' => 500,
			       'blank' => false,
			),
			'desempeno' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'size' => 50,
			       'blank' => false,
			),
			'nombre_maestria' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'size' => 200,
			       'blank' => false,
			),
			'escuela_maestria' =>
			array (
			       'type' => 'Gatuf_DB_Field_Varchar',
			       'size' => 200,
			       'blank' => false,
			),
			'materias_maestria' =>
			array (
			       'type' => 'Gatuf_DB_Field_Integer',
			       'blank' => false,
			),
			'eliminada' => /* Cuando un acta ha sido eliminada */
			array (
			       'type' => 'Gatuf_DB_Field_Boolean',
			       'default' => false,
			       'blank' => false,
			),
			'create_time' =>
			array (
			       'type' => 'Gatuf_DB_Field_Datetime',
			       'blank' => false,
			),
			'create_user' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Calif_User',
			       'blank' => false,
			),
			'modification_time' =>
			array (
			       'type' => 'Gatuf_DB_Field_Datetime',
			       'blank' => false,
			),
			'modification_user' =>
			array (
			       'type' => 'Gatuf_DB_Field_Foreignkey',
			       'model' => 'Calif_User',
			       'blank' => false,
			),
		);
		
		$this->default_order = 'plan ASC, carrera ASC, year(create_time) ASC, folio ASC, opcion ASC';
		
		$this->_a['views'] = array (
			'paginador' => array (
				'select' => $this->_con->pfx.'actas_view.*',
				'from' => $this->_con->pfx.'actas_view',
				'props' => array ('alumno_nombre', 'alumno_apellido', 'anio', 'opcion_descripcion', 'plan_descripcion', 'carrera_descripcion'),
			),
		);
	}
	
	function preSave ($create=true) {
		/* Autogenerar el folio */
		if ($create) {
			$this->create_time = date ('Y-m-d H:i:s');
			
			$anio = date('Y');
			$mes = date ('M');
			/* Generar el folio */
			$sql = sprintf ('SELECT MAX(folio) as max_folio FROM %s WHERE carrera=%s AND plan=%s AND YEAR(create_time)=%s', $this->getSqlTable (), Gatuf_DB_IdentityToDb ($this->carrera, $this->_con), Gatuf_DB_IntegerToDb ($this->plan, $this->_con), Gatuf_DB_IntegerToDb ($anio, $this->_con));
			
			$rs = $this->_con->select ($sql);
			
			if (count ($rs) == 0) {
				$this->folio = 1;
			} else {
				$this->folio = ((int) $rs[0]['max_folio']) + 1;
			}
		}
		
		$this->modification_time = date ('Y-m-d H:i:s');
	}
	
	/*Funcion para que agregue en la participacion que tuvo el maestro en el cata actual*/
	function displayfunge ($extra = null){
		
		if ($extra['codigo'] == $this->secretario_division) {
			return 'Secretario de división';
		}
		if ($extra['codigo'] == $this->jurado1 || $extra['codigo'] == $this->jurado2 || $extra['codigo'] == $this->jurado3) {
			return 'Jurado';
		}
		
		if ($extra['codigo'] == $this->director_division) {
			return 'Director de división';
		}
	}
	
	public function displaylinkedfolio ($extra = null) {
		$url_folio = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $this->id);
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::porAnio', $this->anio);
		
		return '<a href="'.$url_folio.'">'.$this->folio.'</a>/<a href="'.$url.'">'.$this->anio.'</a>';
	}
	
	public function displaylinkedcarrera ($extra = null) {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::porCarrera', $this->carrera);
		
		return '<a href="'.$url.'">'.$this->carrera_descripcion.'</a>';
	}
	
	public function displaylinkedplan ($extra = null) {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::porPlan', $this->plan);
		
		return '<a href="'.$url.'">'.$this->plan_descripcion.'</a>';
	}
	
	public function displaylinkedopcion ($extra = null) {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::porOpcion', $this->opcion);
		
		return '<a href="'.$url.'">'.$this->opcion_descripcion.'</a>';
	}
	
	public function displayfolio ($extra = null) {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $this->id);
		
		return '<a href="'.$url.'">'.$this->folio.'</a>/'.$this->anio;
	}
	
	public function displaycarrera ($extra = null) {
		return $this->carrera_descripcion;
	}
	
	public function displayplan ($extra = null) {
		return $this->plan_descripcion;
	}
	
	public function displayopcion ($extra = null) {
		return $this->opcion_descripcion;
	}
	
	/* Override Gatuf's connection */
	function _getConnection () {
		static $con = null;
		if ($this->_con !== null) {
			return $this->_con;
		}
		if ($con !== null) {
			$this->_con = $con;
			return $this->_con;
		}
		Gatuf::loadFunction('Titulacion_DB_getConnection');
		$this->_con = Titulacion_DB_getConnection();
		$con = $this->_con;
		return $this->_con;
	}
}
