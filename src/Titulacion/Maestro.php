<?php

class Titulacion_Maestro extends Titulacion_User {
	/* Manejador de la tabla Alumnos */
	
	/* Campos */
	public $codigo;
	public $nombre;
	public $apellido;
	public $correo;
	public $grado;
	public $fechas;
	
	function __construct () {
		$this->_getConnection();
		
		$this->tabla = 'Maestros';
		$this->login_tabla = 'Maestros_Login';
		$this->default_order = 'apellido ASC, nombre ASC';
	}
	
	function getMaestro ($codigo) {
		/* Recuperar un maestro */
		$req = sprintf ('SELECT * FROM %s WHERE codigo = %s', $this->getSqlTable(), Gatuf_DB_IdentityToDb ($codigo, $this->_con));
		
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
		$req = sprintf ('INSERT INTO %s (codigo, nombre, apellido, correo, grado, sexo) VALUES (%s, %s, %s, %s, %s, %s);', $this->getSqlTable(), Gatuf_DB_IntegerToDb ($this->codigo, $this->_con), Gatuf_DB_IdentityToDb ($this->nombre, $this->_con), Gatuf_DB_IdentityToDb ($this->apellido, $this->_con), Gatuf_DB_IdentityToDb ($this->correo, $this->_con), Gatuf_DB_IdentityToDb ($this->grado, $this->_con), Gatuf_DB_IdentityToDb ($this->sexo, $this->_con));
		
		$this->_con->execute($req);
		
		$this->createSession ();
		
		return true;
	}
	
	function update () {
		$this->preSave (); /* FIXME: Falta actualizar el grado y el sexo */
		$req = sprintf ('UPDATE %s SET nombre = %s, apellido = %s, correo = %s, grado = %s, sexo = %s WHERE codigo = %s;', $this->getSqlTable(), Gatuf_DB_IdentityToDb ($this->nombre, $this->_con), Gatuf_DB_IdentityToDb ($this->apellido, $this->_con), Gatuf_DB_IdentityToDb ($this->correo, $this->_con), Gatuf_DB_IdentityToDb ($this->grado, $this->_con), Gatuf_DB_IdentityToDb ($this->sexo, $this->_con), Gatuf_DB_IntegerToDb ($this->codigo, $this->_con));
		
		$this->_con->execute($req);
		
		return true;
	}
	
	public function displaygrado () {
		return Titulacion_Utils_grado ($this->sexo, $this->grado);
	}
	
	public function displaylinkedcodigo () {
		return '<a href="'.Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Maestro::verMaestro', array ($this->codigo)).'">'.$this->codigo.'</a>';
	}
	
	
	}
