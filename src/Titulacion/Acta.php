<?php

class Titulacion_Acta extends Gatuf_Model {
	public $id;
	public $planEstudios;
	public $folio;
	public $numeroActa;
	public $opcTitulacion;
	public $opcTitulacion_descripcion;
	public $alumno_nombre;
	public $alumno_apellidos;
	public $alumno; /*Llave foranea*/
	public $fechaHora;
	public $ingreso;
	public $egreso;
	public $carrera;
	
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
		$req = sprintf('INSERT INTO $s(planEstudios, folio, numeroActa,opcTitulacion, alumno, carrera, fechaHora, ingreso, egreso) VALUES($s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)', $this->getSqlTable(), Gatuf_DB_IntegerToDb ($this->planEstudios, $this->con),Gatuf_DB_IntegerToDb ($this->folio, $this->con),Gatuf_DB_IntegerToDb ($this->numeroActa, $this->con),Gatuf_DB_IntegerToDb ($this->opcTitulacion, $this->con),Gatuf_DB_IntegerToDb ($this->alumno, $this->con),Gatuf_DB_IntegerToDb ($this->carrera, $this->con),Gatuf_DB_IntegerToDb ($this->opcTitulacion, $this->con),Gatuf_DB_IntegerToDb ($this->alumno, $this->con),Gatuf_DB_IntegerToDb ($this->fechaHora, $this->con),Gatuf_DB_IntegerToDb ($this->ingreso, $this->con),Gatuf_DB_IntegerToDb ($this->egreso, $this->con));	
		$this->con_->execute ($req);
		return true;
	}
}