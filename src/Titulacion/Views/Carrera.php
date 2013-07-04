<?php  

class Titulacion_Views_Carrera {
	function index ($request, $match) {
		$carrera = new Titulacion_Carrera ();
	
		$carrera->clave ='COM';
		$carrera->descripcion ='LA';
		$carrera->create ();
		return new Gatuf_HTTP_Response ('COM creada');
	}
}
