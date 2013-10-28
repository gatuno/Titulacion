<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');

class Titulacion_Views_Maestro {
	public function index ($request, $match) {
		Gatuf::loadFunction ('Titulacion_Utils_grado');
		$maestro = new Titulacion_Maestro ();
		
		$pag = new Gatuf_Paginator ($maestro);
		$pag->action = array ('Titulacion_Views_Maestro::index');
		$pag->summary = 'Lista de maestros';
		$list_display = array (
			array ('codigo', 'Gatuf_Paginator_FKLink', 'Código'),
			array ('apellido', 'Gatuf_Paginator_DisplayVal', 'Apellido'),
			array ('nombre', 'Gatuf_Paginator_DisplayVal', 'Nombre'),
			array ('grado', 'Gatuf_Paginator_FKExtra', 'Grado'),
		);
		
		$pag->items_per_page = 50;
		$pag->no_results_text = 'No se encontraron maestros';
		$pag->max_number_pages = 5;
		$pag->configure ($list_display,
			array ('codigo', 'nombre', 'apellido'),
			array ('codigo', 'nombre', 'apellido', 'grado')
		);
		
		$pag->setFromRequest ($request);
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/maestro/index.html',
		                                         array('page_title' => 'Maestros',
		                                               'paginador' => $pag),
		                                         $request);
	}
	
	public $agregarMaestro_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.agregar-maestros'));
	public function agregarMaestro ($request, $match) {
		$title = 'Nuevo profesor';
		
		$extra = array ();
		
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Maestro_Agregar ($request->POST, $extra);
			
			if ($form->isValid()) {
				$maestro = $form->save ();
				
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Maestro::index', array ($maestro->codigo));
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Maestro_Agregar (null, $extra);
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/maestro/agregar-maestro.html',
		                                         array ('page_title' => $title,
		                                                'form' => $form),
		                                         $request);
	}
	
	public $actualizarMaestro_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.actualizar-maestros'));
	public function actualizarMaestro ($request, $match) {
		$title = 'Actualizar profesor';
		
		$maestro = new Titulacion_Maestro ();
		
		if (false === $maestro->getMaestro ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$extra = array ('maestro' => $maestro);
		
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Maestro_Actualizar ($request->POST, $extra);
			
			if ($form->isValid()) {
				$maestro = $form->save ();
				
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Maestro::verMaestro', array ($maestro->codigo));
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Maestro_Actualizar (null, $extra);
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/maestro/edit-maestro.html',
		                                         array ('page_title' => $title,
		                                                'maestro' => $maestro,
		                                                'form' => $form),
		                                         $request);
	}
	
	
	
	public function verMaestro ($request, $match) {
		$title = 'Perfil público del profesor';
		
		$maestro = new Titulacion_Maestro ();
		$acta = new Titulacion_Acta ();
		$codigo = $maestro->codigo;
		$director = false;
		$secretario = false;
		$jurado = false;
		$nada = false;
		$funge = '';

		/*
			$choices = array();
		foreach($planes as $m){
			$choices[$m->plan] = $m ->id;
			$choices_planes = array();
			foreach ($planes as $plan){
				$choices_planes[$plan->plan] = $plan->id;
			}
		}
			public $director_division, $secretario_division;
	public $jurado1;
	public $jurado2;
	public $jurado3;
		
		
		$agregar = Gatuf::factory('Titulacion_Acta')->getList();
		$actas = array();
		foreach($agregar as $m){
			$choices[$m->director_division] = $m ->id;
			$actas = array();
			foreach ($planes as $plan){
				$choices_planes[$plan->plan] = $plan->id;
			}
		}*/
		
		
		if (false === $maestro->getMaestro ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		} 
		
		if ($acta->getDirector($codigo) == true){
			$director = true;
			$funge = 'Director de división';
		} else
		if ($acta->getSecretario($codigo) == true){
			$secretario = true;
			$funge = 'Secretario de división';
		}else
		if ($acta->getJurado1($codigo) == true){
			$jurado = true;
			$funge = 'jurado';
		}else
		if ($acta->getJurado2($codigo) == true)
		{
			$jurado = true;
				$funge = 'jurado';
		}else
		if ($acta->getJurado2($codigo) == true){
			$jurado = true;
				$funge = 'jurado';
		} else{
			$nada = true;
		}
		
		$pag = new Gatuf_Paginator($actas);
		//$pag->action = array ('Titulacion_Views_Acta::index');
		$pag->sumary = 'Lista de actas registradas';

		$list_display = array (
			array('carrera','Gatuf_Paginator_FKLink','Carrera'),
			array('alumno','Gatuf_Paginator_DisplayVal', 'Codigo del alumno'),
			array('alumno_nombre','Gatuf_Paginator_DisplayVal', 'Nombre'),
			array('alumno_apellido','Gatuf_Paginator_DisplayVal', 'Apellidos'),
			array('modalidad','Gatuf_Paginator_FKLink', 'Opcion de titulacion'),
			array('fechaHora','Gatuf_Paginator_DateYMDHM','Fecha ceremonia'),
			array('funge','Gatuf_Paginator_DisplayVal','Fungio como ')
		);

		$pag->items_per_page = 25;
		$pag->no_results_text = 'No hay actas de titulacion en la que este profesor haya participado';
		$pag->max_number_pages = 3;
		$pag->configure ($list_display,
				array ('alumno','carrera', 'alumno_nombre', 'alumno_apellido', 'modalidad_descripcion'),
				array ('alumno','carrera')
		);
		$pag->setFromRequest($request);
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/maestro/ver-maestro.html',
		                                         array ('maestro' => $maestro,
														'acta' => $acta,
														'director' => $director,
														'secretario' => $secretario,
														'jurado' => $jurado,
		                                                'page_title' => $title,
														'paginador'  => $pag),
		                                         $request);
	}
}
