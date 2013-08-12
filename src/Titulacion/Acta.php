<?php

class Titulacion_Acta extends Gatuf_Model {
	public $id;
	public $plan; /* El plan de estudios */
	public $plan_descripcion;
	public $folio;
	public $acta; /* El número de acta */
	public $modalidad; /* La opción de titulación */
	public $modalidad_descripcion;
	public $jurado1;
	public $jurado2;
	public $jurado3;
	public $alumno; /*Llave foranea*/
	public $alumno_nombre;
	public $alumno_apellido;
	public $fechaHora;
	public $ingreso; /* Calendario de ingreso */
	public $egreso; /* Calendario de egreso */
	public $carrera;
	public $carrera_descripcion;
	
	function __construct() {
		$this->_getConnection();
		$this->tabla = 'Actas';
		$this->tabla_view= 'Actas_View';
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
		$req = sprintf('INSERT INTO %s (plan, folio, acta, modalidad, alumno, jurado1, jurado2, jurado3, carrera, fechaHora, ingreso, egreso) VALUES($s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)', $this->getSqlTable(), Gatuf_DB_IntegerToDb ($this->plan, $this->con), Gatuf_DB_IntegerToDb ($this->folio, $this->con), Gatuf_DB_IntegerToDb ($this->acta, $this->con), Gatuf_DB_IntegerToDb ($this->modalidad, $this->con), Gatuf_DB_IdentityToDb ($this->alumno, $this->con), Gatuf_DB_IntegerToDb ($this->jurado1, $this->con), Gatuf_DB_IntegerToDb ($this->jurado2, $this->con), Gatuf_DB_IntegerToDb ($this->jurado3, $this->con),Gatuf_DB_IdentityToDb ($this->carrera, $this->con), Gatuf_DB_IdentityToDb ($this->fechaHora, $this->con), Gatuf_DB_IdentityToDb ($this->ingreso, $this->con), Gatuf_DB_IdentityToDb ($this->egreso, $this->con));
		
		$this->con_->execute ($req);
		
		$this->id = $this->_con->getLastId ();
		
		return true;
	}
	
	public function displaycarrera ($extra=null) {
		return '<abbr title="'.$this->carrera_descripcion.'">'.$this->carrera.'</abbr>';
	}
}
