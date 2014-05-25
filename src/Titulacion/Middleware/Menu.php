<?php

class Titulacion_Middleware_Menu {
	static function constructMenu ($signal, &$menus) {
		$m = new stdClass ();
		$m->nombre = 'Titulación';
		$m->klass = 'titulacion';
		$m->href = Gatuf_HTTP_URL_urlForView ('Titulacion_Views::index');
		$m->color = 'FFV000';
		$m->sub = array ();
		
		$sub = new stdClass ();
		$sub->nombre = 'Carreras';
		$sub->href = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Carrera::index');
		
		$m->sub[] = $sub;
		
		$sub = new stdClass ();
		$sub->nombre = 'Actas';
		$sub->href = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index');
		
		$m->sub[] = $sub;
		
		$sub = new stdClass ();
		$sub->nombre = 'Opciones y Modalidades';
		$sub->href = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Modalidad::index');
		
		$m->sub[] = $sub;
		
		$sub = new stdClass ();
		$sub->nombre = 'Planes de estudio';
		$sub->href = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_PlanEstudio::index');
		
		$m->sub[] = $sub;
		
		$menus[] = $m;
	}
};
