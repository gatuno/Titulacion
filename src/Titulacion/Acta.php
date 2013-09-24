<?php

class Titulacion_Acta extends Gatuf_Model {
	public $id;
	public $plan; /* El plan de estudios */
	public $plan_descripcion;
	public $folio;
	public $acta; /* El número de acta */
	public $modalidad; /* La opción de titulación */
	public $modalidad_descripcion;
	public $director_division, $secretario_division;
	public $jurado1;
	public $jurado2;
	public $jurado3;
	public $alumno; /*Llave foranea*/
	public $alumno_nombre;
	public $alumno_apellido;
	public $domicilio;
	public $fechaHora;
	public $ingreso; /* Calendario de ingreso */
	public $egreso; /* Calendario de egreso */
	public $carrera;
	public $carrera_descripcion;
	public $calificacion;
	public $anio;
	
	/* Campos extra dependiendo de la modalidad de titulación */
	public $desempeno;
	public $nombre_trabajo;
	public $materias_maestria;
	public $nombre_maestria;
	public $escuela_maestria;
	
	/* Control interno */
	public $createtime, $modifcationtime;
	public $creador, $modificador;
	
	function __construct() {
		$this->_getConnection();
		$this->tabla = 'Actas';
		$this->tabla_view= 'Actas_View';
		
		$this->default_order = 'anio ASC, modalidad_descripcion ASC, carrera ASC, alumno_apellido ASC';
	}
	
	function getActa($id) {
		$req = sprintf('SELECT * FROM %s WHERE id=%s', $this->getSqlViewTable (),Gatuf_DB_IntegerToDb ($id, $this->_con));
		
		if(false=== ($rs = $this->_con->select ($req))){
			throw new Exception ($this->_con->getError());
		}
		if(count ($rs)== 0){
			return false;
		}
		foreach ($rs[0] as $col =>$val){
			$this->$col = $val;
		}
		return true;
	}

	public function create() {
		$req = sprintf('INSERT INTO %s (plan, folio, acta, modalidad, alumno, domicilio, director_division, secretario_division, jurado1, jurado2, jurado3, carrera, fechaHora, ingreso, egreso, calificacion, desempeno, materias_maestria, nombre_maestria, escuela_maestria, nombre_trabajo, createtime, creador, modificador) ', $this->getSqlTable ());
		$req = $req . sprintf ('VALUES (%s, %s, %s, %s, %s, %s, %s, %s, ', Gatuf_DB_IntegerToDb ($this->plan, $this->_con), Gatuf_DB_IntegerToDb ($this->folio, $this->_con), Gatuf_DB_IntegerToDb ($this->acta, $this->_con), Gatuf_DB_IntegerToDb ($this->modalidad, $this->_con), Gatuf_DB_IdentityToDb ($this->alumno, $this->_con), Gatuf_DB_IntegerToDB ($this->domicilio, $this->_con), Gatuf_DB_IntegerToDb ($this->director_division, $this->_con), Gatuf_DB_IntegerToDb ($this->secretario_division, $this->_con));
		
		$req = $req . sprintf ('%s, %s, %s, %s, %s, %s, %s, %s, ', Gatuf_DB_IntegerToDb ($this->jurado1, $this->_con), Gatuf_DB_IntegerToDb ($this->jurado2, $this->_con), Gatuf_DB_IntegerToDb ($this->jurado3, $this->_con),Gatuf_DB_IdentityToDb ($this->carrera, $this->_con), Gatuf_DB_IdentityToDb ($this->fechaHora, $this->_con), Gatuf_DB_IdentityToDb ($this->ingreso, $this->_con), Gatuf_DB_IdentityToDb ($this->egreso, $this->_con), Gatuf_DB_IntegerToDb ($this->calificacion, $this->_con));
		
		$req = $req . sprintf ('%s, %s, %s, %s, %s, NOW(), %s, %s)', Gatuf_DB_IdentityToDb ($this->desempeno, $this->_con), Gatuf_DB_IntegerToDb ($this->materias_maestria, $this->_con), Gatuf_DB_IdentityToDb ($this->nombre_maestria, $this->_con), Gatuf_DB_IdentityToDb ($this->escuela_maestria, $this->_con), Gatuf_DB_IdentityToDb ($this->nombre_trabajo, $this->_con), Gatuf_DB_IntegerToDb ($this->creador, $this->_con), Gatuf_DB_IntegerToDb ($this->modificador, $this->_con));
		
		$this->_con->execute ($req);
		
		$this->id = $this->_con->getLastId ();
		
		return true;
	}
	
	public function displaycarrera ($extra=null) {
		return '<abbr title="'.$this->carrera_descripcion.'">'.$this->carrera.'</abbr>';
	}
	
	public function displaylinkedfolio ($extra = null) {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $this->id);
		return '<a href="'.$url.'">'.$this->folio.'</a>';
	}
}
