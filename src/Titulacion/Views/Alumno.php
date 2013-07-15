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
			array ('apellidos', 'Gatuf_Paginator_DisplayVal', 'Apellidos'),
			array ('nombre', 'Gatuf_Paginator_DisplayVal', 'Nombre'),
		);
		
		$pag->items_per_page = 25;
		$pag->no_results_tex = 'No se encontro ningun alumno';
		$pag->max_number_pages = 3;
		$pag->configure ($list_display,
			array('codigo', 'apellidos', 'nombre'),
			array('codigo', 'apellidos', 'nombre')
		);
		
		$pag->setFromRequest($request);
		
		return Gatuf_Shortcuts_renderToResponse ('titulacion/alumno/index.html',
			                                     array('page title'=>'Lista de Alumnos',
			                                           'paginador' => $pag),
			                                     $request);
	}
	
	public $agregarAlumno_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.generar-acta'));
	public function agregarAlumno ($request, $match) {
		if($request->method == 'POST') {
			$form = new Titulacion_Form_Alumno_Agregar ($request->POST, array());
			
			if($form->isValid ()){
				$alumno = $form->save ();
				
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::index');
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		}else {
				$form = new Titulacion_Form_Alumno_Agregar (null, array ());
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/alumno/edit-alumno.html',
		                                         array ('page_title' => 'Agregar alumno',
		                                                'form' => $form),
		                                         $request);
	}
}
