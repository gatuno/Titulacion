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
	
	function__construc() {
		$this->_getConnection();
		$this->tabla = 'Actas';
		$this->tabla_view= 'Actas_View';
		
	}

	function getActa($id) {
		$req = sprintf('SELECT * FROM %s WHERE id=%s', $this->getSqlViewTable (),Gatuf_DB_IntegerToDb ($id, $this->con));
		
		if(false== ($rs = $this->_con_select ($req))){
			throw new Exception ($this->_con->_getError());
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
		$req = sprintf('INSERT INTO $s(planEstudios, folio, numeroActa,opcTitulacion, alumno, fechaHora, ingreso, egreso) VALUES($s, %s, %s, %s, %s, %s, %s, %s, %s, %s)', $this->getSqlTable(), Gatuf_DB_IntegerToDb ($this->planEstudios, $this->con),Gatuf_DB_IntegerToDb ($this->folio, $this->con),Gatuf_DB_IntegerToDb ($this->numeroActa, $this->con),Gatuf_DB_IntegerToDb ($this->opcTitulacion, $this->con),Gatuf_DB_IntegerToDb ($this->alumno, $this->con),Gatuf_DB_IntegerToDb ($this->opcTitulacion, $this->con),Gatuf_DB_IntegerToDb ($this->alumno, $this->con),Gatuf_DB_IntegerToDb ($this->fechaHora, $this->con),Gatuf_DB_IntegerToDb ($this->ingreso, $this->con),Gatuf_DB_IntegerToDb ($this->egreso, $this->con) );	
		$this->con_->execute ($req);
		return true;
	}
}