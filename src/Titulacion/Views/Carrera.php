<?php  

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');


class Titulacion_Views_Carrera {
	function index ($request, $match) {
		$carrera = new Titulacion_Carrera ();
		
		$pag = new Gatuf_Paginator($carrera);
		$pag->action = array ('Titulacion_Views_Carrera::index');
		$pag->sumary = 'Lista de carreas';
		
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
							  array('page_title' => 'CARRERAS',
						          'paginador' => $pag),

						        $request);

	}

		public function agregarCarrera ($request, $match) {
			if($request->method == 'POST'){
				$form = new Titulacion_Form_Opcion_Agregar ($request->POST, array());
				
				if($form->isValid() ){
					$carrera = $form->save ();

					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Carrera::index');
					return new Gatuf_HTTP_Response_Redirect ($url);
				
				}			
			}else {
				$form = new Titulacion_Form_Carrera_Agregar (null, array());
			}
			
			return Gatuf_Shortcuts_RenderToResponse ('titulacion/carrera/edit-opcion.html',
								array ('page_title' => 'Nueva carrera',
									'form' =>$form),
								$request);

		
		

	}
}
