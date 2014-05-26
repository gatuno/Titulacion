<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Alumno {
	public $seleccionarAlumno_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.manejar-actas'));
	public function seleccionarAlumno ($request, $match) {
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Alumno_Seleccionar ($request->POST, array ());
			if ($form->isValid ()) {
				$codigo = $form->save ();

				$alumno = new Calif_Alumno ();
				if (false === ($alumno->get ($codigo))) {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::agregarAlumno', array (), array ('acta' => 1, 'alumno' => $codigo), false);
				} else {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::editarAlumno', array ($alumno->codigo), array ('acta' => 1), false);
				}

				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		}
		
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index');
		return new Gatuf_HTTP_Response_Redirect ($url);
	}
	
	public $agregarAlumno_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.manejar-actas'));
	public function agregarAlumno ($request, $match) {
		if (isset ($request->REQUEST['acta']) && $request->REQUEST['acta'] == 1) {
			$extra = array ('acta' => 1);
		} else {
			$extra = array ('acta' => 0);
		}
		if (isset ($request->REQUEST['alumno']) && $request->REQUEST['alumno'] != '') {
			$extra['alumno'] = $request->REQUEST['alumno'];
		} else {
			$extra['alumno'] = '';
		}
		if($request->method == 'POST') {
			$form = new Titulacion_Form_Alumno_Agregar ($request->POST, $extra);
			
			if($form->isValid ()){
				$domicilio = $form->save ();
				if (isset ($request->REQUEST['acta']) && $request->REQUEST['acta'] == 1) {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::agregarActa', array ($domicilio->alumno, $domicilio->id));
				} else {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::index');
				}
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
				$form = new Titulacion_Form_Alumno_Agregar (null, $extra);
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/alumno/agregar-alumno.html',
		                                         array ('page_title' => 'Agregar alumno',
		                                         'form' => $form),
		                                         $request);
	}
	
	public $editarAlumno_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.manejar-actas'));
	public function editarAlumno ($request, $match) {
		$alumno = new Calif_Alumno ();
		if (false === ($alumno->get ($match[1]))) {
			$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::agregarAlumno', array (), (isset ($request->REQUEST['acta']) && $request->REQUEST['acta'] == 1) ? array ('acta' => 1) : array ());
			return new Gatuf_HTTP_Response_Redirect ($url);
		}
		$extra = array ('alumno' => $alumno);
		
		if (isset ($request->REQUEST['acta']) && $request->REQUEST['acta'] == 1) {
			$extra['acta'] = 1;
		} else {
			$extra['acta'] = 0;
		}
		if($request->method == 'POST') {
			$form = new Titulacion_Form_Alumno_Editar ($request->POST, $extra);
			
			if($form->isValid ()){
				$domicilio = $form->save ();
				if (isset ($request->REQUEST['acta']) && $request->REQUEST['acta'] == 1) {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::agregarActa', array ($domicilio->alumno, $domicilio->id));
				} else {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::index');
				}
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
				$form = new Titulacion_Form_Alumno_Editar (null, $extra);
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/alumno/edit-alumno.html',
		                                         array ('page_title' => 'Actualizar alumno',
		                                         'alumno' => $alumno,
		                                         'form' => $form),
		                                         $request);
	}
}
