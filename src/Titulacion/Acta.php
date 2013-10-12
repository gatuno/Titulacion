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
		
		$this->default_order = 'plan ASC, carrera ASC, anio ASC, folio ASC, modalidad_descripcion ASC, alumno_apellido ASC';
		$this->calificacion = 0.0;
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
		$this->preSave (true);
		$req = sprintf('INSERT INTO %s (plan, folio, acta, modalidad, alumno, domicilio, director_division, secretario_division, jurado1, jurado2, jurado3, carrera, fechaHora, ingreso, egreso, calificacion, desempeno, materias_maestria, nombre_maestria, escuela_maestria, nombre_trabajo, createtime, modificationtime, creador, modificador) ', $this->getSqlTable ());
		$req = $req . sprintf ('VALUES (%s, %s, %s, %s, %s, %s, %s, %s, ', Gatuf_DB_IntegerToDb ($this->plan, $this->_con), Gatuf_DB_IntegerToDb ($this->folio, $this->_con), Gatuf_DB_IntegerToDb ($this->acta, $this->_con), Gatuf_DB_IntegerToDb ($this->modalidad, $this->_con), Gatuf_DB_IdentityToDb ($this->alumno, $this->_con), Gatuf_DB_IntegerToDB ($this->domicilio, $this->_con), Gatuf_DB_IntegerToDb ($this->director_division, $this->_con), Gatuf_DB_IntegerToDb ($this->secretario_division, $this->_con));
		
		$req = $req . sprintf ('%s, %s, %s, %s, %s, %s, %s, %s, ', Gatuf_DB_IntegerToDb ($this->jurado1, $this->_con), Gatuf_DB_IntegerToDb ($this->jurado2, $this->_con), Gatuf_DB_IntegerToDb ($this->jurado3, $this->_con),Gatuf_DB_IdentityToDb ($this->carrera, $this->_con), Gatuf_DB_IdentityToDb ($this->fechaHora, $this->_con), Gatuf_DB_IdentityToDb ($this->ingreso, $this->_con), Gatuf_DB_IdentityToDb ($this->egreso, $this->_con), Gatuf_DB_IntegerToDb ($this->calificacion, $this->_con));
		
		$req = $req . sprintf ('%s, %s, %s, %s, %s, %s, %s, %s, %s)', Gatuf_DB_IdentityToDb ($this->desempeno, $this->_con), Gatuf_DB_IntegerToDb ($this->materias_maestria, $this->_con), Gatuf_DB_IdentityToDb ($this->nombre_maestria, $this->_con), Gatuf_DB_IdentityToDb ($this->escuela_maestria, $this->_con), Gatuf_DB_IdentityToDb ($this->nombre_trabajo, $this->_con), Gatuf_DB_IdentityToDb ($this->createtime, $this->_con), Gatuf_DB_IdentityToDb ($this->modificationtime, $this->_con), Gatuf_DB_IntegerToDb ($this->creador, $this->_con), Gatuf_DB_IntegerToDb ($this->modificador, $this->_con));
		
		$this->_con->execute ($req);
		
		$this->id = $this->_con->getLastId ();
		
		return true;
	}
	
	function preSave ($create=true) {
		/* Generar el folio */
		if ($create) {
			$this->createtime = date ('Y-m-d H:i:s');
			
			$anio = date('Y');
			/* Generar el folio */
			$sql = sprintf ('SELECT MAX(folio) as max_folio FROM %s WHERE carrera=%s AND plan=%s AND YEAR(createtime)=%s', $this->getSqlTable (), Gatuf_DB_IdentityToDb ($this->carrera, $this->_con), Gatuf_DB_IntegerToDb ($this->plan, $this->_con), Gatuf_DB_IntegerToDb ($anio, $this->_con));
			
			$rs = $this->_con->select ($sql);
			
			if (count ($rs) == 0) {
				$this->folio = 1;
			} else {
				$this->folio = ((int) $rs[0]['max_folio']) + 1;
			}
		}
		
		$this->modificationtime = date ('Y-m-d H:i:s');
	}
	
	public function update() {
		$req = sprintf('UPDATE %s SET acta=%s, calificacion=%s, ingreso=%s, egreso=%s, fechaHora=%s, director_division=%s, secretario_division=%s, jurado1=%s, jurado2=%s, ', $this->getSqlTable (), Gatuf_DB_IntegerToDB ($this->acta, $this->_con), Gatuf_DB_IdentityToDB ($this->calificacion, $this->_con), Gatuf_DB_IdentityToDB ($this->ingreso, $this->_con), Gatuf_DB_IdentityToDB ($this->egreso, $this->_con), Gatuf_DB_IdentityToDB ($this->fechaHora, $this->_con), Gatuf_DB_IntegerToDB ($this->director_division, $this->_con), Gatuf_DB_IntegerToDB ($this->secretario_division, $this->_con), Gatuf_DB_IntegerToDB ($this->jurado1, $this->_con), Gatuf_DB_IntegerToDB ($this->jurado2, $this->_con));
		
		$req = $req . sprintf ('jurado3=%s, desempeno=%s, nombre_trabajo=%s, materias_maestria=%s, nombre_maestria=%s, escuela_maestria=%s, modificationtime=%s, modificador=%s WHERE id=%s', Gatuf_DB_IntegerToDB ($this->jurado3, $this->_con), Gatuf_DB_IdentityToDB ($this->desempeno, $this->_con), Gatuf_DB_IdentityToDB ($this->nombre_trabajo, $this->_con), Gatuf_DB_IntegerToDB ($this->materias_maestria, $this->_con), Gatuf_DB_IdentityToDB ($this->nombre_maestria, $this->_con), Gatuf_DB_IdentityToDB ($this->escuela_maestria, $this->_con), Gatuf_DB_IdentityToDb ($this->modificationtime, $this->_con), Gatuf_DB_IntegerToDb ($this->modificador, $this->_con), Gatuf_DB_IntegerToDB ($this->id, $this->_con));
		$this->_con->execute ($req);
		
		return false;
	}
	
	public function displaylinkedfolio ($extra = null) {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $this->id);
		
		if (isset ($extra['f_anio'])) {
			return '<a href="'.$url.'">'.$this->folio.'</a>/'.$this->anio;
		}
		$extra['f_anio'] = $this->anio;
		$url_anio = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index', array (), $extra);
		
		return '<a href="'.$url.'">'.$this->folio.'</a>/<a href="'.$url_anio.'">'.$this->anio.'</a>';
	}
	
	public function displaylinkedcarrera ($extra = null) {
		if (isset ($extra['f_carrera'])) {
			return '<abbr title="'.$this->carrera_descripcion.'">'.$this->carrera.'</abbr>';
		}
		$extra['f_carrera'] = $this->carrera;
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index', array (), $extra);
		return '<abbr title="'.$this->carrera_descripcion.'"><a href="'.$url.'">'.$this->carrera.'</a></abbr>';
	}
	
	public function displaylinkedplan ($extra = null) {
		if (isset ($extra['f_plan'])) {
			return $this->plan_descripcion;
		}
		$extra['f_plan'] = $this->plan;
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index', array (), $extra);
		return '<a href="'.$url.'">'.$this->plan_descripcion.'</a>';
	}
}
