<?php

class Titulacion_Views_Alumno {
	function index ($request, $match){
		$alumno = new Titulacion_Alumno();
		
		$alumno->nombre='Miriam';
		$alumno->apellido='Rodriguez LOpez';
		$alumno->codigo='207721269';
		$alumno->create();
		return new Gatuf_HTTP_Response ('Alumno registrado exitosamente');

			
	}


}