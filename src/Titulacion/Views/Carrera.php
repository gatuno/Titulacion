<?php  

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Carrera {
	function index ($request, $match) {
		$carrera = new Calif_Carrera ();
		
		$pag = new Gatuf_Paginator($carrera);
		$pag->action = array ('Titulacion_Views_Carrera::index');
		$pag->sumary = 'Lista de carreras';
		
		$list_display = array(
			array ('clave', 'Gatuf_Paginator_DisplayVal', 'Clave'),
			array ('descripcion',  'Gatuf_Paginator_DisplayVal', 'Opcion')
		);
		
		$pag->items_per_page =25;
		$pag->no_results_text = 'No hay carreras disponibles por el momento';
		$pag->configure ($list_display,
			array('clave', 'descripcion'),
			array('clave', 'descripcion')
		);
		
		$pag->setFromRequest ($request);
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/carrera/index.html',
		                                         array('page_title' => 'Carreras',
		                                               'paginador' => $pag),
		                                         $request);
	}
	
	public $agregarCarrera_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.agregar-carreras'));
	public function agregarCarrera ($request, $match) {
		$title = 'Crear carrera';
		$extra = array ();
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Carrera_Agregar($request->POST, $extra);
			if ($form->isValid()) {
				$carrera = $form->save();
				$url = Gatuf_HTTP_URL_urlForView('Titulacion_Views_Carrera::index');
				return new Gatuf_HTTP_Response_Redirect($url);
			}
		} else {
			$form = new Titulacion_Form_Carrera_Agregar(null, $extra);
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/carrera/edit-carrera.html',
		                                         array('page_title' => $title,
		                                               'form' => $form),
		                                         $request);
	}
}
