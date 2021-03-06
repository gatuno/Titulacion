<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Modalidad {
	public function index ($request, $match) {
		$opciones = new Titulacion_Opcion ();
		
		$pag = new Gatuf_Paginator ($opciones);
		$pag->model_view = 'paginador';
		$pag->action = array ('Titulacion_Views_Modalidad::index');
		$pag->summary = 'Lista de opciones de titulación';
		
		$list_display = array (
			array ('modalidad_desc', 'Gatuf_Paginator_DisplayVal', 'Modalidad'),
			array ('descripcion', 'Gatuf_Paginator_FKLink', 'Opcion'),
			array ('udg', 'Gatuf_Paginator_FKExtra', 'Estatuto U de G'),
			array ('cucei', 'Gatuf_Paginator_FKExtra', 'Estatuto CUCEI')
		);
		
		$pag->items_per_page = 25;
		$pag->no_results_text = 'No hay modalidades de titulación disponibles';
		$pag->max_number_pages = 3;
		$pag->configure ($list_display,
			array ('modalidad_desc', 'descripcion'),
			array ('modalidad_desc', 'descripcion')
		);
		
		$pag->setFromRequest ($request);
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/modalidad/index.html',
		                                         array('page_title' => 'Opciones de titulación',
		                                               'paginador' => $pag),
		                                         $request);
	}
	
	public function verOpcion ($request, $match) {
		$opcion = new Titulacion_Opcion ();
		
		if (false === ($opcion->get ($match[1]))) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$modalidad = $opcion->get_modalidad ();
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/modalidad/ver-opcion.html',
		                                         array ('page_title' => 'Opción '.$opcion->descripcion,
		                                                'opcion' => $opcion,
		                                                'modalidad' => $modalidad),
		                                         $request);
	}
	
	public $agregarOpcion_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.manejar-opciones'));
	public function agregarOpcion ($request, $match) {
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Opcion_Agregar ($request->POST);
			
			if ($form->isValid ()) {
				$modalidad = $form->save ();
				
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Modalidad::index');
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Opcion_Agregar (null);
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/modalidad/agregar-opcion.html',
		                                         array ('page_title' => 'Nueva opción de titulación',
		                                                'form' => $form),
		                                         $request);
	}
	
	public $actualizarOpcion_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.manejar-opciones'));
	public function actualizarOpcion ($request, $match) {
		$opcion = new Titulacion_Opcion ();
		
		if (false === ($opcion->get ($match[1]))) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$modalidad = $opcion->get_modalidad ();
		
		$extra = array ('opcion' => $opcion);
		
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Opcion_Actualizar ($request->POST, $extra);
			
			if ($form->isValid ()) {
				$opcion = $form->save ();
				
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Modalidad::index');
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Opcion_Actualizar (null, $extra);
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/modalidad/edit-opcion.html',
		                                         array ('page_title' => 'Actualizar opción de titulación',
		                                                'modalidad' => $modalidad,
		                                                'form' => $form),
		                                         $request);
	}
	
	public $jsonOpcion_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.visualizar-actas'));
	public function jsonOpcion ($request, $match) {
		$opcion = new Titulacion_Opcion ();
		
		if (false === ($opcion->get ($match[1]))) {
			return new Gatuf_HTTP_Response_Json (array ());
		}
		
		$opcion_json = array ('id' => $opcion->id, 'descripcion' => $opcion->descripcion, 'modalidad' => $opcion->modalidad, 'maestria' => $opcion->maestria, 'trabajo' => $opcion->trabajo, 'desempeno' => $opcion->desempeno);
		
		return new Gatuf_HTTP_Response_Json ($opcion_json);
	}
}
