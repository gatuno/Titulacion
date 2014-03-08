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
			$carreras [$div->id] = Gatuf::factory('Titulacion_Carrera')->getList(array ('filter' => $sql->gen ()));
			if (count ($carreras[$div->id]) == 0) $carreras[$div->id] = array ();
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/carrera/index.html',
		                                         array('page_title' => 'Carreras',
		                                               'divisiones' => $divisiones,
		                                               'carreras' => $carreras),
		                                         $request);
	}
	
	public $agregarCarrera_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.agregar-carreras'));
	public function agregarCarrera ($request, $match) {
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Carrera_Agregar ($request->POST);
			if ($form->isValid()) {
				$carrera = $form->save();
				$url = Gatuf_HTTP_URL_urlForView('Titulacion_Views_Carrera::index');
				return new Gatuf_HTTP_Response_Redirect($url);
			}
		} else {
			$form = new Titulacion_Form_Carrera_Agregar (null);
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/carrera/agregar-carrera.html',
		                                         array('page_title' => 'Crear carrera',
		                                               'form' => $form),
		                                         $request);
	}
	
	public $actualizarCarrera_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.agregar-carreras'));
	public function actualizarCarrera ($request, $match) {
		$carrera = new Titulacion_Carrera ();
		
		if ($carrera->get ($match[1]) === false) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$extra = array ('carrera' => $carrera);
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Carrera_Actualizar ($request->POST, $extra);
			
			if ($form->isValid ()) {
				$carrera = $form->save ();
				$url = Gatuf_HTTP_URL_urlForView('Titulacion_Views_Carrera::index');
				return new Gatuf_HTTP_Response_Redirect($url);
			}
		} else {
			$form = new Titulacion_Form_Carrera_Actualizar (null, $extra);
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/carrera/edit-carrera.html',
		                                         array('page_title' => 'Actualizar carrera',
		                                               'carrera' => $carrera,
		                                               'form' => $form),
		                                         $request);
	}
}
