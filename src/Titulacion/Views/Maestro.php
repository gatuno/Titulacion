<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');

class Titulacion_Views_Maestro {
	public function index ($request, $match) {
		$maestro = new Titulacion_Maestro ();
		
		$pag = new Gatuf_Paginator ($maestro);
		$pag->action = array ('Titulacion_Views_Maestro::index');
		$pag->summary = 'Lista de maestros';
		$list_display = array (
			array ('codigo', 'Gatuf_Paginator_DisplayVal', 'Código'),
			array ('apellido', 'Gatuf_Paginator_DisplayVal', 'Apellido'),
			array ('nombre', 'Gatuf_Paginator_DisplayVal', 'Nombre'),
		);
		
		$pag->items_per_page = 50;
		$pag->no_results_text = 'No se encontraron maestros';
		$pag->max_number_pages = 5;
		$pag->configure ($list_display,
			array ('codigo', 'nombre', 'apellido'),
			array ('codigo', 'nombre', 'apellido')
		);
		
		$pag->setFromRequest ($request);
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/maestro/index.html',
		                                         array('page_title' => 'Maestros',
		                                               'paginador' => $pag),
		                                         $request);
	}
	
	public $agregarMaestro_precond = array (array ('Gatuf_Precondition::hasPerm', 'SIIAU.agregar-maestros'));
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
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/maestro/edit-maestro.html',
		                                         array ('page_title' => $title,
		                                                'form' => $form),
		                                         $request);
	}
	
	public function actualizarMaestro ($request, $match) {
		$acta = new Titulacion_Maestro ();

		if (false === $maestro->getMaestro ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}

			$form = new Titulacion_Form_Maestro_Editar (null, $extra);
		

		return Gatuf_Shortcuts_RenderToResponse ('titulacion/maestro/edit-maestro.html',
		                                         array ('page_title' => 'Actualizar maestro',
		                                                'maestro' => $maestro,
														'codigo' => $codigo,
														'nombre' => $apellido,
														'grado' => $grado,
														'correo' => $correo,		                                             
		                                                'form' => $form),
		                                         $request);
	}
	
	public function verMaestro($request, $match, $params = array ()){
		$maestro = new Titulacion_Maestro ();
		Gatuf::loadFunction ('Titulacion_Utils_grado');
		
		if (false === $maestro->getMaestro ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$nombre = $maestro->nombre;
		$apellido = $maestro->apellido;
		$grado = $maestro->grado;
		$sexo = $maestro->sexo;
		$correo = $maestro->correo;
		$gradoC = Titulacion_Utils_grado ($sexo, $grado);
		

		return Gatuf_Shortcuts_RenderToResponse ('titulacion/maestro/ver-maestro.html',
		                                         array ('maestro' => $maestro,
		                                                'nombre' => $nombre,
		                                                'apellido' => $apellido,
		                                                'grado' => $gradoC,
		                                                'sexo' => $sexo,
		                                                'correo' => $correo,
		                                                'page_title' => 'Ver Maestro',
		                                              
		                                         ),
		                                         $request);
	}

}
