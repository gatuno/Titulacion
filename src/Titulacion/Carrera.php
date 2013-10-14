<?php

class Titulacion_Carrera extends Gatuf_Model {
	/* Manejador de la tabla de carreras */
	
	/* Campos */
	public $clave;
	public $descripcion;
	public $grado_m, $grado_f;
	public $nombre_largo;
	
	function __construct () {
		$this->_getConnection();
		
		$this->tabla = 'Carreras_Extendidas';
		$this->tabla_view = 'Carreras_View';
	}
	
	function getCarrera ($clave) {
		/* Recuperar una carrera */
		$req = sprintf ('SELECT * FROM %s WHERE clave = %s', $this->getSqlViewTable(), Gatuf_DB_IdentityToDb ($clave, $this->_con));
		
		if (false === ($rs = $this->_con->select($req))) {
			throw new Exception($this->_con->getError());
		}
		
		if (count ($rs) == 0) {
			return false;
		}
		foreach ($rs[0] as $col => $val) {
			$this->$col = $val;
		}
		return true;
	}
	
	function create () {
		$carrera = new Calif_Carrera ();
		if (false === ($carrera->getCarrera ($this->clave))) {
			/* La carrera no existe dentro de las carreras originales */
			$carrera->clave = $this->clave;
			$carrera->descripcion = $this->descripcion;
			$carrera->create ();
		}
		$req = sprintf ('INSERT INTO %s (clave, grado_m, grado_f, nombre_largo) VALUES (%s, %s, %s, %s);', $this->getSqlTable(), Gatuf_DB_IdentityToDb ($this->clave, $this->_con), Gatuf_DB_IdentityToDb ($this->grado_m, $this->_con), Gatuf_DB_IdentityToDb ($this->grado_f, $this->_con), Gatuf_DB_IdentityToDb ($this->nombre_largo, $this->_con));
		$this->_con->execute($req);
		
		return true;
	}
	
	function update () {
		$carrera = new Calif_Carrera ();
		$carrera->descripcion = $this->descripcion;
		$carrera->update ();
		
		$req = sprintf ('UPDATE %s SET grado_m = %s, grado_f = %s, nombre_largo = %s WHERE clave = %s', $this->getSqlTable(), Gatuf_DB_IdentityToDb ($this->grado_m, $this->_con), Gatuf_DB_IdentityToDb ($this->grado_f, $this->_con), Gatuf_DB_IdentityToDb ($this->nombre_largo, $this->_con), Gatuf_DB_IdentityToDb ($this->clave, $this->_con));
		
		$this->_con->execute($req);
		
		return true;
	}
	
	public function displaylinkedclave () {
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index', array (), array ('f_carrera' => $this->clave));
		return '<a href="'.$url.'">'.$this->clave.'</a>';
	}
}
