<?php  

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Carrera {
	function index ($request, $match) {
		$carrera = new Calif_Carrera ();
		# Listar las carreras aquí, por división
		$divisiones = Gatuf::factory ('Calif_Division')->getList ();
		
		$carreras = array ();
		foreach ($divisiones as $div) {
			$sql = new Gatuf_SQL ('division=%s', $div->id);
			$carreras [$div->id] = Gatuf::factory('Calif_Carrera')->getList(array ('filter' => $sql->gen ()));
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/carrera/index.html',
		                                         array('page_title' => 'Carreras',
		                                               'divisiones' => $divisiones,
		                                               'carreras' => $carreras),
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
