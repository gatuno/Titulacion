<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_PlanEstudio {
	public $index_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.visualizar-actas'));
	public function index ($request, $match) {
		$title = 'Planes de estudio';
		$planes = Gatuf::factory ('Titulacion_PlanEstudio')->getList ();
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/plan/index.html',
		                                         array ('page_title' => $title,
		                                                'planes' => $planes),
		                                         $request);
	}
}
