<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Modalidad {
	public function index ($request, $match) {
		$opciones = new Titulacion_Opcion ();
		
		$pag = new Gatuf_Paginator ($opciones);
		$pag->action = array ('Titulacion_Views_Modalidad::index');
		$pag->summary = 'Lista de opciones de titulación';
		
		$list_display = array (
			array ('modalidad_descripcion', 'Gatuf_Paginator_DisplayVal', 'Modalidad'),
			array ('descripcion', 'Gatuf_Paginator_DisplayVal', 'Opcion'),
			array ('udg', 'Gatuf_Paginator_FKExtra', 'Estatuto U de G'),
			array ('cucei', 'Gatuf_Paginator_FKExtra', 'Estatuto CUCEI')
		);
		
		$pag->items_per_page = 25;
		$pag->no_results_text = 'No hay modalidades de titulación disponibles';
		$pag->max_number_pages = 3;
		$pag->configure ($list_display,
			array ('modalidad_descripcion', 'descripcion'),
			array ('modalidad_descripcion', 'descripcion')
		);
		
		$pag->setFromRequest ($request);
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/modalidad/index.html',
		                                         array('page_title' => 'Modalidades de titulación',
                                                       'paginador' => $pag),
                                                 $request);
	}
	
	public function agregarOpcion ($request, $match) {
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Opcion_Agregar ($request->POST, array());
			
			if ($form->isValid ()) {
				$modalidad = $form->save ();
				
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Modalidad::index');
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Opcion_Agregar (null, array ());
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/modalidad/edit-opcion.html',
		                                         array ('page_title' => 'Nueva opción de titulación',
		                                                'form' => $form),
		                                         $request);
	}
}
