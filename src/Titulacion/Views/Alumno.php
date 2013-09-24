<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Alumno {
	
	public function index ($request, $match) {
		$alumnos = new Titulacion_Alumno ();
		
		$pag = new Gatuf_Paginator ($alumnos);
		$pag->action = array ('Titulacion_Views_Alumno::index');
		$pag->sumary = 'Lista de alumnos registrados';
		
		$list_display = array (
			array ('codigo', 'Gatuf_Paginator_DisplayVal', 'Codigo'),
			array ('apellido', 'Gatuf_Paginator_DisplayVal', 'Apellido')
			array ('nombre', 'Gatuf_Paginator_DisplayVal', 'Nombre'),
		);
		
		$pag->items_per_page = 25;
		$pag->no_results_tex = 'No se encontro ningun alumno';
		$pag->max_number_pages = 3;
		$pag->configure ($list_display,
			array('codigo', 'apellido', 'nombre'),
			array('codigo', 'apellido', 'nombre')
		);
		
		$pag->setFromRequest($request);
		
		return Gatuf_Shortcuts_renderToResponse ('titulacion/alumno/index.html',
			                                     array('page title'=>'Lista de Alumnos',
			                                           'paginador' => $pag),
			                                     $request);
	}
	
	public $agregarAlumno_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.generar-acta'));
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
	
	public $editarAlumno_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.generar-acta'));
	public function editarAlumno ($request, $match) {
		$alumno = new Titulacion_Alumno ();
		if (false === ($alumno->getAlumno ($match[1]))) {
			return new Gatuf_HTTP_Response_Json (array ());
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
		                                                'form' => $form),
		                                         $request);
	}
	
	public function jsonAlumno ($request, $match) {
		$alumno = new Titulacion_Alumno ();
		if (false === ($alumno->getAlumno ($match[1]))) {
			return new Gatuf_HTTP_Response_Json (array ());
		}
		$alumno_json = array ('codigo' => $alumno->codigo, 'nombre' => $alumno->nombre, 'apellido' => $alumno->apellido, 'sexo' => $alumno->sexo);
		
		return new Gatuf_HTTP_Response_Json ($alumno_json);
	}
}
