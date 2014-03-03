<?php

class Titulacion_DB {
	static function get($engine, $server, $database, $login, $password, 
	                    $prefix, $debug=false, $version='') {
		$engine = 'Gatuf_DB_'.$engine;
		$con = new $engine($login, $password, $server, $database, $prefix, $debug, $version);
		return $con;
	}
}

function Titulacion_DB_getConnection() {
	if (isset($GLOBALS['_TITULACION_db']) && 
		(is_resource($GLOBALS['_TITULACION_db']->con_id) or is_object($GLOBALS['_TITULACION_db']->con_id))) {
		return $GLOBALS['_TITULACION_db'];
	}
	/* FIXME: Arreglar variables de configuración */
	$GLOBALS['_TITULACION_db'] = Titulacion_DB::get(Gatuf::config('db_engine', 'MySQL'),
	                                   Gatuf::config('db_server'),
	                                   'titulacion',
	                                   Gatuf::config('db_login'),
	                                   Gatuf::config('db_password'),
	                                   '');
	return $GLOBALS['_TITULACION_db'];
}
