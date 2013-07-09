<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Acta {
	public function index($request, $match) {
		$actas=new Titulacion_Actas ();
		
		$pag = new Gatuf_Paginator ($actas);
		$pag->action = array ('Titulacion_Views_Acta::index');
		$pag->sumary = 'Lista de actas registradas';
		
		$list_display = array (
			array('folio')
			array('numeroActa')
			array('alumno','Gatuf_paginator_FKExtra')
			array('alumno_nombre','Gatuf_paginator_FKExtra')
			array('alumno_apellidos','Gatuf_paginator_FKExtra')
			array('planEstudios')
			array('opcTitulacion_descripcion')
			array('fechaHora')
			array('ingreso')
			array('egreso')
		);
	}
}