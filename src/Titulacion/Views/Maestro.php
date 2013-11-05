<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

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
		
		
		if (false === $maestro->getMaestro ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		} 
		
	    /*
		if ($acta->getDirector($codigo) == true){
			$funge = 'Director de división';
		} else
		if ($acta->getSecretario($codigo) == true){
			$funge = 'Secretario de división';
		}else
		if ($acta->getJurado1($codigo) == true){
			$funge = 'jurado';
		}else
		if ($acta->getJurado2($codigo) == true)
		{
				$funge = 'jurado';
		}else
		if ($acta->getJurado3($codigo) == true){
				$funge = 'jurado';
		} else{
			$nada = true;
		}*/
		
		
	
		//$acta->funge = $funge;
	
		$carrera = $acta->carrera;
		$alumno = $acta->alumno;
		$alumno_nombre = $acta->alumno_nombre;
		$alumno_apellido = $acta->alumno_apellido;
		$modalidad = $acta->modalidad_descripcion;
		$acta->getFunge($codigo);
		
		
			$this->fields['fechaHora'] = new Gatuf_Form_Field_Datetime (
			array(
				'required' => true,
				'label' => 'Primera fecha',
				'initial' =>'',
				'help_text'=>'Fecha a partir de la cual quieres buscar',
				'widget' => 'Gatuf_Form_Widget_DatetimeJSInput',
				'widget_attrs' => array (
					'js_attrs' => array (
						'minDate' => 0,
					),
				)
		));
		
		

		
		$pag = new Gatuf_Paginator($acta);
		$pag->action = array ('Titulacion_Views_Maestro::verMaestro');
		$pag->sumary = 'Lista en las que a participado';

		$list_display = array (
			array('carrera','Gatuf_Paginator_DisplayVal','Carrera'),
			array('alumno','Gatuf_Paginator_DisplayVal', 'Codigo del alumno'),
			array('alumno_nombre','Gatuf_Paginator_DisplayVal', 'Nombre'),
			array('alumno_apellido','Gatuf_Paginator_DisplayVal', 'Apellidos'),
			array('modalidad_descripcion','Gatuf_Paginator_DisplayVal', 'Opcion de titulacion'),
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
		
		$codigo = $maestro->codigo;
		
		$sql = new Gatuf_SQL ('director_division=%s OR secretario_division=%s OR jurado1=%s OR jurado2=%s OR jurado3=%s',array($codigo,$codigo,$codigo,$codigo,$codigo));
		$pag->forced_where = $sql;
	
			
		
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/maestro/ver-maestro.html',
		                                         array ('maestro' => $maestro,
														'acta' => $acta,
														'director' => $director,
														'secretario' => $secretario,
														'jurado' => $jurado,    
														'funge' => $funge,
														'paginador'  => $pag),
														
		                                         $request);
												 $funge = '';
	}
}
